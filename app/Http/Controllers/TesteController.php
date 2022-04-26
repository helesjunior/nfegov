<?php

namespace App\Http\Controllers;

use App\Http\Traits\NfeOrg;
use App\Models\Unidade;
use Illuminate\Http\Request;

class TesteController extends Controller
{
    use NfeOrg;

    public function teste()
    {
//        $this->emitirDanfePdf();
        $unidade = Unidade::where('codigo_unidade', '110062')
//        $unidade = Unidade::where('codigo_unidade', '110621')
            ->first();

        $this->downloadNfePorChave($unidade,'53220400949483000175550010000049611930119437');
//        $this->consultaNfePorChave($unidade,'53220400949483000175550010000049611930119437');
//        $this->confirmaOperacaoNfePorChave($unidade,'53220400949483000175550010000049611930119437');
//        $this->consultaSefazDistDFe($unidade);
//        $this->decode();
    }

}
