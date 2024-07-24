<!DOCTYPE html>
<html>
<head>
    <title>Solicitação de Exame ou Procedimento</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
        <h3></h3>
        <table>
            <tr>
                <td colspan="2">
                    <img src="logo.png" alt="Logo" style="height: 50px;">
                    Secretaria de Saúde
                </td>
                <td colspan="3" style="text-align: center;">SOLICITAÇÃO DE EXAME OU PROCEDIMENTO</td>
            </tr>
            <tr>
                <td colspan="2">NOME DO PACIENTE: <input type="text" name="nome_paciente"></td>
                <td colspan="3">DOC. IDENTIDADE: <input type="text" name="doc_identidade"></td>
            </tr>
            <tr>
                <td colspan="5">ENDEREÇO: <input type="text" name="endereco"></td>
            </tr>
            <tr>
                <td colspan="5">MOTIVO DA SOLICITAÇÃO: <input type="text" name="motivo_solicitacao"></td>
            </tr>
            <tr>
                <td colspan="3">EXAME OU PROCEDIMENTO SOLICITADO: <input type="text" name="procedimento_solicitado"></td>
                <td colspan="2">CÓDIGO: <input type="text" name="codigo"></td>
            </tr>
            <tr>
                <td colspan="3">PROFISSIONAL SOLICITANTE: <input type="text" name="profissional_solicitante"></td>
                <td colspan="2">AUTORIZAÇÃO: <input type="text" name="autorizacao"></td>
            </tr>
            <tr>
                <td>DATA: <input type="date" name="data_solicitacao"></td>
                <td colspan="2"></td>
                <td>PACIENTE: <input type="text" name="paciente"></td>
                <td>DATA: <input type="date" name="data_paciente"></td>
            </tr>
        </table>
</body>
</html>
