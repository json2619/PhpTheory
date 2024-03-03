<?php 

session_start();

require_once 'DaoProductos.php';

$base = "tiendadao";

$daoProd = new DaoProductos($base);

function InsertarCesta($selec, $solic) 
{

    foreach ($selec as $clave => $valor) 
    {
        if (isset($_SESSION['cesta'][$clave]))  //Si eseproducto ya estaba en la cesta actualizaamos su cantidad
        {   
            $_SESSION['cesta'][$clave] = $_SESSION['cesta'][$clave] + $solic[$clave];
        } else  // Sino inicializamos la cantidad de ese producto
        {    
            $_SESSION['cesta'][$clave]=$solic[$clave]; //Insertariamos en la cesta una entrada para ese producto y la cantidad
        }
    }

}



function MostrarCesta() 
{

        global $daoProd;

        echo "<b>---Contenido de la cesta---</b><br>";

        echo "<fieldset>";
            
        echo "<table border='2'>";
            
        echo "<th>Cod</th><th>Nombre</th><th>Cantidad</th><th>Precio</th>";
            
        foreach ($_SESSION['cesta'] as $clave => $valor) {
                     
            $pro = $daoProd->obtener($clave);
            
            echo "<tr>";

                echo "<td>".$clave."</td>";
                
                echo "<td>".$pro->__get("nombre")."</td>";
                
                echo "<td>".$valor."</td>";
                
                echo "<td>".$pro->__get("PVP")."</td>";
                
                echo "</tr>";

        }


         echo "</table>";
    echo "</fieldset>";

    echo "<br>";

    echo "<a href='Pedidos.php'> Continuar comprando </a>";
}


function CantidadesOk($selec, $solic) 
{
    foreach ($selec as $clave => $valor) //Para los códigos de lo checkbox marcados
    {
        if ((!is_numeric($solic[$clave])) || ($solic[$clave]<=0))
        {
            return false;
        }
    }
    
    return true;
}




if (isset($_POST['Selec'])) // Con esto comprobamos si me llegan códigos de productos
{
        $selec = $_POST['Selec'];
        $solic = $_POST['Solicitados'];

        if (CantidadesOk($selec, $solic)) // Comprobamos que en todos los productos hay alguna cantidad
        {
            InsertarCesta($selec, $solic);
        } 
        else // Lo redireccionamos a pagina de pedidos
        {
            echo "<b>Insercción no realizada!!!!</b><br>";
            echo "<b>Revise las cantidades de los productos seleccionados</b><br<br>";
            header("Refresh:3; url=Pedidos.php", true, 303);
        }
        

}

if(isset($_SESSION['cesta'])) // Si existe la cesta es porque tiene productos insertados
{

MostrarCesta();
        
}