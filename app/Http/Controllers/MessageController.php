<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('chat.index', compact('users'));
    }

    public function show($id)
    {
        $messages = Message::where(function ($query) use ($id) {
                $query->where('remetente_id', auth()->id())->where('destinatario_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('remetente_id', $id)->where('destinatario_id', auth()->id());
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('chat.messages', compact('messages'));
    }


    public function store(Request $request)
    {
        try {
            // Certifique-se de que o campo correto está sendo validado
            $request->validate([
                'destinatario_id' => 'required|exists:users,id',
                'messagem' => 'required|string' // O nome correto é 'messagem'
            ]);

            // Salvar a mensagem no banco de dados
            $message = Message::create([
                'remetente_id' => auth()->id(),
                'destinatario_id' => $request->destinatario_id,
                'messagem' => $request->messagem // O nome correto é 'messagem'
            ]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $remetenteId = $request->remetente_id;
        $destinatarioId = auth()->id();

        // Atualiza todas as mensagens não visualizadas para "S"
        Message::where('remetente_id', $remetenteId)
               ->where('destinatario_id', $destinatarioId)
               ->whereNull('visualizar')
               ->update(['visualizar' => 'S']);

        return response()->json(['success' => true]);
    }


}
