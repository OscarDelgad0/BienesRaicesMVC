<?php

    namespace Model;

class Propiedad extends ActiveRecord{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion',
     'habitaciones', 'wc', 'estacionamiento', 'fecha', 'vendedores_id'];

     
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $fecha;
    public $vendedores_id;

    public function __construct($args = []){

        $this->id = $args['id']  ?? NULL;
        $this->titulo = $args['titulo']  ?? '';
        $this->precio = $args['precio']  ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['wc'] ?? '';
        $this->fecha = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
     }

     public function validar(){
        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if(!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }
        if(strlen($this->descripcion) < 20) {
            self::$errores[] = "Debes añadir un descripcion y mayor a 20 caracteres";
        }
        if(!$this->habitaciones) {
            self::$errores[] = "Debes añadir una habitacion";
        }
        if(!$this->wc) {
            self::$errores[] = "Debes añadir un wc";
        }
        if(!$this->estacionamiento) {
            self::$errores[] = "Debes añadir un estacionamiento";
        }
        if(!$this->vendedores_id) {
            self::$errores[] = "Debes añadir un vendedor";
        }

        if(!$this->imagen){
            self::$errores[] = "La imagen es obligatoria desde propiedad";
        }
        return self::$errores;
    }
    
}