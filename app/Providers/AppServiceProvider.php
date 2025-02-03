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

            if ($user) {
                $messagesNaoVisualizadas = Message::where('destinatario_id', $user->id)
                    ->whereNull('visualizar')
                    ->count();
            }

            $view->with('users', User::all());
            $view->with('messages', Message::all());
            $view->with('messagesNaoVisualizadas', $messagesNaoVisualizadas);
        });
    }
}
