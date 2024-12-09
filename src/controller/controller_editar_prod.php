<?php
require_once ('../../config/dbConnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = $dbh->prepare("SELECT 
                                m.id AS material_id,
                                m.qtd AS quantidade,
                                m.descr AS material_descr,
                                m.nome AS material_nome,
                                um.id AS unidade_medida_id,
                                um.descr AS unidade_medida_descr,
                                c.id AS categoria_id,
                                c.descr AS categoria_descr
                            FROM 
                                material m
                            JOIN 
                                uni_med um ON m.id_uni_med = um.id
                            JOIN 
                                categoria c ON m.id_cat = c.id 
                            WHERE m.id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $produto = $query->fetch(PDO::FETCH_ASSOC);

        echo json_encode($produto ?: ["message" => "Produto não encontrado."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $dados);

    if (isset($dados['id'], $dados['nome'], $dados['descr'], $dados['qtd'])) {
        $query = $dbh->prepare("UPDATE material SET nome = :nome, descr = :descricao, qtd = :quantidade WHERE id = :id");
        $query->bindParam(':id', $dados['id'], PDO::PARAM_INT);
        $query->bindParam(':nome', $dados['nome']);
        $query->bindParam(':descricao', $dados['descr']);
        $query->bindParam(':quantidade', $dados['qtd']);

        if ($query->execute()) {
            echo json_encode(["message" => "Produto atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao atualizar produto."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Dados incompletos."]);
    }
}
