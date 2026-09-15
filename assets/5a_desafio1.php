<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Verificador de Maioridade</title>
</head>
<body>
    <h1>Verificador de Maioridade</h1>
    <form method="post" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="ano_nascimento">Ano de Nascimento:</label>
        <input type="number" name="ano_nascimento" id="ano_nascimento" min="1900" max="<?= date('Y') ?>" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $anoNascimento = filter_input(INPUT_POST, 'ano_nascimento', FILTER_VALIDATE_INT);
    $anoAtual = (int) date('Y');

    if ($nome === '' || $anoNascimento === false || $anoNascimento < 1900 || $anoNascimento > $anoAtual) {
        echo '<p>Informe um nome e um ano de nascimento válido.</p>';
    } else {
        $idade = $anoAtual - $anoNascimento;
        $nomeSeguro = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');

        if ($idade >= 18) {
            file_put_contents('log_acessos.txt', $nome . ';' . $anoNascimento . PHP_EOL, FILE_APPEND | LOCK_EX);
            echo '<p>Acesso permitido, ' . $nomeSeguro . '!</p>';
        } else {
            echo '<p>Acesso negado, ' . $nomeSeguro . '!</p>';
        }
    }
}
?>
</body>
</html>