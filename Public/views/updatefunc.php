<!DOCTYPE html>
<html lang="en">



<head>
    <link rel="stylesheet" href="../style/style.css">
    <title>Deletar funcionário</title>
</head>

<body>
    <?php include_once 'navbar.html'; ?>

    <div class="center">
        <h1>Atualizar funcionário</h1>
        <form action="updatefunc.php" method="PUT">
            <input type="text" name="oldregistro" placeholder="Registro antigo" /> <br>
            <input type="text" name="registro" placeholder="Registro novo" /> <br>
            <input type="text" name="nome" placeholder="Nome" /> <br>
            <button type="submit" class="myButton">Atualizar</button>
        </form>

        <?php
        if (isset($_GET['registro'])) {
            $oldregistro = $_GET['oldregistro'];
            $registro = $_GET['registro'];
            $nome = $_GET['nome'];

            $url = 'http://localhost:8000/funcionario/' . $oldregistro;
            $data = array(
                'registro' => $registro,
                'nome' => $nome
            );

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/json\r\n",
                    'method' => 'PUT',
                    'content' => json_encode($data)
                )
            );

            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) {
                echo 'Funcionário não encontrado';
            } else {
                header('Location: /views/visufunc.php');
            }
        }
        ?>

    </div>

</body>

</html>