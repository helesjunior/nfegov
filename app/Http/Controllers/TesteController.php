<?php

namespace App\Http\Controllers;

use App\Http\Traits\NfeOrg;
use App\Models\Nsu;
use App\Models\Unidade;
use Illuminate\Http\Request;

class TesteController extends Controller
{
    use NfeOrg;

    public function teste()
    {
//        $this->emitirDanfePdf();
        $unidade = Unidade::where('codigo_unidade', '110062')
//        $unidade = Unidade::where('codigo_unidade', '110621')
            ->first();

//        $this->downloadNfePorChave($unidade,'53220400949483000175550010000049611930119437');
//        $this->consultaNfePorChave($unidade,'53220400949483000175550010000049611930119437');
//        $this->confirmaOperacaoNfePorChave($unidade,'53220400949483000175550010000049611930119437');
//        $this->consultaSefazDistDFe($unidade);
//        $this->decode();
//        $this->emitirDanfePdf($this->xml());

        $nsu = Nsu::where('id', 1)->first();
        $this->lerXmlNfe($this->xml(), $nsu);
    }

    private function xml()
    {
                return '<?xml version="1.0" encoding="UTF-8"?>
        <nfeProc xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00">
           <NFe>
              <infNFe versao="4.00" Id="NFe53220430135801000125550010000000091650887712">
                 <ide>
                    <cUF>53</cUF>
                    <cNF>65088771</cNF>
                    <natOp>PRESTAÇÃO DE SERVIÇO FORA DO DF, COM ISS RETIDO</natOp>
                    <mod>55</mod>
                    <serie>1</serie>
                    <nNF>9</nNF>
                    <dhEmi>2022-04-25T08:55:13-03:00</dhEmi>
                    <tpNF>1</tpNF>
                    <idDest>2</idDest>
                    <cMunFG>5300108</cMunFG>
                    <tpImp>1</tpImp>
                    <tpEmis>1</tpEmis>
                    <cDV>2</cDV>
                    <tpAmb>1</tpAmb>
                    <finNFe>1</finNFe>
                    <indFinal>1</indFinal>
                    <indPres>1</indPres>
                    <procEmi>0</procEmi>
                    <verProc>2.0.0.0</verProc>
                 </ide>
                 <emit>
                    <CNPJ>30135801000125</CNPJ>
                    <xNome>GLEICE DE SOUZA SILVA</xNome>
                    <xFant>Q|TEC INFORMATICA E TREINAMENTOS</xFant>
                    <enderEmit>
                       <xLgr>SMT CONJUNTO 8</xLgr>
                       <nro>01</nro>
                       <xCpl>LOTE 01 CASA 01</xCpl>
                       <xBairro>TAGUATINGA SUL (TAGUATINGA)</xBairro>
                       <cMun>5300108</cMun>
                       <xMun>Brasília</xMun>
                       <UF>DF</UF>
                       <CEP>72023440</CEP>
                       <cPais>1058</cPais>
                       <xPais>BRASIL</xPais>
                       <fone>61998467399</fone>
                    </enderEmit>
                    <IE>0785382000106</IE>
                    <IM>0785382000106</IM>
                    <CNAE>8599604</CNAE>
                    <CRT>1</CRT>
                 </emit>
                 <dest>
                    <CNPJ>06170517000105</CNPJ>
                    <xNome>TRIBUNAL REGIONAL ELEITORAL DO RIO DE JANEIRO</xNome>
                    <enderDest>
                       <xLgr>AV PRESIDENTE WILSON</xLgr>
                       <nro>194</nro>
                       <xCpl>PREDIO</xCpl>
                       <xBairro>CASTELO</xBairro>
                       <cMun>3304557</cMun>
                       <xMun>Rio de Janeiro</xMun>
                       <UF>RJ</UF>
                       <CEP>20030021</CEP>
                       <cPais>1058</cPais>
                       <xPais>BRASIL</xPais>
                       <fone>21999922670</fone>
                    </enderDest>
                    <indIEDest>9</indIEDest>
                    <email>sad@tre-rj.jus.br</email>
                 </dest>
                 <det nItem="1">
                    <prod>
                       <cProd>1</cProd>
                       <cEAN />
                       <xProd>Prestação de Serviços de Treinamento no Sistema Compras Contratos (08hs), realizado nos dias 19/04 e 20/04, para...</xProd>
                       <NCM>00</NCM>
                       <CFOP>6933</CFOP>
                       <uCom>SRV</uCom>
                       <qCom>1.0000</qCom>
                       <vUnCom>8434.0000000000</vUnCom>
                       <vProd>8434.00</vProd>
                       <cEANTrib />
                       <uTrib>SRV</uTrib>
                       <qTrib>1.0000</qTrib>
                       <vUnTrib>8434.0000000000</vUnTrib>
                       <indTot>1</indTot>
                    </prod>
                    <imposto>
                       <ISSQN>
                          <vBC>8434.00</vBC>
                          <vAliq>2.01</vAliq>
                          <vISSQN>0.00</vISSQN>
                          <cMunFG>5300108</cMunFG>
                          <cListServ>08.02</cListServ>
                          <vISSRet>169.52</vISSRet>
                          <indISS>2</indISS>
                          <cMun>5300108</cMun>
                          <indIncentivo>2</indIncentivo>
                       </ISSQN>
                       <PIS>
                          <PISOutr>
                             <CST>99</CST>
                             <vBC>0.00</vBC>
                             <pPIS>0.00</pPIS>
                             <vPIS>0.00</vPIS>
                          </PISOutr>
                       </PIS>
                       <COFINS>
                          <COFINSOutr>
                             <CST>99</CST>
                             <vBC>0.00</vBC>
                             <pCOFINS>0.00</pCOFINS>
                             <vCOFINS>0.00</vCOFINS>
                          </COFINSOutr>
                       </COFINS>
                    </imposto>
                 </det>
                 <total>
                    <ICMSTot>
                       <vBC>0.00</vBC>
                       <vICMS>0.00</vICMS>
                       <vICMSDeson>0.00</vICMSDeson>
                       <vFCP>0.00</vFCP>
                       <vBCST>0.00</vBCST>
                       <vST>0.00</vST>
                       <vFCPST>0.00</vFCPST>
                       <vFCPSTRet>0.00</vFCPSTRet>
                       <vProd>0.00</vProd>
                       <vFrete>0.00</vFrete>
                       <vSeg>0.00</vSeg>
                       <vDesc>0.00</vDesc>
                       <vII>0.00</vII>
                       <vIPI>0.00</vIPI>
                       <vIPIDevol>0.00</vIPIDevol>
                       <vPIS>0.00</vPIS>
                       <vCOFINS>0.00</vCOFINS>
                       <vOutro>0.00</vOutro>
                       <vNF>8434.00</vNF>
                    </ICMSTot>
                    <ISSQNtot>
                       <vServ>8434.00</vServ>
                       <vBC>8434.00</vBC>
                       <dCompet>2022-04-25</dCompet>
                       <vISSRet>169.52</vISSRet>
                    </ISSQNtot>
                 </total>
                 <transp>
                    <modFrete>9</modFrete>
                 </transp>
                 <pag>
                    <detPag>
                       <tPag>16</tPag>
                       <vPag>8434.00</vPag>
                    </detPag>
                    <vTroco>0.00</vTroco>
                 </pag>
                 <infAdic>
                    <infCpl>as equipes de contratos e execucao financeira e orcamentaria, conforme proposta aceita e Nota de Empenho 2022NE390, contrato 27/2022. TOTAL APROXIMADO DE TRIBUTOS FEDERAIS, ESTADUAIS E MUNICIPAIS: R$ 506,04. EMPRESA OPTANTE PELO SIMPLES NACIONAL.</infCpl>
                 </infAdic>
              </infNFe>
              <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
                 <SignedInfo>
                    <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" />
                    <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1" />
                    <Reference URI="#NFe53220430135801000125550010000000091650887712">
                       <Transforms>
                          <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature" />
                          <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" />
                       </Transforms>
                       <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1" />
                       <DigestValue>/g2YBBZ6Sivj9Y5jLEpvIMUz/Iw=</DigestValue>
                    </Reference>
                 </SignedInfo>
                 <SignatureValue>aRtVUDbMv1InX2qwBK8Jddp+3zt9+HYYJ41BjsBYJVj6ZAZdqcmtnHX8N4AlU6cJ2dYYQeCVMbGH29Jg2cpV5I7Kcx5FRSp9ZjQfsWWtHSelr5bnrQJrAjLXbH9xsL0j15AHXdwynXhB6THB5CdJF6PhhdMwMjR+LZEPhbZgMgLKU5m/SpihgKVRUs3Tg/DX4Y8Utr886NdtKfjbUMDnDJ21gWR1I3hpUj5VWj2AHes6adZnPhT+zi5YpuiLeOivK98OSeJEmkEyWR8kZTaPFS3qJ9PbByJdIN2m5BvPqUBEGDcEH55K+0/c0tebI5LitENQY1dWDoHx6ca4OHnUuQ==</SignatureValue>
                 <KeyInfo>
                    <X509Data>
                       <X509Certificate>MIIIETCCBfmgAwIBAgIIN/sejkHfgrgwDQYJKoZIhvcNAQELBQAwdTELMAkGA1UE
        BhMCQlIxEzARBgNVBAoMCklDUC1CcmFzaWwxNjA0BgNVBAsMLVNlY3JldGFyaWEg
        ZGEgUmVjZWl0YSBGZWRlcmFsIGRvIEJyYXNpbCAtIFJGQjEZMBcGA1UEAwwQQUMg
        U0VSQVNBIFJGQiB2NTAeFw0yMTEyMDgxOTM0MDBaFw0yMjEyMDgxOTM0MDBaMIIB
        LTELMAkGA1UEBhMCQlIxCzAJBgNVBAgMAkRGMREwDwYDVQQHDAhCcmFzaWxpYTET
        MBEGA1UECgwKSUNQLUJyYXNpbDEYMBYGA1UECwwPMDAwMDAxMDEwNjU4Njc0MTYw
        NAYDVQQLDC1TZWNyZXRhcmlhIGRhIFJlY2VpdGEgRmVkZXJhbCBkbyBCcmFzaWwg
        LSBSRkIxFjAUBgNVBAsMDVJGQiBlLUNOUEogQTExFjAUBgNVBAsMDUFDIFNFUkFT
        QSBSRkIxFzAVBgNVBAsMDjA5MzEzMTM1MDAwMTgxMRMwEQYDVQQLDApQUkVTRU5D
        SUFMMTkwNwYDVQQDDDBHTEVJQ0UgREUgU09VWkEgU0lMVkEgMDE1MDY0NjIxNjI6
        MzAxMzU4MDEwMDAxMjUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDq
        JMqz+sTEJc7pNm2x5grZxC45g/XDqEJwLU13ZL5bfjBBDVh6a45nq0THU5ocfOX3
        9soMID1BtfdN3AfBTO0MmJCIZeZ8GQ7wBhHvtk4prpXyOTk0ej1HlYrAamHXWRac
        fT1rh81VwGQUbCnd0RghGUZfcvW8Q5NiRDXKjYXSgyx0Ffm1eKzOGCPtv8qTaBD0
        JeFaM62u/Rn47PfQj5l1h8Qz5qXFGJKBpc41fvKRCgDU3vyHaxkbb0ehMzj4Krjf
        k4GrMcqnbplvBFcAWhT7VqEUI6pjQjGQ+VVRCsMfX753cZpMpQhOfPyPmSRzcGwH
        8A7TCARnTaVa8J4fcbsVAgMBAAGjggLpMIIC5TAJBgNVHRMEAjAAMB8GA1UdIwQY
        MBaAFOzxQVFXqOY66V6zoCL5CIq1OoePMIGZBggrBgEFBQcBAQSBjDCBiTBIBggr
        BgEFBQcwAoY8aHR0cDovL3d3dy5jZXJ0aWZpY2Fkb2RpZ2l0YWwuY29tLmJyL2Nh
        ZGVpYXMvc2VyYXNhcmZidjUucDdiMD0GCCsGAQUFBzABhjFodHRwOi8vb2NzcC5j
        ZXJ0aWZpY2Fkb2RpZ2l0YWwuY29tLmJyL3NlcmFzYXJmYnY1MIG5BgNVHREEgbEw
        ga6BFlNJTFZBLkdMRUlDRUBHTUFJTC5DT02gIAYFYEwBAwKgFxMVR0xFSUNFIERF
        IFNPVVpBIFNJTFZBoBkGBWBMAQMDoBATDjMwMTM1ODAxMDAwMTI1oD4GBWBMAQME
        oDUTMzAyMDIxOTg3MDE1MDY0NjIxNjIwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAw
        MDAwMDAwMKAXBgVgTAEDB6AOEwwwMDAwMDAwMDAwMDAwcQYDVR0gBGowaDBmBgZg
        TAECAQ0wXDBaBggrBgEFBQcCARZOaHR0cDovL3B1YmxpY2FjYW8uY2VydGlmaWNh
        ZG9kaWdpdGFsLmNvbS5ici9yZXBvc2l0b3Jpby9kcGMvZGVjbGFyYWNhby1yZmIu
        cGRmMB0GA1UdJQQWMBQGCCsGAQUFBwMCBggrBgEFBQcDBDCBnQYDVR0fBIGVMIGS
        MEqgSKBGhkRodHRwOi8vd3d3LmNlcnRpZmljYWRvZGlnaXRhbC5jb20uYnIvcmVw
        b3NpdG9yaW8vbGNyL3NlcmFzYXJmYnY1LmNybDBEoEKgQIY+aHR0cDovL2xjci5j
        ZXJ0aWZpY2Fkb3MuY29tLmJyL3JlcG9zaXRvcmlvL2xjci9zZXJhc2FyZmJ2NS5j
        cmwwHQYDVR0OBBYEFD3jPsS1nrzmb0FmJ/lkjJwkHYuzMA4GA1UdDwEB/wQEAwIF
        4DANBgkqhkiG9w0BAQsFAAOCAgEAbAbyi+U3I1nR0qy/wXw/XGaNQCk3Ru8EXwlu
        TsCT/4YSR0XMuH06bFs74fXVnBuzry8eEJJlt8JgxpShlP4M7D4Hhm4afU+mgMn0
        fQf+dh8uKQX0ra21wIZWKviDkh5I9AfShYsKNSK5GmbuAY+HMfVwVZ55ifV8dMfV
        d09z6F0ov73bb6Ov6hEPnEp0MTCB8BIsaLWVEqCUigUQxNxy+DRF9cPZ/o+VU6mP
        OsIBZCNewBeTC3TsJPz2ZVb8if86zFvWjOdx6pYACoGn/ko62cjq2WabIDQRJ5o3
        nMzxwwRfWa/F/w/YarXs+8ALDnj4a9eHmfEvOlToPLDuctMtnPcf196/sCgym1y0
        6VVPy4soCcoy1wzzOFMquz+hieo7wjeup3wmLBT5RjvZvJ1pJKT9wwtreshvoVqS
        aebJEtNMtk+lgAw7ZGPJBbSyreT9ReneZlrjOmek9Va9VoUSdoi8I2HGZiLr6dT2
        aqefOF4QQtSgmEF7qbk1/Jy+bZHFC6o2nAmlr5e4agduFGK9Eualkrw38vzd7RM5
        SpxzZomrWK6JKec5dnWdKzB+I0yQanMCeJ0AYpV1VFTJkfcEoRrW7H+aVA4rddkB
        2/I6qMViURVEPzxTPovexWf7hduAzEYhJqWhgjmcYXxuNoYN3uhLp2n/1F90IyPR
        hGzaoFU=</X509Certificate>
                    </X509Data>
                 </KeyInfo>
              </Signature>
           </NFe>
           <protNFe versao="4.00">
              <infProt>
                 <tpAmb>1</tpAmb>
                 <verAplic>SVRS202203151209</verAplic>
                 <chNFe>53220430135801000125550010000000091650887712</chNFe>
                 <dhRecbto>2022-04-25T08:55:16-03:00</dhRecbto>
                 <nProt>353220024431427</nProt>
                 <digVal>/g2YBBZ6Sivj9Y5jLEpvIMUz/Iw=</digVal>
                 <cStat>100</cStat>
                 <xMotivo>Autorizado o uso da NF-e</xMotivo>
              </infProt>
           </protNFe>
        </nfeProc>';

    }

    public function xml2()
    {
        return '<nfeProc versao="4.00" xmlns="http://www.portalfiscal.inf.br/nfe"><NFe xmlns="http://www.portalfiscal.inf.br/nfe"><infNFe versao="4.00" Id="NFe53220400949483000175550010000049611930119437"><ide><cUF>53</cUF><cNF>93011943</cNF><natOp>SERVIÇOS</natOp><mod>55</mod><serie>1</serie><nNF>4961</nNF><dhEmi>2022-04-05T15:22:00-03:00</dhEmi><dhSaiEnt>2022-04-05T15:22:00-03:00</dhSaiEnt><tpNF>1</tpNF><idDest>1</idDest><cMunFG>5300108</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>7</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>1</indFinal><indPres>0</indPres><procEmi>0</procEmi><verProc>4.26.4.2</verProc></ide><emit><CNPJ>00949483000175</CNPJ><xNome>A ABBA SERVICOS GERAIS LTDA</xNome><enderEmit><xLgr>QDR SCLRN 705 BLOCO F LOJA 39</xLgr><nro>SN</nro><xBairro>ASA NORTE</xBairro><cMun>5300108</cMun><xMun>BRASILIA</xMun><UF>DF</UF><CEP>70730556</CEP><fone>6132746703</fone></enderEmit><IE>0735882000133</IE><IM>0735882000133</IM><CNAE>9601701</CNAE><CRT>1</CRT></emit><dest><CNPJ>26994558000395</CNPJ><xNome>ADVOCACIA GERAL DA UNIAO - AGU</xNome><enderDest><xLgr>SIG QD. 06 - LOTE 800 ED SEDE</xLgr><nro>06</nro><xBairro>SET. DE IND. GRÁFICA</xBairro><cMun>5300108</cMun><xMun>BRASILIA</xMun><UF>DF</UF><CEP>70610460</CEP><cPais>1058</cPais><xPais>BRASIL</xPais></enderDest><indIEDest>2</indIEDest></dest><det nItem="1"><prod><cProd>00032</cProd><cEAN>SEM GTIN</cEAN><xProd>LAVAGEM DE TOALHA DE MESA</xProd><NCM>00000000</NCM><CFOP>5933</CFOP><uCom>UN</uCom><qCom>7.0000</qCom><vUnCom>24.8100000000</vUnCom><vProd>173.67</vProd><cEANTrib>SEM GTIN</cEANTrib><uTrib>UN</uTrib><qTrib>7.0000</qTrib><vUnTrib>24.8100000000</vUnTrib><indTot>1</indTot></prod><imposto><vTotTrib>23.75</vTotTrib><ISSQN><vBC>173.67</vBC><vAliq>3.4200</vAliq><vISSQN>5.94</vISSQN><cMunFG>5300108</cMunFG><cListServ>14.10</cListServ><vISSRet>5.94</vISSRet><indISS>1</indISS><cMun>5300108</cMun><indIncentivo>2</indIncentivo></ISSQN><PIS><PISOutr><CST>99</CST><vBC>0.00</vBC><pPIS>0.0000</pPIS><vPIS>0.00</vPIS></PISOutr></PIS><COFINS><COFINSOutr><CST>99</CST><vBC>0.00</vBC><pCOFINS>0.0000</pCOFINS><vCOFINS>0.00</vCOFINS></COFINSOutr></COFINS></imposto></det><det nItem="2"><prod><cProd>00003</cProd><cEAN>SEM GTIN</cEAN><xProd>LAVAGEM DE TOALHA DE ROSTO</xProd><NCM>00000000</NCM><CFOP>5933</CFOP><uCom>UN</uCom><qCom>5.0000</qCom><vUnCom>3.7200000000</vUnCom><vProd>18.60</vProd><cEANTrib>SEM GTIN</cEANTrib><uTrib>UN</uTrib><qTrib>5.0000</qTrib><vUnTrib>3.7200000000</vUnTrib><indTot>1</indTot></prod><imposto><vTotTrib>2.54</vTotTrib><ISSQN><vBC>18.60</vBC><vAliq>3.4200</vAliq><vISSQN>0.64</vISSQN><cMunFG>5300108</cMunFG><cListServ>14.10</cListServ><vISSRet>0.64</vISSRet><indISS>1</indISS><cMun>5300108</cMun><indIncentivo>2</indIncentivo></ISSQN><PIS><PISOutr><CST>99</CST><vBC>0.00</vBC><pPIS>0.0000</pPIS><vPIS>0.00</vPIS></PISOutr></PIS><COFINS><COFINSOutr><CST>99</CST><vBC>0.00</vBC><pCOFINS>0.0000</pCOFINS><vCOFINS>0.00</vCOFINS></COFINSOutr></COFINS></imposto></det><det nItem="3"><prod><cProd>00081</cProd><cEAN>SEM GTIN</cEAN><xProd>LAVAGEM DE BANDEIRA</xProd><NCM>00000000</NCM><CFOP>5933</CFOP><uCom>UN</uCom><qCom>8.0000</qCom><vUnCom>9.6500000000</vUnCom><vProd>77.20</vProd><cEANTrib>SEM GTIN</cEANTrib><uTrib>UN</uTrib><qTrib>8.0000</qTrib><vUnTrib>9.6500000000</vUnTrib><indTot>1</indTot></prod><imposto><vTotTrib>10.56</vTotTrib><ISSQN><vBC>77.20</vBC><vAliq>3.4200</vAliq><vISSQN>2.64</vISSQN><cMunFG>5300108</cMunFG><cListServ>14.10</cListServ><vISSRet>2.64</vISSRet><indISS>1</indISS><cMun>5300108</cMun><indIncentivo>2</indIncentivo></ISSQN><PIS><PISOutr><CST>99</CST><vBC>0.00</vBC><pPIS>0.0000</pPIS><vPIS>0.00</vPIS></PISOutr></PIS><COFINS><COFINSOutr><CST>99</CST><vBC>0.00</vBC><pCOFINS>0.0000</pCOFINS><vCOFINS>0.00</vCOFINS></COFINSOutr></COFINS></imposto></det><total><ICMSTot><vBC>0.00</vBC><vICMS>0.00</vICMS><vICMSDeson>0.00</vICMSDeson><vFCPUFDest>0.00</vFCPUFDest><vICMSUFDest>0.00</vICMSUFDest><vICMSUFRemet>0.00</vICMSUFRemet><vFCP>0.00</vFCP><vBCST>0.00</vBCST><vST>0.00</vST><vFCPST>0.00</vFCPST><vFCPSTRet>0.00</vFCPSTRet><vProd>0.00</vProd><vFrete>0.00</vFrete><vSeg>0.00</vSeg><vDesc>0.00</vDesc><vII>0.00</vII><vIPI>0.00</vIPI><vIPIDevol>0.00</vIPIDevol><vPIS>0.00</vPIS><vCOFINS>0.00</vCOFINS><vOutro>0.00</vOutro><vNF>269.47</vNF><vTotTrib>36.85</vTotTrib></ICMSTot><ISSQNtot><vServ>269.47</vServ><vBC>269.47</vBC><vISS>9.22</vISS><dCompet>2022-04-05</dCompet><vISSRet>9.22</vISSRet></ISSQNtot></total><transp><modFrete>9</modFrete></transp><pag><detPag><tPag>99</tPag><xPag>ORDEM BANCARIA</xPag><vPag>269.47</vPag></detPag></pag><infAdic><infCpl>DOCUMENTO EMITIDO POR ME OU EPP OPTANTE PELO SIMPLES NACIONAL.NÃO GERA DIREITO A CRÉDITO FISCAL DE IPI. PROCON 151 (VENANCIO 2000, SCS, QD 08, BLOCO B60, SALA 240). NF REFERENTE AOS SERVIÇOS PRESTADOS NO MES DE MARÇO DE 2022. DADOS PARA ORDEM BANCARIA: BANCO DO BRASIL 001 / AGENCIA 1003-0 / CONTA 8401-8. RETENÇÃO DE ISS 3,42% R$ 9,22</infCpl></infAdic></infNFe><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" /><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1" /><Reference URI="#NFe53220400949483000175550010000049611930119437"><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature" /><Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" /></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1" /><DigestValue>0o/OJupbl0yXrbAQK71ZqqVImTw=</DigestValue></Reference></SignedInfo><SignatureValue>Q1iYbBO6o/PaNdJ0bZMgYSVYi5jwAb6uWiO+hjaoFEJNJfHfB9UU4BkjzXrtMEmbZb/jYVANptc/VR/mOzpCnz+YqoleYc5qArZoHbYiH43wn0I3rwfiHx6RwLsLH4+vDTS4omGE3AdyuP+TM/fPgtWyuHfZnDJmI27UHYyi0mBeweevfc/hX43qSyVQ5frnX+CH0ZoSIBQmfucak2Wca74dtKfEQ1a2GXT5GcU9ib4yq3IEqrvKVr9f/WeHTAme3hPPTjUDWRZWW8slBJdZKtNEDryklKV7oA1QFAYIZ8KT2Pk38ePAshXbpuD0sMfVRK0Vm8Pd5aF/LjjbRiPl3g==</SignatureValue><KeyInfo><X509Data><X509Certificate>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</X509Certificate></X509Data></KeyInfo></Signature></NFe><protNFe versao="4.00" xmlns="http://www.portalfiscal.inf.br/nfe"><infProt><tpAmb>1</tpAmb><verAplic>SVRS202203301230</verAplic><chNFe>53220400949483000175550010000049611930119437</chNFe><dhRecbto>2022-04-05T15:33:33-03:00</dhRecbto><nProt>353220020614753</nProt><digVal>0o/OJupbl0yXrbAQK71ZqqVImTw=</digVal><cStat>100</cStat><xMotivo>Autorizado o uso da NF-e</xMotivo></infProt></protNFe></nfeProc>';
    }

}
