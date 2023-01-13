<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bater ponto</title>
</head>

<body>
    <h1>Bater ponto</h1>
    <!-- send post without reloading the page and show notification-->
    <input type="text" id="registro" placeholder="0000" />
    <select name="tipo" id="tipo">
        <option value="entrada">Entrada</option>
        <option value="saida">Saída</option>
    </select>

    <button id="req">Bater ponto</button>

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
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.dataType = 'json';
            xhr.send(JSON.stringify(data));

            xhr.addEventListener('readystatechange', function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 201) {
                        alert('Ponto registrado com sucesso');
                    } else {
                        alert('Erro ao registrar ponto');
                        console.log(xhr.responseText);
                    }
                }
            });
        });
    </script>
</body>

</html>