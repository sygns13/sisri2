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

   fillinvestigacion:{'titulo':'', 'descripcion':'', 'resolucionAprobacion':'','presupuestoAsignado':'','presupuestoEjecutado':'','horas':'','fechaInicio':'','fechaTermino':'','clasificacion':'','rutadocumento':'','estado':'','avance':'','descripcionAvance':'','escuela_id':'','lineainvestigacion':'','financiamiento':'','patentado':'','id':'','observaciones':'','archivonombre':''},


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
   formularioCrear:true,


   tituloI:'',
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
   patentado:1,
   observaciones:'',
   newNombreArchivo:'',

        imagen : null,
        archivo : null,
        newNombreArchivo : '',
        uploadReady: true,

        imagenE : null,
        archivoE : null,
        uploadReadyE: false,

        oldImg:'',
        oldFile:'',

        file:'',
        image:'',
        nameAdjunto:'',
        urlAdjunto:'',
        iflink:false,
        nameAdjuntoE:'',

     



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


    getArchivo(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivo=null;
                }
                else{
                this.archivo = event.target.files[0];
                }
            },

            getArchivoE(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivoE=null;
                }
                else{
                this.archivoE = event.target.files[0];
                }
            },

   getinvestigacions: function (page) {
       var busca=this.buscar;
       var url = 'investigacions?page='+page+'&busca='+busca;

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


   this.tituloI='';
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
   this.patentado=1;
   this.observaciones='';
   this.newNombreArchivo='';

   this.imagen=null;
        this.archivo=null;
        this.uploadReady = false
        this.$nextTick(() => {
          this.uploadReady = true;

    this.formularioCrear=true;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txttitulo').focus();

    })
   },



   create:function () {
       var url='investigacions';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       var data = new  FormData();

data.append('titulo', this.tituloI);
data.append('descripcion', this.descripcion);
data.append('resolucionAprobacion', this.resolucionAprobacion);
data.append('presupuestoAsignado', this.presupuestoAsignado);
data.append('presupuestoEjecutado', this.presupuestoEjecutado);
data.append('archivo', this.archivo);
data.append('horas', this.horas);
data.append('fechaInicio', this.fechaInicio);
data.append('fechaTermino', this.fechaTermino);
data.append('clasificacion', this.clasificacion);
data.append('rutadocumento', this.rutadocumento);
data.append('estado', this.estado);
data.append('avance', this.avance);
data.append('descripcionAvance', this.descripcionAvance);
data.append('escuela_id', this.escuela_id);
data.append('lineainvestigacion', this.lineainvestigacion);
data.append('financiamiento', this.financiamiento);
data.append('patentado', this.patentado);
data.append('observaciones', this.observaciones);
data.append('nombreArchivo', this.newNombreArchivo);

const config = { headers: { 'Content-Type': 'multipart/form-data' } };

/*var formData = new FormData($("#formulario")[0]);
console.log(formData);*/

axios.post(url,data, config).then(response=>{

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

                var url = 'investigacions/'+investigacion.id;
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

    this.uploadReadyE=false;
          this.$nextTick(() => {
            this.imagenE=null;
            this.archivoE=null;
            this.uploadReadyE=true;
            this.$nextTick(() => {
                

             });
          });

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
       this.fillinvestigacion.observaciones=investigacion.observaciones;
       this.fillinvestigacion.archivonombre=investigacion.archivonombre;


       this.oldFile=investigacion.rutadocumento;

      

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txttituloE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="investigacions/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;


       var data = new  FormData();

data.append('id', this.fillinvestigacion.id);
data.append('titulo', this.fillinvestigacion.titulo);
data.append('descripcion', this.fillinvestigacion.descripcion);
data.append('resolucionAprobacion', this.fillinvestigacion.resolucionAprobacion);
data.append('presupuestoAsignado', this.fillinvestigacion.presupuestoAsignado);
data.append('presupuestoEjecutado', this.fillinvestigacion.presupuestoEjecutado);
data.append('archivo', this.archivoE);
data.append('horas', this.fillinvestigacion.horas);
data.append('fechaInicio', this.fillinvestigacion.fechaInicio);
data.append('fechaTermino', this.fillinvestigacion.fechaTermino);
data.append('clasificacion', this.fillinvestigacion.clasificacion);
data.append('rutadocumento', this.fillinvestigacion.rutadocumento);
data.append('estado', this.fillinvestigacion.estado);
data.append('avance', this.fillinvestigacion.avance);
data.append('descripcionAvance', this.fillinvestigacion.descripcionAvance);
data.append('escuela_id', this.fillinvestigacion.escuela_id);
data.append('lineainvestigacion', this.fillinvestigacion.lineainvestigacion);
data.append('financiamiento', this.fillinvestigacion.financiamiento);
data.append('patentado', this.fillinvestigacion.patentado);
data.append('observaciones', this.fillinvestigacion.observaciones);
data.append('nombreArchivo', this.fillinvestigacion.archivonombre);

data.append('oldfile', this.oldFile);

data.append('_method', 'PUT');
         

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            axios.post(url, data, config).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getinvestigacions(this.thispage);
           this.fillinvestigacion={'titulo':'', 'descripcion':'', 'resolucionAprobacion':'','presupuestoAsignado':'','presupuestoEjecutado':'','horas':'','fechaInicio':'','fechaTermino':'','clasificacion':'','rutadocumento':'','estado':'','avance':'','descripcionAvance':'','escuela_id':'','lineainvestigacion':'','financiamiento':'','patentado':'','id':'','observaciones':'','archivonombre':''};
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