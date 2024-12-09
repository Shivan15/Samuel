<?php
require_once("../../config/dbConnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber e-mail do formulário
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email) {
        // Verificar se o e-mail está cadastrado e ativo
        $verifCadastro = "SELECT email FROM usuario WHERE email = :email AND stts = '1'";
        $req = $dbh->prepare($verifCadastro);
        $req->bindValue(':email', $email);

        // Executar query
        if ($req->execute()) {
            if ($req->rowCount() > 0) { // Se o e-mail for encontrado
                // Atualiza senha para a senha padrão (Senac123)
                $senha = "Senac123";
                $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

                // Atualizar senha no banco de dados
                $upd = "UPDATE usuario SET senha = :senha WHERE email = :email";
                $stmt = $dbh->prepare($upd);
                $stmt->bindValue(':senha', $senhaHash);
                $stmt->bindValue(':email', $email);

                // Executa a atualização
                if ($stmt->execute()) {
                    // Enviar e-mail avisando que a senha foi alterada para a senha padrão
                    $assunto = "Alteração de Senha - Sistema de Gerenciamento LabMaker Senac";
                    $mensagem = "Olá,\n\nSua senha foi alterada para a senha padrão.\n\n"
                              . "Agora você pode fazer o login com a senha: Senac123\n\n"
                              . "Após o login, você poderá alterar sua senha através do sistema.\n\n"
                              . "Atenciosamente,\nEquipe de Suporte.";

                    $headers = "From: suporte@sistema.com.br\r\n";
                    $headers .= "Reply-To: suporte@sistema.com.br\r\n";
                    $headers .= "X-Mailer: PHP/" . phpversion();

                    // Detectar o sistema operacional
                    if (stristr(PHP_OS, 'WIN')) {
                        // Configuração para Windows
                        $mail_sent = mail($email, $assunto, $mensagem, $headers);
                    } else {
                        // Configuração para Linux
                        ini_set('sendmail_path', '/usr/sbin/sendmail -t -i');
                        $mail_sent = mail($email, $assunto, $mensagem, $headers);
                    }

                    // Verificar se o e-mail foi enviado com sucesso
                    if ($mail_sent) {
                        header('Location: ../../views/redefinir_senha.php?success=true');
                        exit;
                    } else {
                        // Caso falhe o envio do e-mail
                        error_log("Falha ao enviar e-mail para $email");
                        header('Location: ../../views/redefinir_senha.php?error=email_fail');
                        exit;
                    }
                } else {
                    // Caso falhe a atualização no banco
                    header('Location: ../../views/redefinir_senha.php?error=db_fail');
                    exit;
                }
            } else {
                // Caso o e-mail não seja encontrado
                header('Location: ../../views/redefinir_senha.php?error=not_found');
                exit;
            }
        } else {
            // Caso falhe a execução da consulta de verificação
            header('Location: ../../views/redefinir_senha.php?error=db_fail');
            exit;
        }
    } else {
        // Caso o e-mail seja inválido ou em branco
        header('Location: ../../views/redefinir_senha.php?error=blank');
        exit;
    }
}
?>
