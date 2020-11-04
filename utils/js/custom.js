//modal para eliminar
$('#remove-modal').on('show.bs.modal', function (event) {
    var ancla = $(event.relatedTarget) // ancla que llama el modal
    var row = ancla.data()
    
    var modal = $(this)
    modal.find('.modal-title').text('Eliminar - ' + row.titulo)
    modal.find('.modal-footer input').val(row.id)
  });
//modal para agregar toners
$('#add-toner-modal').on('show.bs.modal', function (event) {
    var ancla = $(event.relatedTarget) // ancla que llama el modal
    var row = ancla.data()
    
    var modal = $(this)
    modal.find('.modal-title').text('Agregar toner - ' + row.titulo)
    modal.find('.modal-body input[id="idImpresora"]').val(row.id)
  })

//filas clickeables
document.addEventListener('DOMContentLoaded', function(){
        var tds = document.querySelectorAll("td[link]");
        tds.forEach( td =>{
            td.addEventListener("click", function(){
                window.location = td.parentNode.dataset.link;
            })
        })
})
//evitar que se cierren las notificacines
$('.dropdown-menu-clickable').on('click', function (e) {
  e.stopPropagation();
});

//validar formularios de bootstrap
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

//mostar mensaje en pantalla
$(document).ready(function (){
  $('.toast').toast('show');
});

//metodo para cambiar opciones de entrega
function addOptions(){ 
  var form = document.agregarForm;
  var tipoarticulo = form.idTipoArticulo[form.idTipoArticulo.selectedIndex].value;
  
  //quitando la validacion anterior
  var inputs = form.getElementsByClassName("is-invalid");
  if(inputs.length > 0){
    for(var i=0;i<inputs.length;i++){
      inputs[i].classList.remove('is-invalid');
    }  
    form.idTipoArticulo.parentNode.getElementsByClassName('invalid-feedback')[0].firstChild.innerHTML='Por favor, selecciona un articulo de la lista';
  }
  
  if (tipoarticulo != '') { 
     var opciones = document.getElementById('modelos-json').value;
     opciones = JSON.parse(opciones);
     var mostrar = [];
      for(var opcion of opciones){
        if(opcion.idTipoArticulo === tipoarticulo){
          mostrar.push(opcion);
        }
      } 
     //marco el número de opciones en el select de modelos
     form.idArticulo.length = mostrar.length + 1; 
     //para cada articulo del array, lo introduzco en el select 
     for(i=0;i<mostrar.length;i++){ 
        form.idArticulo.options[i + 1].value=mostrar[i].idArticulo;
        form.idArticulo.options[i + 1].text=mostrar[i].modelo;
     }	
     //mostrando mensaje de error
    if(mostrar.length == 0){
      form.classList.remove('was-validated');
      form.idTipoArticulo.classList.add("is-invalid");
      form.idTipoArticulo.parentNode.getElementsByClassName('invalid-feedback')[0].firstChild.innerHTML='Este articulo no tiene existencias en stock';
    }
  }else{ 
     //si no había provincia seleccionada, elimino las provincias del select 
     form.idArticulo.length = 1 ;
     //coloco un guión en la única opción que he dejado 
     form.idArticulo.options[0].value = "" ;
     form.idArticulo.options[0].text = "Selecciona un modelo";
  } 
  //marco como seleccionada la opción primera de provincia 
  form.idArticulo.options[0].selected = true 
}
//poniendo un valor maximo de cantidad de existencia
function maxValue(){
  var form = document.agregarForm;
  var modelo = form.idArticulo[form.idArticulo.selectedIndex].value;

  if(modelo != ''){
    var opciones = document.getElementById('modelos-json').value;
    opciones = JSON.parse(opciones);
    var maxValue=0;
    maxValue = opciones.find(element => element.idArticulo = modelo).cantidadStock;
    form.cantidad.max=maxValue;
    document.getElementById('cantidadFeedBack').innerHTML = 'Por favor, seleccione un cantidad igual a ' + maxValue + ' como maximo';
  }
}

//usuario amigable
function removeValidation(obj){
  obj.classList.remove('is-invalid');
  obj.parentNode.getElementsByClassName('invalid-feedback')[0].innerHTML = 'Por favor, rellene este campo';
  obj.parentNode.classList.add('was-validated');
}

//grafico de reporte
var canvas = document.getElementById('grafico');
if(canvas != null){
  generarGrafico();
}

function generarGrafico(){
  var data = document.getElementById('data').value;
  var cantidad = document.getElementById('cantidad').value;
  data = JSON.parse(data);
  cantidad = JSON.parse(cantidad);
  color = [];
  var h = '220';
  for(row of cantidad){
    h -= 15;
    color.push('hsl('+h+', 100%,50%)');
  }
  var tipo = data.length <=3?'pie':'bar';

  var canvas = document.getElementById('grafico').getContext('2d');
  var grafics = new Chart(canvas,{
      type:tipo,
      data:{
        labels:data,
        datasets:[{
            label: 'Cantidad mensual',
            data: cantidad,
            backgroundColor:color
        }]
      },
      options:{
        scales:{
          yAxes:[{
            ticks:{
              beginAtZero:true
            }
          }]
        }
      }
  });
}

selectedFilter();
//formulario reporte\\
function selectedFilter(){
  var tipos = document.querySelectorAll('input[type="radio"]');
  tipos.forEach(e => {
    var field = document.getElementById(e.value);
    var inputs = field.querySelectorAll('input');
    var selects = field.querySelectorAll('select');
    if(e.checked == true){
     
      $('#' + e.value).on('hidden.bs.collapse', function () {
        $('#' + e.value).collapse('show');
      })
      
      if(field.classList[field.classList.length - 1] != 'show'){
        $('#' + e.value).collapse('show');
      }
      
      selects.forEach(select=>{
        select.setAttribute('required','');
      })
      inputs.forEach(input=>{
        input.setAttribute('required','');
      })
      
    }
    else{
      selects.forEach(select=>{
        select.removeAttribute('required');
      })
      inputs.forEach(input=>{
        input.removeAttribute('required');
      })
    }
  })
}
