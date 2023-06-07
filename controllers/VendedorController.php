<?php 

    namespace Controllers;
    use Model\Vendedor;
    use MVC\Router;

    class VendedorController {
        public static function crear(Router $router){

            $errores = Vendedor::getErrores();
            $vendedor = new Vendedor;

            
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Crear nueva instancia
        $vendedor = new Vendedor($_POST['vendedor']);

        // Validar que no haya campos vaciso
        $errores = $vendedor->validar();

        if(empty($errores)){
            $vendedor->guardar();
        }
    }


            $router->render('vendedores/crear', [
                'errores' => $errores,
                'vendedor' => $vendedor

            ]);
        }
        public static function actualizar(Router $router){

            $id = validarRedireccion('../admin');

            $errores = Vendedor::getErrores();
            $vendedor = Vendedor::find($id);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
                // Asignar los valores
        
                $args = $_POST['vendedor'];
        
                //sincronizar objeto en memoria con lo que el usuario escribio
                $vendedor->sincronizar($args);
        
                $errores = $vendedor->validar();
        
                if(empty($errores)){
                    $vendedor->guardar();
                }
            }  

            $router->render('vendedores/actualizar', [
                'errores' => $errores,
                'vendedor' => $vendedor
            ]);
        }
        public static function eliminar(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                // Validar ID

                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if($id) {
                    $tipo = $_POST['tipo'];
                    if(validarTipoContenido($tipo)) {
                        $vendedor = Vendedor::find($id);

                        $vendedor->eliminar();
                    }
                }
 
            }
        }


    }