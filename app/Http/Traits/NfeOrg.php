<?php

/**
 * Trait para integração com pacote NFePHP.
 *
 * @author Heles Resende S. Júnior <helesjunior@gmail.com>
 */

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
use phpDocumentor\Reflection\Types\This;



trait NfeOrg
{

    /**
     * Emissão da NFe em PDF.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function emitirDanfePdf($xml)
    {
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
            $danfe->creditsIntegratorFooter('by NFeGov (https://github.com/helesjunior/nfegov)', false);
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
            abort('500', $e->getMessage());
        }

    }

    /**
     * Consulta NFe por Chave de Acesso.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function consultaNfePorChave(Unidade $unidade, $chave)
    {
        $config = $this->montaConfig($unidade);

        try {
            $certificate = $this->buscaCertificado($unidade);

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

            return $json;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Confirma Operação NFe por Chave de Acesso.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function confirmaOperacaoNfePorChave(Unidade $unidade, $chave, $evento_op)
    {
        $config = $this->montaConfig($unidade);

        try {
            $certificate = $this->buscaCertificado($unidade);

            $tools = new Tools(json_encode($config), $certificate);

            $tools->model('55');

            $tpEvento = $evento_op; //ciencia da operação
            $xJust = ''; //a ciencia não requer justificativa
            $nSeqEvento = 1; //a ciencia em geral será numero inicial de uma sequencia para essa nota e evento

            $response = $tools->sefazManifesta($chave, $tpEvento, $xJust, $nSeqEvento);

            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário,
            //      quando houver a necessidade de protocolos
//            $stdCl = new Standardize($response);
//            //nesse caso $std irá conter uma representação em stdClass do XML
//            $std = $stdCl->toStd();
//            //nesse caso o $arr irá conter uma representação em array do XML
//            $arr = $stdCl->toArray();
//            //nesse caso o $json irá conter uma representação em JSON do XML
//            $json = $stdCl->toJson();

            return true;

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Realiza Download da NFe por Chave de Acesso.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function downloadNfePorChave(Unidade $unidade, $chave)
    {
        $config = $this->montaConfig($unidade);

        try {
            $certificate = $this->buscaCertificado($unidade);

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

    /**
     * Consulta NFe´s por CNPJ.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function consultaSefazDistDFe(Unidade $unidade)
    {
        $config = $this->montaConfig($unidade);
        try {
            $certificate = $this->buscaCertificado($unidade);

            $tools = new Tools(json_encode($config), $certificate);

            //só funciona para o modelo 55
            $tools->model('55');
            //este serviço somente opera em ambiente de produção
            $tools->setEnvironment(1);

            $ultNSU = Nsu::where('unidade_id', $unidade->id)->latest()->first()->ultimo_nsu;
            $maxNSU = $ultNSU;
            $loopLimit = ($ultNSU == 0) ? 10 : 2;
            $iCount = 0;

            while ($ultNSU <= $maxNSU) {
                $iCount++;
                if ($iCount >= $loopLimit) {
                    break;
                }
                try {
                    $resp = $tools->sefazDistDFe($ultNSU);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    break;
                }

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

                if ($cStat == '656') {
                    //656 - Consumo Indevido, a SEFAZ bloqueou o seu acesso por uma hora pois as regras de consultas não foram observadas
                    break;
                }
                $nsu = new Nsu();
                $nsu = $nsu->inserirUltimoNsu(intval($ultNSU), $unidade, $resp);

//                if($cStat == '137'){
//                    137 - Nenhum documento localizado, a SEFAZ está te informando para consultar novamente após uma hora a contar desse momento
//                    break;
//                }

                if (empty($lote)) {
                    continue;
                }
                $docs = $lote->getElementsByTagName('docZip');
                foreach ($docs as $doc) {
                    $content = '';
                    $numnsu = $doc->getAttribute('NSU');
                    $schema = $doc->getAttribute('schema');
                    $tipo = substr($schema, 0, 6);
                    if ($tipo == 'resNFe') {
                        $xml = $this->decodeDoczip($doc->nodeValue);
                        $stz = new Standardize($xml);
                        $std = $stz->toStd();
                        if (isset($std->chNFe)) {
                            $content = $this->downloadNfePorChave($unidade, $std->chNFe);
                        }

                    }
                    if ($tipo == 'procNF') {
                        $content = $this->decodeDoczip($doc->nodeValue);
                    }

                    $stz = new Standardize($content);
                    $content_teste = $stz->toStd();

                    if (isset($content_teste->NFe)) {
                        $this->lerXmlNfe($content, $nsu);
                    }

                    if (isset($content_teste->chNFe)) {
                        $this->confirmaOperacaoNfePorChave($unidade, $content_teste->chNFe, '210210');
                    }
                }
                if ($ultNSU == $maxNSU) {
                    break;
                }
                sleep(2);
            }
            return true;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Consulta Status Serviço.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function status(Unidade $unidade)
    {
        $config = $this->montaConfig($unidade);

        try {
            $certificate = $this->buscaCertificado($unidade);

            $tools = new Tools(json_encode($config), $certificate);

            $resp = $tools->sefazStatus();

            $st = new Standardize();
            $std = $st->toStd($resp);

            return $std;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Decodifica arquvo.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function decodeDoczip($code)
    {
        return gzdecode(base64_decode($code));
    }

    /**
     * Leitura XML.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
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

    /**
     * Busca Itens da NFe.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
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

    /**
     * Busca Dados da NFe.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
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

    /**
     * Busca dados Fornecedor.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function getFornecedor($dados)
    {
        $municipio = Municipio::where('codigo_ibge', $dados->enderEmit->cMun)
            ->first();

        return [
            'cnpj' => $dados->CNPJ,
            'ie' => @$dados->IE,
            'im' => @$dados->IM,
            'nome' => strtoupper($dados->xNome),
            'endereco' => strtoupper($dados->enderEmit->xLgr),
            'endereco_numero' => @$dados->enderEmit->nro,
            'bairro' => @strtoupper($dados->enderEmit->xBairro),
            'estado_id' => $municipio->estado->id,
            'municipio_id' => $municipio->id,
            'cep' => @$dados->enderEmit->CEP,
            'telefone' => @$dados->enderEmit->fone,
            'cnae' => @$dados->CNAE,
        ];
    }

    /**
     * Monta array configuração.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function montaConfig(Unidade $unidade)
    {
        return [
            "atualizacao" => date('Y-m-d H:i:s'),
            "tpAmb" => 1,
            "razaosocial" => $unidade->nome,
            "cnpj" => $unidade->cnpj,
            "ie" => $unidade->ie,
            "siglaUF" => $unidade->estado->sigla,
            "schemes" => "PL_009_V4",
            "versao" => '4.00'
        ];
    }

    /**
     * Busca certificado por Unidade.
     *
     * @category NFeGov
     * @package App\Http\Traits\NfeOrg
     * @copyright 2022~2050 NFeGov
     * @license MIT License. <https://opensource.org/licenses/MIT>
     * @author Heles Resende S. Júnior <helesjunior@gmail.com>
     */
    protected function buscaCertificado(Unidade $unidade)
    {
        $base = new Base();

        $content = file_get_contents(config('app.app_path') . config('app.app_path_cert') . $unidade->certificado_path);

        return Certificate::readPfx(
            $content,
            $base->decryptPass($unidade->certificado_pass)
        );
    }

}
