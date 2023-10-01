<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    >
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            font-size: 18px; 
            margin: 0;
            
        }
        .navbar {
            background-color: #333;
            color: white;
            padding: 8px;
            text-align: right;
        }
        .navbar .btn-back {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 5px; 
        }
        .navbar .btn-back:hover {
            background-color: #555;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center; 
            justify-content: center; 
            min-height: 85vh;
        }
        .form-container {
            width: 50%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: white;
            font-size: 32px;
            text-align: center;
            font-weight: bold;
        }
        form {
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-row {
            margin-bottom: 15px;
        }
        .btn-submit {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 auto;
            display: block;
            border-radius: 5px;
        }
        .btn-submit:hover {
            background-color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            border-radius: 5px; 
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
        }
        
       

        

        .navbar {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }
        
        .navbar .menu-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 20px;
        }
        .navbar .menu-button:hover {
            background-color: #555;
        }

    </style>
</head>
<body>
<div class="navbar">
    <h1 style="margin: 0; padding: 8px; float: left;">Cadastro de Produtos</h1>
    <form method="post" style="float: right;">
       
        <button class="menu-button" type="submit" formaction="verifica.php">Consultar Produtos</button>
        <button class="menu-button" type="submit" formaction="index.html">Voltar</button>
    </form>
</div>


    <div class="container">
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="nome">Nome do produto:</label>
                        <input type="text" name="nome" id="nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="code">Código:</label>
                        <input type="number" name="code" id="code" required>
                    </div>
                </div>
                <div class="form-row">
                <div class="col-md-6">
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
</div>
<div class="col-md-6">
    <label for="unidadeMedida">Unidade de Medida:</label>
    <select class="form-control" name="unidadeMedida" id="unidadeMedida" required>
    
              <option selected disabled>Selecione uma unidade de medida</option>
              <option value="Bobina">Bobina</option>
              <option value="Caixa com 10 sachês com 1 grama">Caixa com 10 sachês com 1 grama</option>
              <option value="Cartela">Cartela com 1 cartela</option>
              <option value="Caixa com 50 pares">Caixa 50 pares</option>
              <option value="Centena">Centena</option>
              <option value="Dezena">Dezena</option>
              <option value="Fardo">Fardo</option>
              <option value="Frasco">Frasco</option>
              <option value="Galão">Galão</option>
              <option value="Kg">Quilograma</option>
              <option value="Litro">Litro</option>
              <option value="Milheiro">Milheiro</option>
              <option value="Peça">Peça</option>
              <option value="Pacote com 500 folhas">Pacote (500 folhas)</option>
              <option value="Pacote com 4 blocos com 50 folhas ">Pacote com 4 blocos com 50 folhas</option>
            </select>
 
</div>
                </div>
                <div class="form-row">
                <div class="col-md-6">
                    <label for="arquivoFoto">Selecionar Imagem:</label>
                    <input type="file" name="arquivoFoto" id="arquivoFoto" accept="image/*" required>
                </div>
              
                <div class="col-md-6">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" name="quantidade" min="1" id="quantidade"  required>
                </div>
                </div>
                <div class="form-row">
                    <button type="submit" class="btn-submit">Inserir</button>
                </div>
            </form>
        </div>
    </div>
        <?php
    include("conexaoBD.php");

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        try {
            $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
            $code = isset($_POST['code']) ? (int) $_POST['code'] : 0;
            $category = isset($_POST['category']) ? $_POST['category'] : "";
            $unidadeMedida = isset($_POST['unidadeMedida']) ? $_POST['unidadeMedida'] : "";
            $quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 0;

            $uploadDir = 'upload/produtos/';
            $uploadfile = "";

            $foto = isset($_FILES['arquivoFoto']) ? $_FILES['arquivoFoto'] : null;

            if ($foto === null || $foto['error'] !== UPLOAD_ERR_OK) {
                echo '<script>Swal.fire("Erro", "Erro no upload da imagem.", "error");</script>';
            } else if (!preg_match('/^image\/(jpeg|png|gif)$/', $foto['type'])) {
                echo '<script>Swal.fire("Erro", "Isso não é uma imagem válida.", "error");</script>';
            }  else {
                $stmt = $pdo->prepare("SELECT * FROM produtoTCC WHERE nome = :nome");
                $stmt->bindParam(':nome', $nome);
                $stmt->execute();

                $rows = $stmt->rowCount();

                if ($rows <= 0) {
                    $novoNomeFoto = substr($foto['name'], 0, 4) . "." . pathinfo($foto['name'], PATHINFO_EXTENSION);

                    if (move_uploaded_file($foto['tmp_name'], $uploadDir . $novoNomeFoto)) {
                        $uploadfile = $uploadDir . $novoNomeFoto;
                    } else {
                        $uploadfile = "";
                    }

                    $stmt = $pdo->prepare("INSERT INTO produtoTCC (nome, code, category, unidadeMedida, arquivoFoto, quantidade) VALUES (:nome, :code, :category, :unidadeMedida, :arquivoFoto, :quantidade)");

                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':code', $code);
                    $stmt->bindParam(':category', $category);
                    $stmt->bindParam(':unidadeMedida', $unidadeMedida);
                  
                    $stmt->bindParam(':arquivoFoto', $uploadfile);


                    $stmt->bindParam(':quantidade', $quantidade);

                    $stmt->execute();

                    echo '<script>Swal.fire("Sucesso", "Produto cadastrado!", "success");</script>';
                } else if ($rows > 0) {
                    echo '<script>Swal.fire("Erro", "Produto já existe.", "error");</script>';
                }
            }
        } catch (PDOException $ex) {
            echo '<script>Swal.fire("Erro", "Erro: ' . $ex->getMessage() . '", "error");</script>';
        }
    }
    ?>

        

</body>
</html>
