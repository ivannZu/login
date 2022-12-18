<?php
$nameErr = $contraErr = $emailErr = $rfcErr = $rolErr = "";
$name = $email = $rfc = "";
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

  if (empty($_POST["email"])) {
    $emailErr = "Debe llenar el campo del correo";
  }else{
    $email = test_input($_POST["email"]);
    if (!preg_match("/^l(c|m)?([0-9]{2}(120|121)[0-9]{3})@morelia\.tecnm\.mx$/",$email)) {
      $emailErr = "Solo se permiten correos institucionales.";
      $_POST["email"]="";
    } 
  }

  if (empty($_POST["RFC"])) {
    $rfcErr = "Debe llenar el campo del RFC";
  }else{
    $rfc = test_input($_POST["RFC"]);
    if (!preg_match("/^[A-Z]{4}([0-9]{2}([0][1-9]|[1][0-2])([0][1-9]|[1-2][0-9]|30))[A-Z0-9]{3}$/",$rfc)) {
      $rfcErr = "Por favor ingrese el formato correcto del RFC";
      $_POST["RFC"]="";
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="estilos.css">
  <title>Formulario de registro</title>
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
    
</head>
<body class="c">
  <section class="form-register">
    <h4 class="frontal">Registrate</h4>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" role="form" style="display: block;">
  
    <span class="error">* <?php echo $nameErr;?></span>
    <input class="controls" type="text" name="username" id="username" placeholder="Nombre">
    
    <span class="error">* <?php echo $emailErr;?></span>
    <input class="controls" type="email" name="email" id="email" placeholder="Correo">
 
    <span class="error">*<?php echo $rfcErr;?></span>
    <input class="controls" type="text" name="RFC" id="RFC" placeholder="RFC">
   
    <span class="error">* <?php echo $contraErr;?></span>
    <input class="controls" type="password" name="password" id="password" placeholder="Contraseña">
   
   
    <select name="Rol" class="form-control">
    <option value=""> - Selecciona Rol - </option>
    <option value="Jefe">Jefe</option>
    <option value="Personal">Personal</option>
    </select>
   
    <input class="botons" type="submit" value="Entrar">
    <p><a href="login.php">¿Ya tienes cuenta?</a></p>
    </form>
  </section>
</body>
</html>

<?php
    require 'conexion.php';
    if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['RFC']) &&!empty($_POST['password']) && !empty($_POST['Rol'])){
      $usuario = $_POST['username'];
      $email = $_POST['email'];
      $rfc = $_POST['RFC'];
      $password = $_POST['password'];
      $Rol = $_POST['Rol'];

      $miConsulta = "SELECT * FROM jefe_personal WHERE idJefe=NULL;"; //crear consulta que seleccione el registro donde el campo codigo sea igual a la variable $codigo

      $cek = mysqli_query($con, $miConsulta);
      if(mysqli_num_rows($cek) == 0){
              $miConsulta = "INSERT INTO  jefe_personal VALUES (NULL,'$usuario','$email','$rfc','$Rol','$password');"; //crear la consulta del INSERT INTO 
              $insert = mysqli_query($con, $miConsulta) or die(mysqli_error());
              if($insert){
                  echo '<p class="exito">Bien hecho! Los datos han sido guardados con éxito.</p>';
              }else{
                  echo '<p class="error">Error. No se pudo guardar los datos !</p>';
              }
          
      }
    }
?>