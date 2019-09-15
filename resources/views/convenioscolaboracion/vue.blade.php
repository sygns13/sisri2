<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Convenios e Intercambio",
       subtitulo: "Convenios de Colaboación",
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
   classMenu4:'',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'',
   classMenu8:'active',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   convenios: [],
   errors:[],

   fillconvenio:{'id':'', 'nombre':'','descripcion':'','institucion':'','resolucion':'','objetivo':'','obligaciones':'','fechainicio':'','fechafinal':'','estado':'','tipo':''},

   tipogen:3,

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

   nombre:'',
   descripcion:'',
   institucion:'',
   resolucion:'',
   objetivo:'',
   obligaciones:'',
   fechainicio:'',
   fechafinal:'',
   estado:1,
   tipo:3,



},
created:function () {
   this.getConvenios(this.thispage);
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
   getConvenios: function (page) {
       var busca=this.buscar;
       var url = 'convenio?page='+page+'&busca='+busca+'&tipo='+this.tipogen;

       axios.get(url).then(response=>{
           this.convenios= response.data.convenios.data;
           this.pagination= response.data.pagination;

           if(this.convenios.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getConvenios(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getConvenios();
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
       $('#txtnombre').focus();
        this.nombre='';
        this.descripcion='';
        this.institucion='';
        this.resolucion='';
        this.objetivo='';
        this.obligaciones='';
        this.fechainicio='';
        this.fechafinal='';
        this.estado=1;
        this.tipo=3;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtnombre').focus();
   },
   create:function () {
       var url='convenio';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{nombre:this.nombre, descripcion:this.descripcion, institucion:this.institucion, resolucion:this.resolucion, objetivo:this.objetivo, obligaciones:this.obligaciones, fechainicio:this.fechainicio, fechafinal:this.fechafinal, estado:this.estado, tipo:this.tipo }).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getConvenios(this.thispage);
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
   borrar:function (convenio) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Convenio Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'convenio/'+convenio.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getConvenios(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   edit:function (convenio) {

       this.fillconvenio.id=convenio.id;
       this.fillconvenio.nombre=convenio.nombre;
       this.fillconvenio.descripcion=convenio.descripcion;
       this.fillconvenio.institucion=convenio.institucion;
       this.fillconvenio.resolucion=convenio.resolucion;
       this.fillconvenio.objetivo=convenio.objetivo;
       this.fillconvenio.obligaciones=convenio.obligaciones;
       this.fillconvenio.fechainicio=convenio.fechainicio;
       this.fillconvenio.fechafinal=convenio.fechafinal;
       this.fillconvenio.estado=convenio.estado;
       this.fillconvenio.tipo=convenio.tipo;


       $("#boxTitulo").text('Convenio de Colaboación: '+convenio.nombre);
       $("#modalEditar").modal('show');

       $("#txtnombreE").focus();
   },
   update:function (id) {
       var url="convenio/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillconvenio).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getConvenios(this.thispage);
           this.fillconvenio={'id':'', 'nombre':'','descripcion':'','institucion':'','resolucion':'','objetivo':'','obligaciones':'','fechainicio':'','fechafinal':'','estado':'','tipo':''};
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

}
});
</script>