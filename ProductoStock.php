<?php

class ProductoStock
{
    private $cod;
    private $nombre;
    private $PVP;
    private $disponible;
    
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
