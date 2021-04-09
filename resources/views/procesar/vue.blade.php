<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Procesar",
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
   classTitle:'fa fa-cogs',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'active',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   entidads: [],
   recibos: [],
   errors:[],

   fillRecibo:{'id':'', 'efectivo':'','vuelto':'','extorno':'','secuencia':'','codigo':'','fecha':'','hora_pagada':'','persona_id':'','estado':'','user_id':'','fecha_usado':'','hora_usada':'','tipopago_id':'','year':'','borrado':'','total':'','fechaextorno':'','horaextorno':''},
   
   fillPersona:{'id':'', 'nombre':'', 'dni_ruc':'','codigo_alumno':'','direccion':'','activo':'','escuela_id':'','tipopersona_id':0},

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
  
    mostrarNumero(value){
      
      if(value != null && value != undefined){
        value=parseFloat(value).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      return value;
    },
    pasfechaVista:function(date){
        if(date!=null && date.length==10){
            date=date.slice(-2)+'/'+date.slice(-5,-3)+'/'+date.slice(0,4);            
        }else{
          return '';
        }

        return date;
    },
    leftpad:function(n, length) {
        var  n = n.toString();
        while(n.length < length)
            n = "0" + n;
        return n;
    }

  },


methods: {
   getRecibos: function (page) {
       var busca=this.buscar;
       var url = 'proceso?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
          
       this.recibos= response.data.recibos.data;
       this.pagination= response.data.pagination;
       this.entidads= response.data.entidads;

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
 
   procesarRecibo:function (recibo) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea Procesar este concepto de pago del recibo",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Procesar'
           }).then((result) => {

            if (result.value) {

                var url = 'proceso/altabaja/'+recibo.iddetalle+'/2';
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
   quitarProcesoRecibo:function (recibo) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea Cancelar el procesamiento de este concepto de pago del recibo",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Cancelar'
           }).then((result) => {

            if (result.value) {

                var url = 'proceso/altabaja/'+recibo.iddetalle+'/1';
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
}
});
</script>