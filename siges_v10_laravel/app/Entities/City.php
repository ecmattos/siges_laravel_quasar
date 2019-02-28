<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\Revisionable;

/**
 * Class City.
 *
 * @package namespace App\Entities;
 */
class City extends Revisionable implements Transformable
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
    protected $revisionFormattedFieldNames = [
        'state_id' => 'UF', 
        'code' => 'Código', 
        'description' => 'Descrição',
        'region_id' => 'Região', 
        'deleted_at' => 'Excluído'
    ];
    protected $revisionNullString = 'nada';
    protected $revisionUnknownString = 'desconhecido';

    public function identifiableName() 
    {
        return $this->description;
    }

    protected $fillable = [
    	'state_id',
    	'description',
        'region_id'
    ];

    public function state()
    {
        return $this->belongsTo('App\Entities\State'); 
    }

    public function region()
    {
        return $this->belongsTo('App\Entities\Region'); 
    }

    public function members()
    {
        return $this->hasMany('App\Entities\Member'); 
    }

    public function partners()
    {
        return $this->hasMany('App\Entities\Partner');
    }

    public function affiliated_societies()
    {
        return $this->hasMany('App\Entities\AffiliatedSociety'); 
    }

    public function management_units()
    {
        return $this->hasMany('App\Entities\ManagementUnit'); 
    }

    public function meetings()
    {
        return $this->hasMany('App\Entities\Meeting'); 
    }
}

