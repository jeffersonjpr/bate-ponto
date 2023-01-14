<!DOCTYPE html>
<html lang="en">



<head>
    <link rel="stylesheet" href="../style/style.css">
    <title>Deletar funcionário</title>
</head>

<body>
    <?php include_once 'navbar.html'; ?>

    <div class="center">
        <h1>Deletar funcionário</h1>
        <form action="deletarfunc.php" method="DELETE">
            <input type="text" name="registro" placeholder="Registro" /> <br>
            <button type="submit" class="myButton">Deletar</button>
        </form>

        <?php
        if (isset($_GET['registro'])) {
            $registro = $_GET['registro'];
            $url = 'http://localhost:8000/funcionario/' . $registro;
            $data = array(
                'registro' => $registro
            );

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/json\r\n",
                    'method' => 'DELETE',
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