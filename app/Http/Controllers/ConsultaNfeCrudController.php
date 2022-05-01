<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaNfeRequest;
use App\Http\Traits\CommonColumns;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use function config;

/**
 * Class ConsultaNfeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ConsultaNfeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use CommonColumns;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Nfe::class);
        CRUD::setRoute('/nfes');
        CRUD::setEntityNameStrings('consulta nfe', 'consulta NFes');

        CRUD::addClause('select', 'nfes.*');
        CRUD::addClause('join', 'nsus', 'nsus.id', '=', 'nfes.nsu_id');
        CRUD::addClause('join', 'unidades', 'unidades.id', '=', 'nsus.unidade_id');
        CRUD::addClause('join', 'fornecedores', 'fornecedores.id', '=', 'nfes.fornecedor_id');
        CRUD::addClause('join', 'municipios', 'municipios.id', '=', 'fornecedores.municipio_id');

        $this->data['breadcrumbs'] = [
           "Consulta NFes" => false,
        ];
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->setupShowOperation();
        $this->crud->enableExportButtons();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->denyAccess('create');
        $this->crud->denyAccess('update');
        $this->crud->denyAccess('delete');
        $this->crud->addButtonFromView('line', 'emitirnfe', 'emitirnfe', 'beginning');
//        $this->crud->addButtonFromView('line', 'nfeitens', 'nfeitens', 'end');

        $this->addColumnGetUnidade(true);
        $this->addColumnGetFornecedorCnpj(true);
        $this->addColumnGetFornecedorNome(true);
        $this->addColumnGetMunicipioFornecedor();
        $this->addColumnDataEmissao(true);
        $this->addColumnNumeroNfe(true);
        $this->addColumnSerieNfe();
        $this->addColumnValorNfe(true);
        $this->addColumnNaturezaOperacaoNfe();
        $this->addColumnChaveAcessoNfe(true);
        $this->addColumnCreatedAt();
        $this->addColumnUpdatedAt();

    }


    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ConsultaNfeRequest::class);



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
