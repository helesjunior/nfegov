<?php

namespace App\Http\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;

trait CommonColumns
{

    protected function addColumnEstado(): void
    {
        CRUD::addColumn([
            'name' => 'estado_id',
            'label' => 'Estado',
            'type' => 'select',
            'model' => 'App\Models\Estado',
            'entity' => 'estado',
            'attribute' => 'nome',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true,
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

    protected function addColumnMunicipio(): void
    {
        CRUD::addColumn([
            'name' => 'municipio_id',
            'label' => 'Município',
            'type' => 'select',
            'model' => 'App\Models\municipio',
            'entity' => 'municipio',
            'attribute' => 'nome',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true,
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

    protected function addColumnCnpj()
    {
        CRUD::addColumn([
            'name' => 'cnpj',
            'label' => 'CNPJ',
            'type' => 'text',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true
        ]);
    }

    protected function addColumnIe()
    {
        CRUD::addColumn([
            'name' => 'ie',
            'label' => 'IE',
            'type' => 'text',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true
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

    protected function addColumnNome(): void
    {
        CRUD::addColumn([
            'name' => 'nome',
            'label' => 'Nome',
            'type' => 'text',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere(
                    'nome',
                    'iLike',
                    '%' . $searchTerm . '%'
                );
            }
        ]);
    }

    protected function addColumnCreatedAt(): void
    {
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Criado em',
            'type' => 'datetime',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true
        ]);
    }

    protected function addColumnUpdatedAt(): void
    {
        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Alterado em',
            'type' => 'datetime',
            'visibleInTable' => true,
            'visibleInModal' => true,
            'visibleInShow' => true,
            'visibleInExport' => true
        ]);
    }

}
