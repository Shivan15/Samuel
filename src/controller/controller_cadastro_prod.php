<?php
require_once('../../config/dbConnect.php');

// Iniciar a sessão para usar variáveis de sessão
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados do formulário
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
    $categoria = isset($_POST['categoria']) ? (int)$_POST['categoria'] : null;
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : null;
    $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : null;
    $unidade_medida = isset($_POST['unidade_medida']) ? (int)$_POST['unidade_medida'] : null;

    // Definir o valor de "stts" como 1 (ativo) caso não tenha sido passado
    $stts = 1;

    // Validar os dados obrigatórios
    if (!$nome || !$categoria || !$descricao || !$quantidade || !$unidade_medida) {
        $_SESSION['error_message'] = "Preencha todos os campos corretamente.";
        header('Location: ../../views/gerenciamento.php');
        exit();
    }

    try {
        // Preparar a consulta para inserir no banco de dados
        $insert = "INSERT INTO material (qtd, id_cat, id_uni_med, nome, descr, stts) 
                   VALUES (:quantidade, :categoria, :unidade_medida, :nome,  :descricao, :stts)";
        $stmt = $dbh->prepare($insert);

        // Vincular os valores
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
        $stmt->bindParam(':unidade_medida', $unidade_medida, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':stts', $stts, PDO::PARAM_INT);  // Adicionando o campo stts

        // Executar a consulta
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Produto cadastrado com sucesso!";
            header('Location: ../../views/gerenciamento.php');
            exit();
        } else {
            $_SESSION['error_message'] = "Erro ao cadastrar o produto. Tente novamente.";
            header('Location: ../../views/gerenciamento.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erro no banco de dados: " . $e->getMessage();
        header('Location: ../../views/gerenciamento.php');
        exit();
    }
} else {
    $_SESSION['error_message'] = "Método de requisição inválido.";
    header('Location: ../../views/gerenciamento.php');
    exit();
}
?>
