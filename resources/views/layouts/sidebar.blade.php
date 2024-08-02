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
                    class="app-menu__label">Página Inicial</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                    class="app-menu__icon bi bi-person-workspace"></i><span class="app-menu__label">Recepção</span><i
                    class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{ route('agenda.index') }}"><i class="icon bi bi-calendar-plus"></i>
                        Criar Agenda</a></li>
                <li><a class="treeview-item" href="{{ route('agenda.index1') }}"><i class="icon bi bi-search"></i>
                        Consultar Agenda</a></li>
                {{-- <li><a class="treeview-item" href="{{route('anamnese.index')}}"><i class="icon bi bi-ui-checks"></i> Anamnese</a></li>
          <li><a class="treeview-item" href="{{route('anamnese.index1')}}"><i class="icon bi bi bi-list-ul"></i> Histórico de Anamnese</a></li> --}}
                <li>
                    <a class="treeview-item" href="#"><i class="icon bi bi-person-add"></i>Pacientes</a>
                    <ul>
                        <li><a class="treeview-item" href="{{ route('paciente.index') }}"><i
                                    class="icon bi bi-plus-circle"></i> Novo</a></li>
                        <li><a class="treeview-item" href="{{ route('paciente.index1') }}"><i
                                    class="icon bi bi-person-lines-fill"></i> Lista de Pacientes</a></li>
                    </ul>
                </li>
            </ul>
        </li>


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
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
            class="app-menu__icon bi bi-cash-coin"></i><span class="app-menu__label">Financeiro</span><i
            class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{ route('Honorario.index') }}"><i 
                    class="icon bi bi-building-fill-add"></i> Honorario Médico</a></li>
                <li><a class="treeview-item" href="{{ route('convenioProcedimento.index') }}"><i 
                    class="icon bi bi-list-task"></i> Valor Procedimento</a></li>
            </ul>
        </li>
        <li><a class="app-menu__item" href="{{ route('empresa.index') }}"><i
                    class="app-menu__icon bi bi-buildings"></i><span class="app-menu__label">Empresa</span></a></li>
    </ul>
</aside>
