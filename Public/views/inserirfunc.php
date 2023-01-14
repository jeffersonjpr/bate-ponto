<!DOCTYPE html>
<html lang="en">



<head>
    <link rel="stylesheet" href="../style/style.css">
    <title>Inserir funcionário</title>
</head>

<body>
    <?php include_once 'navbar.html'; ?>

    <div class="center">
        <h1>Inserir funcionário</h1>
        <form action="inserirfunc.php" method="POST">
            <input type="text" name="nome" placeholder="Nome" /> <br>
            <input type="text" name="registro" placeholder="Registro" /> <br>
            <button type="submit" class="myButton">Inserir</button>
        </form>

        <!-- redirect to home after submit -->
        <?php
        if (isset($_POST['nome']) && isset($_POST['registro'])) {
            $nome = $_POST['nome'];
            $registro = $_POST['registro'];
            $url = 'http://localhost:8000/funcionario';
            $data = [
                'nome' => $nome,
                'registro' => $registro
            ];

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/json\r\n",
                    'method' => 'POST',
                    'content' => json_encode($data)
                )
            );

            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            if ($result === FALSE) {
                echo '<br>' . 'Funcionário não inserido';
            } else {
                header('Location: /');
            }
        }
        ?>

    </div>

</body>

</html>