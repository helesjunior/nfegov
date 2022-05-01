<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Nfe extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'nfes';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function inserirOuAtualizarNfe(array $dados)
    {
        $chave = ['chave' => $dados['chave']];
        unset($dados['chave']);
        $nfe = Nfe::updateOrCreate(
            $chave,
            $dados
        );

        return $nfe;
    }

    public function getUnidade()
    {
        $unidade = Unidade::find($this->nsu->unidade_id);
        return $unidade->codigo_unidade . ' - ' . $unidade->nome_resumido;
    }

    public function getFornecedorCnpj()
    {
        $fornecedor = Fornecedor::find($this->fornecedor_id);
        return $fornecedor->cnpj;
    }

    public function getFornecedorNome()
    {
        $fornecedor = Fornecedor::find($this->fornecedor_id);
        return $fornecedor->nome;
    }

    public function getMunicipioFornecedor()
    {
        $fornecedor = Fornecedor::find($this->fornecedor_id);
        return $fornecedor->municipio->nome;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function nsu()
    {
        return $this->belongsTo(Nsu::class, 'nsu_id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    public function itens()
    {
        return $this->hasMany(NfeItem::class, 'nfe_id');
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
}
