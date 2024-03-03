<?php

class Producto
{
    private $cod;
    private $nombre;
    private $descripcion;
    private $PVP;
    private $familia;
    private $Foto;
    
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
