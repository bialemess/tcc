<?php
include("conexaoBD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    require "crud.php";

    if ($_POST["action"] == "editar") {
        $nome = $_POST["nome"];
        $quantidade = $_POST["quantidade"];
        $code = $_POST["code"];
        $category = $_POST["category"];
        $unidadeMedida = $_POST["unidadeMedida"];
        $arquivoFoto = isset($_FILES["arquivoFoto"]) ? $_FILES["arquivoFoto"] : null;

        if ($arquivoFoto && $arquivoFoto["tmp_name"] == "") {
            $arquivoFoto = null;
        }

        update($code, $nome, $category, $unidadeMedida, $quantidade, $arquivoFoto);
    } else if ($_POST["action"] == "excluir") {
        $code = $_POST["code"];
        deletar($code);
    }
}

$ordenarPor = isset($_GET["ordenarPor"]) ? $_GET["ordenarPor"] : "nome";

if (isset($_GET["nome"]) && $_GET["nome"]) {
    $nome = $_GET["nome"];

    $sql = "SELECT * FROM produtoTCC WHERE nome LIKE :nome ORDER BY $ordenarPor";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nome', "%$nome%");
} else if (isset($_GET["category"]) && $_GET["category"]) {
    $categoria = $_GET["category"];

    $sql = "SELECT * FROM produtoTCC WHERE category = :category ORDER BY $ordenarPor";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':category', $categoria);
} else {
    $sql = "SELECT * FROM produtoTCC ORDER BY $ordenarPor";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();

if ($stmt->rowCount() === 0) {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "Prato inexistente!",
            });
        </script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Consulta de Produtos</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="verifica.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>

    </style>
</head>

<body>
    <div class="navbar">
        <h1>Consulta de Produtos</h1>
        <form>
            <button class="menu-button" type="submit" formaction="adiciona.php">Inserir Prato</button>
            <button class="menu-button" type="submit" formaction="index.html">Voltar</button>
        </form>
    </div>
    <div class="container">
        <div class="form-container">
            <form>
                <strong>Nome do produto:</strong>
                <input type="text" name="nome">

                <label for="category">Categoria:</label>
                <select class="form-control" name="category" id="category" required>
                    <option selected disabled>Selecione uma unidade de medida</option>
                    <option value="cabeamento">Cabeamento</option>
                    <option value="alimentar">Alimentar</option>
                    <option value="Elétrico">Elétrico</option>
                    <option value="Hidráulico">Hidráulico</option>
                    <option value="Ferramentas">Ferramentas</option>
                    <option value="Maquinário">Maquinário</option>
                </select>

                <br>
                <br>

                <input type="submit" value="Consultar" class="menu-button">
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Código</th>
                    <th>Categoria</th>
                    <th>Unidade de medida</th>
                    <th>Foto</th>
                    <th>Edição</th>
                    <th>Exclusão</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $stmt->fetch()) : ?>
                    <form method="post" enctype="multipart/form-data">
                        <tr>
                            <td>
                                <input type="text" name="nome" value="<?= $row['nome'] ?>">
                            </td>
                            <td>
                                <input type="number" name="quantidade" value="<?= $row['quantidade'] ?>">
                            </td>
                            <td>
                                <input type="text" name="code" value="<?= $row['code'] ?>">
                            </td>
                            <td>
                                <input type="text" name="category" value="<?= $row['category'] ?>">
                            </td>
                            <td>
                                <input type="text" name="unidadeMedida" value="<?= $row['unidadeMedida'] ?>">
                            </td>
                            <td>
                                <input type="file" accept="image/*" name="arquivoFoto">
                                <img src="<?= $row['arquivoFoto'] ?>" width="100px" alt="">
                                </input>
                            </td>
                            <td><button type="submit" name="action" value="editar">Editar</button></td>
                            <td><button type="submit" name="action" value="excluir">Exclusão</button></td>
                        </tr>
                    </form>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function toggleEdit(button) {
            var row = button.parentNode.parentNode;
            var cells = row.querySelectorAll(".editable");
            var confirmButton = row.querySelector(".confirm-button");
            var editButton = row.querySelector(".edit-button");

            for (var i = 0; i < cells.length; i++) {
                cells[i].setAttribute("contenteditable", "true");
            }


            var fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.name = "novaImagem";
            fileInput.accept = "image/*";
            fileInput.style.display = "block";
            row.querySelector("[data-column='arquivoFoto']").appendChild(fileInput);

            confirmButton.style.display = "block";
            editButton.style.display = "none";
        }

        function confirmEdit(button) {
            var row = button.parentNode.parentNode;
            var cells = row.querySelectorAll(".editable");
            var confirmButton = row.querySelector(".confirm-button");
            var editButton = row.querySelector(".edit-button");

            for (var i = 0; i < cells.length; i++) {
                cells[i].setAttribute("contenteditable", "false");
            }

            var fileInput = row.querySelector("[data-column='arquivoFoto'] input");
            if (fileInput) {
                fileInput.parentNode.removeChild(fileInput);
            }

            confirmButton.style.display = "none";
            editButton.style.display = "block";

            var nome = row.querySelector("[data-column='nome']").innerHTML;
            var quantidade = row.querySelector("[data-column='quantidade'] input").value;
            var code = row.querySelector("[data-column='Código']").innerHTML;
            var category = row.querySelector("[data-column='categoria']").innerHTML;
            var unidadeMedida = row.querySelector("[data-column='unidadeMedida']").innerHTML;
            var arquivoFoto = row.querySelector("[data-column='arquivoFoto'] input") ? row.querySelector("[data-column='arquivoFoto'] input").files[0] : null;

            var formData = new FormData();
            formData.append("nome", nome);
            formData.append("quantidade", quantidade);
            formData.append("code", code);
            formData.append("category", category);
            formData.append("unidadeMedida", unidadeMedida);

            if (arquivoFoto) {
                formData.append("novaImagem", arquivoFoto);
            } else {
                var imagemAtual = row.querySelector("[data-column='arquivoFoto'] img").getAttribute("src");
                formData.append("arquivoFoto", imagemAtual);
            }

            var request = new XMLHttpRequest();
            request.open("POST", "edita.php");
            request.send(formData);
        }

        function removeRow(button) {
            var row = button.parentNode.parentNode;
            var nome = row.querySelector("[data-column='nome']").innerHTML;
            var code = row.querySelector("[data-column='Código']").innerHTML;
            var formData = new FormData();
            formData.append("nome", nome);
            formData.append("code", code);
            var request = new XMLHttpRequest();
            request.open("POST", "remove.php");
            request.send(formData);
            row.parentNode.removeChild(row);
        }
    </script>


</body>

</html>
