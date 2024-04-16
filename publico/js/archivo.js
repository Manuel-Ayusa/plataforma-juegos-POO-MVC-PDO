let parrafo = document.getElementById('msj');
document.addEventListener('DOMContentLoaded', mostrarMsj);

function  mostrarMsj() {
    parrafo.innerHTML = '<b>¡Contraseña o usuario incorrectos!</b>';
}

let section = document.getElementById('sec');
document.addEventListener('DOMContentLoaded', agregClass);

function  agregClass() {
    section.classList.add('mb-5');
}

let inputs = document.getElementsByClassName('input');
document.addEventListener('DOMContentLoaded', cambiarBorder);

function  cambiarBorder() {
    inputs[0].classList.add('border', 'border-danger', 'border-2');
    inputs[1].classList.add('border', 'border-danger', 'border-2');
}


