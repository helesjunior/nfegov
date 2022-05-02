<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnidadeRequest;
use App\Http\Traits\CommonColumns;
use App\Http\Traits\CommonFields;
use App\Http\Traits\CommonFilters;
use App\Models\Unidade;
use App\Repositories\Base;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UnidadeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UnidadeCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation { store as traitStore; }
    use UpdateOperation { update as traitUpdate; }
    use DeleteOperation;
    use ShowOperation;
    use CommonColumns;
    use CommonFields;
    use CommonFilters;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Unidade::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/unidade');
        CRUD::setEntityNameStrings('unidade', 'unidades');
        CRUD::orderBy('codigo_unidade', 'asc');
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

        $this->addColumnCodigoUnidade(true);
        $this->addColumnCnpj();
        $this->addColumnIe();
        $this->addColumnIm();
        $this->addColumnNomeResumido(true);
        $this->addColumnNome();
        $this->addColumnEstado();
        $this->addColumnMunicipio();
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
        CRUD::setValidation(UnidadeRequest::class);

        $this->addFieldCodigoUnidadeNumber();
        $this->addFieldCnpj();
        $this->addFieldIe();
        $this->addFieldIm();
        $this->addFieldNomeResumidoText(null,true);
        $this->addFieldNomeText(null,true);
        $this->addFieldEstadoCombo();
        $this->addFieldMunicipioCombo();
        $this->addFieldCertificadoPathUpload();
        $this->addFieldCertificadoPassPassword();

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

    public function store()
    {
        $base = new Base();
        $enc = $base->encryptPass($this->crud->getRequest()->request->get('certificado_pass'));
        $this->crud->getRequest()->request->set('certificado_pass',$enc);

        $response = $this->traitStore();

        return $response;
    }

    public function update()
    {
        $base = new Base();
        $enc = $base->encryptPass($this->crud->getRequest()->request->get('certificado_pass'));
        $this->crud->getRequest()->request->set('certificado_pass',$enc);

        $response = $this->traitUpdate();

        return $response;
    }

}
