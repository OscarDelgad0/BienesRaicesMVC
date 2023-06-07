document.addEventListener('DOMContentLoaded', function() {

    eventListeners();

    darkMode();
});

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    //Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[medio]"]');

    metodoContacto.forEach(input =>
         input.addEventListener('click', mostrarMetodosContacto))
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion', Mostrar);

    navegacion.classList.toggle('mostrar')
}


function mostrarMetodosContacto(e){
    const contactoDiv = document.querySelector('#contacto');

    if(e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
        <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]" require>
        <p>Elija la fecha y la hora</p>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="contacto[fecha]">

        <label for="hora">Hora:</label>
        <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">

        `;

    }else {
        contactoDiv.innerHTML = `
        <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" require>
        `;
    }
    console.log(e);
}