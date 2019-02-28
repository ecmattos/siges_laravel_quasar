<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\Revisionable;

/**
 * Class Region.
 *
 * @package namespace App\Entities;
 */
class Region extends Revisionable implements Transformable
{
    use TransformableTrait;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 9999999; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCreationsEnabled = true;
    protected $dontKeepRevisionOf = [];
    #protected $revisionFormattedFields = array('title'  => 'string:<strong>%s</strong>', 'public' => 'boolean:No|Yes', 'deleted_at' => 'isEmpty:Active|Deleted');
    protected $revisionFormattedFieldNames = ['code' => 'Código', 'description' => 'Descrição', 'deleted_at' => 'Excluído'];

    public function identifiableName() 
    {
        return $this->description;
    }

    protected $fillable = [
    	'code',
    	'description'
    ];

    public function cities()
    {
        return $this->hasMany('App\Entities\City');   
    }

    public function members()
    {
        return $this->hasManyThrough('App\Entities\Member','App\Entities\City');
    }

    public function partners()
    {
        return $this->hasManyThrough('App\Entities\Partner','App\Entities\City');
    }
}

