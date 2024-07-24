<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GenerateIAController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $text = $request->json('text');

        $client = new Client();
        $response = $client->post('https://api-inference.huggingface.co/models/gpt2', [
            'json' => ['inputs' => $text],
            'headers' => [
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        $responseText = $responseBody[0]['generated_text'] ?? 'Nenhuma resposta encontrada.';

        return response()->json(['text' => $responseText]);
    }
}
