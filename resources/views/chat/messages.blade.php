<div class="messages">
    @if ($messages->isEmpty())
        <p class="text-muted text-center">Nenhuma mensagem ainda.</p>
    @else
        @foreach ($messages as $message)
            <div class="message-wrapper {{ $message->remetente_id == auth()->id() ? 'sent' : 'received' }}">
                <div class="message-bubble">
                    <span class="message-sender">
                        {{ $message->remetente_id == auth()->id() ? 'Você' : $message->remetente->name }}
                    </span>
                    <p>{{ $message->messagem }}</p>
                    <span class="message-time">{{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</span>
                </div>
            </div>
        @endforeach
    @endif
</div>
<script>
    function recargarPage() {
        location.reload();  // Recarrega a página
    }

    // Define o intervalo de 3 segundos para chamar a função recargarPage
    setInterval(recargarPage, 3000);  // A cada 3000 milissegundos (3 segundos)
</script>
<style>
/* Estilização do container principal do chat */
.chat-container {
    display: flex;
    flex-direction: column;
    padding: 15px;
    max-height: 400px;
    overflow-y: auto;
    background-color: #f0f0f0;
    border-radius: 10px;
}

/* Estrutura das mensagens */
.message-wrapper {
    display: flex;
    width: 100%;
    margin-bottom: 10px;
}

/* Mensagem enviada */
.message-wrapper.sent {
    justify-content: flex-end;
}

/* Mensagem recebida */
.message-wrapper.received {
    justify-content: flex-start;
}

/* Estilização dos balões de mensagens */
.message-bubble {
    max-width: 60%;
    padding: 10px 15px;
    border-radius: 10px;
    position: relative;
    font-size: 14px;
    line-height: 1.4;
    word-wrap: break-word;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

/* Cor para mensagens enviadas pelo usuário */
.sent .message-bubble {
    background-color: #dcf8c6; /* Verde claro do WhatsApp */
    color: #000;
    border-top-right-radius: 0px;
}

/* Cor para mensagens recebidas */
.received .message-bubble {
    background-color: #ffffff;
    color: #000;
    border-top-left-radius: 0px;
}

/* Nome do remetente */
.message-sender {
    font-size: 12px;
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 3px;
}

/* Tempo da mensagem */
.message-time {
    font-size: 12px;
    color: #777;
    text-align: right;
    display: block;
    margin-top: 5px;
}

</style>
