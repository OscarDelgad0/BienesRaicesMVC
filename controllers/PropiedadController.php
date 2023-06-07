<?php

    namespace Controllers;
    use MVC\Router;
    use Model\Propiedad;
    use Model\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;


    class PropiedadController{
        public static function index(Router $router){

            //$propiedades = Propiedad::all();

            $propiedades = Propiedad::all();
            $vendedores = Vendedor::all();

            $resultado = $_GET['resultado'] ?? null;

            $router->render('propiedades/admin', [
                'propiedades' => $propiedades,
                'resultado' => $resultado,
                'vendedores' => $vendedores
            ]);
        }

        public static function crear(Router $router){
            $propiedad = new Propiedad;
            $vendedores =  Vendedor::all();
            $errores = Propiedad::getErrores();


            
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
                $propiedad = new Propiedad($_POST['propiedad']);
                    //generar nombre unico
                    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
                    //Setear una imagen
                    // Realiza un resize con la img
                    if ($_FILES['propiedad']['tmp_name']['imagen']) {
                        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                        $propiedad->setImagen($nombreImagen);
                    }

        
                //Validar
                $errores = $propiedad->validar();
        
                // Revisar que el arreglo de errores este vacio
                if(empty($errores)){
                    // Crea carpeta para subir imagenes
                    if(!is_dir(CARPETA_IMAGENES)){
                        mkdir(CARPETA_IMAGENES);
                    }
                    // Guarda la imagen en el servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                    $resultado = $propiedad->guardar();

                    if($resultado) {
                        header('location: /propiedades');
                    }
                }
        
            }
        
      
            $router->render('propiedades/crear', [
                    'propiedad' => $propiedad,
                    'vendedores' => $vendedores,
                    'errores' => $errores,
                    
            ]);
        }

        public static function actualizar(Router $router){
            $id = validarRedireccion('../admin');

            $propiedad = Propiedad::find($id);
            $errores = Propiedad::getErrores();
            $vendedores =  Vendedor::all();

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
 

                $args = $_POST['propiedad'];
        
                $propiedad->sincronizar($args);
        
                $errores = $propiedad->validar();
        
                 //generar nombre unico
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
                //Setear una imagen
                // Realiza un resize con la img
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    $propiedad->setImagen($nombreImagen);
                }
        
                // Revisar que el arreglo de errores este vacio
                if(empty($errores)){
                    if($_FILES['propiedad']['tmp_name']['imagen']) {
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                    }
        
                   $propiedad->guardar();
           
                }
        
            }


            $router->render('propiedades/actualizar', [
                'propiedad' => $propiedad,
                'errores' => $errores,
                'vendedores' => $vendedores
            ]);
            
        }

        public static function eliminar(){
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $id = $_POST['id'];

                $id = filter_var($id, FILTER_VALIDATE_INT);

                if($id) {
                    $tipo = $_POST['tipo'];

                    if(validarTipoContenido($tipo)){
                            $propiedad = Propiedad::find($id);
                            $propiedad->eliminar();
                         }
                    }
                }
            }
        }

    