<?php

namespace App\Http\Traits;

use App\Models\Unidade;
use App\Repositories\Base;
use NFePHP\Common\Certificate;
use NFePHP\DA\NFe\Danfe;
use NFePHP\NFe\Tools;

trait NfeOrg
{
    protected function emitirDanfePdf()
    {
        $xml = file_get_contents('C:/nfe.xml');
        $logo = '';
        try {

            $danfe = new Danfe($xml);
            $danfe->exibirTextoFatura = false;
            $danfe->exibirPIS = true;
            $danfe->exibirIcmsInterestadual = true;
            $danfe->exibirValorTributos = true;
            $danfe->descProdInfoComplemento = true;
            $danfe->setOcultarUnidadeTributavel(true);
            $danfe->obsContShow(true);
            $danfe->printParameters(
                $orientacao = 'P',
                $papel = 'A4',
                $margSup = 2,
                $margEsq = 2
            );
            $danfe->logoParameters($logo, $logoAlign = 'C', $mode_bw = false);
            $danfe->setDefaultFont($font = 'times');
            $danfe->setDefaultDecimalPlaces(4);
            $danfe->debugMode(false);
            $danfe->creditsIntegratorFooter('by NFeGov');
            //$danfe->epec('891180004131899', '14/08/2018 11:24:45'); //marca como autorizada por EPEC

            // Caso queira mudar a configuracao padrao de impressao
            /*  $this->printParameters( $orientacao = '', $papel = 'A4', $margSup = 2, $margEsq = 2 ); */
            // Caso queira sempre ocultar a unidade tributável
            /*  $this->setOcultarUnidadeTributavel(true); */
            //Informe o numero DPEC
            /*  $danfe->depecNumber('123456789'); */
            //Configura a posicao da logo
            /*  $danfe->logoParameters($logo, 'C', false);  */
            //Gera o PDF
            $pdf = $danfe->render($logo);
            header('Content-Type: application/pdf');
            echo $pdf;
        } catch (InvalidArgumentException $e) {
            echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
        }

    }

    protected function consulta(Unidade $unidade)
    {
        $base = new Base();

        $config = [
            "atualizacao" => date('Y-m-d H:i:s'),
            "tpAmb" => 1,
            "razaosocial" => $unidade->nome,
            "cnpj" => $unidade->cnpj,
            "ie" => $unidade->ie,
            "siglaUF" => $unidade->estado->sigla,
            "schemes" => "PL_009_V4",
            "versao" => '4.00'
        ];

        try {
            $content = file_get_contents(env('APP_PATH').env('APP_PATH_CERT').$unidade->certificado_path);

            $certificate = Certificate::readPfx(
                $content,
                $base->decryptPass($unidade->certificado_pass)
            );

            $tools = new Tools(json_encode($config), $certificate);

//            $chave = '53220207635498001422550010000013111642220619';
//            $resp = $tools->sefazConsultaChave($chave);
//
//            $st = new Standardize();
//            $std = $st->toStd($resp);
//
//            echo '<pre>';
//            print_r($std);
//            echo "</pre>";

            //só funciona para o modelo 55
            $tools->model('55');
//este serviço somente opera em ambiente de produção
            $tools->setEnvironment(1);

//este numero deverá vir do banco de dados nas proximas buscas para reduzir
//a quantidade de documentos, e para não baixar várias vezes as mesmas coisas.
            $ultNSU = 0;
            $maxNSU = $ultNSU;
            $loopLimit = 20; //mantenha o numero de consultas abaixo de 20, cada consulta retorna até 50 documentos por vez
            $iCount = 0;

//executa a busca de DFe em loop
            while ($ultNSU <= $maxNSU) {
                $iCount++;
                if ($iCount >= $loopLimit) {
                    //o limite de loops foi atingido pare de consultar
                    break;
                }
                try {
                    //executa a busca pelos documentos
                    $resp = $tools->sefazDistDFe($ultNSU);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    //pare de consultar e resolva o erro (pode ser que a SEFAZ esteja fora do ar)
                    break;
                }
                dump($resp);

                //extrair e salvar os retornos
                $dom = new \DOMDocument();
                $dom->loadXML($resp);
                $node = $dom->getElementsByTagName('retDistDFeInt')->item(0);
                $tpAmb = $node->getElementsByTagName('tpAmb')->item(0)->nodeValue;
                $verAplic = $node->getElementsByTagName('verAplic')->item(0)->nodeValue;
                $cStat = $node->getElementsByTagName('cStat')->item(0)->nodeValue;
                $xMotivo = $node->getElementsByTagName('xMotivo')->item(0)->nodeValue;
                $dhResp = $node->getElementsByTagName('dhResp')->item(0)->nodeValue;
                $ultNSU = $node->getElementsByTagName('ultNSU')->item(0)->nodeValue;
                $maxNSU = $node->getElementsByTagName('maxNSU')->item(0)->nodeValue;
                $lote = $node->getElementsByTagName('loteDistDFeInt')->item(0);

//                if (in_array($cStat, ['137', '656']) {
//
//                    //137 - Nenhum documento localizado, a SEFAZ está te informando para consultar novamente após uma hora a contar desse momento
//                    //656 - Consumo Indevido, a SEFAZ bloqueou o seu acesso por uma hora pois as regras de consultas não foram observadas
//                    //nesses dois casos pare as consultas imediatamente e retome apenas daqui a uma hora, pelo menos !!
//        break;
//            }
                if (empty($lote)) {
                    //lote vazio
                    continue;
                }
                //essas tags irão conter os documentos zipados
                $docs = $lote->getElementsByTagName('docZip');
                foreach ($docs as $doc) {
                    $numnsu = $doc->getAttribute('NSU');
                    $schema = $doc->getAttribute('schema');
                    //descompacta o documento e recupera o XML original
                    $content = gzdecode(base64_decode($doc->nodeValue));
                    //identifica o tipo de documento
                    $tipo = substr($schema, 0, 6);
                    //processar o conteudo do NSU, da forma que melhor lhe interessar
                    //esse processamento depende do seu aplicativo
                    dump($content);
                }
                if ($ultNSU == $maxNSU) {
                    //quando o numero máximo de NSU foi atingido não existem mais dados a buscar
                    //nesse caso a proxima busca deve ser no minimo após mais uma hora
                    break;
                }
                sleep(2);
            }

            dump('Finalizado!');

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function status()
    {
        $config = [
            "atualizacao" => date('Y-m-d H:i:s'),
            "tpAmb" => 1,
            "razaosocial" => env('RAZAOSOCIAL'),
            "cnpj" => env('CNPJ'),
            "ie" => env('IE'),
            "siglaUF" => env('SIGLAUF'),
            "versao" => '3.00'
        ];

        try {
            $content = file_get_contents(env('CERTIFICADO_DEV'));

            $certificate = Certificate::readPfx(
                $content,
                env('CERTIFICADO_PASS')
            );

            $tools = new Tools(json_encode($config), $certificate);

            $resp = $tools->sefazStatus();

            $st = new Standardize();
            $std = $st->toStd($resp);

            echo '<pre>';
            print_r($std);
            echo "</pre>";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function decode()
    {
        $code = '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';

        $content = gzdecode(base64_decode($code));

        dd($content);
    }
}
