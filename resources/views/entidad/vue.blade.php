<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Tablas Maestras",
       subtitulo: "Gestión de Entidades",
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
   classTitle:'fa fa-bank ',
   classMenu0:'',
   classMenu1:'active',
   classMenu2:'',
   classMenu3:'',
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

   locals: [],
   entidads: [],
   errors:[],

   fillEntidad:{'id':'', 'descripcion':'', 'code':'','estado':'','local_id':''},

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

   newEntidad:'',
   newCodigo:'',
   newEstado:'1',
   newLocal:'',



},
created:function () {
   this.getEntidad(this.thispage);

   $("#cbslocalE").select2();
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
   getEntidad: function (page) {
       var busca=this.buscar;
       var url = 'entidad?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.entidads= response.data.entidads.data;
           this.pagination= response.data.pagination;
           this.locals= response.data.locals;

           if(this.entidads.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getEntidad(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getEntidad();
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
       $('#txtdesc').focus();
       this.newEntidad='';
       this.newCodigo='';
       this.newEstado='1';

       this.newLocal='';

       $("#cbslocal").select2();
       $('#cbslocal').val('').trigger('change');

       $(".form-control").css("border","1px solid #d2d6de");
   },
   create:function () {

       this.newLocal=$("#cbslocal").val();
       var url='entidad';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{descripcion:this.newEntidad, code:this.newCodigo, estado:this.newEstado, local_id:this.newLocal}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getEntidad(this.thispage);
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
   borrarentidad:function (entidad) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar la Entidad Seleccionada? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'entidad/'+entidad.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getEntidad(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   editentidad:function (entidad) {

       this.fillEntidad.id=entidad.id;
       this.fillEntidad.descripcion=entidad.descripcion;
       this.fillEntidad.code=entidad.code;
       this.fillEntidad.estado=entidad.estado;
       this.fillEntidad.local_id=entidad.local_id;
       
       $("#cbslocalE").select2();
       this.$nextTick(function () {
       $("#cbslocalE").val( this.fillEntidad.local_id).trigger('change');
       $('.select2').css("width","100%");
        });

       $("#boxTitulo").text('Entidad: '+entidad.descripcion);
       $("#modalEditar").modal('show');

       $("#txtdescE").focus();
   },
   updateLocal:function (id) {
       var url="entidad/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       this.fillEntidad.local_id=$("#cbslocalE").val();

       axios.put(url, this.fillEntidad).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getEntidad(this.thispage);
           this.fillLocal={'id':'', 'descripcion':'', 'code':'','estado':'','local_id':''};
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
   bajaentidad:function (entidad) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar la Entidad seleccionada",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'entidad/altabaja/'+entidad.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getEntidad(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altaentidad:function (entidad) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar la Entidad seleccionada",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'entidad/altabaja/'+entidad.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getEntidad(app.thispage);//listamos
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