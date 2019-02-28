<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Notifications\Notifiable;

/**
 * Class Client.
 *
 * @package namespace App\Entities;
 */
class Client extends Model implements Transformable
{
    use TransformableTrait, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'verified',
        'code',
        'cpfcnpj',
        'name',
        'email',
        'domain',
        'database',
        'hostname',
        'username',
        'password',
        'code_verification'
    ];

    public function users()
    {
        return $this->hasMany('App\Entities\User');   
    }
}