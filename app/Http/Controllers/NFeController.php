<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NFeService;

class NFeController extends Controller
{
    public function index()
    {
        return 201;
    }

    public function store(Request $request)
    {
        $nfe_service = new NFeService([
            "atualizacao" => "2015-10-02 06:01:21",
            "tpAmb" => 2, //1-produção / 2-homologação
            "razaosocial" => "Fake Materiais de construção Ltda",
            "siglaUF" => "SP",
            "cnpj" => "34785515000166",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000002"
        ]);

        header('Content-type: text/xml; charset-UTC-8');

        //Gera o XML
        $xml = $nfe_service->gerarNFe();

        // Assinar
        $assinar = $nfe_service->sign($xml);

        // Transmitir
        $resultado = $nfe_service->transmitir($assinar);

        return $resultado;
        // return $assinar;
    }
}