<aside class="app-sidebar">
    <div class="app-sidebar__user">
        @if (auth()->check())
            @if (Auth::user()->imagem)
                <img class="app-sidebar__user-avatar" src="{{ asset('images/' . Auth::user()->imagem) }}" alt="User Image"
                    class="user-image">
            @else
                <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
            @endif
            <div>
                <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
            </div>
        @else
            @php
                abort(419);
            @endphp
        @endif
    </div>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ request()->is('home*') ? 'active' : '' }}" href="/home">
                <i class="app-menu__icon bi bi-speedometer"></i>
                <span class="app-menu__label">Inicio</span>
            </a>
        </li>

        @if (Auth::user()->permissoes->pluck('id')->intersect([2, 3])->isNotEmpty())
            <li class="treeview {{ request()->is('lista', 'pacientes*', 'listapacientes*', 'agenda', 'marcacao*', 'agenda.consulta*', 'rel-agenda*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-telephone-outbound"></i>
                    <span class="app-menu__label">Recepção</span>
                    <i class="treeview-indicator bi bi-chevron-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item {{ request()->is('marcacao*') ? 'active' : '' }}" href="\marcacao">
                            <i class="icon bi bi-plus-square"></i> Marcar Consultas
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('gerar-agenda*') ? 'active' : '' }}" href="\gerar-agenda">
                            <i class="icon bi bi-calendar2-plus"></i> Gerar Agenda
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('lista') ? 'active' : '' }}" href="{{ route('agenda.index1') }}">
                            <i class="icon bi bi-search"></i> Consultas
                        </a>
                    </li>
                    {{-- <li>
                        <a class="treeview-item {{ request()->is('agenda*') ? 'active' : '' }}" href="{{ route('agenda.index') }}">
                            <i class="icon bi bi-calendar-plus"></i> Agenda Recepção
                        </a>
                    </li> --}}
                    <li>
                        <a class="treeview-item {{ request()->is('pacientes*', 'listapacientes*') ? 'active' : '' }}" href="{{ route('paciente.index') }}">
                            <i class="icon bi bi-person-add"></i> Pacientes
                        </a>
                        <ul>
                            <li>
                                <a class="treeview-item {{ request()->is('pacientes*') ? 'active' : '' }}" href="{{ route('paciente.index') }}">
                                    <i class="icon bi bi-plus-circle"></i> Novo
                                </a>
                            </li>
                            <li>
                                <a class="treeview-item {{ request()->is('listapacientes*') ? 'active' : '' }}" href="{{ route('paciente.index1') }}">
                                    <i class="icon bi bi-person-lines-fill"></i> Buscar Paciente
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('rel-agenda*') ? 'active' : '' }}" href="{{ route('agenda.consulta') }}">
                            <i class="icon bi bi-person-lines-fill"></i> Consultar Agenda
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->permissoes->pluck('id')->intersect([1, 3])->isNotEmpty())
            <li class="treeview {{ request()->is('agendamedica*', 'atendimento/lista*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-heart-pulse"></i>
                    <span class="app-menu__label">Médicos</span>
                    <i class="treeview-indicator bi bi-chevron-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item {{ request()->is('agendamedica*') ? 'active' : '' }}" href="{{ route('agenda.agendaMedica') }}">
                            <i class="icon bi bi-calendar2-check"></i> Atendimentos
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('atendimento/lista*') ? 'active' : '' }}" href="{{ route('atendimento.lista') }}">
                            <i class="icon bi bi-pencil-square"></i> Consultar Prontuários
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->permissoes->pluck('id')->intersect([3])->isNotEmpty())
            <li class="treeview {{ request()->is('permisoes*', 'especialidades*', 'usuarios*','honorario*','listausuarios*', 'profissional*','listaprofissional*', 'tipoprof*', 'convenio','listaconvenio*', 'taxa*', 'importar-excel*','convenios/procedures') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi bi-gear"></i>
                    <span class="app-menu__label">Cadastros</span>
                    <i class="treeview-indicator bi bi-chevron-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item {{ request()->is('permisoes*') ? 'active' : '' }}" href="{{ route('permisao.index') }}">
                            <i class="icon bi bi-arrow-bar-right"></i> Permissões
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('especialidades*') ? 'active' : '' }}" href="{{ route('especialidade.index') }}">
                            <i class="icon bi bi-eyeglasses"></i> Especialidades
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('usuarios*', 'listausuarios') ? 'active' : '' }}" href="{{ route('usuario.index') }}">
                            <i class="icon bi bi-people"></i> Usuários
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('profissional*', 'listaprofissional') ? 'active' : '' }}" href="{{ route('profissional.index') }}">
                            <i class="icon bi bi-briefcase"></i> Profissional
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('tipoprof*') ? 'active' : '' }}" href="{{ route('tipoprof.index') }}">
                            <i class="icon bi bi-file-earmark-person"></i> Tipo Profissional
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('convenio', 'listaconvenio*') ? 'active' : '' }}" href="{{ route('convenio.index') }}">
                            <i class="icon bi bi-building-fill-add"></i> Convenios
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('taxa*') ? 'active' : '' }}" href="{{ route('taxa.index') }}">
                            <i class="icon bi bi-building-fill-add"></i> Taxa
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('honorario*') ? 'active' : '' }}" href="{{ route('Honorario.index') }}">
                            <i class="icon bi bi-building-fill-add"></i> Honorario Médico
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('convenios/procedures') ? 'active' : '' }}" href="{{ route('convenios.index') }}">
                            <i class="icon bi bi-list-task"></i> Valores Procedimentos
                        </a>
                    </li>
                    {{-- <li>
                        <a class="treeview-item {{ request()->is('convenioProcedimento*') ? 'active' : '' }}" href="{{ route('convenioProcedimento.index') }}">
                            <i class="icon bi bi-list-task"></i> Cotação Convenio
                        </a>
                    </li> --}}
                    <li>
                        <a class="treeview-item {{ request()->is('importar-excel*') ? 'active' : '' }}" href="{{ route('imp_tabela.index') }}">
                            <i class="icon bi bi-building-fill-add"></i> Importar Tabelas
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('TabelaProcedimento*','relatorioGuia*', 'convenioProcedimento*', 'relatorioFinanceiro*', 'contasPagar', 'contasReceber', 'fornecedores*', 'listafornecedores*', 'bancos*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-bank"></i>
                    <span class="app-menu__label">Financeiro</span>
                    <i class="treeview-indicator bi bi-chevron-right"></i>
                </a>
                <ul class="treeview-menu">

                    {{-- <li>
                        <a class="treeview-item {{ request()->is('TabelaProcedimento*') ? 'active' : '' }}" href="{{ route('TabelaProcedimento.index') }}">
                            <i class="icon bi bi-table"></i> Tabelas
                        </a>
                    </li> --}}
                    <li>
                        <a class="treeview-item">
                            <i class="icon bi bi-file-earmark-excel"></i> Relatórios
                        </a>
                        <ul>
                            <li>
                                <a class="treeview-item {{ request()->is('relatorioFinanceiro*') ? 'active' : '' }}" href="{{ route('relatorioFinanceiro.index') }}">
                                    <i class="icon bi bi-cash"></i> Honorários Médico
                                </a>
                            </li>
                            <li>
                                <a class="treeview-item {{ request()->is('relatorioGuia*') ? 'active' : '' }}" href="{{ route('relatorioGuia.index') }}">
                                    <i class="icon bi bi-cash"></i> Relatório de Guias
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('contasPagar*') ? 'active' : '' }}" href="{{ route('contasPagar.index') }}">
                            <i class="icon bi bi-cash-coin"></i> Contas a pagar
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('contasReceber*') ? 'active' : '' }}" href="{{ route('contasReceber.index') }}">
                            <i class="icon bi bi-credit-card-2-back-fill"></i> Contas a receber
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('bancos*') ? 'active' : '' }}" href="{{ route('bancos.index') }}">
                            <i class="icon bi bi-piggy-bank-fill"></i> Bancos
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('fornecedores*', 'listafornecedores*') ? 'active' : '' }}" href="{{ route('fornecedores.index') }}">
                            <i class="icon bi bi-box-seam-fill"></i> Fornecedores
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is( 'produtos*', 'medicamentos*', 'listaprodutos*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi-house-gear-fill"></i>
                    <span class="app-menu__label">Estoque</span>
                    <i class="treeview-indicator bi bi-chevron-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item {{ request()->is('produtos*') ? 'active' : '' }}" href="{{ route('produtos.index') }}">
                            <i class="icon bi bi-plus-square"></i> Cadastros
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('medicamentos*') ? 'active' : '' }}" href="{{ route('medicamentos.index') }}">
                            <i class="icon bi bi bi-capsule"></i> Lista de Medicamentos
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('listaprodutos*') ? 'active' : '' }}" href="{{ route('listaprodutos.index') }}">
                            <i class="icon bi bi-boxes"></i> Lista de Produtos
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is( 'guia-sp*', 'guia-consulta*', 'guia-honorario') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-cash-coin"></i>
                    <span class="app-menu__label">Faturamento</span>
                    <i class="treeview-indicator bi bi-chevron-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item {{ request()->is('guia-sp*') ? 'active' : '' }}" href="{{ route('guiasp.index') }}">
                            <i class="icon bi bi-file-earmark-break"></i> Guia SP/SADT
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item {{ request()->is('guia-consulta*') ? 'active' : '' }}" href="{{ route('guiaconsulta.index') }}">
                            <i class="icon bi bi-file-earmark-break"></i> Guia de Consulta
                        </a>
                    </li>
                    {{-- <li>
                        <a class="treeview-item {{ request()->is('faturamentoBaixas*') ? 'active' : '' }}" href="{{ route('faturamentoBaixas.index') }}">
                            <i class="icon bi bi-piggy-bank-fill"></i> Lançamentos de Baixas
                        </a>
                    </li> --}}
                    <li>
                        <a class="treeview-item {{ request()->is('faturamentoGlosa*') ? 'active' : '' }}" href="{{ route('faturamentoGlosa.index') }}">
                            <i class="icon bi bi-piggy-bank-fill"></i> Glosas
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="app-menu__item {{ request()->is('empresa*') ? 'active' : '' }}" href="{{ route('empresa.index') }}">
                    <i class="app-menu__icon bi bi-buildings"></i>
                    <span class="app-menu__label">Empresa</span>
                </a>
            </li>
        @endif
    </ul>
</aside>
