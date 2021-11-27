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

    <title>Subastas</title>

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

</head>

<body>

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
                            Subastas <small>Todas las subastas disponibles</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-comment"></i> Subastas
                            </li>
                            <li class="active">
                                <i class="fa fa-comments"></i> Todas las subastas
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Listado de subastas -->
                <div class="row">

                  <?php
                      //Inicia consulta de subastas
                      $res = $bd->select("SELECT * from subasta where estado=0 order by id_subasta desc");
                      if($res->num_rows > 0){
                        while($row = $res->fetch_assoc()){
                          $id_subasta = $row["id_subasta"];
                          $min = $row["min"];
                          $max = $row["max"];
                          $ini = $row["tiempo_ini"];
                          $fin = $row["tiempo_fin"];
                          $comprador = $row["comprador"];
                          $id_producto = $row["id_producto"];

                          $datetime_actual = date("Y-m-d H:i:s");
                          $datetime1 = date_create($datetime_actual);
                          $datetime2 = date_create($fin);
                          $interval = $datetime1->diff($datetime2);

                          //Inicia consulta de producto de las subastas
                          $res2 = $bd->select("SELECT * from producto where id_producto=$id_producto");
                          if($res2->num_rows > 0){
                            while($row2 = $res2->fetch_assoc()){
                              $nombre_p = $row2["nombre"];
                              $imagen_p = $row2["imagen"];

                              //echo "$id_subasta, $min, $max, $ini, $fin, $comprador, $id_producto, $nombre_p, $imagen_p<br>";

                              $res3 = $bd->select("SELECT * from oferta where id_subasta=$id_subasta order by id_oferta desc limit 1");
                              if($res3->num_rows > 0){
                                while($row3 = $res3->fetch_assoc()){
                                  $id_oferta = $row3["id_oferta"];
                                  $oferta = $row3["oferta"];

                                  //echo "$id_subasta, $min, $max, $ini, $fin, $comprador, $id_producto, $nombre_p, $imagen_p, $id_oferta, $oferta<br>";

                                  /*Aqui se mostraran los productos que tienen una oferta ya*/
                                  ?>
                                        <div class="col-sm-6 col-md-4">
                                          <div class="thumbnail">
                                            <?php echo "<img src='images/productos/$imagen_p' style='height: 220px;'>";?>
                                            <div class="caption">
                                              <h3><?php echo $nombre_p; ?></h3>
                                              <p><?php print $interval->format('%a días %H horas %I minutos'); ?></p>
                                              <p><?php echo "$$min.00 - $$max.00"; ?></p>
                                              <h4>Oferta actual: <b class="text-danger"><?php echo "$$oferta.00"; ?></b></h4>
                                              <?php echo "<p><a href='subasta.php?id=$id_subasta' class='btn btn-success btn-block' role='button'>Mejorar oferta</a></p>";?>
                                            </div>
                                          </div>
                                        </div>
                                  <?php
                                  /*Fin de los productos que tienen una oferta ya*/

                                }
                              }else{
                                //echo "Registro sin ofertas aun<br>";

                                /*Aqui se mostraran los productos que aun no tienen oferta*/
                                ?>
                                      <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                          <?php echo "<img src='images/productos/$imagen_p' style='height: 220px;'>";?>
                                          <div class="caption">
                                            <h3><?php echo $nombre_p; ?></h3>
                                            <p><?php print $interval->format('%a días %H horas %I minutos'); ?></p>
                                            <p><?php echo "$$min.00 - $$max.00"; ?></p>
                                            <h4>Oferta actual: <b class="text-danger"><?php echo "$0.00"; ?></b></h4>
                                            <?php echo "<p><a href='subasta.php?id=$id_subasta' class='btn btn-info btn-block' role='button'>Primero en ofertar</a></p>";?>
                                          </div>
                                        </div>
                                      </div>
                                <?php
                                /*Fin de los productos que no tienen oferta*/
                              }

                            }
                          }else{
                            echo "<h4>Hubo un error al recuperar el producto</h4>";
                          }
                          //Termina consulta de producto de la subasta
                        }
                      }else{
                        echo "<h3>Por el momento no existen subastas</h3>";
                      }
                      //Termina consulta de subastas

                  ?>





                </div>
                <!-- Fin de listado -->

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
