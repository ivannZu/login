<?php
$nameErr = $contraErr = $rolErr = "";
$name = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["username"])) {
    $nameErr = "Debe llenar el campo nombre.";//Mensaje de error
  } else {
    $name = test_input($_POST["username"]); //funcion para limpiar entrada
    // verificar si el nombre solamente contiene letras, guion, apostrofe o espacio en blanco
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Solo se permiten letras y espacios en blanco.";
    }
  }
  
  if (empty($_POST["password"])) {
    $contraErr = "Debe llenar el campo contraseña.";
  }

  if (empty($_POST["Rol"])) {
    $rolErr = "Debe seleccionar un rol.";
  }
}


function test_input($data) {
  $data = trim($data); //quita espacios en blanco extras, tabuladores, etc.
  $data = stripslashes($data); //elimina \ en los datos
  $data = htmlspecialchars($data); //convierte caracteres especiales en entidades HTML
  return $data;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
		*{
			margin: 0;
			padding: 0;
		}
		
		
		@keyframes cambiar{
			0%{background-position: 0 50%;}
			50%{background-position: 100% 50%;}
			100%{background-position: 0 50%;}
		}
	</style>
    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <link rel="stylesheet" href="estilos.css">
  <title>Formulario</title>
</head>
<body class="c">
<div class="loader"></div>
  <section class="form-register">
  <img class="frontal" src="https://licoreria247.pe/wp-content/uploads/2021/12/boton-de-cuenta-redonda-con-usuario-dentro.png" >
    <h2 class="titulo">Iniciar Sesion</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" role="form" style="display: block;">
    <br>
    
    <span class="error">* <?php echo $nameErr;?></span>
    <input class="controls" type="text" name="username" id="username" placeholder="Ingrese su nombre:">
   
    <span class="error">* <?php echo $contraErr;?></span>
    <input class="controls" type="password" name="password" id="password" placeholder="Ingrese su Contraseña:">
<br><br>
    <select name="Rol" class="form-control">
      <option value=""> - Selecciona Rol - </option>
    <option value="Administrador">Administrador</option>
    <option value="Jefe">Jefe</option>
    <option value="Personal">Personal</option>
    </select>
  
    <br><span class="error"> <?php echo $rolErr;?></span><br>
    <input class="botons" type="submit" value="Entrar">
    <p><a href="registro.php">¿No tienes cuenta?</a></p>
   
    </form>

    
  </section>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script type="text/javascript">
    $(window).load(function() {
    $(".loader").fadeOut("slow");
     });
</script>
</body>
</html>

<?php
    require 'conexion.php';
    // session_start ();
    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['Rol'])){
    $usuario = $_POST['username'];
    $password = $_POST['password'];
    $Rol = $_POST['Rol'];
    // $pass_sha1= sha1($password);

    $query = "SELECT COUNT(*) AS contar FROM jefe_personal WHERE Nombre='$usuario' AND 
    contrasena='$password' AND Rol='$Rol'";
    $consulta = mysqli_query($con,$query);
    $array = mysqli_fetch_array($consulta);
    if($array['contar']==1){
        //crear una variable de sesión
        echo "Datos correctos.";
        $_SESSION['Nombre']=$usuario;
        $_SESSION['contrasena']=$password;
        if($Rol == "Administrador"){
          header ("location:principaladmin.php");
        }else{
          header ("location:Principal.php");
        }
        
        }else{
        echo "datos incorrectos";
    }
  }
?>