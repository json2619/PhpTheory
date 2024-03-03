<html>
<?php 

require_once 'DaoClientes.php';
require_once 'DaoFamilias.php';
require_once 'DaoProductos.php';
require_once 'DaoPedidos.php';
require_once 'DaoDetPedidos.php';


$base="tiendadao";

$cli="";

if (isset($_POST['Cliente']))
{
   $cli=$_POST['Cliente'];
}

$fami="";

if (isset($_POST['Familia']))
{
    $fami=$_POST['Familia'];
}

$nom="";

if (isset($_POST['Nombre']))
{
    $nom=$_POST['Nombre'];
}


$daoCli= new DaoClientes($base);
$daoFami= new DaoFamilias($base);
$daoPro= new DaoProductos($base);

$daoPed= new DaoPedidos($base);

$daoDetPed= New DaoDetPedidos($base);

//Procesamos el pedido

if (  isset($_POST['Pedir']) && (isset($_POST['Selec']) )   )   //Si hemos pulsado en pedir y seleccionado algún producto
{
    $pedido= new Pedido();
    
    $pedido->__set("Id", NULL);
    $pedido->__set("Cliente", $cli);
    
    $fecha=time(); //Obtenemos la fecha actual
    
    $pedido->__set("Fecha", $fecha);
    
    $daoPed->insertar($pedido);
    
    //Recuperar el Id que nos ha asignado la BBDD para ese pedido
    
    $pedido2=$daoPed->recuperarId($cli, $fecha);
    
    $IdPed=$pedido2->__get("Id");  //El Id del nuevo pedido que acabamos de generar
    
    $selec=$_POST['Selec'];   //Recogemos los checkbox de los productos seleccionados
    
    $cantidades=$_POST['Solicitados'];  //Recogemos el array con las cantidades solicidas
    
    foreach ($selec as $clave=>$valor)
    {
        $detpedido = new DetPedido();   //Creamos un instancia de la clase DetPedido
        
        $detpedido->__set("IdPed",$IdPed );
        $detpedido->__set("IdPro",$clave );
        $detpedido->__set("Cantidad", $cantidades[$clave]);
         
        $daoDetPed->insertar($detpedido); //Insertamos ese detalle de pedido
    }
}

?>


<body>

    <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
        <fieldset>
            <legend>Seleccione Cliente</legend>

            <label for='Cliente'>Cliente</label>
            <select name='Cliente'>
                <option value=""></option>

                <?php 
                      
                         $daoCli->listar();
                         
                         foreach ($daoCli->clientes as $cliente)
                         {
                             echo "<option value=".$cliente->__get('NIF') ;
                             
                             if ($cli==$cliente->__get('NIF'))
                             {
                                 echo " selected ";
                             }
                             
                             echo ">".$cliente->__get('Apellido1')." ".$cliente->__get('Apellido2').",".$cliente->__get('Nombre')."</option>";
                         }
         
 
                    ?>
            </select>

        </fieldset>


        <fieldset>
            <legend>Buscar Producto</legend>

            <label for='Familia'>Familia</label>
            <select name='Familia'>
                <option value=''></option>

                <?php         
                          
                         $daoFami->listar();
                         
                         foreach ($daoFami->familias as $familia)
                         {
                             echo "<option value=".$familia->__get('cod') ;
                             
                             if ($fami==$familia->__get('cod'))
                             {
                                 echo " selected ";
                             }
                             
                             echo ">".$familia->__get('nombre')."</option>";
                         }
         
 
                    ?>
            </select> <b>(+)</b>

            <label for='Nombre'>Nombre</label><input type='text' name='Nombre' value='<?php echo $nom ?>'>

            <input type='submit' name='Buscar' value='Buscar'>

    </form>

    </fieldset>



    <?php 
       
       if (isset($_POST['Buscar']) )
       {
           echo "<fieldset><legend>Resultado de la búsqueda</legend>";
           
           echo"<form name='f2' method='post' action='Cesta.php'>";

    $daoPro->listFamNom($fami,$nom);

    echo "<table border='2'>";
        echo "<th>Selec</th>
        <th>Nombre</th>
        <th>PVP</th>
        <th>Disponible</th>
        <th>Cantidad Pedida</th>";

        foreach ($daoPro->productos as $producto)
        {
        echo "<tr>";
            echo "<td><input type='checkbox' name='Selec[".$producto->__get("cod")."]'></td>";

            echo "<td>".substr($producto->__get('nombre'),0,20)."</td>";
            echo "<td>".$producto->__get('PVP')."</td>";

            echo "<td>".$producto->__get('disponible')."</td>";
            echo "<td><input type='number' name='Solicitados[".$producto->__get("cod")."]'></td>";

            echo "</tr>";
        }


        echo "
    </table>";

    // echo "<input type='submit' name='Pedir' value='Pedir'>";

    echo "<input type='submit' name='Cesta' value='Añadir a la cesta'>";

    echo "</form>";

    echo "</fieldset>";

    }

    ?>


</body>

</html>