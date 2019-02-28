<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\Revisionable;

/**
 * Class Employee.
 *
 * @package namespace App\Entities;
 */
class Employee extends Revisionable implements Transformable
{
    use TransformableTrait;

    protected $connection = 'tenant';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 9999999; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCreationsEnabled = true;
    protected $dontKeepRevisionOf = [];
    #protected $revisionFormattedFields = array('title'  => 'string:<strong>%s</strong>', 'public' => 'boolean:No|Yes', 'deleted_at' => 'isEmpty:Active|Deleted');
    protected $revisionFormattedFieldNames = [
        'cpfcnpj' => 'CPF/CNPJ',
        'code' => 'Matrícula',
        'name' => 'Nome',
        'address' => 'Endereço',
        'building' => 'Nr predial',
        'building_comments' => 'Complemento',
        'neighborhood' => 'Bairro',
        'zip_code' => 'CEP',
        'city' => 'Cidade',
        'state' => 'UF',
        'phone' => 'Telefone',
        'mobile' => 'Celular',
        'email' => 'e-mail', 
        'comments' => 'Observações',
        'lat' => 'Latitude',
        'lng' => 'Longetude',
        'deleted_at' => 'Excluído'
    ];
    protected $revisionNullString = 'nada';
    protected $revisionUnknownString = 'desconhecido';

    public function identifiableName() 
    {
        return $this->name;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cpfcnpj',
        'code',
        'name',
        'address',
        'building',
        'building_comments',
        'zip_code',
        'neighborhood',
        'city',
        'state',
        'phone',
        'mobile',
        'email',
        'comments',
    ];

}
