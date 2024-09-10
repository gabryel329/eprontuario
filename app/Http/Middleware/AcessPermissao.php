<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class AcessPermissao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$permissions
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = Auth::user();

        // Verifica se o usuário está autenticado
        if (!$user) {
            return response('Unauthorized.', 401);
        }

        // Recupera a licença da empresa associada ao usuário (ou à aplicação)
        $empresa = DB::table('empresas')->first();
        
        if (!$empresa || !$empresa->licenca) {
            return redirect()->back()->with('error', 'Licença não encontrada.');
        }

        // Converte a data de licença e a data atual para comparação
        $dataLicenca = Carbon::parse($empresa->licenca)->startOfDay();
        $dataAtual = Carbon::now()->startOfDay();

        // Se a data atual for maior que a data de licença, redireciona de volta
        if ($dataAtual->greaterThan($dataLicenca)) {
            return redirect()->back()->with('error', 'Licença expirada, entre em contado com o suporte.');
        }

        // Verifica as permissões do usuário
        $userPermissions = $user->permissoes()->pluck('permisao_id')->toArray();

        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                return $next($request);
            }
        }

        // Se não tiver a permissão, redireciona de volta
        return redirect()->back()->with('error', 'Página não encontrada.');
    }
}
