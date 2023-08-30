<?php
@session_start();
require_once("../../conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['newValue'])) {
    $idToEdit = $_POST['id'];
    $newValue = $_POST['newValue'];
    echo "Received ID:", $idToEdit;

    // Processamento para editar o registro no banco de dados
    $query = $pdo->prepare("UPDATE deposito SET valor = :valor WHERE id = :id");
    $query->bindParam(':valor', $newValue);
    $query->bindParam(':id', $idToEdit);

    try {
        if ($query->execute()) {
            echo "Registro editado com sucesso!";
        } else {
            echo "Ocorreu um erro ao editar o registro.";
        }
    } catch (PDOException $e) {
        echo "Erro na execução da consulta: " . $e->getMessage();
    }
}
?>
