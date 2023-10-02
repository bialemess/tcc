
<?php
include("conexaoBD.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
    $quantidade = isset($_POST["quantidade"]) ? $_POST["quantidade"] : "";
    $code = isset($_POST["code"]) ? $_POST["code"] : "";
    $category = isset($_POST["category"]) ? $_POST["category"] : "";
    $unidadeMedida = isset($_POST["unidadeMedida"]) ? $_POST["unidadeMedida"] : "";

    $arquivoFoto = $_FILES["novaImagem"];

    // Se um novo arquivo foi enviado, faça o upload
    if ($arquivoFoto["error"] === 0) {
        $caminhoArquivo = "upload/produtos/" . $arquivoFoto["name"];
        move_uploaded_file($arquivoFoto["tmp_name"], $caminhoArquivo);
    } else {
        // Se nenhum novo arquivo foi enviado, mantenha o caminho atual
        $caminhoArquivo = $_POST["arquivoFoto"];
    }

    try {
        $sql = "UPDATE produtoTCC SET nome=?, quantidade=?, code=?, category=?, unidadeMedida=?, arquivoFoto=? WHERE code=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $quantidade, $code, $category, $unidadeMedida, $caminhoArquivo, $code]);

        // Aqui você pode adicionar uma lógica para exibir uma mensagem de sucesso, se necessário
        echo "Edição bem-sucedida!";
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>



