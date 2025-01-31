<div class="messages">
    @foreach ($messages as $message)
        <div class="message {{ $message->remetente_id == auth()->id() ? 'text-end' : 'text-start' }}">
            <strong>
                {{ $message->remetente_id == auth()->id() ? 'Você' : $message->remetente->name }}
            </strong>: 
            {{ $message->messagem }}
        </div>
    @endforeach
</div>
<script>
    function recargarPage() {
        location.reload();  // Recarrega a página
    }

    // Define o intervalo de 3 segundos para chamar a função recargarPage
    setInterval(recargarPage, 3000);  // A cada 3000 milissegundos (3 segundos)
</script>
