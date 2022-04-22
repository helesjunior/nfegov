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
        $unidade = Unidade::where('codigo_unidade', '110161')
            ->first();

        $this->consulta($unidade);
    }

}
