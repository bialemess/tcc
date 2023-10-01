<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Produtos</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            text-align: center;
            margin: 0;
            padding: 0;
            font-size: 20px;
        }
        .navbar {
            background-color: #333;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            font-size: 32px;
            margin: 0;
        }
        .menu-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 20px;
           display: block;
           text-align: center;
           align-items: center;
              justify-content: center;


        }
         .menu-button:hover {
            background-color: #555;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #fff;
            margin-top: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            
        }
        th, td {
            border: 1px solid #ddd;
            padding: 16px;
            text-align: center;
            align-items: center;
            justify-content: center;

        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            margin-top: 20px;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        a:hover {
            color: #555;
        }
        .form-container {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .form-container p {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 10px;
        }


        
        .editable img {
            pointer-events: none;
            /* Impede a edição direta da imagem */
        }

        .editable input[type="file"] {
            display: none;
        }
        
        .form-container input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 20px;
        }
        .form-container input[type="submit"]:hover {
            background-color: #555;
        }
        .form-container label {
            font-weight: bold;
            font-size: 20px;
        }
        .form-container input[type="radio"] {
            margin-right: 10px;
        }
       

        #nomePrato {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Consulta de Produtos</h1>
        <form method="post">
            <button class="menu-button" type="submit" formaction="adiciona.php">Inserir Prato</button>
            <button class="menu-button" type="submit" formaction="index.html">Voltar</button>
        </form>
    </div>
    <div class="container">
        <div class="form-container">
            <form method="post">
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

        <?php
include("conexaoBD.php");

$nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
$categoria = isset($_POST["category"]) ? $_POST["category"] : "";

try {
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $ordenarPor = isset($_POST["ordenarPor"]) ? $_POST["ordenarPor"] : "nome"; 

        $sql = "SELECT * FROM produtoTCC";

      
        $conditions = [];
        $params = [];

        if (!empty($nome)) {
            $conditions[] = "nome LIKE ?";
            $params[] = "%$nome%";
        }

        if (!empty($categoria)) {
            $conditions[] = "category = ?";
            $params[] = $categoria;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY $ordenarPor, quantidade, code";

        $stmt = $pdo->prepare($sql);

    
        for ($i = 0; $i < count($params); $i++) {
            $stmt->bindValue($i + 1, $params[$i]);
        }

      
        $stmt->execute();

        echo "<table>";
        echo "<tr><th>Nome</th><th>Quantidade</th><th>Código</th><th>Categoria</th><th>Unidade de Medida</th><th>Foto</th><th>Edição</th><th>Exclusão</th></tr>";

        $resultFound = false; 
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td class='editable' contenteditable='false' data-column='nome'>" . $row['nome'] . "</td>";
            echo "<td class='editable' contenteditable='false' data-column='quantidade'>" . $row['quantidade'] . "</td>";
            echo "<td class='editable' contenteditable='false' data-column='Código'>" . $row['code'] . "</td>";
            echo "<td class='editable' contenteditable='false' data-column='categoria'>" . $row['category'] . "</td>";
            echo "<td class='editable' contenteditable='false' data-column='unidadeMedida'>" . $row['unidadeMedida'] . "</td>";

            echo "<td class='editable' contenteditable='false' data-column='arquivoFoto'><img src='" . $row['arquivoFoto'] . "' width='100px' height='100px'></td>";


         

            echo "<td>";
            echo "<button class='menu-button edit-button' onclick='toggleEdit(this)'>Editar</button>";
            echo "<button class='menu-button confirm-button' style='display: none' onclick='confirmEdit(this)'>Confirmar</button>";
            echo "</td>";

            echo "<td>";
            echo "<button class='menu-button remove-button' onclick='removeRow(this)'>Excluir</button>";
            echo "</td>";

            echo "</tr>";
            $resultFound = true;
        }

        echo "</table>";

if (!$resultFound) {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Erro",
                text: "Prato inexistente!",
            });
          </script>';
}

    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>



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