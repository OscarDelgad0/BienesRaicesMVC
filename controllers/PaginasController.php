<?php

    namespace Controllers;
    use PHPMailer\PHPMailer\PHPMailer;
    use MVC\Router;
    use Model\Propiedad;


    class PaginasController {

        public static function index(Router $router){

            $propiedades = Propiedad::getInicio(3);
            $inicio = true;

            $router->render('paginas/index',[
                'propiedades' => $propiedades,
                'inicio' => $inicio
            ]);
        }
        public static function nosotros(Router $router){
            $router->render('paginas/nosotros');
        }
        public static function propiedades(Router $router){
            $propiedades = Propiedad::all();
            $router->render('paginas/propiedades', [
                'propiedades' => $propiedades
            ]);
        }
        public static function propiedad(Router $router){
            $id = validarRedireccion('/propiedad');

            $propiedad = Propiedad::find($id);
            $router->render('paginas/propiedad', [
                'propiedad' => $propiedad
            ]);
        }
        public static function blog(Router $router){
            $router->render('paginas/blog');

        }
        public static function entrada(Router $router){
            $router->render('paginas/entrada');

        }
        public static function contacto(Router $router){

            $mensaje = null;

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                $respuesta = $_POST['contacto'];
              
                $mail = new PHPMailer();
                // configurar SMTP
                $mail->isSMTP();
                $mail->Host = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = 'd7c8f4cf68cb7d';
                $mail->Password = '220d8a680453ca';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 2525;

                // Configurar el contenido de email
                // Quien envia el email
                $mail->setFrom('admin@bienesraices.com');
                // A quien le llega el email
                $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
                $mail->Subject = 'Tienes un nuevo mensaje';

                // Habilitar HTML
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';

                // Definir el contenido
                $contenido = '<html>';
                $contenido .= '<p> Tienes un nuevo mensaje </p>';
                $contenido .= '<p>Nombre: ' . $respuesta['nombre'] .' </p>';

                if($respuesta['medio'] === 'telefono'){
                    $contenido .= '<p>Eligio ser contactado por telefono: </p>';
                    $contenido .= '<p>telefono: ' . $respuesta['telefono'] .' </p>';
                    $contenido .= '<p>Fecha: ' . $respuesta['fecha'] .' </p>';
                    $contenido .= '<p>Hora: ' . $respuesta['hora'] .' </p>';
                }else {
                    $contenido .= '<p>Eligio ser contactado por email: </p>';
                    $contenido .= '<p>email: ' . $respuesta['email'] .' </p>';

                }
                $contenido .= '<p>mensaje: ' . $respuesta['mensaje'] .' </p>';
                $contenido .= '<p>Vende o compra: ' . $respuesta['medio'] .' </p>';
                $contenido .= '<p>Precio o presupuesto: $' . $respuesta['precio'] .' </p>';
                $contenido .= '</html>';

                $mail->Body = $contenido;
                $mail->AltBody = 'Esto es texto alternativo';
                //Enviar email
                if($mail->send()){
                    $mensaje = "Mensaje enviado corrrectamente";
                }else {
                    $mensaje = "El mensaje no se pudo enviar";
                }

            }
            $router->render('paginas/contacto', [
                'mensaje' => $mensaje
            ]);
        }

    }