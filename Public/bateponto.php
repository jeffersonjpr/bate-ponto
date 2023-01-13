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
            xhr.dataType = 'json';

            xhr.setRequestHeader('Content-type', "application/json;charset=UTF-8");




            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 201) {
                    console.log(xhr.responseText);
                }
            }
            console.log(JSON.stringify(data));
            xhr.send(JSON.stringify(data));
        });
    </script>
</body>

</html>