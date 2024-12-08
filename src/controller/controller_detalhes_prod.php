<?php
require_once '../../config/dbConnect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $select = $dbh->prepare("
        SELECT 
            m.nome, 
            m.descr AS descricao, 
            m.qtd AS quantidade, 
            c.descr AS categoria, 
            u.descr AS unidade
        FROM material m
        LEFT JOIN categoria c ON m.id_cat = c.id
        LEFT JOIN uni_med u ON m.id_uni_med = u.id
        WHERE m.id = :id
    ");
    $select->bindParam(':id', $id, PDO::PARAM_INT);
    $select->execute();

    $material = $select->fetch(PDO::FETCH_ASSOC);

    if ($material) {
        echo json_encode($material);
    } else {
        echo json_encode(['error' => 'Material não encontrado.']);
    }
} else {
    echo json_encode(['error' => 'ID do material não fornecido.']);
}
?>