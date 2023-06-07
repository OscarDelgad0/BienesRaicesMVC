<main class="contenedor seccion">
        <h1>Iniciar Sesion</h1>

        <?php foreach($errores as $error) { ?>
            <div class="alerta error">
              <?php echo $error; ?>
        </div>
        <?php } ?>

        <form method="POST" class="formulario contenido-centrado" action="/login">
        <fieldset>
                <legend>Email y password</legend>

                <label for="email">E-mail:</label>
                <input type="email" name="email"placeholder="Tu Email" id="email" >

                <label for="password">Password:</label>
                <input type="password" name="password"placeholder="Tu password" id="password" >
            </fieldset>
            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
        </form>
    </main>