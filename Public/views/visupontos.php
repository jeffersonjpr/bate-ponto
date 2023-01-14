<!DOCTYPE html>
<html lang="en">



<head>
    <link rel="stylesheet" href="../style/style.css">
    <title>Visualizar pontos</title>
</head>

<body>
    <?php include_once 'navbar.html'; ?>

    <div class="center">
        <h1>Visualizar pontos</h1>

        <?php
        $url = 'http://localhost:8000/ponto/liquidas';

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
            echo '<br> Pontos não encontrados';
        } else {
            echo '<table  class="centertb">';
            echo '<tr>';
            echo '<th>Nome</th>';
            echo '<th>Registro</th>';
            echo '<th>Data</th>';
            echo '<th>Horas Trabalhadas</th>';
            echo '</tr>';
            foreach ($result as $ponto) {
                $data = new DateTime($ponto['data']);
                $data = $data->format('d/m/Y');
                echo '<tr>';
                echo '<td>' . $ponto['nome'] . '</td>';
                echo '<td>' . $ponto['registro'] . '</td>';
                echo '<td>' . $data . '</td>';
                echo '<td>' . $ponto['horas_liquidas'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        ?>


    </div>

</body>

</html>