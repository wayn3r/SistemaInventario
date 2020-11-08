<?php
    namespace Model\db;

use mysqli;
use stdClass;

class conexion {
        private $conex;
        private static  $instance;
        
        private function __construct(){
            try{
                require_once('configx.php');
                $this->conex = mysqli_connect(HOST,USER,PASS,NAME,PORT);
                if(is_bool($this->conex)){
                    header('location: ../error.php');
                }
            }catch(\Exception $e){
                die("Error: {$e->getMessage()}");
            }
        }

        public static function getInstance(): conexion{
            if(self::$instance==null){
                self::$instance = new conexion();
            }
            return self::$instance;
        }

        public function query(string $sql){
            $sql = str_replace("''",'default',$sql);
            // var_dump($sql);exit;
            $con = mysqli_query(self::$instance->conex,$sql);
            $datos = [];
            if(!is_bool($con)){
                while($data = mysqli_fetch_assoc($con)){
                    $datos[] = $data;
                }
            }
            else $datos = $con;
            return $datos;
        }

        public function getResult(){
            $result= new stdClass;
            $result->rows = mysqli_affected_rows(self::$instance->conex);
            $result->error = mysqli_error(self::$instance->conex);
            $result->errno = mysqli_errno(self::$instance->conex);
            return $result;
        }

        public function GetLastId(){
            return mysqli_insert_id(self::$instance->conex);
        }
       




    }

?>