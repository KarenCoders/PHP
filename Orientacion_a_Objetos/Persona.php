<?php

//Clase persona

class Persona {
    //Propiedades
    public $nombre;
    public $edad;

    //Método constructor
    public function __construct($nombre, $edad) {
        $this->nombre = $nombre;
        $this->edad = $edad;
    }

    //Método Saludar()
    public function Saludar() {
        return "$this->nombre está saludando";
    }
}

//Crear un objeto
$miPersona = new Persona("María", 20);
echo $miPersona->saludar(); 