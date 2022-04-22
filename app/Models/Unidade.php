<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Database\Seeders\MunicipiosSeeder;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'unidades';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'codigo_unidade',
        'cnpj',
        'ie',
        'nome_resumido',
        'nome',
        'estado_id',
        'municipio_id',
        'certificado_path',
        'certificado_pass',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setCertificadoPathAttribute($value)
    {
        $attribute_name = "certificado_path";
        $disk = "local";
        $destination_path = "certificados/".$this->codigo_unidade;

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }
}
