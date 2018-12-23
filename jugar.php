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
        <span class="right"><a href="registro.php">Registrarse</a></span>
        <span class="right"><a href="login.php">Login</a></span>
        <span class="right" style="display:none;"><a href="/logout">Logout</a></span>
        <h2>Quiz: el juego de las preguntas</h2>
    </header>
    <nav class='main' id='n1' role='navigation'>
        <span><a href='jugar.php'>Jugar a Quizz!</a></span>
        <span><a href='layout.php'>Inicio</a></span>
        <span><a href='creditos.html'>Creditos</a></span>
        <span><a href='CambiarPassword.php'>Recuperar contraseña</a></span>
    </nav>
    <section class="main" id="s1" >

        <div id="dispQuestion" style="font-weight: bold ; font-size: large ; display: none">
        </div>
        <br>
        <button type="button" id="comprobarRespuesta" onclick="comprobarRespuesta()">Comprobar respuesta</button>
        <button type="button" id="nextQuestion" onclick="mostrarPregunta()" style="display: none">Siguiente pregunta</button>
        <button type="button" id="startGame">Comenzar la partida</button>
        <button type="button" id="abandonarPartida">Abandonar partida</button>
        <br>
        <select id="comboBoxTemas">
            <?php
            include "configDB.php";
            $link = mysqli_connect($server,$user,$pass,$basededatos);
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $result = mysqli_query($link,"SELECT DISTINCT tema FROM preguntas");
            while($row = mysqli_fetch_array($result))
            {
                echo '<option value="'.$row['tema'].'">'.$row['tema'].'</option>';
            }
            ?>
        </select>
        <button type="button" id="obtenerPreguntas">Obtener preguntas por tema</button>
        <div>Número de aciertos: <span id="numAciertos">0</span></div>

    </section>
    <form id="ptoForm" method="post" action="abandonarPartida.php" style="display: none">
        <input id="puntuacion" type="text">
    </form>
    <footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
    </footer>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    var preguntas;
    var questionCont=0;
    var aciertos=0;
    $("#startGame").click(function () {
        XMLHttpRequestObject = new XMLHttpRequest();
        XMLHttpRequestObject.onreadystatechange = function () {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                preguntas=JSON.parse(XMLHttpRequestObject.responseText);
                document.getElementById('dispQuestion').style.display="inline-block";
                document.getElementById('startGame').style.display="none";
                document.getElementById('nextQuestion').style.display="inline";
                mostrarPregunta();
            }
        };
        XMLHttpRequestObject.open('GET', 'getQuestion.php', true);
        XMLHttpRequestObject.send();
    });


    $("#obtenerPreguntas").click(function () {
        var tema = document.getElementById('comboBoxTemas').value;
        XMLHttpRequestObject = new XMLHttpRequest();
        XMLHttpRequestObject.onreadystatechange = function () {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                var preguntas3 = JSON.parse(XMLHttpRequestObject.responseText);
                console.log(preguntas3);
                document.getElementById('dispQuestion').style.display="inline-block";
                document.getElementById('startGame').style.display="none";
                document.getElementById('nextQuestion').style.display="inline";
                document.getElementById('obtenerPreguntas').style.display="none";
                preguntas=preguntas3;
                questionCont=0;
                mostrarPregunta(preguntas,0);
            }
        };
        XMLHttpRequestObject.open('GET', 'getQuestionsByTopic.php?tema='+ tema, true);
        XMLHttpRequestObject.send();
    });

    $("#abandonarPartida").click(function () {
        //var aux=document.getElementById("puntuacion");
        //aux.value=aciertos;
        //console.log(aux);
        //form=document.getElementById("ptoForm");
        //console.log(form);
        window.location.replace("abandonarPartida.php?puntuacion="+aciertos);
    });

    function mostrarPregunta() {
        if(questionCont<preguntas.length){
            var correct = "<input id='correctAns' align='left' type='radio' name='ans' value='correct'>" + preguntas[questionCont]['correct'];
            var incorrect1 = "<input align='left' type='radio' name='ans' value='incorrect1'>" + preguntas[questionCont]['incorrect1'];
            var incorrect2 = "<input align='left' type='radio' name='ans' value='incorrect2'>" + preguntas[questionCont]['incorrect2'];
            var incorrect3 = "<input align='left' type='radio' name='ans' value='incorrect3'>" + preguntas[questionCont]['incorrect3'];
            var answers = shuffle([correct, incorrect1, incorrect2, incorrect3]);
            var obj=document.getElementById('dispQuestion');
            obj.innerHTML = preguntas[questionCont]['enunciado'] +'<br><br>' +  answers[0] + '<br>' + answers[1] + '<br>' + answers[2] + '<br>' +answers[3];
            questionCont=questionCont+1;
        }else{
            var message="Partida finalizada, tu puntuación: " + aciertos;
            alert(message);
            //document.getElementById("puntuacion").value=aciertos;
            //document.getElementById("ptoForm").submit();
            window.location.replace("abandonarPartida.php?puntuacion="+aciertos);
        }

    }


    function comprobarRespuesta(){
        var correctAns = document.getElementById('correctAns');
        if(correctAns.checked){
            alert('Respuesta Correcta');
            aciertos=aciertos+1;
            document.getElementById('numAciertos').innerText=aciertos;
        }else{
            alert('Respuesta Incorrecta');
        }
        mostrarPregunta();
    }
    function shuffle(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    }


</script>
</body>
</html>
