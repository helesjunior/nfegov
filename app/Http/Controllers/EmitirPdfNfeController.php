<?php

namespace App\Http\Controllers;

use App\Http\Traits\NfeOrg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmitirPdfNfeController extends Controller
{
    use NfeOrg;

    public function index($chave_acesso)
    {
        $nfe = \App\Models\Nfe::where('chave', $chave_acesso)->first();

        if ($nfe) {
            return $this->emitirDanfePdf($nfe->xml);
        }

        abort('400', "Chave não encontrada ou Inválida!");
    }
}
