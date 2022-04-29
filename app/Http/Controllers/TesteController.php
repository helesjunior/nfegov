<?php

namespace App\Http\Controllers;

use App\Http\Traits\NfeOrg;
use App\Models\Nsu;
use App\Models\Unidade;
use Illuminate\Http\Request;
use NFePHP\NFe\Common\Standardize;

class TesteController extends Controller
{
    use NfeOrg;

    public function teste()
    {
        $unidade = Unidade::where('codigo_unidade', '110062')
            ->first();

        $xml = $this->decodeDoczip('H4sIAAAAAAAEAIVSXW+CQBD8K4Z3ub07vrNeYq022goErGl8Q0Al4cMAEe2v7ym2jX3py+3OZmZnMzms08adpYNzkZeNc26SkXJo26NDSNd1asfVqt4TBkDJx/ItjA9pESk/5Ox/8jArmzYq41QZnNK6iaqRQlWg9x0P+mNVt1G+y5o4ytWs3KnbmpS7VBEYH+SJQuOMgQY2o4YhTaQNN3UdQPaMUhNsk1qWbXBqMx1Jr8GJ6y/EowbJbYhntypS8RSEg/DdD+bLqbvywsHEC3wvGK/mawlCMkbS83A+FZRpwDRLowyJhJgcpkUmGDA2BG3I9BWYDrMcjQ+BOwBIegK2R3cmKJJbxZN8uGZw1bCQXAEm2X4d5aL+7Ew4vSZLb7PJFxdYPx95cTmZzQuM5K6eJE2DNN621V9fWzr++t45WPp11Qp6yw4s3ZAx2BxJP8Y4zNprTPK27xZJ/yPEF35ozXAaAgAA');

        $stz = new Standardize();
        $std = $stz->toStd('<?xml version="1.0" encoding="UTF-8"?>
<resNFe xmlns="http://www.portalfiscal.inf.br/nfe" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" versao="1.01">
   <chNFe>43220409216620000137550020021170971889631925</chNFe>
   <CNPJ>09216620000137</CNPJ>
   <xNome>BRS SUPRIMENTOS CORPORATIVOS S/A</xNome>
   <IE>1240248412</IE>
   <dhEmi>2022-04-25T07:28:43-03:00</dhEmi>
   <tpNF>1</tpNF>
   <vNF>3463.68</vNF>
   <digVal>rzw70vKdMOZZlJy0VDp3myv7sG0=</digVal>
   <dhRecbto>2022-04-25T07:29:00-03:00</dhRecbto>
   <nProt>143220085666293</nProt>
   <cSitNFe>1</cSitNFe>
</resNFe>');

        dd($std);
//        $this->downloadNfePorChave($unidade, '53220400949483000175550010000049611930119437')

//        dd($this->consultaNfePorChave($unidade, '43220409216620000137550020021170971889631925'));

//        $this->emitirDanfePdf();
//        $unidade = Unidade::where('codigo_unidade', '99')
//

//        $unidade = Unidade::where('codigo_unidade', '99')
//            ->first();

//        dd($this->downloadNfePorChave($unidade,'53220400949483000175550010000049611930119437'));

//        $this->consultaSefazDistDFe($unidade);

//        $this->consultaNfePorChave($unidade,'53220400949483000175550010000049611930119437');
//        $this->confirmaOperacaoNfePorChave($unidade,'53220400949483000175550010000049611930119437');

        $unidades = Unidade::all();
        foreach ($unidades as $unidade){
            $this->consultaSefazDistDFe($unidade);
        }
//        $this->emitirDanfePdf($this->xml());
    }

    public function xml()
    {
        return '<nfeProc versao="4.00" xmlns="http://www.portalfiscal.inf.br/nfe"><NFe xmlns="http://www.portalfiscal.inf.br/nfe"><infNFe versao="4.00" Id="NFe53220400949483000175550010000049611930119437"><ide><cUF>53</cUF><cNF>93011943</cNF><natOp>SERVIÇOS</natOp><mod>55</mod><serie>1</serie><nNF>4961</nNF><dhEmi>2022-04-05T15:22:00-03:00</dhEmi><dhSaiEnt>2022-04-05T15:22:00-03:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>5300108</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>7</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>0</indPres><procEmi>0</procEmi><verProc>4.26.4.2</verProc></ide><emit><CNPJ>00949483000175</CNPJ><xNome>A ABBA SERVICOS GERAIS LTDA</xNome><enderEmit><xLgr>QDR SCLRN 705 BLOCO F LOJA 39</xLgr><nro>SN</nro><xBairro>ASA NORTE</xBairro><cMun>5300108</cMun><xMun>BRASILIA</xMun><UF>DF</UF><CEP>70730556</CEP><fone>6132746703</fone></enderEmit><IE>0735882000133</IE><IM>0735882000133</IM><CNAE>9601701</CNAE><CRT>1</CRT></emit><dest><CNPJ>26994558000395</CNPJ><xNome>ADVOCACIA GERAL DA UNIAO - AGU</xNome><enderDest><xLgr>SIG QD. 06 - LOTE 800 ED SEDE</xLgr><nro>06</nro><xBairro>SET. DE IND. GRÁFICA</xBairro><cMun>5300108</cMun><xMun>BRASILIA</xMun><UF>DF</UF><CEP>70610460</CEP><cPais>1058</cPais><xPais>BRASIL</xPais></enderDest><indIEDest>2</indIEDest></dest><det nItem="1"><prod><cProd>00032</cProd><cEAN>SEM GTIN</cEAN><xProd>LAVAGEM DE TOALHA DE MESA</xProd><NCM>00000000</NCM><CFOP>5933</CFOP><uCom>UN</uCom><qCom>7.0000</qCom><vUnCom>24.8100000000</vUnCom><vProd>173.67</vProd><cEANTrib>SEM GTIN</cEANTrib><uTrib>UN</uTrib><qTrib>7.0000</qTrib><vUnTrib>24.8100000000</vUnTrib><indTot>1</indTot></prod><imposto><vTotTrib>23.75</vTotTrib><ISSQN><vBC>173.67</vBC><vAliq>3.4200</vAliq><vISSQN>5.94</vISSQN><cMunFG>5300108</cMunFG><cListServ>14.10</cListServ><vISSRet>5.94</vISSRet><indISS>1</indISS><cMun>5300108</cMun><indIncentivo>2</indIncentivo></ISSQN><PIS><PISOutr><CST>99</CST><vBC>0.00</vBC><pPIS>0.0000</pPIS><vPIS>0.00</vPIS></PISOutr></PIS><COFINS><COFINSOutr><CST>99</CST><vBC>0.00</vBC><pCOFINS>0.0000</pCOFINS><vCOFINS>0.00</vCOFINS></COFINSOutr></COFINS></imposto></det><det nItem="2"><prod><cProd>00003</cProd><cEAN>SEM GTIN</cEAN><xProd>LAVAGEM DE TOALHA DE ROSTO</xProd><NCM>00000000</NCM><CFOP>5933</CFOP><uCom>UN</uCom><qCom>5.0000</qCom><vUnCom>3.7200000000</vUnCom><vProd>18.60</vProd><cEANTrib>SEM GTIN</cEANTrib><uTrib>UN</uTrib><qTrib>5.0000</qTrib><vUnTrib>3.7200000000</vUnTrib><indTot>1</indTot></prod><imposto><vTotTrib>2.54</vTotTrib><ISSQN><vBC>18.60</vBC><vAliq>3.4200</vAliq><vISSQN>0.64</vISSQN><cMunFG>5300108</cMunFG><cListServ>14.10</cListServ><vISSRet>0.64</vISSRet><indISS>1</indISS><cMun>5300108</cMun><indIncentivo>2</indIncentivo></ISSQN><PIS><PISOutr><CST>99</CST><vBC>0.00</vBC><pPIS>0.0000</pPIS><vPIS>0.00</vPIS></PISOutr></PIS><COFINS><COFINSOutr><CST>99</CST><vBC>0.00</vBC><pCOFINS>0.0000</pCOFINS><vCOFINS>0.00</vCOFINS></COFINSOutr></COFINS></imposto></det><det nItem="3"><prod><cProd>00081</cProd><cEAN>SEM GTIN</cEAN><xProd>LAVAGEM DE BANDEIRA</xProd><NCM>00000000</NCM><CFOP>5933</CFOP><uCom>UN</uCom><qCom>8.0000</qCom><vUnCom>9.6500000000</vUnCom><vProd>77.20</vProd><cEANTrib>SEM GTIN</cEANTrib><uTrib>UN</uTrib><qTrib>8.0000</qTrib><vUnTrib>9.6500000000</vUnTrib><indTot>1</indTot></prod><imposto><vTotTrib>10.56</vTotTrib><ISSQN><vBC>77.20</vBC><vAliq>3.4200</vAliq><vISSQN>2.64</vISSQN><cMunFG>5300108</cMunFG><cListServ>14.10</cListServ><vISSRet>2.64</vISSRet><indISS>1</indISS><cMun>5300108</cMun><indIncentivo>2</indIncentivo></ISSQN><PIS><PISOutr><CST>99</CST><vBC>0.00</vBC><pPIS>0.0000</pPIS><vPIS>0.00</vPIS></PISOutr></PIS><COFINS><COFINSOutr><CST>99</CST><vBC>0.00</vBC><pCOFINS>0.0000</pCOFINS><vCOFINS>0.00</vCOFINS></COFINSOutr></COFINS></imposto></det><total><ICMSTot><vBC>0.00</vBC><vICMS>0.00</vICMS><vICMSDeson>0.00</vICMSDeson><vFCPUFDest>0.00</vFCPUFDest><vICMSUFDest>0.00</vICMSUFDest><vICMSUFRemet>0.00</vICMSUFRemet><vFCP>0.00</vFCP><vBCST>0.00</vBCST><vST>0.00</vST><vFCPST>0.00</vFCPST><vFCPSTRet>0.00</vFCPSTRet><vProd>0.00</vProd><vFrete>0.00</vFrete><vSeg>0.00</vSeg><vDesc>0.00</vDesc><vII>0.00</vII><vIPI>0.00</vIPI><vIPIDevol>0.00</vIPIDevol><vPIS>0.00</vPIS><vCOFINS>0.00</vCOFINS><vOutro>0.00</vOutro><vNF>269.47</vNF><vTotTrib>36.85</vTotTrib></ICMSTot><ISSQNtot><vServ>269.47</vServ><vBC>269.47</vBC><vISS>9.22</vISS><dCompet>2022-04-05</dCompet><vISSRet>9.22</vISSRet></ISSQNtot></total><transp><modFrete>9</modFrete></transp><pag><detPag><tPag>99</tPag><xPag>ORDEM BANCARIA</xPag><vPag>269.47</vPag></detPag></pag><infAdic><infCpl>DOCUMENTO EMITIDO POR ME OU EPP OPTANTE PELO SIMPLES NACIONAL.NÃO GERA DIREITO A CRÉDITO FISCAL DE IPI. PROCON 151 (VENANCIO 2000, SCS, QD 08, BLOCO B60, SALA 240). NF REFERENTE AOS SERVIÇOS PRESTADOS NO MES DE MARÇO DE 2022. DADOS PARA ORDEM BANCARIA: BANCO DO BRASIL 001 / AGENCIA 1003-0 / CONTA 8401-8. RETENÇÃO DE ISS 3,42% R$ 9,22</infCpl></infAdic></infNFe><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" /><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1" /><Reference URI="#NFe53220400949483000175550010000049611930119437"><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature" /><Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" /></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1" /><DigestValue>0o/OJupbl0yXrbAQK71ZqqVImTw=</DigestValue></Reference></SignedInfo><SignatureValue>Q1iYbBO6o/PaNdJ0bZMgYSVYi5jwAb6uWiO+hjaoFEJNJfHfB9UU4BkjzXrtMEmbZb/jYVANptc/VR/mOzpCnz+YqoleYc5qArZoHbYiH43wn0I3rwfiHx6RwLsLH4+vDTS4omGE3AdyuP+TM/fPgtWyuHfZnDJmI27UHYyi0mBeweevfc/hX43qSyVQ5frnX+CH0ZoSIBQmfucak2Wca74dtKfEQ1a2GXT5GcU9ib4yq3IEqrvKVr9f/WeHTAme3hPPTjUDWRZWW8slBJdZKtNEDryklKV7oA1QFAYIZ8KT2Pk38ePAshXbpuD0sMfVRK0Vm8Pd5aF/LjjbRiPl3g==</SignatureValue><KeyInfo><X509Data><X509Certificate>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</X509Certificate></X509Data></KeyInfo></Signature></NFe><protNFe versao="4.00" xmlns="http://www.portalfiscal.inf.br/nfe"><infProt><tpAmb>1</tpAmb><verAplic>SVRS202203301230</verAplic><chNFe>53220400949483000175550010000049611930119437</chNFe><dhRecbto>2022-04-05T15:33:33-03:00</dhRecbto><nProt>353220020614753</nProt><digVal>0o/OJupbl0yXrbAQK71ZqqVImTw=</digVal><cStat>100</cStat><xMotivo>Autorizado o uso da NF-e</xMotivo></infProt></protNFe></nfeProc>';
    }

}
