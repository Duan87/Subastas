<?php
if(isset($_POST["tiempo_limite"])){
  //arreglo para agregar bandera cuando la fecha concluya
  $indicador = array();
  //obtenemos fecha del servidor
  $fecha_servidor = date("Y-m-d H:i:s");
  //declaramos el primer valor de fecha y tiempo
  $datetime1 = date_create($fecha_servidor);
  //declaramos el segundo valor de fecha y tiempo
  $datetime2 = date_create($_POST["tiempo_limite"]);
  //sacamos la diferencia entre las 2 fechas la limite de la bd y la del servidor
  $interval = date_diff($datetime1, $datetime2);
  //le damos formato al intervalo que nos regreso la diferencia
  $fecha_restantes = $interval->format('%R%d días %H:%I:%s');
  $fecha_comparar = $interval->format('%R');
  if($fecha_comparar == '-'){
    echo "Subasta cerrada";
  }else{
    echo $fecha_restantes;
  }
}
?>
