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

    public function email()
    {
        return $this->hasOne(FormEmail::class, 'form_id');
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


}
