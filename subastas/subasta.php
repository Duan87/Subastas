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
  //Se verifica si existe una variable get id si no redirecciona
  if(!$_GET["id"]){
    header("Location: subastas.php");
  }

  //Si no redirecciona guardamos la variable get en una variable
  $id_sub = $_GET["id"];
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Subasta de producto</title>

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

    <?php
      if (isset($_POST["ofertar"])) {
        //Si el usuario quiere ofertar por un producto
        $oferta = $_POST["oferta"];
        $id_user_1 = $_POST["id_user"];
        $id_sub_1 = $_POST["id_sub"];
        $max = $_POST["max"];
        $fecha_hora_actual = date("Y-m-d H:i:s");

          if($oferta == $max){
            //echo "<script>alert('$oferta, 0, $fecha_hora_actual, $id_sub_1, $id_user_1');</script>";
            $res_1 = $bd->query("INSERT into oferta(oferta, estado, fecha, id_subasta, comprador) values($oferta, 1, '$fecha_hora_actual',$id_sub_1, $id_user_1);");
            if($res_1 == false){
              echo "<script>alert('No se ha podido ofertar');</script>";
            }else{
              $res_2 = $bd->query("INSERT into cesta(id_usuario, id_subasta) values($id_user_1,$id_sub_1);");
              if($res_2 == false){
                echo "<script>alert('No se pudo agregar producto a la cesta');</script>";
              }else{
                $res_2_1 = $bd->query("UPDATE subasta set estado=1, comprador=$id_user_1 where id_subasta=$id_sub_1;");
                if($res_2_1 == false){
                  echo "<script>alert('No se pudo actualizar la subasta');</script>";
                }else{
                  echo "<script>alert('1... 2... 3... ¡VENDIDO!');</script>";
                }
              }
            }
          }else{
            //echo "<script>alert('Oferta hecha');</script>";
            $res_1 = $bd->query("INSERT into oferta(oferta, estado, fecha, id_subasta, comprador) values($oferta, 0, '$fecha_hora_actual',$id_sub_1, $id_user_1);");
            if($res_1 == false){
              echo "<script>alert('No se ha podido ofertar');</script>";
            }else{
              $res_2_1 = $bd->query("UPDATE subasta set comprador=$id_user_1 where id_subasta=$id_sub_1;");
              if($res_2_1 == false){
                echo "<script>alert('No se pudo actualizar la subasta');</script>";
              }else{
                echo "<script>alert('Oferta realizada con exito');</script>";
              }
            }
          }
      }elseif(isset($_POST["comprar"])){
        //echo "<script>alert('Vendido');</script>";
        //Si el usuario quiere comprar el producto pagando el monto maximo de la subasta
        $oferta = $_POST["max"];
        $id_user_1 = $_POST["id_user"];
        $id_sub_1 = $_POST["id_sub"];
        $max = $_POST["max"];
        $fecha_hora_actual = date("Y-m-d h:i:s");

          $res_1 = $bd->query("INSERT into oferta(oferta, estado, fecha, id_subasta, comprador) values($oferta, 1, '$fecha_hora_actual',$id_sub_1, $id_user_1);");
          if($res_1 == false){
            echo "<script>alert('No se ha podido ofertar');</script>";
          }else{
            $res_2 = $bd->query("INSERT into cesta(id_usuario, id_subasta) values($id_user_1,$id_sub_1);");
            if($res_2 == false){
              echo "<script>alert('No se pudo agregar producto a la cesta');</script>";
            }else{
              $res_2_1 = $bd->query("UPDATE subasta set estado=1, comprador=$id_user_1 where id_subasta=$id_sub_1;");
              if($res_2_1 == false){
                echo "<script>alert('No se pudo actualizar la subasta');</script>";
              }else{
                echo "<script>alert('1... 2... 3... ¡VENDIDO!');</script>";
              }
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
                            Producto <small>Haz tu mejor oferta</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-comment"></i> Subastas
                            </li>
                            <li>
                                <i class="fa fa-comments"></i> Todas las subastas
                            </li>
                            <li class="active">
                                <i class="fa fa-certificate"></i> Haz una oferta
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Listado de subastas -->
                <div class="row">

                  <?php
                      //Inicia consulta de subastas
                      $res = $bd->select("SELECT * from subasta where id_subasta=$id_sub");
                      if($res->num_rows > 0){
                        while($row = $res->fetch_assoc()){
                          $min = $row["min"];
                          $max = $row["max"];
                          $ini = $row["tiempo_ini"];
                          $fin = $row["tiempo_fin"];
                          $estado = $row["estado"];
                          $comprador = $row["comprador"];
                          $subastador = $row["subastador"];
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
                              $descripcion_p = $row2["descripcion"];
                              $id_categoria = $row2["id_categoria"];

                              //Inicia consulta de categoria del producto
                              $result = $bd->select("SELECT * from categoria where id_categoria=$id_categoria");
                              $categoria_arr = mysqli_fetch_array($result);
                              $categoria = $categoria_arr["categoria"];

                              //echo "$id_subasta, $min, $max, $ini, $fin, $comprador, $id_producto, $nombre_p, $imagen_p<br>";

                              $res_count=$bd->select("SELECT count(*) as total from oferta where id_subasta=$id_sub");
                              $data=mysqli_fetch_array($res_count);
                              $count_ofert = $data['total'];

                              $res3 = $bd->select("SELECT * from oferta where id_subasta=$id_sub order by id_oferta desc limit 1");
                              if($res3->num_rows > 0){
                                while($row3 = $res3->fetch_assoc()){
                                  $id_oferta = $row3["id_oferta"];
                                  $oferta = $row3["oferta"];
                                  $ofertante_comp = $row3["comprador"];

                                  //echo "$id_subasta, $min, $max, $ini, $fin, $comprador, $id_producto, $nombre_p, $imagen_p, $id_oferta, $oferta<br>";

                                  /*Aqui se mostraran los productos que tienen una oferta ya*/
                                  ?>
                                  <div class="col-sm-6 col-md-6">
                                      <?php
                                        //Aqui se mostrara la imagen del producto en grande
                                        echo "<img src='images/productos/$imagen_p' style='max-height: 450px; width: 100%;'>";
                                      ?>
                                  </div>
                                  <div class="col-sm-6 col-md-6">
                                    <div class="thumbnail">
                                      <?php //echo "<img src='images/productos/$imagen_p' style='height: 220px;'>";?>
                                      <div class="caption">
                                        <?php
                                          if($estado == 1 && $ofertante_comp != null){
                                            echo "<h1 class='text-danger'>VENDIDO | SOLD</h1>";
                                          }
                                        ?>
                                        <h2 class="text-success"><?php echo $nombre_p; ?></h2>
                                        <h4 class="text-info"><?php echo $descripcion_p; ?></h4>
                                        <p class="text-warning text-right"><i class="fa fa-tag"></i> <?php echo $categoria; ?></p>
                                        <hr style="margin: 1px 1px 1px 1px;">

                                        <p>Producto publicado el <?php echo "<b>$ini</b>"; ?></p>
                                        <p><?php //print $interval->format('%R %a días %H horas %I minutos'); ?></p>

                                        <p id="tiempo"></p>
                                        <input type="hidden" id="limite" value="<?php echo $fin; ?>">

                                        <p><?php echo "<b>Ofertantes:</b> $count_ofert";?></p>
                                        <p><?php echo "<b>Oferta minima:</b> $$min.00"; ?></p>
                                        <p><?php echo "<b>Oferta maxima:</b> $$max.00"; ?></p>
                                        <h4>Oferta actual: <b class="text-danger"><?php echo "$$oferta.00"; ?></b></h4>

                                        <form class="form-inline" action="" method="post">

                                          <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_usuario']; ?>">
                                          <input type="hidden" name="id_sub" value="<?php echo $id_sub; ?>">
                                          <input type="hidden" name="max" value="<?php echo $max; ?>">
                                          <input type="hidden" name="fin" value="<?php echo $fin; ?>">

                                          <?php
                                            if($estado == 1 || $_SESSION["id_usuario"] == $ofertante_comp || $_SESSION["id_usuario"] == $subastador){
                                              ?>

                                              <div class="form-group">
                                                <input type="number" disabled name="oferta" max="<?php echo $max;?>" min="<?php echo $oferta+1;?>" class="form-control" value="<?php echo $oferta+1;?>">
                                              </div>

                                              <button type="submit" disabled class="btn btn-warning" name="ofertar">Mejorar oferta</button>
                                              <button type="submit" disabled class="btn btn-success" name="comprar">Comprar ahora</button>

                                              <?php
                                            }elseif($estado == 0){
                                              ?>
                                              <div class="form-group">
                                                <input type="number" name="oferta" max="<?php echo $max;?>" min="<?php echo $oferta+1;?>" class="form-control" value="<?php echo $oferta+1;?>">
                                              </div>

                                              <button type="submit" class="btn btn-warning" name="ofertar">Mejorar oferta</button>
                                              <button type="submit" class="btn btn-success" name="comprar">Comprar ahora</button>

                                              <?php
                                            }
                                          ?>


                                        </form>


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
                                      <div class="col-sm-6 col-md-6">
                                          <?php
                                            //Aqui se mostrara la imagen del producto en grande
                                            echo "<img src='images/productos/$imagen_p' style='max-height: 450px; width: 100%;'>";
                                          ?>
                                      </div>
                                      <div class="col-sm-6 col-md-6">
                                        <div class="thumbnail">
                                          <?php //echo "<img src='images/productos/$imagen_p' style='height: 220px;'>";?>
                                          <div class="caption">
                                            <h2 class="text-success"><?php echo $nombre_p; ?></h2>
                                            <h4 class="text-info"><?php echo $descripcion_p; ?></h4>
                                            <p class="text-warning text-right"><i class="fa fa-tag"></i> <?php echo $categoria; ?></p>
                                            <hr style="margin: 1px 1px 1px 1px;">
                                            <p>Producto publicado el <?php echo "<b>$ini</b>"; ?></p>
                                            <p><?php //print $interval->format('%R %a días %H horas %I minutos'); ?></p>

                                            <p id="tiempo"></p>
                                            <input type="hidden" id="limite" value="<?php echo $fin; ?>">

                                            <p><?php echo "<b>Oferta minima:</b> $$min.00"; ?></p>
                                            <p><?php echo "<b>Oferta maxima:</b> $$max.00"; ?></p>
                                            <h4>Oferta actual: <b class="text-danger"><?php echo "$0.00"; ?></b></h4>

                                            <form class="form-inline" action="" method="post">

                                              <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_usuario']; ?>">
                                              <input type="hidden" name="id_sub" value="<?php echo $id_sub; ?>">
                                              <input type="hidden" name="max" value="<?php echo $max; ?>">
                                              <input type="hidden" name="fin" value="<?php echo $fin; ?>">

                                              <?php
                                                if($_SESSION["id_usuario"] == $subastador){
                                                  ?>
                                                  <div class="form-group">
                                                    <input type="number" disabled name="oferta" class="form-control" max="<?php echo $max;?>" min="<?php echo $min;?>" value="<?php echo $min;?>">
                                                  </div>

                                                  <button type="submit" disabled class="btn btn-info" name="ofertar">Ofertar ahora</button>
                                                  <button type="submit" disabled class="btn btn-success" name="comprar">Comprar ahora</button>
                                                  <?php
                                                }else{
                                                  ?>
                                                  <div class="form-group">
                                                    <input type="number" name="oferta" class="form-control" max="<?php echo $max;?>" min="<?php echo $min;?>" value="<?php echo $min;?>">
                                                  </div>

                                                  <button type="submit" class="btn btn-info" name="ofertar">Ofertar ahora</button>
                                                  <button type="submit" class="btn btn-success" name="comprar">Comprar ahora</button>
                                                  <?php
                                                }
                                              ?>


                                            </form>


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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>







    <!-- Archivo de cuenta regresiva -->
    <script src="js/regresivo.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

    <script>
      //Se le define el tiempo de ejecucion - al segundo
      setInterval("tiempo()",1000);

      function tiempo(){
        $.post("ajax/tiempo_regresivo.php",{tiempo_limite:$("#limite").val()}, function(data){

            $("#tiempo").html(data);

        });

      }
    </script>

</body>

</html>
