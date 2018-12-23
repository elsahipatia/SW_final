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
    <section class="main" id="s1">

        <div>
            <img id="image" src="http://britishclublaspalmas.es/wp-content/uploads/2017/01/English-Grammar-Quiz-Time.png"/>
            <table border="1">
                <tr>
                    <td>TOP 10 QUIZZERS</td>
                    <td>Ptos</td>
                </tr>
                <?php
                include "configDB.php";
                $link = mysqli_connect($server,$user,$pass,$basededatos);
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                $result = mysqli_query($link,"SELECT nick,puntuacion FROM ranking ORDER BY puntuacion DESC");
                $i=0;
                while($row = mysqli_fetch_array($result)) {
                    if($i>=10)
                        break;
                    echo '<tr><td>'.$row['nick'].'</td><td>'.$row['puntuacion'].'</td></tr>';
                    $i=$i+1;
                }
                mysqli_close($link);
                ?>
            </table>
        </div>
    </section>
    <footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
    </footer>
</div>
</body>
</html>
