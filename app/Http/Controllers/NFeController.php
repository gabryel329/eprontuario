<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\NfeParticula;
use Illuminate\Http\Request;
use App\Services\NFeService;
use NFePHP\NFe\Complements;

class NFeController extends Controller
{
    public function index()
    {
        return 201;
    }

    public function store(Request $request)
    {
        $empresa = Empresas::first();

        $nfe_service = new NFeService([
            "atualizacao" => date("Y-m-d\TH:i:sP"),
            "tpAmb" => 2, // 1 - Produção / 2 - Homologação
            "razaosocial" => $empresa->name,
            "siglaUF" => substr($empresa->uf, 0, 2), // Garante que só pegue 2 caracteres
            "cnpj" => preg_replace('/\D/', '', $empresa->cnpj), // Remove tudo que não for número
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            // "tokenIBPT" => "AAAAAAA", // Caso tenha um token IBPT, adicione aqui
            // "CSC" => "SEU_CSC_AQUI", // Adicione o CSC se disponível
            // "CSCid" => "000002" // Adicione o CSCid se necessário
        ]);

        header('Content-type: text/xml; charset-UTC-8');

        //Gera o XML
        $xml = $nfe_service->gerarNFe();

        // Assinar
        $assinar_xml = $nfe_service->sign($xml);

        // Transmitir
        $resultado = $nfe_service->transmitir($assinar_xml);

         // Verifica se houve sucesso na transmissão
        if (isset($resultado->cStat) && $resultado->cStat == "104") { // 104 = Lote processado
            if (isset($resultado->protNFe->infProt->cStat) && $resultado->protNFe->infProt->cStat == "100") { // 100 = Autorizado
                // Captura o protocolo de autorização
                $request_xml = $assinar_xml; // XML original assinado
                $response_xml = $nfe_service->convertToXml($resultado); // Resposta da SEFAZ

                // Insere o protocolo no XML da NF-e
                try {
                    $xml_protocolado = Complements::toAuthorize($request_xml, $response_xml);
                    // **Salva o XML protocolado em um arquivo**
                    // Corrigindo a forma de acessar o 'nProt' no nome do arquivo
                    $protocolo = $resultado->protNFe->infProt->nProt;
                    $file_name = storage_path("app/public/{$protocolo}.xml");

                    file_put_contents($file_name, $xml_protocolado);
                     // **Salva o XML protocolado em um arquivo**
                    //file_put_contents(storage_path('app/public/nota.xml'), $xml_protocolado);
                    // **Faz o update no último registro da tabela NfeParticula**
                    $ultimaNfe = NfeParticula::orderBy('id', 'desc')->first();
                    
                    if ($ultimaNfe) {
                        // Atualiza o último registro com os valores de nRec e nProt
                        $ultimaNfe->nRec = $resultado->infRec->nRec;
                        $ultimaNfe->nProt = $protocolo;
                        $ultimaNfe->save();
                    }

                    return response($xml_protocolado, 200)->header('Content-Type', 'text/xml');
                } catch (\Exception $e) {
                    return response("Erro ao protocolar NF-e: " . $e->getMessage(), 500);
                }
            } else {
                return response("Erro na transmissão da NF-e: " . $resultado->protNFe->infProt->xMotivo, 500);
            }
        } else {
            return response("Erro na comunicação com SEFAZ: " . json_encode($resultado), 500);
        }
    }

    public function show()
    {
        $nfe_service = new NFeService([
            "atualizacao" => date("Y-m-d\TH:i:sP"),
            "tpAmb" => 2, // 1 - Produção / 2 - Homologação
            "razaosocial" => "EG TECNOLOGIA E PUBLICIDADE LTDA",
            "siglaUF" => "BA", // Substitua pelo estado correto da empresa
            "cnpj" => "54487176000149",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            // "tokenIBPT" => "AAAAAAA", // Caso tenha um token IBPT, adicione aqui
            // "CSC" => "SEU_CSC_AQUI", // Adicione o CSC se disponível
            // "CSCid" => "000002" // Adicione o CSCid se necessário
        ]);

        $numeroRecibo = "291200011429743";
        
        // Garante que a função de consulta está implementada
        $resposta = $nfe_service->consultarLote($numeroRecibo);
        
        // Exibir o retorno estruturado
        return $resposta;
    }
}