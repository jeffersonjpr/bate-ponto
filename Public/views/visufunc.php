<!DOCTYPE html>
<html lang="en">



<head>
    <link rel="stylesheet" href="../style/style.css">
    <title>Deletar funcionário</title>
</head>

<body>
    <?php include_once 'navbar.html'; ?>

    <div class="center">
        <h1>Visualizar funcionários</h1>

        <?php
        $url = 'http://localhost:8000/funcionario';

        $options = array(
            'http' => array(
                'header' => "Content-type: application/json\r\n",
                'method' => 'GET'
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);

        if ($result === FALSE) {
            echo 'Funcionário não encontrado';
        } else {
            echo '<table  class="centertb">';
            echo '<tr>';
            echo '<th>Nome</th>';
            echo '<th>Registro</th>';
            echo '</tr>';
            foreach ($result as $funcionario) {
                echo '<tr>';
                echo '<td>' . $funcionario['nome'] . '</td>';
                echo '<td>' . $funcionario['registro'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        ?>


    </div>

</body>

</html>