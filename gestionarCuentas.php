<?php
session_start();
if (!isset($_SESSION['email']))
    header("Location: login.php");
else
    if($_SESSION['rol']!=0) {
        header("Location: layout2.php");
    }

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
        <span>
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
    </nav>
    <section class="main" id="s1" >

        <div style="font-weight: bold ; font-size: large">
            <?php
            include "configDB.php";
            $link = mysqli_connect($server,$user,$pass,$basededatos);
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $result = mysqli_query($link,"SELECT * FROM usuarios");
            echo '<table id="usuarios" border="1">';
            echo '<tr>'.
                '<td>Correo</td>'.
                '<td>Contraseña</td>'.
                '<td>Nombre</td>'.
                '<td>Estado</td>'.
                '<td>Cambiar Estado</td>'.
                '<td>Imagen</td>'.
                '<td>Eliminar usuario</td>'.
                '</tr>';
            $i = 0;
            $j = 0;
            while($row = mysqli_fetch_array($result))
            {
                $foto='<img height="60" width="60" src="data:image/*;base64,'.base64_encode($row['foto']).' "/>';
                if($row['estado'] == 1){
                    $bloqueado='Bloqueado';
                    $estado = 1;
                }else{
                    $bloqueado='Desbloqueado';
                    $estado = 0;
                }
                $user = '"'.$row['email'].'"'.','.$i;

                echo "<tr id='user".$i."'>".
                    "<td>".$row['email']. "</td>".
                    "<td>".$row['password']."</td>".
                    "<td>".$row['nombreApellido']."</td>".
                    "<td><div id='divj".$j."'>".$bloqueado."</div></td>".
                    "<td><input type='button' value='Cambiar estado' onclick='cambiarEstado(".$user.",".$estado.")'/></td>".
                    "<td>".$foto."</td>".
                    "<td><input type='button' value='Eliminar' onclick='eliminarUsuario(".$user.")'/></td>".
                    "</tr>";
                $i=$i+1;
                $j=$j+1;
            }
            echo '</table>'
            ?>
        </div>
    </section>
    <footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
    </footer>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    function eliminarUsuario(email,id) {
        if(!confirm("¿Estas seguro de que deseas eliminar el usuario?"))
            return;
        XMLHttpRequestObject = new XMLHttpRequest();
        XMLHttpRequestObject.onreadystatechange = function () {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                var obj = document.getElementById("usuarios").childNodes[0];
                var tr = document.getElementById("user" + id);
                obj.removeChild(tr);
            }
        }
        XMLHttpRequestObject.open('GET', 'eliminarUsuario.php?email=' + email, true);
        XMLHttpRequestObject.send();
    }

    function cambiarEstado(email,id,estado) {
        if(!confirm("¿Estas seguro de que deseas cambiar el estado del usuario?"))
            return;
        XMLHttpRequestObject = new XMLHttpRequest();
        XMLHttpRequestObject.onreadystatechange = function () {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                var tr = document.getElementById("divj" + id);
                if(tr.innerText=='Bloqueado'){
                    tr.innerText='Desbloqueado';
                }else{
                    tr.innerText='Bloqueado';
                }
            }
        }
        XMLHttpRequestObject.open('GET', 'cambiarEstado.php?email=' + email+'&?estado='+estado, true);
        XMLHttpRequestObject.send();
    }
</script>
</body>
</html>


