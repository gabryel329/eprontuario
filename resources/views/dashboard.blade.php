<!-- resources/views/open-custom-window.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrindo Janela Personalizada</title>
    <script type="text/javascript">
        window.onload = function () {
            const width = 800;
            const height = 600;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;

            const novaJanela = window.open(
                "{{ url('/home') }}",
                "_blank",
                `width=${width},height=${height},top=${top},left=${left},toolbar=no,location=no,` +
                `status=no,menubar=no,scrollbars=yes,resizable=no`
            );

            if (!novaJanela || novaJanela.closed || typeof novaJanela.closed == 'undefined') {
                alert("Por favor, permita pop-ups para abrir a página.");
            } else {
                setTimeout(() => {
                    window.history.back();
                }, 1000);
            }
        };
    </script>
</head>
<body>
</body>
</html>
