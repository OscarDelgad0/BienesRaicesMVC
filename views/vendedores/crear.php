    <main class="contenedor seccion">
        <h1>Registrar vendedores</h1>

        <a href="../admin" class="boton boton-verde">Regresar</a>

        <?php foreach($errores as $error){ ?>
            <div class="alerta error">
               <p><?php echo $error; ?></p> 
            </div>
        <?php } ?>

     <form class="formulario" method="POST" action="crear" enctype="multipart/form-data">
        <?php include 'formulario.php'?>
        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>

    </main>