<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

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
            
            if ($user) {
                // Usando cache para armazenar dados temporários e evitar consultas repetidas
                $messagesNaoVisualizadas = Cache::remember("user_{$user->id}_messages_nao_visualizadas", 60, function () use ($user) {
                    return Message::where('destinatario_id', $user->id)
                        ->whereNull('visualizar')
                        ->count();
                });

                $remetentesNaoVisualizados = Cache::remember("user_{$user->id}_remetentes_nao_visualizados", 60, function () use ($user) {
                    return Message::where('destinatario_id', $user->id)
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
                });
            } else {
                $messagesNaoVisualizadas = 0;
                $remetentesNaoVisualizados = [];
            }
            
            // Carregar dados necessários para a view
            $users = Cache::remember('all_users', 60, function () {
                return User::select('id', 'name')->get(); // Apenas dados necessários
            });

            // $messages = Message::all();

            $view->with([
                'users' => $users,
                'messagesNaoVisualizadas' => $messagesNaoVisualizadas,
                'remetentesNaoVisualizados' => $remetentesNaoVisualizados
            ]);
        });
    }
}
