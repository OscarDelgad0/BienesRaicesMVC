<?php 

namespace Model;

class ActiveRecord {
    // Base de datos

    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

     // Errores 


    protected static $errores = [];

     // Definir a la conexión a la bd
     public static function setDB($database){
        self::$db = $database;
    }

    public static function pruebaDebug(){
        echo 'Direccion correcta';
     }


     public function guardar(){

        

        $atributos = $this->sanitizarAtributos();

        if(!is_null($this->id)){
            //actualizar
            $resultado = $this->actualizar();
        }else {
            // Creando
            $resultado = $this->crear();
        }

        return $resultado;
     }

     public function crear(){
        // Sanitizar
        $atributos = $this->sanitizarAtributos();
         // Insertar a BD
         $query = "INSERT INTO " . static::$tabla . "( ";
         $query .= join(', ', array_keys($atributos));
         $query .= ") VALUES ( ";
         foreach ($atributos as $valor) {
            if (is_numeric($valor)) {
                $valores[] = $valor;
            } else {
                $valores[] = "'" . $valor . "'";
            }
        }
        $query .= join(', ', $valores);
        $query .= " )";
        
        $resultado = self::$db->query($query);
     // Mensaje de exito

     if($resultado) {
        header('Location: /admin?resultado=1');
    }
    
     }
     public function actualizar(){
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        if($resultado) {
            header('Location: /admin?resultado=2');
        }
        
     }

     // Eliminar un registro

     public function eliminar(){
         // Eliminar la propiedad
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        

        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
     }

    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
       }

       return $sanitizado;
    }

    // Subida de archivos 
    public function setImagen($imagen) {
        // Elimina la imagen previa

        if(!is_null($this->id)) {
            $this->borrarImagen();
        }

        // Asignar el atributo de la imagen a el nombre  de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminar archivo 
    public function borrarImagen(){
               // Comprobar si exite el archivo

               $existeArchivo = file_exists(CARPETA_IMAGENES . "$this->imagen");
               if($existeArchivo) {
                   unlink(CARPETA_IMAGENES . $this->imagen);
               }
    }
    // Validacion
    public static function getErrores(){
        
        return static::$errores;
    }

    public function validar(){
        static::$errores = [];
        return static::$errores;
    }

    public static function all() {
       $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtiene determinado cant
    public static function getInicio($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
         $resultado = self::consultarSQL($query);
         return $resultado;
     }

    // Busca una propiedad por su id
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        //Consultar la base de datos
   
        $resultado = self::$db->query($query);
        //Iterar
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }
        //Liberar la memoria
        $resultado->free();
        //Retornar resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = [] ){
        foreach($args as $key =>$value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
}