<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'Producto.php';
require_once 'ProductoStock.php';

class DaoProductos extends DB 
{
   public $productos=array();  //Array de objetos con el resultado de las consultas
    
   public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
   {
       $this->dbname=$base;
   }
    
   public function insertar($producto)      //Recibe como parámetro un objeto con la situación administrativa
   {
       $consulta="insert into producto values(:cod,:nombre,:descripcion,:PVP,:familia,:Foto)";
        
       $param=array();
       
       $param[":cod"]=$producto->__get("cod");
       $param[":nombre"]=$producto->__get("nombre");
       $param[":descripcion"]=$producto->__get("descripcion");
       $param[":PVP"]=$producto->__get("PVP");
       $param[":familia"]=$producto->__get("familia");
       $param[":Foto"]=$producto->__get("Foto");
      
       $this->ConsultaSimple($consulta,$param);
       
      
   }
   
   
   
   public function obtener($cod)          //Obtenemos el elemento a partir de su Id
   {
       $consulta="select * from producto where cod=:cod";
       $param=array(":cod"=>$cod);
       
       $this->productos=array();  //Vaciamos el array de las situaciones entre consulta y consulta
       
       $this->ConsultaDatos($consulta,$param);
       
       $pro=null; //Inicializamos a nulo la variable que almacenarça el objeto de retorno 
       
       if (count($this->filas)==1 )
       {
           $fila=$this->filas[0];  //Recuperamos la fila devuelta
         
           $pro= new Producto();
           
           $pro->__set("cod", $fila['cod']);
           $pro->__set("nombre", $fila['nombre']);
           $pro->__set("descripcion", $fila['descripcion']);
           $pro->__set("PVP", $fila['PVP']);
           $pro->__set("familia", $fila['familia']);
           $pro->__set("Foto", $fila['Foto']);
           
       }
       
       return $pro;  //Retornamos el objeto con los datos del producto
   }
   
   public function listFamTien($familia,$tienda)       //Lista los productos de una familia
   {
     $consulta="SELECT p.*
                FROM  producto p, stock s
                where p.cod=s.producto and p.familia=:familia and s.tienda=:tienda; ";
     
     $param=array(":familia"=>$familia,":tienda"=>$tienda);
     
     $this->productos=array();  //Vaciamos el array de las situaciones entre consulta y consulta
     
     $this->ConsultaDatos($consulta,$param);
       
     foreach($this->filas as $fila)
     {
        $pro= new Producto();
        
        $pro->__set("cod", $fila['cod']);
        $pro->__set("nombre", $fila['nombre']);
        $pro->__set("descripcion", $fila['descripcion']);
        $pro->__set("PVP", $fila['PVP']);
        $pro->__set("familia", $fila['familia']);
        $pro->__set("Foto", $fila['Foto']);
        
        $this->productos[]=$pro;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        
     }
     
   }
   public function listFamNom($familia="",$nombre="")       //Lista los productos de una familia y que coincida el nombre
   {
         $consulta="SELECT p.cod,p.nombre,p.PVP,sum(s.unidades) as disponible
                    from producto p, stock s 
                    where p.cod=s.producto ";
         
         $param=array();
         
         if ($familia!='')   // si hemos recibido un código de familia
         {
            $consulta.=" AND familia=:familia "; 
            $param[":familia"]=$familia;
         }
         
         if ($nombre!='')   // si hemos recibido un código de familia
         {
             $consulta.=" AND nombre like :nombre ";
             $param[":nombre"]="%".$nombre."%";
         }
         
         $consulta.=" GROUP by cod ";
          
         $this->productos=array();  //Vaciamos el array de las situaciones entre consulta y consulta
         
         $this->ConsultaDatos($consulta,$param);
         
         foreach($this->filas as $fila)
         {
             $pro= new ProductoStock();
             
             $pro->__set("cod", $fila['cod']);
             $pro->__set("nombre", $fila['nombre']);
             $pro->__set("PVP", $fila['PVP']);
             $pro->__set("disponible", $fila['disponible']);
           
             $this->productos[]=$pro;   //Insertamos el objeto con los valores de esa fila en el array de objetos
             
         }
     
   }
   
 
}

?>