<?php

namespace App\Http\Controllers;

use App\Http\Traits\NfeOrg;
use Illuminate\Http\Request;

class TesteController extends Controller
{
    use NfeOrg;

    public function teste()
    {
        $this->emitirDanfePdf();
    }

}
