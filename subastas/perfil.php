<?php
  //Se incluye el archivo Conexion.php que contiene la clase usada para la conexion a la bd
  include ("conexion/Conexion.php");
  //Se crea el objeto conexion
  $bd = new Conexion();
  //Se inicia la sesion o se propaga
  session_start();
  //Condicion que no deja entrar al index a menos que exista una variable de session
  if(!isset($_SESSION["id_usuario"])){
    //Redirecciona al login
    header("Location: login.php");
  }
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Perfil</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.png">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

  <?php

    if(isset($_POST["guardar"])){

      $id_usuario = $_POST["id_usuario"];
      $nombre = $_POST["nombre"];
      $paterno = $_POST["paterno"];
      $materno = $_POST["materno"];
      $edad = $_POST["edad"];
      //$foto = $_POST["foto"];
      $correo = $_POST["correo"];
      $user = $_POST["user"];
      $pass = $_POST["pass"];

      $foto = $_FILES["foto"]["name"];
      $ruta = $_FILES["foto"]["tmp_name"];

      if($foto == null){
        echo "<script>alert('Foto vacia (Continuaras con la misma foto)');</script>";

        $res = $bd->query("UPDATE usuario set nombre='$nombre', paterno='$paterno', materno='$materno', edad='$edad',
                          correo='$correo', user='$user', pass='$pass' where id_usuario=$id_usuario;");

        if($res==true){
          echo "<script>alert('Datos modificados correctamente');</script>";
          $_SESSION["nomb_comp"] = $nombre." ".$paterno;
        }else{
          echo "<script>alert('No se modificaron los datos');</script>";
        }

      }else{
        echo "<script>alert('Tu nueva foto sera modificada o agregada');</script>";

        $dest = "images/";
        copy($ruta,$dest.''.$foto);

        $res = $bd->query("UPDATE usuario set nombre='$nombre', paterno='$paterno', materno='$materno', edad='$edad',
                          foto='$foto', correo='$correo', user='$user', pass='$pass' where id_usuario=$id_usuario;");

        if($res==true){
          echo "<script>alert('Datos modificados correctamente');</script>";
          $_SESSION["nomb_comp"] = $nombre." ".$paterno;
        }else{
          echo "<script>alert('No se modificaron los datos');</script>";
        }
      }

    }

  ?>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="subastas.php">Subastas</a>
            </div>
            <!-- Top Menu Items -->
            <?php
              include ("header.php");
            ?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php
              include ("sidebar.php");
            ?>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Perfil <small>Datos personales</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> Consola
                            </li>
                            <li class="active">
                                <i class="fa fa-user"></i> Perfil
                            </li>
                        </ol>
                    </div>
                </div>

                <?php
                  $id_user = $_SESSION["id_usuario"];
                  $res = $bd->select("SELECT * from usuario where id_usuario=$id_user");

                  if($res->num_rows == 1){
                    while($row = $res->fetch_assoc()){
                      $id_usuario = $row["id_usuario"];
                      $nombre = $row["nombre"];
                      $paterno = $row["paterno"];
                      $materno = $row["materno"];
                      $edad = $row["edad"];
                      $foto = $row["foto"];
                      $correo = $row["correo"];
                      $user = $row["user"];
                      $pass = $row["pass"];

                      ?>

                      <div class="row">

                        <form role="form" action="" method="post" enctype="multipart/form-data">

                          <div class="col-lg-6">

                                  <div class="form-group">
                                      <label>Id</label>
                                      <input type="text" name="id_usuario" class="form-control" readonly value="<?php echo $id_usuario; ?>">
                                  </div>

                                  <div class="form-group">
                                      <label>Nombre</label>
                                      <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                                  </div>

                                  <div class="form-group">
                                      <label>Paterno</label>
                                      <input type="text" name="paterno" class="form-control" value="<?php echo $paterno; ?>">
                                  </div>

                                  <div class="form-group">
                                      <label>Materno</label>
                                      <input type="text" name="materno" class="form-control" value="<?php echo $materno; ?>">
                                  </div>

                                  <div class="form-group">
                                      <label>Edad</label>
                                      <input type="number" name="edad" class="form-control" value="<?php echo $edad; ?>">
                                  </div>

                        </div>
                        <div class="col-lg-6">

                                  <div class="form-group">
                                      <label>Foto</label>
                                      <input type="file" name="foto">
                                  </div>

                                  <div class="form-group">
                                      <label>Correo</label>
                                      <input type="email" name="correo" class="form-control" value="<?php echo $correo; ?>" required>
                                  </div>

                                  <div class="form-group">
                                      <label>Usuario</label>
                                      <input type="text" name="user" class="form-control" value="<?php echo $user; ?>" required>
                                  </div>

                                  <div class="form-group">
                                      <label>Contraseña</label>
                                      <input type="text" name="pass" class="form-control" value="<?php echo $pass; ?>" required>
                                  </div>

                                  <br>

                                  <button name="guardar" type="submit" class="btn btn-success">Guardar</button>
                                  <button type="reset" class="btn btn-danger">Cancelar</button>

                          </div>

                        </form>

                      </div>
                      <!-- /.row -->

                      <?php
                    }
                  }
                ?>



            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
