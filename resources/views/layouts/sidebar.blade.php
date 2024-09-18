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
        <li><a class="app-menu__item active" href="/home"><i class="app-menu__icon bi bi-speedometer"></i><span
                    class="app-menu__label">Inicio</span></a></li>
                    @if (Auth::user()->permissoes->pluck('id')->intersect([2, 3])->isNotEmpty())
                        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                                    class="app-menu__icon bi bi-calendar-range"></i><span
                                    class="app-menu__label">Call-Center</span><i
                                    class="treeview-indicator bi bi-chevron-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a class="treeview-item" href="\gerar-agenda"><i
                                            class="icon bi bi-calendar2-plus"></i> Gerar Agenda</a></li>
                                <li><a class="treeview-item" href="\marcacao"><i
                                            class="icon bi bi-telephone-plus"></i> Marcação de Consultas</a></li>
                            </ul>
                        </li>
                    @endif
        @if (Auth::user()->permissoes->pluck('id')->intersect([2, 3])->isNotEmpty())
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                        class="app-menu__icon bi bi-person-workspace"></i><span
                        class="app-menu__label">Agendamento</span><i
                        class="treeview-indicator bi bi-chevron-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="{{ route('agenda.index') }}"><i
                                class="icon bi bi-calendar-plus"></i>
                            Agenda Recepção</a></li>
                    <li><a class="treeview-item" href="{{ route('agenda.index1') }}"><i class="icon bi bi-search"></i>
                            Disponibilidade</a></li>
                    <li>
                        <a class="treeview-item" href="#"><i class="icon bi bi-person-add"></i>Pacientes</a>
                        <ul>
                            <li><a class="treeview-item" href="{{ route('paciente.index') }}"><i
                                        class="icon bi bi-plus-circle"></i> Novo</a></li>
                            <li><a class="treeview-item" href="{{ route('paciente.index1') }}"><i
                                        class="icon bi bi-person-lines-fill"></i> Buscar Paciente</a></li>
                        </ul>
                    </li>
                    {{-- <li><a class="treeview-item" href="{{route('anamnese.index')}}"><i class="icon bi bi-ui-checks"></i> Anamnese</a></li>
                <li><a class="treeview-item" href="{{route('anamnese.index1')}}"><i class="icon bi bi bi-list-ul"></i> Histórico de Anamnese</a></li> --}}
                    
                </ul>
            </li>
        @endif
        @if (Auth::user()->permissoes->pluck('id')->intersect([1, 3])->isNotEmpty())
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                        class="app-menu__icon bi bi-heart-pulse"></i><span class="app-menu__label">Atendimento</span><i
                        class="treeview-indicator bi bi-chevron-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="{{ route('atendimento.lista') }}"><i
                                class="icon bi bi-pencil-square"></i> Prontuarios</a></li>
                    <li><a class="treeview-item" href="{{ route('agenda.agendaMedica') }}"><i
                                class="icon bi bi-calendar2-check"></i> Agenda Medica</a></li>
                </ul>
            </li>
        @endif
        @if (Auth::user()->permissoes->pluck('id')->intersect([3])->isNotEmpty())
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                        class="app-menu__icon bi bi bi-gear"></i><span class="app-menu__label">Administração</span><i
                        class="treeview-indicator bi bi-chevron-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="{{ route('permisao.index') }}"><i
                                class="icon bi bi-arrow-bar-right"></i> Permissões</a></li>
                    <li><a class="treeview-item" href="{{ route('especialidade.index') }}"><i
                                class="icon bi bi-eyeglasses"></i> Especialidades</a></li>
                    <li><a class="treeview-item" href="{{ route('usuario.index') }}"><i class="icon bi bi-people"></i>
                            Usuários</a></li>
                    <li><a class="treeview-item" href="{{ route('profissional.index') }}"><i
                                class="icon bi bi-briefcase"></i> Profissional</a></li>
                    <li><a class="treeview-item" href="{{ route('tipoprof.index') }}"><i
                                class="icon bi bi-file-earmark-person"></i> Tipo Profissional</a></li>
                    <li><a class="treeview-item" href="{{ route('convenio.index') }}"><i
                                class="icon bi bi-building-fill-add"></i> Convenios</a></li>
                    
                </ul>
            </li>
        @endif
        @if (Auth::user()->permissoes->pluck('id')->intersect([3])->isNotEmpty())
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                        class="app-menu__icon bi bi-cash-coin"></i><span class="app-menu__label">Financeiro</span><i
                        class="treeview-indicator bi bi-chevron-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="{{ route('guiatiss.index') }}"><i
                        class="icon bi bi-file-earmark-arrow-up"></i> Guia TISS</a></li>

                    <li><a class="treeview-item" href="{{ route('Honorario.index') }}"><i
                                class="icon bi bi-building-fill-add"></i> Honorario Médico</a></li>

                    <li><a class="treeview-item" href="{{ route('convenioProcedimento.index') }}"><i
                                class="icon bi bi-list-task"></i> Valor Procedimento</a></li>
                                
                    <li>
                        <a class="treeview-item" href="#"><i
                            class="icon bi bi-file-bar-graph"></i>Relatórios</a>
                        <ul>
                            <li><a class="treeview-item" href="{{ route('relatorioFinanceiro.index') }}"><i
                                class="icon bi bi-cash"></i> Honorários</a></li>
                            
                        </ul>
                    </li>
                    
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                        class="app-menu__icon bi bi-cash-coin"></i><span class="app-menu__label">Faturamento</span><i
                        class="treeview-indicator bi bi-chevron-right"></i></a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item" href="#"><i
                            class="icon bi bi-file-bar-graph"></i>Emissão de Guias</a>
                        <ul>
                            <li>
                                <a class="treeview-item" href="{{ route('guia_honorario.index') }}"><i
                                class="icon bi bi-cash"></i> Guia de Honorários</a>
                            </li>
                            <li>
                                <a class="treeview-item" href="{{ route('relatorioFinanceiro.index') }}"><i
                                class="icon bi bi-cash"></i> Guia SP/SADT</a>
                            </li>
                            <li>
                                <a class="treeview-item" href="{{ route('relatorioFinanceiro.index') }}"><i
                                class="icon bi bi-cash"></i> Guia de Consulta</a>
                            </li>
                            
                        </ul>
                    </li>
                    
                </ul>
            </li>
        @endif
        @if (Auth::user()->permissoes->pluck('id')->intersect([3])->isNotEmpty())
            <li><a class="app-menu__item" href="{{ route('empresa.index') }}"><i
                        class="app-menu__icon bi bi-buildings"></i><span class="app-menu__label">Empresa</span></a>
            </li>
        @endif
    </ul>
</aside>
