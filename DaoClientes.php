<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'Cliente.php';

class DaoClientes extends DB 
{
   public $clientes=array();  //Array de objetos con el resultado de las consultas
    
   public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
   {
       $this->dbname=$base;
   }
    
   public function listar()       //Lista el contenido de la tabla
   {
     $consulta="select * from clientes ";
     $param=array();
     
     $this->clientess=array();  //Vaciamos el array de las situaciones entre consulta y consulta
     
     $this->ConsultaDatos($consulta);
       
     foreach($this->filas as $fila)
     {
        $cli= new Cliente();
        
        $cli->__set("NIF", $fila['NIF']);
        $cli->__set("Nombre", $fila['Nombre']);
        $cli->__set("Apellido1", $fila['Apellido1']);
        $cli->__set("Apellido2", $fila['Apellido2']);
        $cli->__set("FechaNac", $fila['FechaNac']);
        $cli->__set("Sexo", $fila['Sexo']);
        $cli->__set("Direccion", $fila['Direccion']);
        $cli->__set("Estado", $fila['Estado']);
        $cli->__set("Telefono", $fila['Telefono']);
        $cli->__set("CP", $fila['CP']);
        $cli->__set("Foto", $fila['Foto']);
        
        $this->clientes[]=$cli;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        
     }
    
   }
   
   /*
    
   public function obtener($NIF)          //Obtenemos el elemento a partir de su Id
   {
       $consulta="select * from Alumnos where NIF=:NIF";
       $param=array(":NIF"=>$NIF);
        
       $this->ConsultaDatos($consulta,$param);
       
       if (count($this->filas)==1 )
       {
           $fila=$this->filas[0];  //Recuperamos la fila devuelta
           
           $alu= new Alumno();
           
           $alu->__set("NIF", $fila['NIF']);
           $alu->__set("Nombre", $fila['Nombre']);
           $alu->__set("Apellido1", $fila['Apellido1']);
           $alu->__set("Apellido2", $fila['Apellido2']);
           $alu->__set("Telefono", $fila['Telefono']);
           $alu->__set("Premios", $fila['Premios']);
           $alu->__set("FechaNac", $fila['FechaNac']);
           $alu->__set("Foto", $fila['Foto']);
           
       }
       else 
       {
           echo "<b>El NIF introducido no corresponde con ningun alumno</b>";
       }
   
       return $alu;
   }
   
   public function borrar($NIF)      //Elimina una situación de la tabla
   {
       $consulta="delete from Alumnos where NIF=:NIF";
       $param=array(":NIF"=>$NIF);
        
       $this->ConsultaSimple($consulta,$param);
          
   }
   
   public function insertar($alu)      //Recibe como parámetro un objeto con la situación administrativa
   {
      $consulta="insert into Alumnos values(:NIF,
                                            :Nombre,
                                            :Apellido1,
                                            :Apellido2, 
                                            :Telefono,
                                            :Premios,
                                            :FechaNac,
                                            :Foto )";
       
      $param=array();
      
      $param[":NIF"]=$alu->__get("NIF");
      $param[":Nombre"]=$alu->__get("Nombre");
      $param[":Apellido1"]=$alu->__get("Apellido1");
      $param[":Apellido2"]=$alu->__get("Apellido2");
      $param[":Telefono"]=$alu->__get("Telefono");
      $param[":Premios"]=$alu->__get("Premios");
      $param[":FechaNac"]=$alu->__get("FechaNac");
      $param[":Foto"]=$alu->__get("Foto");
      
      $this->ConsultaSimple($consulta,$param);
   
   }

   public function actualizar($alu)     //Recibimos como parámetro un objeto con los datos a actualizar   
   { 
       $consulta="update Alumnos set Nombre=:Nombre,
                                     Apellido1=:Apellido1,
                                     Apellido2=:Apellido2, 
                                     Telefono=:Telefono,    
                                     Premios=:Premios,
                                     FechaNac=:FechaNac,
                                     Foto=:Foto          where NIF=:NIF";
       
       $param=array();
       
       $param[":NIF"]=$alu->__get("NIF");
       $param[":Nombre"]=$alu->__get("Nombre");
       $param[":Apellido1"]=$alu->__get("Apellido1");
       $param[":Apellido2"]=$alu->__get("Apellido2");
       $param[":Telefono"]=$alu->__get("Telefono");
       $param[":Premios"]=$alu->__get("Premios");
       $param[":FechaNac"]=$alu->__get("FechaNac");
       $param[":Foto"]=$alu->__get("Foto");
       
       $this->ConsultaSimple($consulta,$param);
       
   }

   */


}







?>