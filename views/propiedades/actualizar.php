<main class="contenedor seccion">
        <h1>Actualizar</h1>

        <?php foreach($errores as $error){ ?>
            <div class="alerta error">
               <p><?php echo $error; ?></p> 
            </div>
        <?php } ?>

        <a href="../admin" class="boton boton-verde">Volver</a>



        <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php';?>
        <input type="submit" value="actualizar propiedad" class="boton boton-verde">

        </form>
</main>