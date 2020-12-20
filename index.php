
<?php




session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos_login.css">

    <script>
        //VALIDA QUE HAYA DATOS
        function validaIngreso() {
            var usuario = document.forms["loginform"]["usuario_login"].value;
            var password = document.forms["loginform"]["password_login"].value;
            
            if(usuario != "" && password != ""){
                return true;                
            }else{
                alert("Datos vacios y/o incompletos");
                return false;
            }
                                   
        }


        //VALIDA QUE LAS CONTRASEÑAS SEAN IGUALES Y QUE HAYA DATOS
        function validaRegistro(){
            
            var usuario = document.forms["registroform"]["usuario_registro"].value;
            var password = document.forms["registroform"]["password_registro"].value;
            var password2 = document.forms["registroform"]["password_registro_2"].value;
            

            if(usuario != "" && password != "" && password2 != ""){
                if(password != password2){
                    alert("La contraseña debe ser la misma");
                    return false;
                }
                if(usuario.length >= 50 || password.length >=50){
                    alert("El nombre de usuario y/o contraseña es muy larga");
                    return false;
                }
                return true;                                                 
            }
            else{
                alert("Datos vacios y/o incompletos");
                return false;
            }
        }
    </script>
        
    <title>Login y registro</title>
</head>
<body>
    

    <div class="container">
        <div class="row justify-content-around">
                <!--LOGIN FORM-->
            <div class="col-12 col-md-12 col-lg-5 bg-secondary text-light border rounded mt-3 mb-3 p-3">
                <h2 class="text-center">Log in</h2>

                <?php require_once("valida_login.php")?>

                <form action="" id="loginform" name="loginform" method="POST" onsubmit="return validaIngreso()">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" class="form-control" id="usuario_login" placeholder="Ingrese usuario" name="usuario_login">
                    </div>
                    <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password_login" placeholder="Ingrese Contraseña" name="password_login">
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-primary" name="Login_continuar">Continuar</button></div>
                    
                </form>

            </div>

            <?php require_once("valida_registro.php")?>
                <!--REGISTRO FORM-->
            <div class="col-12 col-md-12 col-lg-5 bg-secondary text-light border rounded mt-3 mb-3 p-3">
                <h2 class="text-center">Registro</h2>
            
                <form action="" id="registroform" name="registroform" method="POST" onsubmit="return validaRegistro()">
                                        
                    <div class="form-group">
                            <label for="usuario_registro">Usuario:</label>
                            <input type="text" class="form-control" id="usuario_registro" placeholder="Ingrese su nombre de usuario" name="usuario_registro">
                    </div>
                    <div class="form-group">
                        <label for="password_registro">Contraseña:</label>
                        <input type="password" class="form-control" id="password_registro" placeholder="Ingrese su contraseña" name="password_registro">
                    </div>
                    <div class="form-group">
                            <label for="password_registro_2">Repita su Contraseña:</label>
                            <input type="password" class="form-control" id="password_registro_2" placeholder="Repita su Contraseña" name="password_registro_2">
                    </div>
                    
                    <div class="text-center"><button type="submit" class="btn btn-primary" name="Registro_continuar">Continuar</button></div>

                </form>
                
                
            </div>
        </div>

        <!--ALERTAS DE EXITO O ERROR-->
        <?php 
        if(isset($_POST["Registro_continuar"])){ ?>
            
            <div class="alert <?php echo $tipo; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            </div>

        <?php } ?>

        <?php 
        if(isset($_POST["Login_continuar"])){ ?>
            <?php if($daerror == 1){ ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Usuario y/o contraseña no encontrado, registrese primero.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            </div>
            <?php } ?>
        <?php } ?>

        
                
        
    </div>


    <!--SCRIPTS DE JAVASCRIPT DE BOOTSTRAP-->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>