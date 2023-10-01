<?php
include("conexaoBD.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";

    try {
        $stmt = $pdo->prepare("DELETE FROM produtoTCC WHERE nome = :nome");
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>