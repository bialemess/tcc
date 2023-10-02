<?php
include("conexaoBD.php");

define("UPLOAD_DIR", "upload/produtos/");

function deletar($code)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("DELETE FROM produtoTCC WHERE code = :code");
        $stmt->bindValue(':code', $code);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function update($code, $nome, $category, $unidadeMedida, $quantidade, $foto)
{
    global $pdo;

    if ($foto) {
        $novoNomeFoto = substr($foto['name'], 0, 4) . "." . pathinfo($foto['name'], PATHINFO_EXTENSION);
        $uploadfile = UPLOAD_DIR . $novoNomeFoto;

        if (!move_uploaded_file($foto['tmp_name'], UPLOAD_DIR . $novoNomeFoto)) {
            $uploadfile = null;
        }

        $sql = "UPDATE produtoTCC SET nome = :nome, category = :category, unidadeMedida = :unidadeMedida, quantidade = :quantidade, arquivoFoto = :arquivoFoto WHERE code = :code";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':code', $code);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':category', $category);
            $stmt->bindValue(':unidadeMedida', $unidadeMedida);
            $stmt->bindValue(':quantidade', $quantidade);
            $stmt->bindValue(':arquivoFoto', $uploadfile);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        $sql = "UPDATE produtoTCC SET nome = :nome, category = :category, unidadeMedida = :unidadeMedida, quantidade = :quantidade WHERE code = :code";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':code', $code);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':category', $category);
            $stmt->bindValue(':unidadeMedida', $unidadeMedida);
            $stmt->bindValue(':quantidade', $quantidade);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
