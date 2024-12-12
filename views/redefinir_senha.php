<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir senha</title>
    <link rel="stylesheet" href="../public/css/redefinir.css" />
</head>
<body>
    <div class="left-border"></div>
    <div class="image-overlay"> 
        <div class="blue-bar">
            <div class="senac-logo">
                <img src="../public/imgs/senac_logo_branco.png" alt="Logo Senac">
            </div>
            <div class="texts">
                <div class="text-primary">Sistema de Gerenciamento</div>
                <div class="text-secondary">Laboratório Maker</div>
            </div>
        </div>
    </div>
    <div class="reset-password-section">
        <h2>Redefinir Senha</h2>
        <?php
            if (isset($_GET['success'])) {
                echo "<p class='success-msg'>Senha redefinida com sucesso. Verifique seu e-mail para mais detalhes.</p>";
            } elseif (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error == 'email_fail') {
                    echo "<p class='error-msg'>Falha ao enviar e-mail. Tente novamente mais tarde.</p>";
                } elseif ($error == 'db_fail') {
                    echo "<p class='error-msg'>Erro ao conectar ao banco de dados. Tente novamente mais tarde.</p>";
                } elseif ($error == 'not_found') {
                    echo "<p class='error-msg'>E-mail não encontrado. Verifique e tente novamente.</p>";
                } elseif ($error == 'blank') {
                    echo "<p class='error-msg'>O campo de e-mail não pode estar vazio.</p>";
                } else {
                    echo "<p class='error-msg'>Ocorreu um erro desconhecido.</p>";
                }
            }
        ?>
        <form action="../src/controller/controller_redef_senha.php" method="post">
            <label for="email">Endereço de E-mail:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Confirmar</button>
            <a href="login.php" class="back-to-login">Voltar para login</a>
        </form>
    </div>
</body>
</html>
