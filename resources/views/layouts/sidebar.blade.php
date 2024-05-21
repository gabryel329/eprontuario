<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        @if(Auth::user()->imagem)
            <img class="app-sidebar__user-avatar" src="images/{{ asset(Auth::user()->imagem) }}" alt="User Image" class="user-image">
        @else
            <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
        @endif
        <div>
          <p class="app-sidebar__user-name">{{ Auth::user()->name }} {{ Auth::user()->name }}</p>
          <p class="app-sidebar__user-designation">{{ optional(Auth::user()->especialidade)->especialidade }}</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="/home"><i class="app-menu__icon bi bi-speedometer"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-laptop"></i><span class="app-menu__label">Atendimento</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Lista</a></li>
            <li><a class="treeview-item" href="#" target="_blank" rel="noopener"><i class="icon bi bi-circle-fill"></i> Histórico</a></li>
            {{-- <li><a class="treeview-item" href="ui-cards.html"><i class="icon bi bi-circle-fill"></i> Cards</a></li>
            <li><a class="treeview-item" href="widgets.html"><i class="icon bi bi-circle-fill"></i> Widgets</a></li> --}}
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-ui-checks"></i><span class="app-menu__label">Forms</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Form Components</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Form Samples</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-table"></i><span class="app-menu__label">Pacientes</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Novo</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Lista</a></li>
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
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Login Page</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Lockscreen Page</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> User Page</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Invoice Page</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Mailbox</a></li>
            <li><a class="treeview-item" href="#"><i class="icon bi bi-circle-fill"></i> Error Page</a></li>
          </ul>
        </li>
        {{-- <li><a class="app-menu__item" href="docs.html"><i class="app-menu__icon bi bi-code-square"></i><span class="app-menu__label">Docs</span></a></li> --}}
      </ul>
    </aside>