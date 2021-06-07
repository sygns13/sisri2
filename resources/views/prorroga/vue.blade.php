<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
    titulo:"Configuraciones",
        subtitulo: "Gestión y Programación de Submódulos",
        subtitulo2: "Solicitudes de Prórroga",

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
   classTitle:'fa fa-calendar-check-o',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'',
   classMenu8:'',
   classMenu9:'active',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   programaciones: [],
   errors:[],

   fillprogramacion:{'id':'', 'titulo':'', 'fechaini':'','fechafin':'','descripcion':'', 'idModulo':'','modulo':'', 'idSubmodulo':'','submodulo':'','estadoSubmodulo':'','fechainiSubmodulo':'','fechafinSubmodulo':'', 'idProrroga':'','tituloProrroga':'','descripcionProrroga':'','numeroProrroga':'','motivoProrroga':'','usuarioProrroga':'', 'fechaProrroga':'','horaProrroga':'', 'estadoProrroga':'', 'activoProrroga':'','motivoatencion':'', 'atencion':'2','nuevaFecha':''},

   
   divNuevo:false,
   divloaderNuevo:false,
   divloaderEdit:false,

   thispage:'1',

   



},
created:function () {
   this.getProgramaciones(this.thispage);
},
mounted: function () {
    console.log("aqui");
   this.divloader0=false;
   this.divprincipal=true;
   

},
filters:{
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
   getProgramaciones: function () {
       var url = 'prorroga';

       axios.get(url).then(response=>{
           this.programaciones= response.data.programaciones;
       })
   },


   atenderSolicitud:function (programacion) {

       this.fillprogramacion.id=programacion.id;
       this.fillprogramacion.titulo=programacion.titulo;
       this.fillprogramacion.fechaini=programacion.fechaini;
       this.fillprogramacion.fechafin=programacion.fechafin;
       this.fillprogramacion.descripcion=programacion.descripcion;
       this.fillprogramacion.idModulo=programacion.idModulo;
       this.fillprogramacion.modulo=programacion.modulo;
       this.fillprogramacion.idSubmodulo=programacion.idSubmodulo;
       this.fillprogramacion.submodulo=programacion.submodulo;
       this.fillprogramacion.estadoSubmodulo=programacion.estadoSubmodulo;
       this.fillprogramacion.fechainiSubmodulo=programacion.fechainiSubmodulo;
       this.fillprogramacion.fechafinSubmodulo=programacion.fechafinSubmodulo;

       this.fillprogramacion.idProrroga=programacion.idProrroga;
       this.fillprogramacion.tituloProrroga=programacion.tituloProrroga;
       this.fillprogramacion.descripcionProrroga=programacion.descripcionProrroga;
       this.fillprogramacion.numeroProrroga=programacion.numeroProrroga;
       this.fillprogramacion.motivoProrroga=programacion.motivoProrroga;
       this.fillprogramacion.usuarioProrroga=programacion.usuarioProrroga;
       this.fillprogramacion.fechaProrroga=programacion.fechaProrroga;
       this.fillprogramacion.horaProrroga=programacion.horaProrroga;
       this.fillprogramacion.estadoProrroga=programacion.estadoProrroga;
       this.fillprogramacion.activoProrroga=programacion.activoProrroga;

       this.fillprogramacion.atencion='2';
       this.fillprogramacion.motivoatencion='';
       this.fillprogramacion.nuevaFecha=programacion.fechafinSubmodulo;


       $("#boxTitulo").text(programacion.tituloProrroga);
       $("#modalEditar").modal('show');

       $("#motivoatencion").focus();
   },

   
   procesarSolicitud:function (id) {
       var url="prorroga/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillprogramacion).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getProgramaciones(this.thispage);
           this.fillprogramacion={'id':'', 'titulo':'', 'fechaini':'','fechafin':'','descripcion':'', 'idModulo':'','modulo':'', 'idSubmodulo':'','submodulo':'','estadoSubmodulo':'','fechainiSubmodulo':'','fechafinSubmodulo':'', 'idProrroga':'','tituloProrroga':'','descripcionProrroga':'','numeroProrroga':'','motivoProrroga':'','usuarioProrroga':'', 'fechaProrroga':'','horaProrroga':'', 'estadoProrroga':'', 'activoProrroga':'','motivoatencion':'', 'atencion':'2','nuevaFecha':''};
           this.errors=[];
           $("#modalEditar").modal('hide');
           Swal.fire(
            'Solicitud Procesada',
            response.data.msj,
            'success'
            );

           }else{
               $('#'+response.data.selector).focus();
               toastr.error(response.data.msj);
           }

       }).catch(error=>{
           this.errors=error.response.data
       })
   },


}
});
</script>