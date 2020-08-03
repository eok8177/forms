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
    static function search($search, $trash = 0, $order = 'ASC')
    {
        $forms = Form::Where('title','LIKE', '%'.$search.'%')->with('types', 'groups');

        return $forms->where('is_trash', $trash);
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
        return $this->hasOne(FormType::class, 'id', 'form_type_id');
    }

    public function active()
    {
        $active = true;
        if ($this->groups()->exists()) $active = false;
        if ($this->types()->exists()) $active = false;
        if ($this->draft == 1) $active = false;
        if ($this->is_trash == 1) $active = false;

        return $active;
    }

    public function completed()
    {
        $completed = true;
        if (!$this->groups()->exists()) $completed = false;
        if (!$this->types()->exists()) $completed = false;
        return $completed;
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
        $apps = $this->hasMany(Application::class, 'form_id', 'id');
        return $apps->count() > 0 ? true : false;
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

    static function selectAppsList()
    {
        $forms = Application::select('form_id')->distinct()->pluck('form_id')->toArray();

        return [0 =>'All Forms'] + Form::whereIn('id',$forms)->pluck('title', 'id')->all();
    }


}
