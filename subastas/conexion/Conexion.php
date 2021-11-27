<?php

    //Clase usada para la conexion a la base de datos
    class Conexion{

    //atributo donde se guardara la conexion a la base de datos
    private $conn = null;

    //constructor de la clase Conexion
    public function __construct(){

        include("config.php");

        //Se crea la nueva conexion
        //$this->conn = new mysqli($serv, $user, $pass, $namedb);
        $this->conn = new mysqli("localhost", "root", "Fernando_87", "subastas");

        //Se comprueba la conexion creada y muestra mensaje de error
        if ($this->conn->connect_errno) {
            echo "Error MySQLi: ". $this->conn->connect_error;
            exit();
        }
        $this->conn->set_charset("utf8");
    }

    //Destructor de la clase Conexion
    public function __destruct(){
        $this->CloseDB();
    }

    //Funcion con la que se obtienen los datos de la conexion
    public function getConexion(){
        return $this->conn;
    }

    //funcion que regresa el resultado de un select
    public function select($qry){
        $result = $this->conn->query($qry);
        return $result;
    }

    //metodo para conectar a otras DB
    public function select_db($db){
      return $this->conn->select_db($db);
    }

    //metodo para regresar ultimo id
    public function insert_id(){
      return $this->conn->insert_id;
    }

    //funcion que realiza INSERT, UPDATE y DELETE y regresa true o false segun sea
    public function query($qry){
        if(!$this->conn->query($qry)){
            return false;
        }else{
            return true;
        }
        return null;
    }

    //Funcion que cierra la base de datos que se esta usando
    public function CloseDB(){
        $this->conn->close();
    }

}
?>
