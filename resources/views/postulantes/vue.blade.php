<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Registro Principal",
       subtitulo: "Gestión de Postulantes",
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
   classTitle:'fa fa-graduation-cap',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'active',
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

   modadmisions: [],
   errors:[],

   fillmodadmision:{'id':'', 'nombre':'', 'descripcion':'','activo':''},

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

   validated:'0',
   formularioCrear:true,

  
    tipodoc:'',
    doc:'',
    nombres:'',
    apellidopat:'',
    apellidomat:'',
    genero:'',
    estadocivil:'',
    fechanac:'',
    esdiscapacitado:'',
    discapacidad:'',
    pais:'',
    departamento:'',
    provincia:'',
    distrito:'',
    direccion:'',
    email:'',
    telefono:'',

    codigo:'',
    semestre_id:'',
    escuela_id:'',
    colegio:'',
    modalidadadmision_id:'',
    modalidadestudios:'',
    puntaje:'',
    estado:'',
    opcioningreso:'',
    observaciones:'',
    pais:'',
    provincia:'',
    distrito:'',
    email:'',
    escuela_id2:'',
    tipogestioncolegio:'',






},
created:function () {
   this.getModalidadAdmision(this.thispage);

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
   getModalidadAdmision: function (page) {
       var busca=this.buscar;
       var url = 'modadmision?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.modadmisions= response.data.modadmisions.data;
           this.pagination= response.data.pagination;

           

           if(this.modadmisions.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   




   changePage:function (page) {
       this.pagination.current_page=page;
       this.getModalidadAdmision(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getModalidadAdmision();
       this.thispage='1';
   },
   nuevo:function () {
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



       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtnom').focus();
   },
   create:function () {
       var url='modadmision';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{nombre:this.nombre, descripcion:this.descripcion, activo:this.activo}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getModalidadAdmision(this.thispage);
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
   borrar:function (modadmision) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar la Modalidad de Admisión Seleccionada? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'modadmision/'+modadmision.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getModalidadAdmision(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (modAdmision) {

       /*
               fillmodadmision:{'id':'', 'codigo':'', 'descripcion':'','codnum':'','eqcodcentral':'','jurisprudencia':'','visualiza':'','activo':''},

               */

       this.fillmodadmision.id=modAdmision.id;
       this.fillmodadmision.nombre=modAdmision.nombre;
       this.fillmodadmision.descripcion=modAdmision.descripcion;
       this.fillmodadmision.activo=modAdmision.activo;


       $("#boxTitulo").text('Modalidad de Admisión: '+modAdmision.nombre);
       $("#modalEditar").modal('show');

       $("#txtnomE").focus();
   },
   update:function (id) {
       var url="modadmision/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillmodadmision).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getModalidadAdmision(this.thispage);
           this.fillmodadmision={'id':'', 'nombre':'', 'descripcion':'','activo':''};
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
   baja:function (modAdmision) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar esta Modalidad de Admisión",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'modadmision/altabaja/'+modAdmision.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getModalidadAdmision(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   alta:function (modAdmision) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar esta Modalidad de Admisión",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'modadmision/altabaja/'+modAdmision.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getModalidadAdmision(app.thispage);//listamos
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