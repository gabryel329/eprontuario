<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $messagesNaoVisualizadas = 0;
            $remetentesNaoVisualizados = [];
        
            if ($user) {
                $messagesNaoVisualizadas = Message::where('destinatario_id', $user->id)
                    ->whereNull('visualizar')
                    ->count();
        
                $remetentesNaoVisualizados = Message::where('destinatario_id', $user->id)
                    ->whereNull('visualizar')
                    ->selectRaw('remetente_id, COUNT(*) as total, MAX(created_at) as ultima_mensagem')
                    ->groupBy('remetente_id')
                    ->get()
                    ->map(function ($item) {
                        $tempo = now()->diffInMinutes($item->ultima_mensagem);
                        if ($tempo > 59) {
                            $tempo = floor($tempo / 60) . 'h ' . ($tempo % 60) . 'm';
                        } else {
                            $tempo .= ' min';
                        }
                        $item->tempo = $tempo;
                        return $item;
                    });
            }
        
            $view->with('users', User::all());
            $view->with('messages', Message::all());
            $view->with('messagesNaoVisualizadas', $messagesNaoVisualizadas);
            $view->with('remetentesNaoVisualizados', $remetentesNaoVisualizados);
        });
        
        
        
    }
}
