<?php

namespace App\Services;

use Exception;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Make;
use NFePHP\NFe\Tools;
use stdClass;

class NFeService
{
    private $config;
    private $tools;
    public function __construct($config){
        $this->config = $config;
        $certificadoDigital = file_get_contents('teste.pfx');
        $this->tools = new Tools(json_encode($config), Certificate::readPfx($certificadoDigital, '1234'));
        
    }
    public function gerarNFe()
    {
        // Criar uma nota vazia
        $nfe = new Make();

        /** Inf NFe **/
        $stdInNFe = new stdClass();
        $stdInNFe->versao = '4.00'; //versão do layout (string)
        //$stdInNFe->Id = 'NFe35150271780456000160550010000000021800700082'; //se o Id de 44 digitos não for passado será gerado automaticamente
        $stdInNFe->pk_nItem = null; //deixe essa variavel sempre como NULL

        $infNFe = $nfe->taginfNFe($stdInNFe);

        $stdIde = new stdClass();
        $stdIde->cUF = 43;//29; // Código da UF do emitente do Documento Fiscal. Utilizar a Tabela do IBGE
        $stdIde->cNF = rand(11111111, 99999999); // Código Interno do documento, número aleatório
        $stdIde->natOp = 'REVENDA DE MERCADORIAS SIMPLES NACIONAL'; // Descrição da Natureza da Operação

        //$stdIde->indPag = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00

        /** IDE **/
        $stdIde->mod = 55; //55=NF-e emitida em substituição ao modelo 1/1A
        $stdIde->serie = 1; //Série da NF-e
        $stdIde->nNF = 2;  //Número da NF-e
        $stdIde->dhEmi = date("Y-m-d\TH:i:sP"); //Obrigatória informar a data e hora no formato AAAA-MM-DDThh:mm:ssTZD
        $stdIde->dhSaiEnt = date("Y-m-d\TH:i:sP"); //Obrigatória informar a data e hora no formato AAAA-MM-DDThh:mm:ssTZD
        $stdIde->tpNF = 1; //0-entrada; 1-saída
        $stdIde->idDest = 1; //1-Operação interna; 2-Operação interestadual; 3-Operação com exterior
        $stdIde->cMunFG = 3518800; //2927408 //Código do município de ocorrência do fato gerador
        $stdIde->tpImp = 1; //1=Retrato; 2=Paisagem
        $stdIde->tpEmis = 1; //1=Emissão normal (não em contingência); 2=Contingência FS-IA, com impressão do DANFE em formulário de segurança; 3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional); 4=Contingência DPEC (Declaração Prévia da Emissão em Contingência); 5=Contingência FS-DA, com impressão do DANFE em formulário de segurança; 6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN); 7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS)
        $stdIde->cDV = 2; //Dígito Verificador da Chave de Acesso da NF-e
        $stdIde->tpAmb = 2; //1=Produção; 2=Homologação
        $stdIde->finNFe = 1; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste
        $stdIde->indFinal = 1; //0=Normal; 1=Consumidor final
        $stdIde->indPres = 1; //0=Não se aplica; 1=Operação presencial; 2=Operação não presencial, pela Internet; 3=Operação não presencial, Teleatendimento; 4=NFC-e em operação com entrega em domicílio; 9=Operação não presencial, outros
        //$std->indIntermed = null; //NÃO EXISTE MAIS NA VERSÃO 4.00
        $stdIde->procEmi = 0; //0=Emissão de NF-e com aplicativo do contribuinte; 1=Emissão de NF-e avulsa pelo Fisco; 2=Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco; 3=Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco
        $stdIde->verProc = '1.0'; //Versão do aplicativo emissor
        //$std->dhCont = null; //NÃO EXISTE MAIS NA VERSÃO 4.00
        //$std->xJust = null; //NÃO EXISTE MAIS NA VERSÃO 4.00

        $tagide = $nfe->tagide($stdIde);

        /** EMITENTE **/

        $stdEmit = new stdClass();
        $stdEmit->xNome = "E-Sales Solucoes Oobj"; //
        $stdEmit->xFant = "Oobj";
        $stdEmit->IE = "0963233556";
        //$stdEmit->IEST;
        //$stdEmit->IM;
        //$stdEmit->CNAE = "";
        $stdEmit->CRT = "1";
        $stdEmit->CNPJ = "07385111000102"; //indicar apenas um CNPJ ou CPF
        //$stdEmit->CPF; 

        $emit =$nfe->tagemit($stdEmit);

        //** ENDEREÇO DO EMITENTE */
        $stdEnderEmit = new stdClass();
        $stdEnderEmit->xLgr = "PROF ALGACYR MUNHOZ MADER";
        $stdEnderEmit->nro = "2800";
        //$stdEnderEmit->xCpl = "CIC";
        $stdEnderEmit->xBairro = "CIC";
        $stdEnderEmit->cMun = "4314902";
        $stdEnderEmit->xMun = "Porto Alegre";
        $stdEnderEmit->UF = "RS";
        $stdEnderEmit->CEP ="81310020";
        $stdEnderEmit->cPais = "1058";
        $stdEnderEmit->xPais = "BRASIL";
        $stdEnderEmit->fone = "0963233556";

        $enderEmit = $nfe->tagenderEmit($stdEnderEmit);

        /** DESTINATARIO */
        $stdDest = new stdClass();
        $stdDest->xNome ="NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL";
        $stdDest->indIEDest = "2";
        $stdDest->IE = "0963233556";
        //$stdDest->ISUF;
        $stdDest->IM = "InsMun";
        $stdDest->email = "teste-sustentacao@oobj.com.br";
        $stdDest->CNPJ = "07385111000102"; //indicar apenas um CNPJ ou CPF ou idEstrangeiro
        //$stdDest->CPF;
        //$stdDest->idEstrangeiro;

        $dest = $nfe->tagdest($stdDest);

        /** ENDERECO DESTINATARIO */
        $stdEnderDest = new stdClass();
        $stdEnderDest->xLgr = "AV FRANCA";
        $stdEnderDest->nro = "1162";
        $stdEnderDest->xCpl = "SALA 201";
        $stdEnderDest->xBairro = "NAVEGANTES";
        $stdEnderDest->cMun = "4314902";
        $stdEnderDest->xMun = "PORTO ALEGRE";
        $stdEnderDest->UF = "RS";
        $stdEnderDest->CEP = "90230220";
        $stdEnderDest->cPais = "1058";
        $stdEnderDest->xPais = "BRASIL";
        $stdEnderDest->fone = "5133373764";

        $enderDest = $nfe->tagenderDest($stdEnderDest);

        /** PRODUTOS */
        $stdProd = new stdClass();
        $stdProd->item = 1; //item da NFe
        $stdProd->cProd = "4450";
        $stdProd->cEAN = "7897534826649";
        $stdProd->xProd = "LIMPA TELA 120ML";
        $stdProd->NCM = "44170010";
        $stdProd->CFOP = "5102";
        $stdProd->uCom = "UN";
        $stdProd->qCom = 10; // Correct: integer
        $stdProd->vUnCom = 6.99; // Correct: float
        $stdProd->cEANTrib = "7897534826649";
        $stdProd->uTrib = "UN";
        $stdProd->qTrib = 10; // Correct: integer
        $stdProd->vUnTrib = 6.99; // Correct: float
        $stdProd->vProd = floatval($stdProd->qTrib * $stdProd->vUnTrib); // Ensure calculation is a float.
        $stdProd->vFrete = "";
        $stdProd->vSeg = "";
        $stdProd->vDesc = "";
        $stdProd->vOutro = "";
        $stdProd->indTot = "1";

        $prod = $nfe->tagprod($stdProd);

        /** INFORMAÇÂO ADICIONAL DO PRODUTO*/
        $stdAdProd = new stdClass();
        $stdAdProd->item = 1; //item da NFe

        $stdAdProd->infAdProd = 'informacao adicional do item';

        $adProd = $nfe->taginfAdProd($stdAdProd);

        /** IMPOSTO */
        $stdImposto = new stdClass();
        $stdImposto->item = 1;
        $stdImposto->vTotTrib = 4.00; // Example, can be the sum of all taxes.

        $imposto = $nfe->tagimposto($stdImposto);


        /** ICMS */
        $stdICMS = new stdClass();
        $stdICMS->item = 1;
        $stdICMS->orig = 0;
        $stdICMS->CST = "00";
        $stdICMS->modBC = "0";
        $stdICMS->vBC = $stdProd->vProd; // Base calculation (vProd)
        $stdICMS->pICMS = 18.00; // ICMS percentage (adjust if different)
        $stdICMS->vICMS = floatval($stdICMS->vBC * ($stdICMS->pICMS / 100));  // Calculate ICMS value

        $icms = $nfe->tagICMS($stdICMS);

        /** PIS */
        $stdPIS = new stdClass();
        $stdPIS->item = 1; //item da NFe
        $stdPIS->CST = '99';
        $stdPIS->vBC = $stdProd->vProd;
        $stdPIS->pPIS = 1.65;
        $stdPIS->vPIS = $stdPIS->vBC * ($stdPIS->pPIS / 100);
        //$stdPIS->qBCProd = null;
        //$stdPIS->vAliqProd = null;

        $pis = $nfe->tagPIS($stdPIS);

        /** COFINS */
        $stdCOFINS = new stdClass();
        $stdCOFINS->item = 1; //item da NFe
        $stdCOFINS->CST = '99';
        $stdCOFINS->vBC = $stdProd->vProd;
        $stdCOFINS->pCOFINS = 0.65;
        $stdCOFINS->vCOFINS = $stdCOFINS->vBC * ($stdCOFINS->pCOFINS / 100);

        $cofins = $nfe->tagCOFINS($stdCOFINS);

        /** TOTAL */
        $stdICMSTot = new stdClass();
        $stdICMSTot->vBC = floatval($stdICMS->vBC);  // Set the vBC value
        $stdICMSTot->vICMS = floatval($stdICMS->vICMS);  // Set the vICMS value
        $stdICMSTot->vProd = $stdProd->vProd;
        $stdICMSTot->vNF = $stdProd->vProd + $stdICMS->vICMS;
        // ... other fields, like vProd, vNF, etc.  You'll likely need to compute these totals.
        $stdICMSTot->vFrete = 0.00;  // Example - adjust as necessary
        $stdICMSTot->vSeg = 0.00;
        $stdICMSTot->vDesc = 0.00;
        $stdICMSTot->vII = 0.00;
        $stdICMSTot->vIPI = 0.00;
        $stdICMSTot->vPIS = $stdPIS->vPIS;
        $stdICMSTot->vCOFINS = $stdCOFINS->vCOFINS;
        $stdICMSTot->vOutro = 0.00;
        $stdICMSTot->vIPIDevol = 0.00;
        $stdICMSTot->vFCP = 0.00;
        $stdICMSTot->vFCPST = 0.00;
        $stdICMSTot->vTotTrib = $stdImposto->vTotTrib; // total of taxes

        $icmsTot = $nfe->tagICMSTot($stdICMSTot);

        /** TRANSPORTADORA */
        $stdTransp = new stdClass();
        $stdTransp->modFrete = 1;

        $transp = $nfe->tagtransp($stdTransp);

        // //** VOLUME */
        // $stdVolume = new stdClass();
        // $stdVolume->item = 1; //indicativo do numero do volume
        // $stdVolume->qVol = 2;
        // $stdVolume->esp = 'caixa';
        // $stdVolume->marca = 'OLX';
        // $stdVolume->nVol = '11111';
        // $stdVolume->pesoL = 10.50;
        // $stdVolume->pesoB = 11.00;

        // $volume = $nfe->tagvol($stdVolume);

        /** PAGAMENTO */
        $stdPag = new stdClass();
        $stdPag->vTroco = 0.00; //incluso no layout 4.00, obrigatório informar para NFCe (65)
        
        $pagamento = $nfe->tagpag($stdPag);

        /** DETALHE PAGAMENTO */
        $stdDetPag = new stdClass();
        //$stdDetPag->indPag = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo
        $stdDetPag->tPag = '01';
        $stdDetPag->vPag = $stdProd->vProd; //Obs: deve ser informado o valor pago pelo cliente
        $stdDetPag->CNPJ = '12345678901234'; //CNPJ da aut
        $stdDetPag->tBand = '01'; //Bandeira
        $stdDetPag->cAut = '3333333'; //codigo aut da via do estabelecimento
        $stdDetPag->tpIntegra = 1; //incluso na NT 2015/002 (se Tipo de Integração do processo de pagamento com o
                                                                // sistema de automação da empresa:
                                                                // 1=Pagamento integrado com o sistema de automação da
                                                                // empresa (Ex.: equipamento TEF, Comércio Eletrônico);
                                                                // 2= Pagamento não integrado com o sistema de automação
                                                                // da empresa (Ex.: equipamento POS);)
        //$stdDetPag->CNPJPag; //NT 2023.004 v1.00
        //$stdDetPag->UFPag; //NT 2023.004 v1.00
        //$stdDetPag->CNPJReceb; //NT 2023.004 v1.00
        //$stdDetPag->idTermPag; //NT 2023.004 v1.00

        $detpag = $nfe->tagdetPag($stdDetPag);

        //** INFORMAÇÔES ADICIONAIS */
        $stdAdic = new stdClass();
        $stdAdic->infAdFisco = 'informacoes para o fisco';
        $stdAdic->infCpl = 'informacoes complementares';

        $infAdic = $nfe->taginfAdic($stdAdic);

        //** INFORMAÇÔES ADICIONAIS */
        $stdinfNFeSupl = new stdClass();
        $stdinfNFeSupl->qrcode = "";
        $stdinfNFeSupl->urlChave = "";

        $infNFeSupl = $nfe->taginfNFeSupl($stdinfNFeSupl);
        // $erros = $nfe->getErrors();
        // dd($erros); // Exibe os erros na tela

        //Monta a nota
        if($nfe->montaNFe()){
            return $nfe->getXML();
        }else{
            throw new Exception("Erro ao montar a NFe: " . implode(", ", $nfe->getErrors()));
        }
    }

    //** ASSINAR NOTA */
    public function sign($xml)
    {
        return $this->tools->signNFe($xml);
    }

    //** Transmitir */
    public function transmitir($assinar)
    {
        $resp = $this->tools->sefazEnviaLote([$assinar], 1);
        $st = new Standardize();
        $stdResposta = $st->toStd($resp);
        // return $this->tools->sefazEnviaLote($aXml, $idLote, $indStnc, $compactar);
        return $stdResposta;
    }
}


//NOTA: para NFe (modelo 55), temos ...

// vPag=0.00 mas pode ter valor se a venda for à vista

// tPag é usualmente:

// 01=Dinheiro
// 02=Cheque
// 03=Cartão de Crédito
// 04=Cartão de Débito
// 05=Crédito Loja
// 10=Vale Alimentação
// 11=Vale Refeição
// 12=Vale Presente
// 13=Vale Combustível
// 15=Boleto Bancário
// 16=Depósito Bancário
// 17=Pagamento Instantâneo (PIX)
// 18=Transferência bancária, Carteira Digital
// 19=Programa de fidelidade, Cashback, Crédito Virtual
// 90= Sem pagamento
// 99=Outros
// (Atualizado na NT2016.002, NT2020.006)


// 01=Visa
// 02=Mastercard
// 03=American Express
// 04=Sorocred
// 05=Diners Club
// 06=Elo
// 07=Hipercard
// 08=Aura
// 09=Cabal
// 99=Outros
// (Atualizado na NT2016.002)