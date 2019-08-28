<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Emisión",
       subtitulo: "Recibos",
       subtitulo2: "Principal",

   subtitle2:false,
   subtitulo2:"",

   tipouserPerfil:'{{ $tipouser->nombre }}',
   userPerfil:'{{ Auth::user()->name }}',
   mailPerfil:'{{ Auth::user()->email }}',

   
   divloader0:true,
   divloader1:false,
   divloader2:false,
   divloader3:false,
   divloader4:false,
   divloader5:false,
   divloader6:false,
   divloader7:false,
   divloader8:false,
   divloader9:false,
   divloader10:false,
   divtitulo:true,
   classTitle:'fa fa-credit-card',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'active',
   classMenu4:'',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   precios: [],
   errors:[],

   fillRecibo:{'id':'', 'efectivo':'', 'vuelto':'','extorno':'','secuencia':'','codigo':'','fecha_externo':'','hora_pagada':'','persona_id':'','estado':'','user_id':'','fecha_usado':'','hora_usada':'','tipopago_id':''},

   pagination: {
   'total': 0,
           'current_page': 0,
           'per_page': 0,
           'last_page': 0,
           'from': 0,
           'to': 0
           },
           offset: 9,
   buscar:'',
   divNuevo:false,
   divloaderNuevo:false,
   divloaderEdit:false,

   thispage:'1',

   newlocal:'',
   newDir:'',
   newEstado:'1',

   year:'',
   fecha:'',
   numgen:'',



   newDNI:'',
   newNombre:'',
   newNombreZ:'',

   noNombre:false,


   persona:[],
   numPer:0,

   newmontoU:'0.00',
   newmontoT:'0.00',

   newcant:'',

   clearselect:true,


   detallerecibo:[],

   nombrerecibo:'',

   importerecibo:'S/ 0.00',
   importerecibo2:'0.00',

   importeletras:'--',

   newmontoP:'0.00',
   newmontoV:'0.00',



},
created:function () {
   this.getDatosIni(this.thispage);

   
},
mounted: function () {
   this.divloader0=false;
   this.divprincipal=true;
   this.$nextTick(function () {
    $("#precio_id").select2({
      closeOnSelect: true
    });
    $('#precio_id').val('').trigger('change');

    $("#dni_ruc").focus();
     });
   $("#divtitulo").show('slow');

},
computed:{
   isActived: function(){
       return this.pagination.current_page;
   },
   pagesNumber: function () {
       if(!this.pagination.to){
           return [];
       }

       var from=this.pagination.current_page - this.offset 
       var from2=this.pagination.current_page - this.offset 
       if(from<1){
           from=1;
       }

       var to= from2 + (this.offset*2); 
       if(to>=this.pagination.last_page){
           to=this.pagination.last_page;
       }

       var pagesArray = [];
       while(from<=to){
           pagesArray.push(from);
           from++;
       }
       return pagesArray;
   }
},

filters: {
  fecha: function (value) {
    if (!value) return ''
    value = value.toString()
    return value.slice(8)+"/"+value.slice(5,7)+"/"+value.slice(0,4)
  }
},

methods: {
   getDatosIni: function (page) {
       var busca=this.buscar;
       var url = 'recibo?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
          /* this.precios= response.data.precios.data;
           this.pagination= response.data.pagination;

           if(this.precios.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }*/

           this.precios= response.data.precios;
           this.year= response.data.year;
           this.fecha= response.data.fecha;
           this.numgen= response.data.numgen;
       })
   },

   pasarenter:function(){

    var nletras=this.newDNI.length;

    if(nletras<8){
        alertify.error('Complete un Número de DNI o RUC válido');
    }
    else{
        var url='recibo/buscarpersona';

       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{dni_ruc:this.newDNI}).then(response=>{
          

   
           if(parseInt(response.data.numPer)>0){

               this.noNombre=false;
               this.persona=response.data.persona;
               this.newNombreZ=response.data.persona[0].nombre;
               this.nombrerecibo=response.data.persona[0].nombre.toUpperCase();
               $("#persona").show('slow');

               $('#precio_id').select2('open');


           }else{
               this.noNombre=true;
               this.$nextTick(function () {
                $("#nonombre").focus();
                $("#persona").hide('slow');
                });
           }
       }).catch(error=>{
           //this.errors=error.response.data
       })

    }
    
   },

   pasarenter2:function(){

    event.preventDefault();
    if(this.newNombre.trim().length>0){
        this.nombrerecibo=this.newNombre.trim().toUpperCase();
        $('#precio_id').select2('open');
    }
    else{
        toastr.error("Complete el nombre de la persona");
        $("#nonombre").focus();
    }
   },


   calcular:function(){

    event.preventDefault();
   // console.log(this.newcant.length);
    if($("#cantidad").val().trim()>0){

   
    this.newcant=parseFloat(this.newcant);
    this.newmontoU=parseFloat(this.newmontoU);

    if(this.newcant>0 && this.newmontoU>0){
        this.newmontoT=parseFloat(this.newcant*this.newmontoU).toFixed(2);
    }
}
else{
    this.newmontoT='0.00';
    //console.log("here");
}
   

   },


   calculartotal:function(){

    var total=0;
    this.importeletras='--';
    $.each( app.detallerecibo, function( key, dt ) {
        total=total+parseFloat(dt.precioT);
        app.$nextTick(function () {
        app.importerecibo='S/. '+parseFloat(total).toFixed(2);
        app.importerecibo2=parseFloat(total).toFixed(2);

        var numeroletras=numeroALetras(Math.trunc(total), {
  plural: 'SOLES',
  singular: 'SOL',
  centPlural: 'CENTAVOS',
  centSingular: 'CENTAVO'
});

var decimalletras=(total-Math.trunc(total)).toFixed(2);

this.importeletras=numeroletras+'CON '+decimalletras+'/100';
//console.log(numeroletras+'CON '+decimalletras+'/100');
    });
});
   },

   pasarrecibo:function(){
    event.preventDefault();

    var montof=parseFloat(this.newmontoT);

    if(montof>0){

    var key=$("#precio_id").val();

    if(key==''){
        $('#precio_id').select2('open');
        toastr.error("Seleccione un Concepto de Pago");
    }
    else{
        //app.newmontoU=parseFloat(app.precios[key].monto).toFixed(2);
        
        this.detallerecibo.push({concepto:this.precios[key].descripcion,precioU:this.newmontoU,cant:this.newcant,precioT:this.newmontoT, valuep:this.precios[key].id});

        this.$nextTick(function () {
            this.calculartotal();
            this.limpiardetalle();
            this.$nextTick(function () {

            $('#precio_id').select2('open');
                });
        });

    }   

    }
    else{
        toastr.error("Complete una cantidad adecuada");
        $("#cantidad").focus();
    }



   },

   quitarEle:function(key){
    this.detallerecibo.splice(key, 1);
    this.$nextTick(function () {
    this.calculartotal();
});
   },


   limpiardetalle:function(){
    $('#precio_id').val('').trigger('change');
    this.newmontoU='0.00';
    this.newcant='';
    this.newmontoT='0.00';
   },


   calcular2:function(){

event.preventDefault();


var montoP=parseFloat(this.newmontoP);
var importe=parseFloat(this.importerecibo2);

var vuelto=montoP-importe;

if(isNaN(vuelto)){
    vuelto=importe;
}
this.newmontoV=vuelto.toFixed(2);


},

modalpagar:function(){
    if(this.nombrerecibo!=''){
        if(this.detallerecibo.length>0){

            this.newmontoP=this.importerecibo2;
            this.newmontoV='0.00';
            
            $("#modalPagar").modal('show');
        }
        else{
            alertify.error('Ingrese por lo menos un concepto de pago válido');
            $('#precio_id').select2('open');
        }

    }else{
        toastr.error("Ingrese el DNI y nombre de la persona que efectúa el pago");
        $("#dni_ruc").focus();
    }
   },

pagarRecibo:function(){

    this.calculartotal();
    this.$nextTick(function () {
        var montoP=parseFloat(this.newmontoP);
        var importe=parseFloat(this.importerecibo2);

        if(montoP>=importe){
            this.create();
        }
        else{
            alertify.error('Considere un monto de pago válido: mayor o igual al importe de pago');
            $("#efectivoFinal").focus();
        }   

});

},



   cancelFormNuevo: function () {
      
    this.limpiardetalle();
    this.detallerecibo=[];
    this.newDNI='';
    this.newNombre='';
    this.newNombreZ='';
    this.noNombre=false;

    this.nombrerecibo='';
    this.importerecibo='';
    this.importeletras='--';
    this.importerecibo2='';

    this.$nextTick(function () {
    this.calculartotal();
    $("#dni_ruc").focus();
});


   },



   create:function () {
       var url='recibo';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
      // $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{dni:this.newDNI, nombre:this.nombrerecibo, totalP:this.newmontoP, detallerecibo:this.detallerecibo}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           //$("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
             this.getDatosIni(this.thispage);
               this.errors=[];
               toastr.success(response.data.msj);
               $("#modalPagar").modal('hide');

               this.imprimirRecibo();
               this.$nextTick(function () {
                this.cancelFormNuevo();
            });



           }else{
             //  $('#'+response.data.selector).focus();
              // $('#'+response.data.selector).css( "border", "1px solid red" );
               toastr.error(response.data.msj);
           }
       }).catch(error=>{
           //this.errors=error.response.data
       })
   },


imprimirRecibo:function () {

    

    $('#recib').printArea();

       /*    
       
        $("#divImp").printArea(options);   
        
         this.$nextTick(function () {

                

                    var options = { extraHead : '<style rel="stylesheet" type="text/css" media="print">@page { size: landscape; } body {-webkit-print-color-adjust: exact; } #divImp{width: 30cm!important; } .saltoDePagina{ display:block; page-break-before:always;} #btncrearArea{display: none!important;} #btnvolver1{display: none!important;} #btnvolver2{display: none!important;} #tablaNoPrint{display: none!important;} #tablaPrint{display: block!important;} #titulo1{padding-top: 0px!important;} .logorep{ top:0mm!important;} #tablerep2{width:9cm;} #titulo7{display: block!important;} #tablelast{width:50%!important;} .divResult{display: none!important;}</style>', strict:false  };


                      $("#divImp").printArea(options);

            })
*/
             


        },

















   changePage:function (page) {

       

this.pagination.current_page=page;
this.getDatosIni(page);
this.thispage=page;
},
buscarBtn: function () {
this.getDatosIni();
this.thispage='1';
},


   borrarlocal:function (local) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Local Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'local/'+local.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getDatosIni(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   editlocal:function (local) {

       /*
               fillRecibo:{'id':'', 'codigo':'', 'descripcion':'','codnum':'','eqcodcentral':'','jurisprudencia':'','visualiza':'','activo':''},

               */

       this.fillRecibo.id=local.id;
       this.fillRecibo.nombre=local.nombre;
       this.fillRecibo.direccion=local.direccion;
       this.fillRecibo.estado=local.estado;

       $("#boxTitulo").text('Local: '+local.nombre);
       $("#modalEditar").modal('show');

       $("#txtnomE").focus();
   },
   updateLocal:function (id) {
       var url="local/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillRecibo).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getDatosIni(this.thispage);
           this.fillRecibo={'id':'', 'nombre':'', 'direccion':'','estado':''};
           this.errors=[];
           $("#modalEditar").modal('hide');
           toastr.success(response.data.msj);

           }else{
               $('#'+response.data.selector).focus();
               toastr.error(response.data.msj);
           }

       }).catch(error=>{
           this.errors=error.response.data
       })
   },
   bajalocal:function (local) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar este Local",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'local/altabaja/'+local.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getDatosIni(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altalocal:function (local) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar el Local",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'local/altabaja/'+local.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getDatosIni(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
}
});


function volver(){
    app.clearselect=true;
}



function cambiardato(){

    var key=$("#precio_id").val();

    if(key==null){
        //console.log('holi');
    }
    else{

        if(key==''){
        $('#precio_id').select2('open');
        toastr.error("Seleccione un Concepto de Pago");
    }
    else{

   
        app.newmontoU=parseFloat(app.precios[key].monto).toFixed(2);

        app.clearselect=false;

        app.$nextTick(function () {
            $("#cantidad").focus();
            app.$nextTick(function () {
              setTimeout("volver()",1);
              $("#cantidad").focus();
            }); 
            //

    });

}
    }

    //console.log(key);
    //app.newmontoU=parseFloat(app.precios[key].monto).toFixed(2);


}




var numeroALetras = (function() {

// Código basado en https://gist.github.com/alfchee/e563340276f89b22042a
    function Unidades(num){

        switch(num)
        {
            case 1: return 'UN';
            case 2: return 'DOS';
            case 3: return 'TRES';
            case 4: return 'CUATRO';
            case 5: return 'CINCO';
            case 6: return 'SEIS';
            case 7: return 'SIETE';
            case 8: return 'OCHO';
            case 9: return 'NUEVE';
        }

        return '';
    }//Unidades()

    function Decenas(num){

        let decena = Math.floor(num/10);
        let unidad = num - (decena * 10);

        switch(decena)
        {
            case 1:
                switch(unidad)
                {
                    case 0: return 'DIEZ';
                    case 1: return 'ONCE';
                    case 2: return 'DOCE';
                    case 3: return 'TRECE';
                    case 4: return 'CATORCE';
                    case 5: return 'QUINCE';
                    default: return 'DIECI' + Unidades(unidad);
                }
            case 2:
                switch(unidad)
                {
                    case 0: return 'VEINTE';
                    default: return 'VEINTI' + Unidades(unidad);
                }
            case 3: return DecenasY('TREINTA', unidad);
            case 4: return DecenasY('CUARENTA', unidad);
            case 5: return DecenasY('CINCUENTA', unidad);
            case 6: return DecenasY('SESENTA', unidad);
            case 7: return DecenasY('SETENTA', unidad);
            case 8: return DecenasY('OCHENTA', unidad);
            case 9: return DecenasY('NOVENTA', unidad);
            case 0: return Unidades(unidad);
        }
    }//Unidades()

    function DecenasY(strSin, numUnidades) {
        if (numUnidades > 0)
            return strSin + ' Y ' + Unidades(numUnidades)

        return strSin;
    }//DecenasY()

    function Centenas(num) {
        let centenas = Math.floor(num / 100);
        let decenas = num - (centenas * 100);

        switch(centenas)
        {
            case 1:
                if (decenas > 0)
                    return 'CIENTO ' + Decenas(decenas);
                return 'CIEN';
            case 2: return 'DOSCIENTOS ' + Decenas(decenas);
            case 3: return 'TRESCIENTOS ' + Decenas(decenas);
            case 4: return 'CUATROCIENTOS ' + Decenas(decenas);
            case 5: return 'QUINIENTOS ' + Decenas(decenas);
            case 6: return 'SEISCIENTOS ' + Decenas(decenas);
            case 7: return 'SETECIENTOS ' + Decenas(decenas);
            case 8: return 'OCHOCIENTOS ' + Decenas(decenas);
            case 9: return 'NOVECIENTOS ' + Decenas(decenas);
        }

        return Decenas(decenas);
    }//Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let letras = '';

        if (cientos > 0)
            if (cientos > 1)
                letras = Centenas(cientos) + ' ' + strPlural;
            else
                letras = strSingular;

        if (resto > 0)
            letras += '';

        return letras;
    }//Seccion()

    function Miles(num) {
        let divisor = 1000;
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let strMiles = Seccion(num, divisor, 'UN MIL', 'MIL');
        let strCentenas = Centenas(resto);

        if(strMiles == '')
            return strCentenas;

        return strMiles + ' ' + strCentenas;
    }//Miles()

    function Millones(num) {
        let divisor = 1000000;
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let strMillones = Seccion(num, divisor, 'UN MILLON DE', 'MILLONES DE');
        let strMiles = Miles(resto);

        if(strMillones == '')
            return strMiles;

        return strMillones + ' ' + strMiles;
    }//Millones()

    return function NumeroALetras(num, currency) {
        currency = currency || {};
        let data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
            letrasCentavos: '',
            letrasMonedaPlural: currency.plural || 'PESOS CHILENOS',//'PESOS', 'Dólares', 'Bolívares', 'etcs'
            letrasMonedaSingular: currency.singular || 'PESO CHILENO', //'PESO', 'Dólar', 'Bolivar', 'etc'
            letrasMonedaCentavoPlural: currency.centPlural || 'CHIQUI PESOS CHILENOS',
            letrasMonedaCentavoSingular: currency.centSingular || 'CHIQUI PESO CHILENO'
        };

        if (data.centavos > 0) {
            data.letrasCentavos = 'CON ' + (function () {
                    if (data.centavos == 1)
                        return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoSingular;
                    else
                        return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoPlural;
                })();
        };

        if(data.enteros == 0)
            return 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
        if (data.enteros == 1)
            return Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos;
        else
            return Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
    };

})();
</script>