<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \NFePHP\Common\Certificate;
use \NFePHP\MDFe\Common\Standardize;
use \NFePHP\MDFe\Tools;

class Teste extends Controller
{

    public function index()
    {
        $config = [
            "atualizacao" => date('Y-m-d H:i:s'),
            "tpAmb" => 2,
            "razaosocial" => 'FÁBRICA DE SOFTWARE MATRIZ',
            "cnpj" => '',
            "ie" => '',
            "siglaUF" => 'PR',
            "versao" => '3.00'
        ];

        try {
            $certificate = Certificate::readPfx(
                'D:\junior\Dropbox\Compartilhada Gleice\Gleice Silva - MEI\Certificado Digital\CNPJ\30135801000125_000001010658674.pfx',
                'Hrsj0808'
            );

            $tools = new Tools(json_encode($config), $certificate);

            $chave = '41190822545265000108580260000000081326846774';
            $resp = $tools->sefazConsultaChave($chave);

            $st = new Standardize();
            $std = $st->toStd($resp);

            echo '<pre>';
            print_r($std);
            echo "</pre>";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
