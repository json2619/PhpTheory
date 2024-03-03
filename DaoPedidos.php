<?php

//Necesitamos incluir la libreria y la clase entidad asociada al DAO

require_once 'libreriaPDO.php';
require_once 'Pedido.php';
require_once 'ImpPedido.php';

class DaoPedidos extends DB 
{
   public $pedidos=array();  //Array de objetos con el resultado de las consultas
    
   public function __construct($base)  //Al instancial el dao especificamos sobre que BBDD queremos que actue 
   {
       $this->dbname=$base;
   }
    
   public function insertar($pedido)      //Recibe como parámetro un objeto con la situación administrativa
   {
       $consulta="insert into pedido values(:Id,:Cliente,:Fecha)";
        
       $param=array();
       
       $param[":Id"]=$pedido->__get("Id");
       $param[":Cliente"]=$pedido->__get("Cliente");
       $param[":Fecha"]=$pedido->__get("Fecha");
       
       $this->ConsultaSimple($consulta,$param);
      
   }
   
   public function recuperarId($cliente,$fecha)
   {
       $consulta="select * from pedido where Cliente=:Cliente and Fecha=:Fecha";
       
       $param=array();
       
       $param[":Cliente"]=$cliente;
       $param[":Fecha"]=$fecha;
       
       $this->ConsultaDatos($consulta,$param);
       
       $fila=$this->filas[0];
       
       $pedido= new Pedido();
       
       $pedido->__set("Id", $fila["Id"]);
       $pedido->__set("Cliente", $fila["Cliente"]);
       $pedido->__set("Fecha", $fila["Fecha"]);
       
       return $pedido;
       
   }
   
   public function ImportesPed($ord)   //Método que retorna el pedido con may/men importe según el parámetro de orden
   {
      $consulta="SELECT d.IdPed as Id,sum((d.Cantidad*p.PVP)) as Importe 
                 FROM detpedido d, producto p
                 where d.IdPro=p.cod
                 GROUP by IdPed
                 order by Importe ";
      
      if ($ord==0)   //Solicitan el Mayor importe
      {
          $consulta.=" desc ";
      }
       
      $consulta.=" limit 1";
       
      $param=array();
      
      $this->ConsultaDatos($consulta,$param);
      
      $fila=$this->filas[0];
      
      $ImpPed= new ImpPedido();
     
      $ImpPed->__set("Id", $fila["Id"]);
      $ImpPed->__set("Importe", $fila["Importe"]);
      
    return $ImpPed;  
    
   }
   
   public function MediaPed()   //Método que retorna la media de los pedidos
   {
     $consulta=" SELECT d.IdPed as Id,avg((d.Cantidad*p.PVP)) as Importe 
                 FROM detpedido d, producto p
                 where d.IdPro=p.cod "; 
       
     $param=array();
     
     $this->ConsultaDatos($consulta,$param);
     
     $fila=$this->filas[0];
     
     $ImpPed= new ImpPedido();
     
     $ImpPed->__set("Id", $fila["Id"]);
     $ImpPed->__set("Importe", $fila["Importe"]);
     
     return $ImpPed;  
    
   }
   
   /*
   
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
 
   */ 
 
}

?>