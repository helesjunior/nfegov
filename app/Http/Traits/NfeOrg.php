<?php

namespace App\Http\Traits;

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

        }catch (\Exception $e) {
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
                    echo "Documento não retornado. [$std->cStat] $std->xMotivo";
                    die;
                }
                $zip = $std->loteDistDFeInt->docZip;
                $xml = gzdecode(base64_decode($zip));

                header('Content-type: text/xml; charset=UTF-8');
                echo $xml;

            } catch (\Exception $e) {
                echo str_replace("\n", "<br/>", $e->getMessage());
            }

        }catch (\Exception $e) {
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
        $code = 'H4sIAAAAAAAEAK06abPiyJF\/hWjvRtiB++lCHL1qwroRSAJ0gfjiEJIQAl0PBAJif\/xmlXhHz\/R4Zux9EU1lZmVl5V1V0FyxixenMuxc49M5KL9\/6b2Q5JfOLc+K8\/cv+7quvhFE0zQvVXmqg2yXnsMge0mL3cv2RMDaL2POVOI\/xQ8IWqJF37\/AyDI0TfbIAT3qsz0S\/iiSYVk0IJhimSE1ZOkhww5Hwy8\/agmionjMha4yZhmOQCMXmsr4jR9IgHFFUM+r8cKSbacjyR1btjxNnNsc0U5weRmNWZYj0Mid41MajymOaAGuAAlYC2BHwqK9nKdjmqTpr2TvKzl0qN43ZvCNJL+SDHxyRMsAfHaQykX9r1mfPFxdoW04Ao9glRSfa4Q\/IS40LoWigpXIL6DKE4d1Wl61CxEAOGx+bgkY4kLJG6MFMMAsn2\/bSQRwuxRMwsY+IQhNpKRFkOG932BEXZzi85jERAxyFeQMMhRobyAHwUGpNKboF+qFpAed\/+0wL8DwRkf2wCZxnoJJormYjn8MO0dgInczyzweawvbNTri3JAtUZt35I4loxjKpsOLc9nGodRsRzZ4DMumbKkawLoj8RzRyuBuSgD+xaKAhhEuLqL4JGMlbnpyGkNa8CBAnJtT13TmHYr5e8cmTOBHs1xxKsc2YGjkbmKVjXWnQ0G+YJi7CUF6giledWFzUectHlLrjYoj92PcYAn6FIBP0zWkKiZC8koKR6AcFuXFeECNhoMBDd5DGBcuAhRXkkVCMMzd8NCKASEtcVcW8bhPMWSv1x+hosAEjvhksyaD23v9fp8agFa9PkcAhdOMX1ENFCReHjMMxYxICkUHME60nDEKFQwgF4uMcJLi4DEkBaWHq5ei2R8jquqyJso4cHN3w0P4dO8jVFjFNt3fwmIbzkdYhj8PyNPRDvK\/o5kqiHX1\/48AQOEyvd6\/GYDRsNcfMKPRjwForYMa0mQMjnBBPZE2MENoNTQuh8+B+ZFqoBoK0myMHfjSuvUfqsFr+gvUC4oKmoUGg+VGcd0ptDrOv3+hvuDKjZA9aACRQ9tDcpFV7YTMm2NbNjoqeBOoCAVT0dyzc6IAGrzpOrIp8nNkOV5oigaSh\/84AmFcKMRFvOsQ4FFlvhizIwYlDgK5i1jmYxc2wAD3ij6haeC1GOGuboHGPkm+fIh9Erkr3rOdA+qH6s4p3f5CfUziLnjAO7aEVzy879kSQT4GfrVrOw3Rcsr62QgRhLsfbJ3mVXmuId2uQMW8zFO1N5zTFhpSsXgdj1BeYAgRTagj0XbwEYZGCHBLJPAKzbaXEIGrIH6YCzB35bP0dcw+1W8x7tpyv+39XPtbp0eop+fajk\/XMQXnKRT4BwFLsuL6syiE4uS17ef5gKCfFhiaK8K4qNNrOaZb3nccDGv1Wmg2\/mh1R7bjLoN8gEx8s7RCfOicwfzXJ4ZHjnhfTmBcnCua+T7+nuAnN5L9tvD6QXsDYeUnacQ79T3mcKHhI5yC+JLBQ1V8umh0PlcLtDPLkh3N49HJ1nGsucgjXoF3ZAtOrxfkqzdpqIDR5aCs0SmsiYaNU+6zCVdExRgGWhzaSVm8E1uMuyriwlVwp0EzH1i75tPUJ\/Rtzorz+PNki2OZb9KwXsjTWDPs6ieGYeB4oi30pFhx\/UHECdbW8kdRX5VTXMctE4ZAbpy0gmHkrqBoiFEMgMZaq6iG4MUTWTwxKb6W2RupRX6RUT9LgOv8UsNZgkgtxF3hnvZejujO9tt1T7wHDqd9jUOIi+xdwLPkflXiqL4+FSC0cmh+Vfz5Ugk58qT9ZskSH\/uCA599DmaQuczLCLE+MUx+Gk0NWykflHbW1vVx\/2MKoRzxLpd4Jmt9Copze7d+j987DFzP6bDcwoG+C0C1QoHPz9d+OOARCZx\/SpMx24NLJQ4Awn4ddR01wzceHRcqFhtdYJtCgk8S9QAMcZEXF+GPTsQUEAvT72IwL4ElEK2mVZDg83SBRnQXDpK3WzGiYDrapmW4os+PMwqRiLfFRNWKgFpPQwyg2yS0BmgTz9utZizmtjO3v3X+4z\/IAJDyV\/bvJPnff+tY\/9VhSAD\/5z+W6wVZeerwcAbe0jyIyk5UnjsoEy41AEXQKSAdOu0jsBOWxa485XGnirOgo8dpBx4Kgx5FUHQHUgkCUMbnbx1IxG8dlJedTpt43zo4FwGFZPvW6WP4Jzv\/9fy3t70B\/NaaiZj\/ik5JsBuOpjRMK3iP4i6Lr+\/E5xBY8bly4vB5lWUZimIGo\/YqS79fZcWyqANo+1YZQSrCxnGHz\/I4jYKOHZzq8pSW6G3w5Hre1ODNVP2zjkNQoPxntIv\/CYrX+\/hy\/gcUzPX8EpY5PJDfb2740khR9BCuTCOy936L\/Kwj0b6jx5ydJvCSvZx+9gpvmJfylBDo7kiQIwIYonOa\/OVLuyqGU3lX\/qllYlCUYESQpY+gTsvCiOt9GYEHEjC83uc\/E+NYSBJFWLL4FUR9Dale8ZXGTz6K\/YKuh+8m\/BFxv9TqdA6+nvcBhSVZ8S4+QSrFHdfSvn\/5y5\/9hmHMOag3oUQ9f4L\/nEZxcY2zsoqjr+c3w7Byf1Dc7\/uL+KyklCZwVv87nnv3WisCauoSj5dS+rqyzOlaz0elp9o14wxmLFXflfI7R3zm5Ih3bwP8kVCf4tkyrklmtSMUhy5W2nRmxf5Nn8z74r1PHgf3kZc\/Xje3u\/N6UZXIL2spmauuY16WkXP02U1PXklRoYeLchcz9WB6kPSL0ifS82JSa45lKIsBKw3PtyosL8WtZJtyfQw3zHKt1kZVjI49uVsb4ch8PefanpLk2WY2kbqqd78GUpBtzZ4mno2ZkjoqId6iZU3czUtXzw40n7FWMbmU3kA1GzHXRPVhCMxMi092zBwsfyLMThZ52hCR4Ovrg3MnR69anG6DY8yWmyKYF4cs2lznlWs9dveDFvDdk2Ly6knf+sxQ9GfNZZMzdjx9TReXIcke3aoeqNq5nJf7dden75UVBfdwSO75obVabyZLWprNIrWgyFvWFZrv31unf3I0N4vvbQTWLDmSgjpoITE+1ekOyhZOX0PTJkNHFIUoT\/hGE\/hEc+28S6\/L14mmDbZTKXFXUpiRjN512LKRlv50Vm60\/TU0+aWsC0u+iQ+ybvBHladcWdgb4jLTbvKDt4TE9AS+dMRjJrkiJYa58ghWzc088GQ7d3Z0z8x8ZppFqnIPVnKyUeXEzb3DZpWRvi2om5WVwbqzplpXTZ7e\/bVZbUW+1pSpujzIsSE0eF\/+ZnhL10gsOZvYniU4ijm1yF7iHjeiJocQq95acrS7IWk38yHfTCckDa9EtMcvaE2SyJaxPDfi0pe85VKVm6noHmTHEGS8l7g3ZrZrLnX3qY\/0Yb8oGKIl+zfZ4RetjaEjvumtZnvD8RuTx3J1+U45m5V536ytfZhne7BxD3ZlPu1VEfjByr3jZj3db0XhuL0Lb\/5LdFuwraN2Uw68++ZHyQN\/pEKmu+bclctk6cg35cF77\/MHmTUe4d14+DdD4hvDOTKGdWyU5qnLTaAD8PWWNq\/bfAM+9y4+Dfq6x8ZqeSSZFKauYnqOLUgOSSnu0Zw6d0EBnRUX\/SO9uScrMOc5mmwB3Zy6lKU4rtLisjefH3jGOBxp01k2rR78A3JQ0A68KSTH1\/0xVUcNKUBuKTwP76HlkEfzYjIDWObvvhBuLgubtbYD5ySMLopcuXPzlkhyKp+2yYLO7vRcWkyVqUhK1\/5+XemzvQAt5yRueubxtE3n+yE5j1J9Qll9RylscgC5lPgDx50Wlx0Tx+GuUcreLBuYLv\/YeIy4Fwbl3p6Vg2JCqutS1a9yVIf9ZVMPyb4knLtnUwsH5NW+l8p2f7joBDNfZ2JPH2yIdDfvXqzNQdkq\/GC3Pe4mykkVQmLWr+7n22HADs7UJu4\/3Op1oGTzoJE2D+mQNPFDvUvbi8TmajEXprlNOMI+0u7JoVbonsp4C5nPA7bwqu2VqaSHuneDunvZTRaLTTLSolW\/OJtkHdbH42w1NObDniUPc+d06026a9MIuyJ7JJXDw5ErfalJ\/JIXSmh+lCRCdfGNlEDMLXLBLycEBEPik3ViaGopJMlJSGRFWIZAtoX8IQq5xDOf6A3v+6dgYpGhVF51enQIGf6yUbMigDzfTsxqQ7MHyGsyWG0qn1aOW2a613PIO5tNw4MQ\/SCr3FjvspiIie7sMVhFUB\/KOaSzYpubWVhY1SbPDv7Kuoa5DHk7qvV8etehr4Tq6AH7Aj2D9dPcT0fCkrSgN2Tu0r05thvNUY+wHsYllKLUEIaojiOtWfqGEPCKSffqiBQZfb+8Fz3VkxfC7nq\/jGbUwFDIlpe3VoaybNzEV325gR4qnw05aazE12aNLwhLdwK01Tzfk9GE7+v3EVgS\/nGfpCPoEcIV7CWBXm3vgOda258s0hF4reElUTi3+E7Q1ApilRtKnHiB4OwzpYwmVjNPh1fwIKPn4C+Q5a9u0E8i8Jd3j9QsD1bmfqOO7r7NHrY0efELDfzmNVvGBH+PoD8PAd+kOqlIP\/ZZFvrRdGLc2UOYN43dF6alHKvW6rfste7R2iR\/x77r0jVliM8UeorhktnEyaDHHcMHrLtvwd6ax\/ZaYO8Z7K0SK7rDuXGBXnvdTjywwXss1aj2V9kZ7xXwPSHxEoeXJWHGw6uavBmOfIdeyBqH8GFKPjmXEuhJfg\/3pn\/5T0w03ldwvJtZojRLzzp6hu1BP5Q3gktBbzzKyfKo2O5x5JTCURVWgsEvDakUQIGf9MFSCN94JiXfk6Vf7xuhfj6xXbnt\/e91AvX5Kdea5c\/OaSlJ4HyfXUpqNNwIa8vdw02SaKIeMVvfnXw4GPjr6Txr\/NLlyfjSo6Nwe5\/1F6X5SqkCuV8IenoWp9ugtEp2pg+FTJzvQmJFyMFsRt4877pzrlqXol2lNnv+IAmm3ctVah5Xf06+Lqr4EHozN2DTXrdhppLgRtaSulrWdm6wTTVLRxdaXJzzySJ81W3TnlleVUTraFtHE9vKF5NTla31YULoqzKeq1uWSpd3P9WYozmaK2Q4VEbaXg68wyjhe6r\/OIo0u9cuRkAV+13uhz591spVTIfU6SSeLzd2VU3I5sGTEzjg+leiz9+N7ELfmPvUCtZDOxV7mzhjS\/k1Pix2KqWn1TG8e2t\/4Ga34zaY3Y96f+JfJGlyJ+iGXrGkuisH0bEkGKoOL4oUG69MwTZRftqoRu4IO0WtRnFFD2Z3+3U\/u5j0XYr7pMrSwevaKstEj8\/5RenG0NG8RbVeqmVEZ9Fjsu4KPSkxKcnsXauuvKTjPjMd7VVjVsJREbN5VcaT9aBWfPFgbWQvc5ba2Zh2nb1FPB6z3l2c6TuP6KYH0b02zMIhr\/K5v9b8zD833mynn3jR7m7sySresfXd0hXDow5Jn1A2Ujc9K0Q+uVaT1+woEnR3Ud2KqFztg9fUGl2djWD464EHt+BmHa7TW9+xjylFHgv68GhCfspG06JQRnZPJHeSXWaas2OYPiV6trLQusvVIj0uKoFOJoZvqKZ23lxW8Wp0OlaTK0f88rbaUtqbLPF+u\/249wKMH8HoPY1+Vf73f8YGZHEq61\/\/TAoi+SpLwzF0Pxt9aYQekxTTG+JfNtspLtwjNf7MU5Mj2jVctLficFuXv\/ypePiN6n\/8VPzk4QqsJIN3ImmqRwM04oiWzEUp9P\/sd95wTyYutOugHlNIfgtyN6PEX9HzF\/Q9xgN9r1J2LueyEwUdU\/kao9\/KyueX+O\/+Ip6+B+j5nwnG\/wfQcaxyViAAAA==';

        $content = gzdecode(base64_decode($code));

        dd($content);
    }
}
