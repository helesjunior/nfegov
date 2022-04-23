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
        $unidade = Unidade::where('codigo_unidade', '321654')
            ->first();

        $this->downloadNfePorChave($unidade,'53220407296540000103550010000115381852835898');
//        $this->consultaNfePorChave($unidade,'53220407296540000103550010000115381852835898');
//        $this->consultaSefazDistDFe($unidade);
//        $this->decode();
    }

}
