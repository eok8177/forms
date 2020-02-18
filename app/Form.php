<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Form extends Model
{
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
        $forms = Form::Where('title','LIKE', '%'.$search.'%');

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

        $fields = [];
        $config = json_decode($this->config, true);

        foreach ($config['sections'] as $section) {
            if (array_key_exists('rows', $section) && !$section['isDynamic']) {
              // get only not Dynamic fields
                foreach ($section['rows'] as $row) {
                    if (array_key_exists('controls', $row)) {
                        foreach ($row['controls'] as $control) {
                            $fields[$section['label']][$control['fieldName']] = $control['label'];
                        }
                    }
                }
            }
        }
        return $fields;
    }

    static function selectAppsList()
    {
        $forms = Application::select('form_id')->distinct()->pluck('form_id')->toArray();

        return [0 =>'All Forms'] + Form::whereIn('id',$forms)->pluck('title', 'id')->all();
    }


}
