<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Gestión",
       subtitulo: "Recibos Emitidos",
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
   classTitle:'fa fa-dolar',
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

   recibos: [],
   errors:[],

   fillRecibo:{'id':'', 'efectivo':'','vuelto':'','extorno':'','secuencia':'','codigo':'','fecha':'','hora_pagada':'','persona_id':'','estado':'','user_id':'','fecha_usado':'','hora_usada':'','tipopago_id':'','year':'','borrado':'','total':'','fechaextorno':'','horaextorno':''},

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

   newbanco:'',
   newactivo:'1',

   fecha:'',
   year:'',
   numgen:'',
   nombrerecibo:'',
   importerecibo:'',
   importeletras:'',
   detallerecibo:[],
   importerecibo2:'',



},
created:function () {
   this.getRecibos(this.thispage);
},
mounted: function () {
   this.divloader0=false;
   this.divprincipal=true;
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
   getRecibos: function (page) {
       var busca=this.buscar;
       var url = 'reciboemitido?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.recibos= response.data.recibos.data;
           this.pagination= response.data.pagination;
           this.fecha= response.data.fecha;
           this.year= response.data.year;

           if(this.recibos.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getRecibos(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getRecibos();
       this.thispage='1';
   },
   nuevo:function () {
       this.divNuevo=true;
       //$("#txtespecialidad").focus();
       //$('#txtespecialidad').focus();
       this.$nextTick(function () {
       this.cancelFormNuevo();
     })
       
   },
   cerrarFormNuevo: function () {
       this.divNuevo=false;
       this.cancelFormNuevo();
   },
   cancelFormNuevo: function () {
       $('#txtnom').focus();
       this.newbanco='';
       this.newactivo='1';

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtnom').focus();
   },
   create:function () {
       var url='banco';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{nombre:this.newbanco, activo:this.newactivo}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getRecibos(this.thispage);
               this.errors=[];
               this.cerrarFormNuevo();
               toastr.success(response.data.msj);
           }else{
               $('#'+response.data.selector).focus();
               $('#'+response.data.selector).css( "border", "1px solid red" );
               toastr.error(response.data.msj);
           }
       }).catch(error=>{
           //this.errors=error.response.data
       })
   },
   borrarrecibo:function (recibo) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el recibo Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'reciboemitido/'+recibo.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getRecibos(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   editbanco:function (banco) {

       this.fillRecibo.id=banco.id;
       this.fillRecibo.nombre=banco.nombre;
       this.fillRecibo.activo=banco.activo;

       $("#boxTitulo").text('Banco: '+banco.nombre);
       $("#modalEditar").modal('show');

       $("#txtnomE").focus();
   },
   updateBanco:function (id) {
       var url="banco/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillRecibo).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getRecibos(this.thispage);
           this.fillRecibo={'id':'', 'nombre':'','activo':''};
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
   bajarecibo:function (recibo) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "¿Realmente desea extornar el recibo de pago?",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Extornar'
           }).then((result) => {

            if (result.value) {

                var url = 'reciboemitido/altabaja/'+recibo.id+'/3';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getRecibos(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altarecibo:function (recibo) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea cancelar el Extorno del Recibo?",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Aceptar'
           }).then((result) => {

            if (result.value) {

                var url = 'reciboemitido/altabaja/'+recibo.id+'/2';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getRecibos(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },

   impRecibo:function (recibo) {


    var url='reciboemitido/buscarrecibo';

       axios.post(url,{idimp:recibo.id}).then(response=>{
            this.year=recibo.year;
            this.numgen=recibo.codigo;
            this.nombrerecibo=recibo.persona;
            this.importerecibo='S/.'+parseFloat(recibo.total).toFixed(2);
            this.importerecibo2=parseFloat(recibo.total).toFixed(2);

            
            this.detallerecibo= response.data.detallerecibo;

            this.importeletras=numeroALetras(Math.trunc(parseFloat(recibo.total)), {
                plural: 'SOLES',
                singular: 'SOL',
                centPlural: 'CENTAVOS',
                centSingular: 'CENTAVO'
                });
            var decimalletras=(parseFloat(recibo.total)-Math.trunc(parseFloat(recibo.total))).toFixed(2);
            this.importeletras=this.importeletras+'CON '+decimalletras+'/100';

            
            this.$nextTick(function () {

            //setTimeout("app.Imprimir()",5000);
            app.Imprimir();
            })
            


       }).catch(error=>{
           //this.errors=error.response.data
       });

      

  
},
Imprimir:function (recibo) {
$("#recib").printArea();
},


verRecibo:function(recibo){


    var url='reciboemitido/buscarrecibo';

       axios.post(url,{idimp:recibo.id}).then(response=>{
            this.year=recibo.year;
            this.numgen=recibo.codigo;
            this.nombrerecibo=recibo.persona;
            this.importerecibo='S/.'+parseFloat(recibo.total).toFixed(2);
            this.importerecibo2=parseFloat(recibo.total).toFixed(2);

            
            this.detallerecibo= response.data.detallerecibo;

            this.importeletras=numeroALetras(Math.trunc(parseFloat(recibo.total)), {
                plural: 'SOLES',
                singular: 'SOL',
                centPlural: 'CENTAVOS',
                centSingular: 'CENTAVO'
                });
            var decimalletras=(parseFloat(recibo.total)-Math.trunc(parseFloat(recibo.total))).toFixed(2);
            this.importeletras=this.importeletras+'CON '+decimalletras+'/100';

            
            this.$nextTick(function () {

                $("#modalVisualizar").modal('show');

            //setTimeout("app.Imprimir()",5000);
            
            })
            


       }).catch(error=>{
           //this.errors=error.response.data
       });
},


}
});




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