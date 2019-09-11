<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Investigación",
       subtitulo: "Gestión de Tesis",
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
   classTitle:'fa fa-books',
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

   facultads: [],
   escuelas: [],
   errors:[],

   filltesis:{'id':'', 'proyecto':'', 'autor':'','dni':'','grado':'','financiamiento':'','escuela_id':'','programaprofesional':''},

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

   proyecto:'',
   autor:'',
   dni:'',
   grado:1,
   financiamiento:'',
   escuela_id:0,
   programaprofesional:'',



},
created:function () {
   this.getTesis(this.thispage);

   $("#cbsfacultadE").select2();
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
   getTesis: function (page) {
       var busca=this.buscar;
       var url = 'escuela?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.escuelas= response.data.escuelas.data;
           this.pagination= response.data.pagination;
           this.facultads= response.data.facultads;

           if(this.escuelas.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getTesis(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getTesis();
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
       $('#txtautor').focus();
        this.proyecto='';
        this.autor='';
        this.dni='';
        this.grado=1;
        this.financiamiento='';
        this.escuela_id=0;
        this.programaprofesional='';

       $(".form-control").css("border","1px solid #d2d6de");
   },
   create:function () {

       this.newFacultad=$("#cbsFacultad").val();
       var url='escuela';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{nombre:this.newEscuela, activo:this.newActivo, facultad_id:this.newFacultad}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getTesis(this.thispage);
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
   borrarescuela:function (escuela) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar la Escuela Profesional Seleccionada? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'escuela/'+escuela.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getTesis(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   editescuela:function (escuela) {

       this.filltesis.id=escuela.id;
       this.filltesis.nombre=escuela.nombre;
       this.filltesis.activo=escuela.activo;
       this.filltesis.facultad_id=escuela.facultad_id;


       $("#cbsfacultadE").select2();
       this.$nextTick(function () {
       $("#cbsfacultadE").val( this.filltesis.facultad_id).trigger('change');
       $('.select2').css("width","100%");
    });

       $("#boxTitulo").text('Escuela: '+escuela.nombre);
       $("#modalEditar").modal('show');

       $("#txtfacE").focus();
   },
   updateEscuela:function (id) {
       var url="escuela/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       this.filltesis.facultad_id=$("#cbsfacultadE").val();

       axios.put(url, this.filltesis).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getTesis(this.thispage);
           this.fillLocal={'id':'', 'nombre':'', 'activo':'','facultad_id':''};
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
   bajaescuela:function (escuela) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar la Escuela seleccionada",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'escuela/altabaja/'+escuela.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getTesis(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altaescuela:function (escuela) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar la Escuela seleccionada",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'escuela/altabaja/'+escuela.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getTesis(app.thispage);//listamos
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