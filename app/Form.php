<?php

/**
* Description:
* Model (based on MVC architecture) for form definitions
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - search($search = false, $trash = false, $draft = false, $order = 'ASC') | search forms
* - email($type = false) | get email template of $type
* - emails() | reference to email templates setup for the form (Object-Relational Mapper)
* - groups() | reference to the form groups (Object-Relational Mapper)
* - types() | reference to the form type (Object-Relational Mapper)
* - completed() | Is form completed?
* - active() | Is form active?
* - notUniqueAlias() | Is form alias unique?
* - getTypeAttribute() | get form type name (Laravel Accessor)
* - apps() | reference to applications (submittions) made with this form definition (Object-Relational Mapper)
* - getHasAppsAttribute() | are there any submissions made for this form definition?
* - getFieldsAttribute() | get form groups for this form definition
* - staticFields() | get the list of static form groups with nested fields
* - getFieldsAlias() | get fields aliases
* - getFieldsData() | get fields meta-data and fields values
* - updateAlias($alias) | update alias value in Form config (json)
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\FormConfig;

class Form extends Model
{
    use FormConfig;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
    * Description:
    * Search forms
    *
    * List of parameters:
    * - $search : boolean - string keyword to search
    * - $trash : boolean - search for trashed forms?
    * - $draft : boolean - search for drafts as well?
    * - $order : string  - ASC|DESC
    *
    * Return:
    * - list of forms
    *
    * Example of usage:
    * see method app/Http/Controllers/FrontendController-commented.form()
    */
    static function search($search = false, $trash = false, $draft = false, $order = 'ASC')
    {
        $forms = Form::Where('title','LIKE', '%'.$search.'%')
            ->with('types')
            ->withCount('groups')
            // ->withCount('apps')
            ;

        if ($trash !== false) {
            $forms->where('is_trash', $trash);
        }

        if ($draft !== false) {
            $forms->where('draft', $draft);
        }

        return $forms;
    }


    /**
    * Description:
    * get email template of $type
    *
    * List of parameters:
    * $type : string
    *
    * Return:
    * FormEmail
    *
    * Example of usage:
    * see method Application.sendEmail()
    */
    public function email($type = false)
    {
        // TODO why $type=false? not empty
        return $this->emails()->where('type', $type)->first();
    }


    /**
    * Description:
    * reference to email templates setup for the form (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object | list of objects
    *
    * Example of usage:
    * see method email()
    */
    public function emails()
    {
        return $this->hasMany(FormEmail::class, 'form_id');
    }


    /**
    * Description:
    * reference to the form groups (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object | list of objects
    *
    * Example of usage:
    * see method Http/Controllers/Admin/FormController.update()
    */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }


    /**
    * Description:
    * reference to the form type (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object
    *
    * Example of usage:
    * object | list of objects
    *
    * Example of usage:
    * TOADD
    */
    public function types()
    {
        return $this->hasOne(FormType::class, 'id', 'form_type_id')->withDefault();
    }


    /**
    * Description:
    * Is form completed?
    * Only completed forms can by published
    *
    * List of parameters:
    * - none
    *
    * Return:
    * - boolean
    *
    * Example of usage:
    * see view resources/views/admin/form/index.blade.php
    */
    public function completed()
    {
        $completed = true;
        // if ($this->groups()->count() == 0) $completed = false;
        if ($this->groups_count == 0) $completed = false;
        if ($this->form_type_id < 1) $completed = false;
        return $completed;
    }


    /**
    * Description:
    * Is form active?
    *
    * List of parameters:
    * - none
    *
    * Return:
    * - boolean
    *
    * Example of usage:
    * see view resources/views/admin/form/index.blade.php
    */
    public function active()
    {
        $active = true;
        if (!$this->completed()) $active = false;
        if ($this->draft == 1) $active = false;
        if ($this->is_trash == 1) $active = false;

        return $active;
    }


    /**
    * Description:
    * Is form alias unique?
    *
    * List of parameters:
    * - none
    *
    * Return:
    * - boolean
    *
    * Example of usage:
    * see view resources/views/admin/form/index.blade.php
    */
    public function notUniqueAlias()
    {
        $notUnique = false;
        $alias = $this->parseFormConfig($this->config)['alias'];

        $counts = array_count_values($alias);
        foreach ($counts as $name => $count) {
            if ($count > 1) $notUnique = true;
        }
        return $notUnique;
    }


    /**
    * Description:
    * get form type name (Laravel Accessor)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * string
    *
    * Example of usage:
    * see resources/views/admin/response.blade.php
    */
    public function getTypeAttribute()
    {
        return $this->types->name;
    }


    /**
    * Description:
    * reference to applications (submittions) made with this form definition (Object-Relational Mapper)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * object | list of objects
    *
    * Example of usage:
    *
    */
    public function apps()
    {
        return $this->hasMany(Application::class, 'form_id', 'id');
    }


    /**
    * Description:
    * are there any submissions made for this form definition?
    *
    * List of parameters:
    * - none
    *
    * Return:
    * boolean
    *
    * Example of usage:
    * see resources/views/admin/form/email.blade.php
    */
    public function getHasAppsAttribute()
    {
        return $this->apps_count > 0 ? true : false;
    }


    /**
    * Description:
    * get form groups for this form definition
    *
    * List of parameters:
    * - none
    *
    * Return:
    * array
    *
    * Example of usage:
    * see resources/views/admin/form/email.blade.php
    */
    public function getFieldsAttribute()
    {
        if (!$this->config) return [];

        return $this->parseFormConfig($this->config)['groups'];
    }


    /**
    * Description:
    * get the list of static form groups with nested fields
    *
    * List of parameters:
    * - none
    *
    * Return:
    * array
    *
    * Example of usage:
    * see resources/views/admin/form/setting.blade.php
    */
    public function staticFields()
    {
        if (!$this->config) return [];

        return $this->parseFormStaticSections($this->config);
    }


    /**
    * Description:
    * get fields aliases
    *
    * List of parameters:
    * - none
    *
    * Return:
    * array
    *
    * Example of usage:
    * see resources/views/admin/form/setting.blade.php
    */
    public function getFieldsAlias()
    {
        if (!$this->config) return [];

        return $this->parseFormConfig($this->config)['full'];
    }


    /**
    * Description:
    * get fields meta-data and fields values
    * 
    * List of parameters:
    * - none
    *
    * Example of usage:
    * see method Http/Controllers/Admin/AjaxController.status()
    */
    public function getFieldsData()
    {
        $fieldsData = $this->parseFormConfig($this->config)['fields'];
        $result = [];
        foreach($fieldsData as $fKey => $fValue) {
            $result[strval(preg_replace("/[^0-9]/", '', $fKey))] = [
                'label' => $fValue['label'],
                'alias' => $fValue['alias'],
                'control_type' => $fValue['control_type'],
                'section' => $fValue['section'],
            ];
        }
        return $result;
    }


    /** 
    * Description:
    *  update alias value in Form config (json)
    *
    * List of parameters:
    * - $user : string
    *
    * Return:
    * null
    *
    * see method Http/Controllers/Admin/FormController.alias()
    */
    public function updateAlias($alias)
    {
        $this->config = $this->updateConfigAlias($this->config, $alias);
        $this->save();
        return;
    }

}
