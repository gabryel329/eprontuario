<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GenerateIAController extends Controller
{
public function index(Request $request)
{
    set_time_limit(120);

    $request->validate([
        'text' => 'required|string',
    ]);

    $inputText = $request->input('text');

    try {
        $scriptPath = public_path('python' . DIRECTORY_SEPARATOR . 'blackbox_automation.py');
        $pythonPath = '"C:\\Users\\Design Rafaela\\AppData\\Local\\Programs\\Python\\Python312\\python.exe"';

        $command = $pythonPath . ' "' . $scriptPath . '" ' . escapeshellarg($inputText);
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(120);
        $process->run();

        if (!$process->isSuccessful()) {
            \Log::error("Erro no Python: " . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        $output = utf8_encode($process->getOutput()); // Garantir a codificação correta
        return response()->json(['text' => $output]);
    } catch (\Exception $e) {
        \Log::error("Erro ao executar script Python: " . $e->getMessage());
        return response()->json(['text' => 'Erro ao processar a solicitação.'], 500);
    }
}

}
