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

}
