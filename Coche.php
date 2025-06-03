<?php 
//Clase coche

class Coche {
    //propiedades
    public $marca;
    public $modelo;
    public $año;

    //Método constructor
    public function __construct($marca, $modelo, $año) {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->año = $año;
    }
    //Método mostrarDetalles()
    public function mostrarDetalles() {
        return "Marca: $this->marca, Modelo: $this->modelo, Año: $this->año";
    }
}

//Crear un objeto
$miCoche = new Coche("","", "");
echo $miCoche->mostrarDetalles();