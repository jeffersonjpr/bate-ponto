<!DOCTYPE html>
<html lang="en">



<head>
    <link rel="stylesheet" href="../style/style.css">
    <title>Bater ponto</title>
</head>


<body>
    <?php include_once 'navbar.html'; ?>


    <main>

    <div class="center">
        <h1>Bater ponto</h1>
        <input type="text" id="registro" placeholder="0000" />
        <select name="tipo" id="tipo">
            <option value="entrada">Entrada</option>
            <option value="pausa">Pausa</option>
            <option value="retorno">Retorno</option>
            <option value="saida">Saída</option>
        </select>  
        <br>
        <button id="req" class="myButton">Bater ponto</button>
    </div>

    <form action="" enctype="application/x-www-form-urlencoded"></form>

    <script>
        document.all.req.addEventListener('click', function() {
            let registro = document.all.registro.value;
            let tipo = document.all.tipo.value;
            let url = 'http://localhost:8000/ponto';
            let data = {
                registro: registro,
                tipo: tipo
            };

            let xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.dataType = 'json';

            xhr.setRequestHeader('Content-type', "application/json;charset=UTF-8");


            console.log(JSON.stringify(data));
            xhr.send(JSON.stringify(data));

            xhr.onload = function() {
                if (xhr.status == 201) {
                    alert('Ponto registrado com sucesso');
                    //show message
                    document.body.innerHTML +=
                        '<div class="alert alert-success" role="alert"><p style="color:green">Ponto registrado com sucesso</p></div>';
                } else if (xhr.status == 404) {
                    alert('Funcionário não encontrado');
                } else {
                    alert('Erro ao registrar ponto');
                }
            }
        });
    </script>
    </main>
</body>

</html>