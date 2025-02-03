<header class="app-header">
    <a class="app-header__logo" href="/home">
        <img src="{{ asset('images/LOGO_01_HORIZONTAL.png') }}" alt="ePRONTUARIO" style="height: 35px;">
    </a>
    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
        <li class="dropdown d-flex align-items-center">
            <span id="current-date-time" class="me-3 text-white"></span>
            <a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu">
                <i class="bi bi-person fs-4"></i>
            </a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item open-chat-modal" href="#"><i class="bi bi-chat-dots"></i> êProntuário Chat</a></li>
                <li><a class="dropdown-item" href="http://esuporte.com.br:8090"><i class="bi bi-headset"></i> Suporte</a></li>
                @if (Auth::user()->permissoes->contains('id', 3))
                    <li><a type="button" onclick="abrirNovaJanela1();" class="dropdown-item"><i class="bi bi-person-vcard"></i> Tela de Chamado</a></li>
                @endif
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2 fs-5"></i> Sair
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</header>

<!-- Modal para abrir o chat -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">êProntuário Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex">
                <div class="nav flex-column nav-pills me-3" id="chatTabs" role="tablist">
                    @foreach ($users as $user)
                        @if ($user->id !== auth()->id())
                                <button class="nav-link @if ($loop->first) active @endif" id="tab-{{ $user->id }}" data-bs-toggle="tab" data-bs-target="#chat-{{ $user->id }}" type="button" role="tab">
                                    {{ $user->name }}
                                </button>
                        @endif
                    @endforeach
                </div>
                <div class="tab-content" id="chatTabContent" style="width: 650px;">
                    @foreach ($users as $user)
                        <div class="tab-pane fade @if ($loop->first) show active @endif" id="chat-{{ $user->id }}" role="tabpanel">
                            <iframe class="chat-iframe" id="chat-iframe-{{ $user->id }}" data-user-id="{{ $user->id }}" width="100%" height="400px" frameborder="0"></iframe>
                            <form class="chat-form" data-user-id="{{ $user->id }}">
                                @csrf
                                <input type="hidden" name="destinatario_id" value="{{ $user->id }}">
                                <textarea name="messagem" class="form-control" placeholder="Digite sua mensagem"></textarea>
                                <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    
    // Função para formatar a data e hora de forma mais limpa
    function updateDateTime() {
        const dateTimeElement = document.getElementById('current-date-time');
        const now = new Date();

        // Formata a data e hora de forma dinâmica
        const day = String(now.getDate()).padStart(2, '0'); // Dia com dois dígitos
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Mês com dois dígitos
        const year = now.getFullYear(); // Ano completo
        const hours = String(now.getHours()).padStart(2, '0'); // Hora com dois dígitos
        const minutes = String(now.getMinutes()).padStart(2, '0'); // Minutos com dois dígitos

        // Exibição no formato: 10/01/2025 - 14:36
        const formattedDate = `${day}/${month}/${year}`;
        const formattedTime = `${hours}:${minutes}`;

        dateTimeElement.textContent = `${formattedDate} - ${formattedTime}`;
    }

    // Atualiza a cada segundo
    setInterval(updateDateTime, 1000);
    updateDateTime(); // Atualiza imediatamente ao carregar a página

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("textarea[name='messagem']").forEach(function (textarea) {
            textarea.addEventListener("keydown", function (event) {
                if (event.key === "Enter" && !event.shiftKey) {
                    event.preventDefault(); // Evita quebra de linha
                    let form = this.closest("form"); // Encontra o formulário mais próximo
                    form.querySelector("button[type='submit']").click(); // Simula clique no botão enviar
                }
            });
        });
    });


    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".chat-form").forEach(form => {
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Impede o recarregamento da página

            let formData = new FormData(this);
            let userId = this.dataset.userId;
            let chatContainer = document.querySelector(`#chat-iframe-${userId}`);

            fetch("{{ route('chat.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Erro na requisição. Código: " + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Atualiza a lista de mensagens no iframe sem recarregar
                    if (chatContainer) {
                        chatContainer.contentWindow.location.reload();
                    }

                    // Limpa o campo de mensagem
                    form.querySelector("textarea[name='messagem']").value = "";
                } else {
                    alert("Erro ao enviar a mensagem: " + data.error);
                }
            })
            .catch(error => {
                console.error("Erro na requisição:", error);
                alert("Erro ao processar a mensagem. Verifique o console para mais detalhes.");
            });
        });
    });
});

    // Evento para abrir o modal pelo botão "Call Interno"
    document.querySelector(".open-chat-modal").addEventListener("click", function (event) {
        event.preventDefault();
        let firstUserTab = document.querySelector(".chat-iframe");
        if (firstUserTab && firstUserTab.src === "") {
            firstUserTab.src = `/chat/${firstUserTab.dataset.userId}`;
        }
        new bootstrap.Modal(document.getElementById("chatModal")).show();
    });

    // Carregar o chat ao clicar em uma aba
    document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (event) {
            let targetId = event.target.getAttribute('data-bs-target').replace("#chat-", "");
            let iframe = document.querySelector(`#chat-iframe-${targetId}`);
            if (iframe && iframe.src === "") {
                iframe.src = `/chat/${targetId}`;
            }
        });
    });
</script>

<style>
    #current-date-time {
        color: white; /* Define o texto em branco */
        font-size: 14px; /* Ajusta o tamanho do texto */
    }
</style>
''
