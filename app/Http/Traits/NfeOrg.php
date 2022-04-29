<?php

namespace App\Http\Traits;

use App\Models\Fornecedor;
use App\Models\Municipio;
use App\Models\Nfe;
use App\Models\NfeItem;
use App\Models\Nsu;
use App\Models\Unidade;
use App\Repositories\Base;
use NFePHP\Common\Certificate;
use NFePHP\DA\NFe\Danfe;
use NFePHP\NFe\Common\Standardize;
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

    protected function consultaNfePorChave(Unidade $unidade, $chave)
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
            $content = file_get_contents(env('APP_PATH') . env('APP_PATH_CERT') . $unidade->certificado_path);

            $certificate = Certificate::readPfx(
                $content,
                $base->decryptPass($unidade->certificado_pass)
            );

            $tools = new Tools(json_encode($config), $certificate);

            $tools->model('55');

            $response = $tools->sefazConsultaChave($chave);

            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário,
            //      quando houver a necessidade de protocolos
            $stdCl = new Standardize($response);
            //nesse caso $std irá conter uma representação em stdClass do XML
            $std = $stdCl->toStd();
            //nesse caso o $arr irá conter uma representação em array do XML
            $arr = $stdCl->toArray();
            //nesse caso o $json irá conter uma representação em JSON do XML
            $json = $stdCl->toJson();
            dd($json);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function confirmaOperacaoNfePorChave(Unidade $unidade, $chave)
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
            $content = file_get_contents(env('APP_PATH') . env('APP_PATH_CERT') . $unidade->certificado_path);

            $certificate = Certificate::readPfx(
                $content,
                $base->decryptPass($unidade->certificado_pass)
            );

            $tools = new Tools(json_encode($config), $certificate);

            $tools->model('55');

            $tpEvento = '210200'; //ciencia da operação
            $xJust = ''; //a ciencia não requer justificativa
            $nSeqEvento = 1; //a ciencia em geral será numero inicial de uma sequencia para essa nota e evento

            $response = $tools->sefazManifesta($chave, $tpEvento, $xJust, $nSeqEvento);

            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário,
            //      quando houver a necessidade de protocolos
            $stdCl = new Standardize($response);
            //nesse caso $std irá conter uma representação em stdClass do XML
            $std = $stdCl->toStd();
            //nesse caso o $arr irá conter uma representação em array do XML
            $arr = $stdCl->toArray();
            //nesse caso o $json irá conter uma representação em JSON do XML
            $json = $stdCl->toJson();
            dd($json);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function downloadNfePorChave(Unidade $unidade, $chave)
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
            $content = file_get_contents(env('APP_PATH') . env('APP_PATH_CERT') . $unidade->certificado_path);

            $certificate = Certificate::readPfx(
                $content,
                $base->decryptPass($unidade->certificado_pass)
            );

            $tools = new Tools(json_encode($config), $certificate);
            $tools->model('55');

            $response = $tools->sefazDownload($chave);

            try {
                $stz = new Standardize($response);
                $std = $stz->toStd();
                if ($std->cStat != 138) {
                    die;
                }
                $zip = $std->loteDistDFeInt->docZip;
                return $this->decodeDoczip($zip);

            } catch (\Exception $e) {
                echo str_replace("\n", "<br/>", $e->getMessage());
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function consultaSefazDistDFe(Unidade $unidade)
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
            $content = file_get_contents(env('APP_PATH') . env('APP_PATH_CERT') . $unidade->certificado_path);

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
//            $ultNSU = 7639;

            $ultNSU = Nsu::where('unidade_id', $unidade->id)->latest()->first()->ultimo_nsu;
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

                if($cStat == '656'){
                    continue;
                }
                $nsu = new Nsu();
                $nsu = $nsu->inserirUltimoNsu(intval($ultNSU), $unidade, $resp);

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
//                    $content = gzdecode(base64_decode($doc->nodeValue));

                    //identifica o tipo de documento
                    $tipo = substr($schema, 0, 6);
                    //processar o conteudo do NSU, da forma que melhor lhe interessar
                    //esse processamento depende do seu aplicativo
                    if (substr($schema,0,6) == 'resNFe') {
                        $xml = $this->decodeDoczip($doc->nodeValue);
                        $stz = new Standardize($xml);
                        $std = $stz->toStd();
                        if(isset($std->chNFe)){
                            $content = $this->downloadNfePorChave($unidade,$std->chNFe);
                            $this->lerXmlNfe($content, $nsu);
                        }

                    }
                    if (substr($schema,0,7) == 'procNFe') {
                        $content = $this->decodeDoczip($doc->nodeValue);
                        $this->lerXmlNfe($content, $nsu);
                    }

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

    protected function decodeDoczip($code)
    {
        return gzdecode(base64_decode($code));
    }

    protected function lerXmlNfe($xml, Nsu $nsu)
    {
        $stz = new Standardize($xml);
        $std = $stz->toStd();

        //dados fornecedor
        $fornecedor = new Fornecedor();
        $fornecedor = $fornecedor->inserirOuAtulizadarFornecedor($this->getFornecedor($std->NFe->infNFe->emit));

        //dados
        $nfe = new Nfe();
        $nfe = $nfe->inserirOuAtualizarNfe($this->getDadosNfe($xml, $nsu, $fornecedor));

        //dados itens
        $nfeItens = new NfeItem();
        $nfeItens->inserirOuAtualizarNfeItens($this->getItensNfe($std->NFe->infNFe->det, $nfe));

        return $nfe;

    }

    protected function getItensNfe($dados, Nfe $nfe)
    {
        $retorno = [];
        $i = 1;
        if (is_array($dados)) {
            foreach ($dados as $dado) {
                $retorno[] = [
                    'nfe_id' => $nfe->id,
                    'sequencial' => $i,
                    'descricao' => strtoupper($dado->prod->xProd),
                    'cfop' => $dado->prod->CFOP,
                    'unidade_medida' => $dado->prod->uCom,
                    'quantidade' => $dado->prod->qCom,
                    'valor_unitario' => $dado->prod->vUnCom,
                    'valor_total' => $dado->prod->vProd,
                    'unidade_medida_tributado' => $dado->prod->uTrib,
                    'quantidade_tributado' => $dado->prod->qTrib,
                    'valor_unitario_tributado' => $dado->prod->vUnTrib,
                ];
                $i++;
            }
        } else {
            $retorno = [
                'nfe_id' => $nfe->id,
                'sequencial' => $i,
                'descricao' => $dados->prod->xProd,
                'cfop' => $dados->prod->CFOP,
                'unidade_medida' => $dados->prod->uCom,
                'quantidade' => $dados->prod->qCom,
                'valor_unitario' => $dados->prod->vUnCom,
                'valor_total' => $dados->prod->vProd,
                'unidade_medida_tributado' => $dados->prod->uTrib,
                'quantidade_tributado' => $dados->prod->qTrib,
                'valor_unitario_tributado' => $dados->prod->vUnTrib,
            ];;
        }
        return $retorno;
    }

    protected function getDadosNfe($xml, Nsu $nsu, Fornecedor $fornecedor)
    {
        $stz = new Standardize($xml);
        $nfe = $stz->toStd();

        return [
            'nsu_id' => $nsu->id,
            'fornecedor_id' => $fornecedor->id,
            'numero' => $nfe->NFe->infNFe->ide->nNF,
            'chave' => substr($nfe->NFe->infNFe->attributes->Id, 3, 44),
            'serie' => $nfe->NFe->infNFe->ide->serie,
            'data_emissao' => $nfe->NFe->infNFe->ide->dhEmi,
            'data_saida_entrada' => @$nfe->NFe->infNFe->ide->dhSaiEnt,
            'valor' => $nfe->NFe->infNFe->total->ICMSTot->vNF,
            'natureza_operacao' => strtoupper($nfe->NFe->infNFe->ide->natOp),
            'xml' => $xml,
        ];
    }

    protected function getFornecedor($dados)
    {
        $municipio = Municipio::where('codigo_ibge', $dados->enderEmit->cMun)
            ->first();

        return [
            'cnpj' => $dados->CNPJ,
            'ie' => @$dados->IE,
            'im' => @$dados->IM,
            'nome' => $dados->xNome,
            'endereco' => $dados->enderEmit->xLgr,
            'endereco_numero' => @$dados->enderEmit->nro,
            'bairro' => @$dados->enderEmit->xBairro,
            'estado_id' => $municipio->estado->id,
            'municipio_id' => $municipio->id,
            'cep' => @$dados->enderEmit->CEP,
            'telefone' => @$dados->enderEmit->fone,
            'cnae' => @$dados->CNAE,
        ];
    }


}
