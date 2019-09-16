<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Investigación",
       subtitulo: "Gestigón de Investigaciones",
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
   classTitle:'fa fa-book',
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

   investigacions: [],
   errors:[],

   fillinvestigacion:{'titulo':'', 'descripcion':'', 'resolucionAprobacion':'','presupuestoAsignado':'','presupuestoEjecutado':'','horas':'','fechaInicio':'','fechaTermino':'','clasificacion':'','rutadocumento':'','estado':'','avance':'','descripcionAvance':'','escuela_id':'','lineainvestigacion':'','financiamiento':'','patentado':'','id':''},


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
   divEdit:false,
   divloaderNuevo:false,
   divloaderEdit:false,

   thispage:'1',

   validated:'0',
   formularioCrear:false,


   titulo:'',
   descripcion:'',
   resolucionAprobacion:'',
   presupuestoAsignado:'',
   presupuestoEjecutado:'',
   horas:'',
   fechaInicio:'',
   fechaTermino:'',
   clasificacion:'',
   rutadocumento:'',
   estado:1,
   avance:'',
   descripcionAvance:'',
   escuela_id:0,
   lineainvestigacion:'',
   financiamiento:'',
   patentado:'',

     



},
created:function () {
   this.getinvestigacions(this.thispage);

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

methods: {



   getinvestigacions: function (page) {
       var busca=this.buscar;
       var url = 'investigacion?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.investigacions= response.data.investigacions.data;
           this.pagination= response.data.pagination;

           

           if(this.investigacions.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getinvestigacions(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getinvestigacions();
       this.thispage='1';
   },




   nuevo:function () {

       this.divEdit=false;
       this.divNuevo=true;

       this.$nextTick(function () {
       this.cancelFormNuevo();
     })
       
   },
   cerrarFormNuevo: function () {
       this.divNuevo=false;
       this.cancelFormNuevo();
   },
   cancelFormNuevo: function () {


   this.titulo='';
   this.descripcion='';
   this.resolucionAprobacion='';
   this.presupuestoAsignado='';
   this.presupuestoEjecutado='';
   this.horas='';
   this.fechaInicio='';
   this.fechaTermino='';
   this.clasificacion='';
   this.rutadocumento='';
   this.estado=1;
   this.avance='';
   this.descripcionAvance='';
   this.escuela_id=0;
   this.lineainvestigacion='';
   this.financiamiento='';
   this.patentado='';

    this.formularioCrear=false;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txttitulo').focus();
   },



   create:function () {
       var url='investigacion';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{titulo:this.titulo, descripcion:this.descripcion, resolucionAprobacion:this.resolucionAprobacion, presupuestoAsignado:this.presupuestoAsignado, presupuestoEjecutado:this.presupuestoEjecutado, horas:this.horas, fechaInicio:this.fechaInicio, fechaTermino:this.fechaTermino,clasificacion:this.clasificacion, rutadocumento:this.rutadocumento, estado:this.estado, avance:this.avance, descripcionAvance:this.descripcionAvance, escuela_id:this.escuela_id, lineainvestigacion:this.lineainvestigacion, financiamiento:this.financiamiento, patentado:this.patentado}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getinvestigacions(this.thispage);
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




   borrar:function (investigacion) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Registro de la Investigación Seleccionada? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'investigacion/'+investigacion.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getinvestigacions(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (investigacion) {

       this.cerrarFormNuevo();


       this.fillinvestigacion.id=investigacion.id;
       this.fillinvestigacion.titulo=investigacion.titulo;
       this.fillinvestigacion.descripcion=investigacion.descripcion;
       this.fillinvestigacion.resolucionAprobacion=investigacion.resolucionAprobacion;
       this.fillinvestigacion.presupuestoAsignado=investigacion.presupuestoAsignado;
       this.fillinvestigacion.presupuestoEjecutado=investigacion.presupuestoEjecutado;
       this.fillinvestigacion.horas=investigacion.horas;
       this.fillinvestigacion.fechaInicio=investigacion.fechaInicio;
       this.fillinvestigacion.fechaTermino=investigacion.fechaTermino;
       this.fillinvestigacion.clasificacion=investigacion.clasificacion;
       this.fillinvestigacion.rutadocumento=investigacion.rutadocumento;
       this.fillinvestigacion.estado=investigacion.estado;
       this.fillinvestigacion.avance=investigacion.avance;
       this.fillinvestigacion.descripcionAvance=investigacion.descripcionAvance;
       this.fillinvestigacion.escuela_id=investigacion.escuela_id;
       this.fillinvestigacion.lineainvestigacion=investigacion.lineainvestigacion;
       this.fillinvestigacion.financiamiento=investigacion.financiamiento;
       this.fillinvestigacion.patentado=investigacion.patentado;

 
      

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txttituloE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="investigacion/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillinvestigacion).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getinvestigacions(this.thispage);
           this.fillinvestigacion={'titulo':'', 'descripcion':'', 'resolucionAprobacion':'','presupuestoAsignado':'','presupuestoEjecutado':'','horas':'','fechaInicio':'','fechaTermino':'','clasificacion':'','rutadocumento':'','estado':'','avance':'','descripcionAvance':'','escuela_id':'','lineainvestigacion':'','financiamiento':'','patentado':'','id':''};
           this.errors=[];

           this.cerrarFormE();
           toastr.success(response.data.msj);
           }else{
               $('#'+response.data.selector).focus();
               toastr.error(response.data.msj);
           }

       }).catch(error=>{
           this.errors=error.response.data
       })
   },


   descargarPlantilla:function(){
    //window.location="investigacions/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="investigacions/imprimirExcel/"+3;
   },
}
});
</script>