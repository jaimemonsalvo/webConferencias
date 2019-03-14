//Escribimos nuestro efi
(function() {
    
      

  let regalo = document.getElementById("regalo"); //se define aca fuera para que funcione, creo yo q es una variable global
  
    "use strict";
    
   
    
    

  document.addEventListener('DOMContentLoaded', function() {
      
      
    

    


    //campo datos de usuario
    let nombre = document.getElementById("nombre");
    let apellido = document.getElementById("apellido");
    let email = document.getElementById("email");

    //campo pases

    let pase_dia = document.getElementById("pase_dia");
    let pase_dosdias = document.getElementById("pase_dosdias");
    let pase_completo = document.getElementById("pase_completo");



    //botones y divs
    let calcular = document.getElementById("calcular");
    let errorDiv = document.getElementById("error");
    let botonRegistro = document.getElementById("btnRegistro");
    let lista_productos = document.getElementById("lista-productos");
    let suma = document.getElementById("suma_total");




    //extras
    let etiquetas = document.getElementById("etiquetas");
    let camisas = document.getElementById("camisa_evento");
    
      
     /*Deshabilitando el boton de registro para q no pague hasta que se de alguna instruccion */
      
         botonRegistro.disabled=true;


    //habilitando el boton de calcular
if(document.getElementById('calcular')){
    calcular.addEventListener('click', calcularMontos);

    pase_dia.addEventListener('blur', mostrarDias); //blur funciona escribiendo o dandole el numero y se queda el ultimo numero escrito al salir
    pase_dosdias.addEventListener('blur', mostrarDias);
    pase_completo.addEventListener('blur', mostrarDias);

    //valida campos

    nombre.addEventListener('blur', validarCampos);
    apellido.addEventListener('blur', validarCampos);
    email.addEventListener('blur', validarCampos);
    email.addEventListener('blur', validarEmail); //validar Email





    function validarCampos() {
        
      if (this.value == '') {
        errorDiv.style.display = 'block';
        errorDiv.innerHTML = "Este campo es obligatorio";
        this.style.border = '2px solid red';
      } else {
        errorDiv.style.display = 'none';
        this.style.border = '2px solid #cccccc';
      }

    }
    


    function validarEmail() {
      if (this.value.indexOf('@') > -1) {
        errorDiv.style.display = 'none';
        this.style.border = '2px solid #cccccc';
      } else {
        errorDiv.style.display = 'block';
        errorDiv.innerHTML = "Debe tener un @";
        this.style.border = '2px solid red';
      }


    }



    function calcularMontos(event) {

      event.preventDefault();


      if (regalo.value === "") {
        alert("Debes elegir un regalo");
        regalo.focus(); //enfocarse en regalo
      } else {
        //aqui es donde vamos a agregar nuestro codigo.

        let boletosDia = pase_dia.value,
          boletos2Dias = pase_dosdias.value,
          boletoCompleto = pase_completo.value,
          cantCamisas = camisas.value,
          cantEtiquetas = etiquetas.value;


        //suma total de lo que compra
        let totalPagar = (boletosDia * 30) + (boletos2Dias * 45) + (boletoCompleto * 50) + (cantCamisas * 10) * (0.93) + (cantEtiquetas * 2);

        let listadoProductos = []; //creo un arreglo

        if (boletosDia >= 1) {
          listadoProductos.push(boletosDia + " Pases por día");

        }
        if (boletos2Dias >= 1) {
          listadoProductos.push(boletos2Dias + " Pases por 2 día");
        }
        if (boletoCompleto >= 1) {
          listadoProductos.push(boletoCompleto + " Pases Completo");
        }
        if (cantCamisas >= 1) {
          listadoProductos.push(cantCamisas + " Camisas");
        }
        if (cantEtiquetas >= 1) {
          listadoProductos.push(cantEtiquetas + " Etiquetas");
        }


        lista_productos.style.display = "block"; //para que se muestre el recuadro gris y se oculte sin utilizarse
        lista_productos.innerHTML = '';

        for (var i = 0; i < listadoProductos.length; i++) {
          lista_productos.innerHTML += listadoProductos[i] + '<br/>';
        }

        suma.innerHTML = "$ " + totalPagar.toFixed(2);

          /*habilitando boton registro cuando se calcula el monto*/
          botonRegistro.disabled=false;
          /*relacionando el total pago con el boton pagar*/
          document.getElementById('total_pedido').value=totalPagar; 
          
      }
    
    }


    function mostrarDias() {

      let boletosDia = pase_dia.value,
        boletos2Dias = pase_dosdias.value,
        boletoCompleto = pase_completo.value;

      let diasElegidos = [];


      if (boletosDia > 0) {
        diasElegidos.push('viernes');
      }

      if (boletos2Dias > 0) {
        diasElegidos.push('viernes', 'sabado');
      }

      if (boletoCompleto > 0) {
        diasElegidos.push('viernes', 'sabado', 'domingo');
      }

      for (var i = 0; i < diasElegidos.length; i++) {

        document.getElementById(diasElegidos[i]).style.display = 'block';

      }


    }



}

  }); //DOM CONTENT LOADED
})();

//he tenido que colocar la funcion de mapa en una funcion por aparte debido a que causaba conflito con las validaciones del registro.




if(document.getElementById('mapa')) {



// Código del mapa


$(function(){

 //mapa de leafletjs
   
    var map = L.map('mapa').setView([ 6.159478, -75.607052], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([6.159478, -75.607052]).addTo(map)
      .bindPopup('GDLWebcamp.<br> Boletos ya disponible.')
      .openPopup();
});

}







$(function(){
    
    //Lettering
    
    $('.nombre-sitio').lettering();
    
    //funcion para que se resalte el marcador de la pagina actual, agregando clase a menu
    
    $('body.conferencia .navegacion-principal a:contains("Conferencia")').addClass('activo');
    $('body.calendario .navegacion-principal a:contains("Calendario")').addClass('activo');
    $('body.invitados .navegacion-principal a:contains("Invitados")').addClass('activo');
    
    
    
    //Menu fijo
    
    var windowHeight=$(window).height();
    
    var barraAltura=$('.barra').innerHeight();
    
    $(window).scroll(function(){
       
    var scroll=$(window).scrollTop();//esta linea es la que nos va ayudar a detectar el scroll, meduante el uso de scrollTop
      
        if(scroll>windowHeight){
        $('.barra').addClass('fixed');
        $('body').css({'margin-top':barraAltura+'px'});    
        }else{
         $('.barra').removeClass('fixed');   
        $('body').css({'margin-top':'0px'});    

        }
  
   });
    
    
    //menu-movil resposivo (el de hambuerguesa)

    $('.menu-movil').on('click',function(){
        
        $('.navegacion-principal').slideToggle();
        
    });
    
    
    
    
    
    //programa de conferencias
     $('.menu-programa a:first').addClass('activo');//para que el primer elemento aparezca activo
  $(' .programa-evento .info-curso:first').show();
    
    $('.menu-programa a').on('click', function(){
        $('.menu-programa a').removeClass();//para que remueva todas las clases que se agregaron , y solo aparezca las que se va agregando
        $(this).addClass('activo');//nos va a decir que en lace esta activo
         $('.ocultar').hide();
    
        var enlace=$(this).attr('href');
       
        $(enlace).fadeIn(1000);
        
        return false;//se utiliza para que no salte 
       
    })
    
    
    //Animacion de los numeros con Plugins y jQuery
    
     var resumenLista=jQuery('.resumen-evento');//esto se agrega para cunado llegue el usuario ve a los numeros animarse
    
    if(resumenLista.length > 0){
        $('.resumen-evento').waypoint(function(){//waypoint va a ejecutar ahora la animacion, para que se ejecute cuando la pantalla este visible
    $('.resumen-evento li:nth-child(1) p').animateNumber({number:6},1200);
    $('.resumen-evento li:nth-child(2) p').animateNumber({number:15},1200);
    $('.resumen-evento li:nth-child(3) p').animateNumber({number:3},1500);
    $('.resumen-evento li:nth-child(4) p').animateNumber({number:9},1500);
     }, { offset: '60%'
       
        });
        
    }
    
    
    
    
    //animacion cuenta regresiva con count down
    
    $('.cuenta-regresiva ').countdown('2019/02/08 08:00:00', function(event){
        $('#dias').html(event.strftime('%D'));
        $('#horas').html(event.strftime('%H'));
        $('#minutos').html(event.strftime('%M'));
        $('#segundos').html(event.strftime('%S'));
    });
    
    
    //COLORBOX
    
    $('.invitado_info').colorbox({inline:true,width:"50%"});
    
    $('.boton_newsletter').colorbox({inline:true,width:"50%"});
    
    
    
    
});