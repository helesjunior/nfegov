<?php

namespace App\Http\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;

trait CommonColumns
{

    protected function addColumnEstado($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'estado_id',
            'label' => 'Estado',
            'type' => 'select',
            'model' => 'App\Models\Estado',
            'entity' => 'estado',
            'attribute' => 'nome',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('estado', function ($q) use ($column, $searchTerm) {
                    $q->where(
                        'nome',
                        'iLike',
                        '%' . $searchTerm . '%'
                    );
                });
            }
        ]);
    }

    protected function addColumnMunicipio($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'municipio_id',
            'label' => 'Município',
            'type' => 'select',
            'model' => 'App\Models\municipio',
            'entity' => 'municipio',
            'attribute' => 'nome',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('municipio', function ($q) use ($column, $searchTerm) {
                    $q->where(
                        'nome',
                        'iLike',
                        '%' . $searchTerm . '%'
                    );
                });
            }
        ]);
    }

    protected function addColumnCodigoUnidade(): void
    {
        CRUD::addColumn([
            'name' => 'codigo_unidade',
            'label' => 'Código Unidade',
            'type' => 'number',
            'thousands_sep' => '',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere(
                    'codigo_unidade',
                    'iLike',
                    '%' . $searchTerm . '%'
                );
            }
        ]);
    }

    protected function addColumnCnpj($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'cnpj',
            'label' => 'CNPJ',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnEndereco($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'endereco',
            'label' => 'Endereço',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnEnderecoNumero($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'endereco_numero',
            'label' => 'Número',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnEmail($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'email',
            'label' => 'E-mail',
            'type' => 'email',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnBairro($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'bairro',
            'label' => 'Bairro',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnCep($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'cep',
            'label' => 'Cep',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnTelefone($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'cep',
            'label' => 'Cep',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnCnae($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'cep',
            'label' => 'Cep',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnIe($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'ie',
            'label' => 'IE',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnIm($table = false, $modal = true, $show = true, $export = true)
    {
        CRUD::addColumn([
            'name' => 'im',
            'label' => 'IM',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnNomeResumido(): void
    {
        CRUD::addColumn([
            'name' => 'nome_resumido',
            'label' => 'Nome Resumido',
            'type' => 'text',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere(
                    'nome_resumido',
                    'iLike',
                    '%' . $searchTerm . '%'
                );
            }
        ]);
    }

    protected function addColumnNome($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'nome',
            'label' => 'Nome',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere(
                    'nome',
                    'iLike',
                    '%' . $searchTerm . '%'
                );
            }
        ]);
    }

    protected function addColumnCreatedAt($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Criado em',
            'type' => 'datetime',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnGetUnidade($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'unidade',
            'label' => 'Unidade',
            'type' => 'model_function',
            'function_name' => 'getUnidade',
//            'limit' => 1000,
            'orderable' => true,
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere('unidades.codigo_unidade', 'like', "%" . strtoupper($searchTerm) . "%");
                $query->orWhere('unidades.nome_resumido', 'like', "%" . strtoupper($searchTerm) . "%");
                $query->orWhere('unidades.nome', 'like', "%" . strtoupper($searchTerm) . "%");
            },
        ]);

    }

    protected function addColumnGetFornecedorCnpj($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'fornecedor_cnpj',
            'label' => 'Fornecedor CNPJ',
            'type' => 'model_function',
            'function_name' => 'getFornecedorCnpj',
//            'limit' => 1000,
            'orderable' => true,
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere('fornecedores.cnpj', 'like', "%" . strtoupper($searchTerm) . "%");
            },
        ]);

    }

    protected function addColumnGetFornecedorNome($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'fornecedor_nome',
            'label' => 'Fornecedor Nome',
            'type' => 'model_function',
            'function_name' => 'getFornecedorNome',
            'limit' => 30,
            'orderable' => true,
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere('fornecedores.nome', 'like', "%" . strtoupper($searchTerm) . "%");
            },
        ]);

    }

    protected function addColumnGetMunicipioFornecedor($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'municipio_fornecedor',
            'label' => 'Município Fornecedor',
            'type' => 'model_function',
            'function_name' => 'getMunicipioFornecedor',
//            'limit' => 1000,
            'orderable' => true,
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere('municipios.nome', 'ilike', "%" . $searchTerm . "%");
            },
        ]);

    }

    protected function addColumnUpdatedAt($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Alterado em',
            'type' => 'datetime',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnDataEmissao($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'data_emissao',
            'label' => 'Data Emissão',
            'type' => 'date',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnNumeroNfe($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'numero',
            'label' => 'Número',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnNaturezaOperacaoNfe($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'natureza_operacao',
            'label' => 'Natureza Operação',
            'type' => 'text',
            'limit' => 40,
            'escaped' => false,
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnSerieNfe($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'serie',
            'label' => 'Série',
            'type' => 'text',
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnChaveAcessoNfe($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'chave',
            'label' => 'Chave Acesso',
            'type' => 'text',
            'limit' => 44,
            'priority' => 1,
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

    protected function addColumnValorNfe($table = false, $modal = true, $show = true, $export = true): void
    {
        CRUD::addColumn([
            'name' => 'valor',
            'label' => 'Valor (R$)',
            'type' => 'number',
//            'prefix' => 'R$',
            'dec_point' => ',',
            'thousands_sep' => '.',
            'decimals' => 2,
            'visibleInTable' => $table,
            'visibleInModal' => $modal,
            'visibleInShow' => $show,
            'visibleInExport' => $export
        ]);
    }

}
