let paso = 1;
const pasoInicial=1;
const pasoFinal=3;
const api_url ='http://localhost:3000/api/'
const cita = {
    id_usuario: '',
    nombre: '',
    fecha: '',
    hora:'',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
})
function iniciarApp(){
    mostrarSeccion();//Muestra y oculta las secciones
    tabs();// Cambia la seccion cuando se presionen los tabs
    botonesPaginador(); // Agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();
    consultarAPI(); //Consulta la api en el backen de php
    nombreCliente();//Añade el nombre del cliente al objeto de cita
    idCliente();//Añade el nombre del cliente al objeto de cita
    seleccionarFecha();//Añade la fecha de la cita en el objeto
    seleccionarHora();//Añade la Hora de la cita en el objeto
    mostrarResumen();
}
function mostrarSeccion(){
    //Ocultar la seccion que tenga la clase de mostrar 
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
        seccionAnterior.classList.add('ocultar');
    }

    //Selecionar la seccuin con el paso
    const pasoSelector =`#paso-${paso}`
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.remove('ocultar');
    seccion.classList.add('mostrar');

    //Quita la clase de actual
    const tabAnterior = document.querySelector('.actual');
    tabAnterior.classList.remove('actual');
    //resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}


function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(
        (boton)=>boton.addEventListener(
            'click',(e)=>{
                paso = parseInt(e.target.dataset.paso)//*target.dataset se aceden a los atributos que estamos creando
                mostrarSeccion();
                botonesPaginador();
            }
    ))

}

function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    if(paso === pasoInicial){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
        }else if(paso === pasoFinal){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click',(_)=>{
        if(paso<=pasoInicial) return;
        paso = paso-1;
        mostrarSeccion();
        botonesPaginador();
        
    });
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click',(_)=>{
        if(paso>=pasoFinal) return;
        paso = paso+1;
        mostrarSeccion();
        botonesPaginador();
        
    });
}



async function consultarAPI(){
    try{
        const url = api_url+'servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    }catch(error){
        console.log(error);
    }
}
function mostrarServicios(servicios){
    let n = 0;
    servicios.forEach(servicio=>{
        const{ id_servicio, nombre_servicio, precio} = servicio;
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre_servicio;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id_servicio;//Generar un atributo personalizado(data-id-servicio)
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        }
        
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        
        document.querySelector('#servicios').appendChild(servicioDiv);
    })
}
function seleccionarServicio(servicio){
    const {id_servicio}=servicio;
    const{servicios}=cita;
    //Identificar al elemento que se le hace click
    const divServicio = document.querySelector(`[data-id-servicio="${id_servicio}"]`)??null;
    //comprobar si un servicio ya fue agregado
    if(servicios.some(agregado=>agregado.id_servicio===id_servicio)){
        //eliminarlo
        cita.servicios = servicios.filter(agregado=>agregado.id_servicio!==id_servicio);//guarda todos los servicios que su id_Servicio sea diferente al id_servicio
        divServicio.classList.remove('seleccionado');
    }else{
        //agregarlo
        cita.servicios = [...servicios,servicio];
        divServicio.classList.add('seleccionado');
    }  

}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
}
function idCliente(){
    cita.id_usuario = document.querySelector('#id_usuario').value;
}


function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay();//me da el dia se la semana 0(domingo), 1 (lunes) ..
        if([6,0].includes(dia)){
            e.target.value ='';
            cita.fecha = '';
            mostrarAlerta('Fines de semana no permitidos', 'error');
        }else{
            cita.fecha = e.target.value;
        }
        
    })
}
function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value;//me da el dia se la semana 0(domingo), 1 (lunes) ..
        const hora = horaCita.split(":");//me da el dia se la semana 0(domingo), 1 (lunes) ..
        
        
        if(hora[0]>8 && hora[0]<21){
            cita.hora = e.target.value;
        }else{
            e.target.value ='';
            cita.hora = '';
            mostrarAlerta('Trabajamos de 9am a 9pm', 'error');
        }
        
    })
}


function mostrarAlerta(mensaje, tipo, elemento='.formulario',desaparece = true){
    //? Previene que se genere más de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }
    //? Acripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent=mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    const formulario = document.querySelector(elemento);
    formulario.appendChild(alerta);
    //?Elimina la alerta
    if(desaparece){  
        setTimeout(()=>{
            alerta.remove();
        },3000);
    }
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');
    //limpiar el contenido del resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }
    if(Object.values(cita).includes('') || cita.servicios.length==0 ){
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora', 'error', elemento='.contenido-resumen',desaparece = false);
        return;
    }
    
    //Formatear el div de resumen
    const{nombre, fecha, hora, servicios}=cita;

    //Heading para servicios en Resumen
    const headigServicios = document.createElement('H3');
    headigServicios.textContent = 'Resumen de servicios'
    resumen.appendChild(headigServicios);

    //iterando y mostrando los servicios
    servicios.forEach(servicio=>{
        const {id_servicio, nombre_servicio, precio}=servicio;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicios');

        const textServicio = document.createElement('P');
        textServicio.textContent = nombre_servicio;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;
        
        contenedorServicio.appendChild(textServicio);
        contenedorServicio.appendChild(precioServicio);
        resumen.appendChild(contenedorServicio);
    });

    //Heading para citas en Resumen
    const headigCita = document.createElement('H3');
    headigCita.textContent = 'Resumen de la cita'
    resumen.appendChild(headigCita);


    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    const fechaFormateada=dateFormate(fecha);
    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;
    // Boton para Crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.id='boton-reservar';
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);

    
}
function dateFormate(fecha){
    //Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate()+2;
    const year = fechaObj.getFullYear();
    const fechaUTC =new Date(Date.UTC(year,mes,dia));
    const opciones = {weekday:'long',year:'numeric',month:'long',day:'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX',opciones);
    return fechaFormateada;
}
async function reservarCita(){
    const botonReservar = document.querySelector('#boton-reservar')
    botonReservar.classList.add('deshabilitar')
    const {id_usuario, fecha, hora, servicios} = cita;
    const idServicio = servicios.map(servicio=>servicio.id_servicio);
    const datos = new FormData();

    datos.append('id_usuario',id_usuario);
    datos.append('fecha',fecha);
    datos.append('hora',hora);
    datos.append('servicios',idServicio);
    //Petición hacia la api
    try{
        const url = api_url+'citas'
        const respuesta = await fetch(url, {
            method:'POST',
            body: datos
        });
        const resultado = await respuesta.json();
        if(resultado.resultado){
            Swal.fire({
                icon: "success",
                title: "Cita Creada",
                
              }).then(()=>{
                window.location.reload(); //recargar la pagina
            })
        }
    }catch(error){
        Swal.fire({
            icon: "error",
            title: 'Error',
            text: "Hubo un error al guardar la cita"
          }).then(()=>{
             botonReservar.classList.remove('deshabilitar')
        })
    }
}

