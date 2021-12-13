<?php 

class ConectarDB{
    /* PDO */
    private $server="mysql: host=localhost; dbname=agenda";
    private $user ="root";
    private $pass ="";

    /* private $server="mysql: host=localhost; dbname=id18112947_agenda";
    private $user ="id18112947_root";
    private $pass ="^hcxNw#9kgE/9g!&"; */

    /* arreglo */
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    protected $conn;
    public function open(){
        try {
            $this->conn = new PDO($this->server,$this->user,$this->pass,$this->options);
            return $this->conn;
        } 
        catch (PDOException $e) {
            echo "Ocurrio un error de conexion".$e->getMessage();
        }
    }
    public function close(){
        $this->conn = null;
    }
}
?>