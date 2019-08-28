<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Reportes",
       subtitulo: "Generales",
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
   classTitle:'fa fa-file-pdf-o',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'active',
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
   
   fillPersona:{'id':'', 'nombre':'', 'dni_ruc':'','codigo_alumno':'','direccion':'','activo':'','escuela_id':'','tipopersona_id':0},

   personas: [],

   pagination: {
   'total': 0,
           'current_page': 0,
           'per_page': 0,
           'last_page': 0,
           'from': 0,
           'to': 0
           },
    
    pagination2 : {
   'total': 0,
           'current_page': 0,
           'per_page': 0,
           'last_page': 0,
           'from': 0,
           'to': 0
           },

    offset: 9,
    offset2: 9,
   buscar:'',
   divNuevo:false,
   divloaderNuevo:false,
   divloaderEdit:false,

   thispage:'1',
   thispage2:'1',

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

   cbufec:0,


   years:[],
   meses:[],
   diahoy:'',
   

   anio:0,
   mes:0,
   
   fecha0:'',
   fechai:'',
   fechaf:'',

   tipo:0,

   mostrartabla:false,


    fecha0bc: '',
    mesbc:0,
    aniobc:0,

    totalcobrado:'0.00',
    totalextornado:'0.00',

    numcobrados:0,
    numextornados:0,
    
    soloCabecera:[],

    cajeros:[],
    cajero:0,
    nombrecajero:'',

    persona:'',
    dni_ruc:'',

    recibosimp:[],

},
created:function () {
   this.getInfoInicial();
   //this.getRecibos(this.thispage);
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
   },


   isActived2: function(){
       return this.pagination2.current_page;
   },
   pagesNumber2: function () {
       if(!this.pagination2.to){
           return [];
       }

       var from=this.pagination2.current_page - this.offset2 
       var from2=this.pagination2.current_page - this.offset2 
       if(from<1){
           from=1;
       }

       var to= from2 + (this.offset2*2); 
       if(to>=this.pagination2.last_page){
           to=this.pagination2.last_page;
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
  },

  mescotejar:function (value) {
    if (!value) return ''
    value = parseInt(value.toString());
    switch (value) {
        case 1:
                return "ENERO";
            break;
        case 2:
                return "FEBRERO";
            break;
        case 3:
                return "MARZO";
            break;
        case 4:
                return "ABRIL";
            break;
        case 5:
                return "MAYO";
            break;
        case 6:
                return "JUNIO";
            break;
        case 7:
                return "JULIO";
            break;
        case 8:
                return "AGOSTO";
            break;
        case 8:
                return "AGOSTO";
            break;
        case 9:
                return "SETIEMBRE";
            break;
        case 10:
                return "OCTUBRE";
            break;
        case 11:
                return "NOVIEMBRE";
            break;
    
        case 12:
                return "DICIEMBRE";
            break;
    
        default:
                return "";
            break;
    }

    return value
  },
},

methods: {


    cambiarfiltro:function(){
        this.mostrartabla=false;
    },


   getInfoInicial:function(){
        var busca=this.buscar;
        var url = 'reportegeneral';

        axios.get(url).then(response=>{
           this.fecha= response.data.fecha;
           this.year= response.data.year;
           this.anio= response.data.anio;
           this.fecha0= response.data.fecha0;
           this.fechai= response.data.fecha0;
           this.fechaf= response.data.fecha0;
           this.mes= response.data.mes;
           this.years= response.data.years;

           this.fecha0bc= response.data.fecha0;
           this.mesbc= response.data.mes;
           this.aniobc= response.data.anio;

           this.cajeros= response.data.cajeros;

       })
    },


    cancelFiltros:function(page){


        this.totalcobrado= 0;
       this.totalextornado= 0;
       this.numcobrados= 0;
       this.numextornados= 0;



        this.cbufec=0;
        this.tipo=0;
        this.fecha0=this.fecha0bc;
        this.fechai=this.fecha0bc;
        this.fechaf=this.fecha0bc;
        this.mes=this.mesbc;
        this.anio=this.aniobc;

        this.mostrartabla=false;
        this.cajero=0;
        this.nombrecajero='';
        this.persona='';
        this.dni_ruc='';

        this.fillPersona={'id':'', 'nombre':'', 'dni_ruc':'','codigo_alumno':'','direccion':'','activo':'','escuela_id':'','tipopersona_id':0};
    },


    cambiarcajero:function(){
        this.nombrecajero=$("#cbuCajero option:selected").text();
        this.mostrartabla=false;
    },

    buscarpersonas:function(){
        this.getPersona();
        this.$nextTick(function () {
            $("#modalPeronas").modal('show');
        })
    },
    getPersona: function (page) {
       var busca=this.buscar;
       var url = 'persona?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.personas= response.data.personas.data;
           this.pagination2= response.data.pagination;


           

           if(this.personas.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage2) ;
               a--;
               this.thispage2=a.toString();
               this.changePage2(this.thispage2);
           }
       })
   },
   changePage2:function (page) {
       this.pagination2.current_page=page;
       this.getPersona(page);
       this.thispage2=page;
   },
   buscarBtn2: function () {
       this.getPersona();
       this.thispage2='1';
   },


   selectpersona:function(perso) {
    this.persona=perso.nombre;
    this.dni_ruc=perso.dni_ruc;
    this.fillPersona.id=perso.id;

       this.fillPersona.nombre=perso.nombre;
       this.fillPersona.dni_ruc=perso.dni_ruc;
       this.fillPersona.codigo_alumno=perso.codigo_alumno;
       this.fillPersona.direccion=perso.direccion;
       this.fillPersona.activo=perso.activo;
       this.fillPersona.escuela_id=perso.escuela_id;
       this.fillPersona.tipopersona_id=perso.tipopersona_id;
    
       $("#modalPeronas").modal('hide');

       this.mostrartabla=false;

   },

   limpiarcliente : function () {
    this.persona='';
    this.dni_ruc='';
    this.fillPersona={'id':'', 'nombre':'', 'dni_ruc':'','codigo_alumno':'','direccion':'','activo':'','escuela_id':'','tipopersona_id':0};
    this.mostrartabla=false;
},




buscarDatos:function(){

//  $("body").css({ 'height' : '2100px'});
   
   var url="reportegeneral/buscarDatos";


   this.divloaderNuevo=true;
   this.mostrartabla=false;


   axios.post(url,{cbufec:this.cbufec, fechai:this.fechai, fechaf:this.fechaf, anio:this.anio, mes:this.mes , fecha0:this.fecha0, tipo:this.tipo, cajero:this.cajero, idpersona:this.fillPersona.id}).then(response=>{

       this.mostrartabla=true;
       this.recibos= response.data.recibos.data;
       this.pagination= response.data.pagination;
       this.totalcobrado= response.data.totalcobrado;
       this.totalextornado= response.data.totalextornado;
       this.numcobrados= response.data.numcobrados;
       this.numextornados= response.data.numextornados;

       this.divloaderNuevo=false;
       this.mostrartabla=true;
       
       alertify.success('Datos Cargados Exitosamente'); 

   }).catch(error=>{
       this.errors=error.response.data
   })
},


imprimirReporte(){

    var cabecera=this.soloCabecera.length;


    if(cabecera==0)

    {
    var url="reportegeneral/buscarDatosImp";

    this.divloaderNuevo=true;
    $("#btncrearReporte").attr('disabled', true);
    axios.post(url,{cbufec:this.cbufec, fechai:this.fechai, fechaf:this.fechaf, anio:this.anio, mes:this.mes , fecha0:this.fecha0, tipo:this.tipo, cajero:this.cajero, idpersona:this.fillPersona.id}).then(response=>{

        this.divloaderNuevo=false;
        $("#btncrearReporte").removeAttr("disabled");
       this.recibosimp= response.data.recibosimp;

       this.$nextTick(function () {

        var options = { extraHead : '<style rel="stylesheet" type="text/css" media="print">@page { size: landscape; } body {-webkit-print-color-adjust: exact; } #divImp{width: 30cm!important; } .saltoDePagina{ display:block; page-break-before:always;} #btncrearArea{display: none!important;} #btnvolver1{display: none!important;} #btnvolver2{display: none!important;} #tablaNoPrint{display: none!important;} #tablaPrint{display: block!important;} #titulo1{padding-top: 0px!important;} .logorep{ top:0mm!important;} #tablerep2{width:9cm;} #titulo7{display: block!important;} #tablelast{width:50%!important;} .divResult{display: none!important;}</style>', strict:false  };

        $("#divImp").printArea(options);
        });


   }).catch(error=>{
       this.errors=error.response.data
   })

    }else{

        console.log("entro aqui");
        var options = { extraHead : '<style rel="stylesheet" type="text/css" media="print">@page { size: landscape; } body {-webkit-print-color-adjust: exact; } #divImp{width: 30cm!important; } .saltoDePagina{ display:block; page-break-before:always;} #btncrearArea{display: none!important;} #btnvolver1{display: none!important;} #btnvolver2{display: none!important;} #tablaNoPrint{display: none!important;} #tablaPrint{display: block!important;} #titulo2{padding-top: 0px!important;} .logorep{ top:0mm!important;} #tablerep2{width:9cm;} #titulo7{display: block!important;} #tablelast{width:50%!important;} .divResult{display: none!important;}</style>', strict:false  };

        $("#divImp2").printArea(options);
    }

},


   getRecibos: function (page) {
       var busca=this.buscar;
       var url = 'reportegeneral?page='+page+'&busca='+busca;

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