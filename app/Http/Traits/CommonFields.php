<?php

namespace App\Http\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;

trait CommonFields
{

    protected function addFieldEstadoCombo($tab = null)
    {
        CRUD::addField([
            'name' => 'estado_id',
            'label' => 'Estado',
            'type' => 'relationship',
            'model' => 'App\Models\Estado',
            'entity' => 'estado',
            'attribute' => 'nome',
            'placeholder' => 'Selecione o Estado',
            'allows_null' => true,
            'options' => (function (Builder $query) {
                return $query->orderBy('nome', 'ASC')
                    ->get();
            }),
            'tab' => $tab
        ]);
    }

    protected function addFieldMunicipioCombo($tab = null)
    {
        CRUD::addField([
            'name' => 'municipio_id',
            'label' => 'Município',
            'type' => 'relationship',
            'model' => 'App\Models\Municipio',
            'entity' => 'municipio',
            'ajax' => true,
            'attribute' => 'nome',
            'data_source' => url("admin/fetch/municipios"),
            'placeholder' => 'Selecione município',
            'dependencies' => ['estado_id'],
            'minimum_input_length' => 0,
            'allows_null' => true,
            'tab' => $tab
        ]);
    }

    protected function addFieldNomeText($tab = null, $upper = false)
    {
        CRUD::addField([
            'name' => 'nome',
            'label' => 'Nome',
            'type' => 'text',
            'attributes' => [
                'onkeyup' => $upper ? 'maiuscula(this)' : ''
            ],
            'tab' => $tab
        ]);
    }

    protected function addFieldNomeResumidoText($tab = null, $upper = false)
    {
        CRUD::addField([
            'name' => 'nome_resumido',
            'label' => 'Nome Resumido',
            'type' => 'text',
            'attributes' => [
                'onkeyup' => $upper ? 'maiuscula(this)' : '',
                'maxlength' => "19"
            ],
            'tab' => $tab
        ]);
    }

    protected function addFieldCnpj($tab = null)
    {
        CRUD::addField([
            'name' => 'cnpj',
            'label' => 'CNPJ',
            'type' => 'number',
            'tab' => $tab
        ]);
    }

    protected function addFieldIe($tab = null)
    {
        CRUD::addField([
            'name' => 'ie',
            'label' => 'IE',
            'type' => 'number',
            'tab' => $tab
        ]);
    }

    protected function addFieldIm($tab = null)
    {
        CRUD::addField([
            'name' => 'im',
            'label' => 'IM',
            'type' => 'number',
            'tab' => $tab
        ]);
    }

    protected function addFieldCodigoUnidadeNumber($tab = null)
    {
        CRUD::addField([
            'name' => 'codigo_unidade',
            'label' => 'Código Unidade',
            'type' => 'number',
            'tab' => $tab
        ]);
    }

    protected function addFieldCertificadoPassPassword($tab = null)
    {
        CRUD::addField([
            'name' => 'certificado_pass',
            'label' => 'Senha Certificado',
            'type' => 'password',
            'tab' => $tab
        ]);
    }

    protected function addFieldCertificadoPathUpload($tab = null)
    {
        CRUD::addField([   // Upload
            'name' => 'certificado_path',
            'label' => 'Certificado e-CNPJ A1',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'local',
            'tab' => $tab
        ]);
    }


}
