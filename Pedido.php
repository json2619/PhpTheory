<?php

class Pedido
{
    private $Id;
    private $Cliente;
    private $Fecha;
    
    public function __get($propiedad)
    {
        return $this->$propiedad;
    }
    
    public function __set($propiedad,$valor)
    {
        $this->$propiedad=$valor;
    }
    
}

?>
