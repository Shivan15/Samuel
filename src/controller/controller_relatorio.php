<?php
require_once('../config/dbConnect.php');

// Função para atualizar os status das reservas
function atualizarStatusReservas() {
    global $dbh;

    $currentDate = date('Y-m-d');  // Data atual no formato Y-m-d
    $currentTime = date('H:i:s');  // Hora atual no formato H:i:s

    // Passo 1: Selecionar os IDs das reservas a serem atualizadas
    $selectQuery = "
        SELECT id
        FROM reserva
        WHERE (dt < :currentDate OR (dt = :currentDate AND hr_f <= :currentTime))
          OR (dt = :currentDate AND hr_i <= :currentTime AND hr_f > :currentTime)
    ";

    $stmt = $dbh->prepare($selectQuery);
    $stmt->execute([
        ':currentDate' => $currentDate,
        ':currentTime' => $currentTime,
    ]);

    // Obter os IDs das reservas
    $reservasToUpdate = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $idArray = array_map(function($reserva) {
        return $reserva['id'];
    }, $reservasToUpdate);

    // Passo 2: Atualizar as reservas com base nos IDs
    if (!empty($idArray)) {
        $idList = implode(",", $idArray);

        // Agora vamos fazer o UPDATE com os IDs selecionados
        $updateQuery = "
            UPDATE reserva
            SET stts = 
                CASE
                    WHEN dt < :currentDate OR (dt = :currentDate AND hr_f <= :currentTime) THEN 'Concluído'
                    WHEN dt = :currentDate AND hr_i <= :currentTime AND hr_f > :currentTime THEN 'Em andamento'
                    ELSE 'Pendente'
                END
            WHERE id IN ($idList)
        ";

        $updateStmt = $dbh->prepare($updateQuery);
        $updateStmt->execute([
            ':currentDate' => $currentDate,
            ':currentTime' => $currentTime,
        ]);
    }
}

// Função para obter as reservas e seus dados
function obterReservas() {
    global $dbh;

    $infos = "
        SELECT 
            r.id, 
            r.solicitante, 
            r.email, 
            u.nome AS nome_usuario, 
            r.stts, 
            m.nome AS nome_material, 
            r.dt, 
            r.hr_i, 
            r.hr_f 
        FROM reserva AS r 
        JOIN usuario AS u ON r.id_us = u.id 
        JOIN resmat AS rm ON r.id = rm.id_res 
        JOIN material AS m ON m.id = rm.id_mat
    ";
    $todasInfos = $dbh->query($infos);
    return $todasInfos->fetchAll(PDO::FETCH_ASSOC);
}
?>
