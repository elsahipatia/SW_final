<?php
session_start();
if (!isset($_SESSION['email']))
    header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (min-width: 530px) and (min-device-width: 481px)'
          href='estilos/wide.css' />
    <link rel='stylesheet'
          type='text/css'
          media='only screen and (max-width: 480px)'
          href='estilos/smartphone.css' />
</head>
<body>
<div id='page-wrap'>
    <header class='main' id='h1'>
        <span class="right"><a href="logout.php">Logout</a></span>
        <span class='right'>
            <?php
                echo '<img height="60" width="60" src="data:image/*;base64,'.$_SESSION['foto'].' "/>';
            ?>
        </span>
        <h2>Quiz: el juego de las preguntas</h2>
    </header>
    <nav class='main' id='n1' role='navigation'>
        <span><a href="layout2.php">Inicio</a></span>
        <span><a href="gestionPreguntas.php">Gestionar Preguntas</a></span>
        <span><a href="creditos2.php">Creditos</a></span>
        <span><a href="obtenerDatos.php">Obtener Datos</a></span>
        <span><a href="obtenerPreguntaId.php">Ver preguntas por ID</a></span>
        <span><a href="verPreguntasXML.php">Ver tabla XML</a></span>
        <span><a href="preguntas.xml">Ver tabla XSL</a></span>
        <?php
        if($_SESSION['rol'] == 0)
            echo '<span><a href="gestionarCuentas.php">Gestionar Cuentas (admin)</a></span>';
        ?>
    </nav>
    <section class="main" id="s1">
        <table border="1">
            <tr>
                <td>Usuarios en línea</td>
                <td id="numUsuarios">0</td>
            </tr>
            <tr>
                <td>Mis preguntas / Total preguntas </td>
                <td id="contador">0 / 0</td>

            </tr>
        </table>

        <div>
            <button id="verPreguntasBtn" type="button" onclick="verPreguntas()">Ver Preguntas</button>
            <form  method='post' id='questionForm' name='questionForm' enctype="multipart/form-data" action="prueba.php" >
                <table>
                    <tr>
                        <td align="left">Email*: <input id="email" name="email" type="text" class="emailComplexSubj" value=<?php echo $_SESSION['email'];?> required placeholder="Introduce un correo de la UPV-EHU."  pattern="^[a-z]+[0-9]{3}@ikasle\.ehu\.eus$" readonly="true"></td>
                    </tr>
                    <tr>
                        <td align="left">Enunciado de la pregunta*: <input id="question" name="question" type="text" class="response" required placeholder="Introduce una pregunta de al menos 10 carácteres." pattern="^.{10,}$"></td>
                    </tr>
                    <tr>
                        <td align="left">Respuesta correcta*: <input id="correct" name="correct" type="text" class="response" required placeholder="Introduce una respuesta correcta."></td>
                    </tr>
                    <tr>
                        <td align="left">Respuesta incorrecta*: <input id="incorrect1" name="incorrect1" type="text" class="response" required placeholder="Introduce la primera respuesta incorrecta."></td>
                    </tr>
                    <tr>
                        <td align="left">Respuesta incorrecta*: <input id="incorrect2" name="incorrect2" type="text" class="response" required placeholder="Introduce la segunda respuesta incorrecta."></td>
                    </tr>
                    <tr>
                        <td align="left">Respuesta incorrecta*: <input id="incorrect3" name="incorrect3" type="text" class="response" required placeholder="Introduce la tercera respuesta incorrecta."></td>
                    </tr>
                    <tr>
                        <td align="left">Complejidad (0-5)*: <input id="complexity" name="complexity" type="text" class="emailComplexSubj" required placeholder="Introduce un número de 0 a 5." pattern="^[0-5]$"></td>
                    </tr>
                    <tr>
                        <td align="left">Tema (subject)*: <input id="subject" name="subject" type="text" class="emailComplexSubj" required placeholder="Introduce un tema."></td>
                    </tr>
                    <tr>
                        <td align="left"><input type="file" id="examine" name="examine" ></td>
                    </tr>
                    <tr>
                        <td align="left"><button id="send" type="submit">Enviar solicitud</button> <button id="reset" >Borrar todo</button> </td>
                    </tr>
                    <tr>
                        <td><img id="image" width="200px" height="200px"/></td>
                    </tr>
                </table>

                <div id="verPreguntas">

                </div>
            </form>

        </div>
    </section>
    <footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
    </footer>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
setInterval(cuentaPreguntas,5000);
setInterval(numUsuarios,4000);

    function cuentaPreguntas() {
        XMLHttpRequestObject = new XMLHttpRequest();
        XMLHttpRequestObject.onreadystatechange = function () {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                var obj1 = document.getElementById('contador');
                obj1.innerHTML = XMLHttpRequestObject.responseText;
            }
        };
        XMLHttpRequestObject.open('GET', 'verPreguntasXML.php?op=getContador', true);
        XMLHttpRequestObject.send();
    }
    function numUsuarios(){
        XMLHttpRequestObject = new XMLHttpRequest();
        XMLHttpRequestObject.onreadystatechange = function () {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                var obj2 = document.getElementById('numUsuarios');
                obj2.innerHTML = XMLHttpRequestObject.responseText;
            }
        };
        XMLHttpRequestObject.open('GET', 'verConectadosXML.php', true);
        XMLHttpRequestObject.send();
    }
    function verPreguntas(){
        XMLHttpRequestObject = new XMLHttpRequest();
        //alert(email);

        XMLHttpRequestObject.onreadystatechange = function () {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                var obj = document.getElementById('verPreguntas');
                obj.innerHTML = XMLHttpRequestObject.responseText;
            }
            };
        XMLHttpRequestObject.open('GET', 'verPreguntasXML.php', true);
        XMLHttpRequestObject.send();
    }

    $("#reset").click(function(){
        $("#email").val("");
        $("#question").val("");
        $("#correct").val("");
        $("#incorrect1").val("");
        $("#incorrect2").val("");
        $("#incorrect3").val("");
        $("#complexity").val("");
        $("#subject").val("");
        $("#examine").val("");
        $("#image").css("display","none");

    });
</script>

</body>
</html>