<?php

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
     * Search forms
     */
    static function search($search = false, $trash = false, $draft = false, $order = 'ASC')
    {
        $forms = Form::Where('title','LIKE', '%'.$search.'%')
            ->with('types', 'groups', 'apps')
            ->withCount(['groups', 'apps'])
            ;

        if ($trash !== false) {
            $forms->where('is_trash', $trash);
        }

        if ($draft !== false) {
            $forms->where('draft', $draft);
        }

        return $forms;
    }

    public function email($type = false)
    {
        return $this->emails()->where('type', $type)->first();
    }

    public function emails()
    {
        return $this->hasMany(FormEmail::class, 'form_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function types()
    {
        return $this->hasOne(FormType::class, 'id', 'form_type_id')->withDefault();
    }

    public function completed()
    {
        $completed = true;
        // if ($this->groups()->count() == 0) $completed = false;
        if ($this->groups_count == 0) $completed = false;
        if ($this->form_type_id < 1) $completed = false;
        return $completed;
    }

    public function active()
    {
        $active = true;
        if (!$this->completed()) $active = false;
        if ($this->draft == 1) $active = false;
        if ($this->is_trash == 1) $active = false;

        return $active;
    }

    public function getTypeAttribute()
    {
        return $this->types->name;
    }

    public function apps()
    {
        return $this->hasMany(Application::class, 'form_id', 'id');
    }

    public function getHasAppsAttribute()
    {
        return $this->apps->count() > 0 ? true : false;
    }

    public function getFieldsAttribute()
    {
        if (!$this->config) return false;

        return $this->parseFormConfig($this->config)['groups'];
    }

	public function getFieldsData()
	{
		$fieldsData = $this->parseFormConfig($this->config)['fields'];
		$result = [];
		foreach($fieldsData as $fKey => $fValue) {
			$result[strval(preg_replace("/[^0-9]/", '', $fKey))] = [
				'label' => $fValue['label'],
				'control_type' => $fValue['control_type'],
			];
		}
		return $result;
	}

}
