<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        @if(Auth::user()->imagem)
            <img class="app-sidebar__user-avatar" src="images/{{ asset(Auth::user()->imagem) }}" alt="User Image" class="user-image">
        @else
            <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
        @endif
        <div>
          <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
          <p class="app-sidebar__user-designation">{{ optional(Auth::user()->especialidade)->especialidade }}</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="/home"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-laptop"></i><span class="app-menu__label">Atendimento</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{route('anamnese.index')}}"><i class="icon bi bi-circle-fill"></i> Anamnese</a></li>
            <li><a class="treeview-item" href="{{route('anamnese.index1')}}"><i class="icon bi bi-circle-fill"></i> Histórico de <br> Anamnese</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Agenda Médica</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Histórico de <br> Atendimentos</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Agenda</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Marcação</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Criar Agenda</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Agenda do dia</a></li>

          </ul>
        </li>
        <li>
          <li class="treeview"><a class="app-menu__item" href="{{route('paciente.index')}}" data-toggle="treeview"><i class="app-menu__icon bi bi-table"></i><span class="app-menu__label">Pacientes</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="{{route('paciente.index')}}"><i class="icon bi bi-circle-fill"></i> Novo</a></li>
            <li><a class="treeview-item" href="{{route('paciente.index1')}}"><i class="icon bi bi-circle-fill"></i> Lista de Pacientes</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-file-earmark"></i><span class="app-menu__label">Administração</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li>
              <a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i>Cadastros</a>
              <ul>
                <li><a class="treeview-item" href="{{route('permisao.index')}}"><i class="icon bi bi-circle-fill"></i> Permissões</a></li>
                <li><a class="treeview-item" href="{{route('especialidade.index')}}"><i class="icon bi bi-circle-fill"></i> Especialidades</a></li>
                <li><a class="treeview-item" href="{{route('usuario.index')}}"><i class="icon bi bi-circle-fill"></i> Usuários</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a class="app-menu__item" href="#"><i class="app-menu__icon bi bi-code-square"></i><span class="app-menu__label">Empresa</span></a></li>
      </ul>
    </aside>