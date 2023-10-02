<?php
include("conexaoBD.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["code"])) {
    $code = $_POST["code"];

    try {
        $stmt = $pdo->prepare("DELETE FROM produtoTCC WHERE code = :code");
        $stmt->bindValue(':code', $code);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
