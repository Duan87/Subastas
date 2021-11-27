<?php
  include ("conexion/Conexion.php");
  //include ("Encryptar.php");
  $bd = new Conexion();
  //$enc = new Encryptar();
  session_start();
  if(!isset($_SESSION["id_usuario"])){
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

    <title>Mi cesta</title>

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
                            Mi cesta <small>Productos adquiridos</small>
                        </h1>
                        <ol class="breadcrumb">
                          <li>
                              <i class="fa fa-dashboard"></i> Consola
                          </li>
                          <li class="active">
                              <i class="fa fa-shopping-cart"></i> Mi cesta
                          </li>
                        </ol>
                    </div>
                </div>

                <!-- Listado de subastas -->
                <div class="row">
                  <div class="col-lg-12">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Categoria</th>
                                    <th>Minimo</th>
                                    <th>Maximo</th>
                                    <th>Pagado</th>
                                </tr>
                            </thead>
                            <tbody>

                  <?php
                      //Inicia consulta de cestas
                      $res0 = $bd->select("SELECT * from cesta where id_usuario=".$_SESSION["id_usuario"].";");
                      if($res0->num_rows > 0){
                        while($row0 = $res0->fetch_assoc()){
                          $cesta = $row0["id_cesta"];
                          $sub = $row0["id_subasta"];

                          //echo "$cesta, $user, $sub<br>";

                          //Inicia consulta de subastas
                          $res = $bd->select("SELECT * from subasta where id_subasta=$sub order by id_subasta desc");
                          if($res->num_rows > 0){
                            while($row = $res->fetch_assoc()){
                              $min = $row["min"];
                              $max = $row["max"];
                              $ini = $row["tiempo_ini"];
                              $fin = $row["tiempo_fin"];
                              $id_producto = $row["id_producto"];

                              //Inicia consulta de producto de las subastas
                              $res2 = $bd->select("SELECT * from producto where id_producto=$id_producto");
                              if($res2->num_rows > 0){
                                while($row2 = $res2->fetch_assoc()){
                                  $nombre_p = $row2["nombre"];
                                  $descri_p = $row2["descripcion"];
                                  $imagen_p = $row2["imagen"];
                                  $catego_p = $row2["id_categoria"];

                                  //Inicia consulta de categoria del producto
                                  $result = $bd->select("SELECT * from categoria where id_categoria=$catego_p");
                                  $categoria_arr = mysqli_fetch_array($result);
                                  $categoria = $categoria_arr["categoria"];

                                  //Inicia consulta de categoria del producto
                                  $result1 = $bd->select("SELECT * from oferta where id_subasta=$sub order by id_oferta desc limit 1");
                                  $oferta = mysqli_fetch_array($result1);
                                  $of_final = $oferta["oferta"];

                                  ?>


                                      <tr>
                                          <td width="180px"><center><img src="<?php echo "images/productos/$imagen_p";?>" style="height: 80px;"></center></td>
                                          <td><?php echo "<b class='text-success'>$nombre_p</b>";?></td>
                                          <td><?php echo "<p class='text-info'>$descri_p</p>";?></td>
                                          <td><?php echo $categoria;?></td>
                                          <td><?php echo "$$min.00";?></td>
                                          <td><?php echo "$$max.00";?></td>
                                          <td><?php echo "<b class='text-danger'>$$of_final.00</b>";?></td>
                                      </tr>


                                  <?php


                                }
                              }
                            }
                          }


                        }
                      }else{
                        echo "<h3>Cesta vacia</h3>";
                      }
                      //Termina consulta de subastas

                  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
