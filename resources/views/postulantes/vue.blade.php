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

   postulantes: [],
   errors:[],

   fillpostulantes:{'id':'', 'nombre':'', 'descripcion':'','activo':''},

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
   formularioCrear:false,

  
    tipodoc:1,
    doc:'',
    nombres:'',
    apellidopat:'',
    apellidomat:'',
    genero:'M',
    estadocivil:1,
    fechanac:'',
    esdiscapacitado:0,
    discapacidad:'',
    pais:'PERÚ',
    departamento:'ANCASH',
    provincia:'HUARAZ',
    distrito:'HUARAZ',
    direccion:'',
    email:'',
    telefono:'',

    codigo:'',
    semestre_id:{{$semestresel}},
    escuela_id:0,
    colegio:'',
    modalidadadmision_id:0,
    modalidadestudios:1,
    puntaje:'',
    estado:0,
    opcioningreso:0,
    observaciones:'',
    escuela_id2:0,
    tipogestioncolegio:1,

    contse:{{$contse}},
    semestreNombre:'{{$semestreNombre}}',



    persona_id:'0',       


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

    cambiarSemestre:function(){

        this.semestreNombre=$("#txtseme"+this.semestre_id).val();

        this.$nextTick(function () {
            this.buscarBtn();
            });

    },



   getModalidadAdmision: function (page) {
       var busca=this.buscar;
       var url = 'postulantes?page='+page+'&busca='+busca+'&semestre_id='+this.semestre_id;

       axios.get(url).then(response=>{
           this.postulantes= response.data.postulantes.data;
           this.pagination= response.data.pagination;

           

           if(this.postulantes.length==0 && this.thispage!='1'){
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


    this.tipodoc=1;
    this.doc='';
    this.nombres='';
    this.apellidopat='';
    this.apellidomat='';
    this.genero='M';
    this.estadocivil=1;
    this.fechanac='';
    this.esdiscapacitado=0;
    this.discapacidad='';
    this.pais='PERÚ';
    this.departamento='ANCASH';
    this.provincia='HUARAZ';
    this.distrito='HUARAZ';
    this.direccion='';
    this.email='';
    this.telefono='';
    this.codigo='';
    this.semestre_id={{$semestresel}};
    this.escuela_id=0;
    this.colegio='';
    this.modalidadadmision_id=0;
    this.modalidadestudios=1;
    this.puntaje='';
    this.estado=0;
    this.opcioningreso=0;
    this.observaciones='';
    this.escuela_id2=0;
    this.tipogestioncolegio=1;


    this.persona_id='0';

    this.formularioCrear=false;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtDNI').focus();
   },

   pressNuevoDNI: function() {

var url='persona/buscarDNI';

   axios.post(url,{doc:this.doc,tipodoc:this.tipodoc}).then(response=>{

       if(String(response.data.result)=='1'){

           this.formularioCrear=true;

           this.$nextTick(function () {
                $("#txtapepat").focus();
            });

           toastr.success(response.data.msj);
       }else if (String(response.data.result)=='2') {

        this.persona_id=response.data.idPer;

        this.nombres=response.data.persona.nombres;
    this.apellidopat=response.data.persona.apellidopat;
    this.apellidomat=response.data.persona.apellidomat;
    this.genero=response.data.persona.genero;
    this.estadocivil=response.data.persona.estadocivil;
    this.fechanac=response.data.persona.fechanac;
    this.esdiscapacitado=response.data.persona.esdiscapacitado;
    this.discapacidad=response.data.persona.discapacidad;
    this.pais=response.data.persona.pais;
    this.departamento=response.data.persona.departamento;
    this.provincia=response.data.persona.provincia;
    this.distrito=response.data.persona.distrito;
    this.direccion=response.data.persona.direccion;
    this.email=response.data.persona.email;
    this.telefono=response.data.persona.telefono;


        this.formularioCrear=true;

        this.$nextTick(function () {
                $("#txtapepat").focus();
            });

        }else{
           $('#'+response.data.selector).focus();
           $('#'+response.data.selector).css( "border", "1px solid red" );
           toastr.error(response.data.msj);
       }
   }).catch(error=>{
       //this.errors=error.response.data
   })

},




/*
    this.tipodoc=1;
    this.doc='';
    this.nombres='';
    this.apellidopat='';
    this.apellidomat='';
    this.genero='M';
    this.estadocivil=1;
    this.fechanac='';
    this.esdiscapacitado=0;
    this.discapacidad='';
    this.pais='PERÚ';
    this.departamento='ANCASH';
    this.provincia='HUARAZ';
    this.distrito='HUARAZ';
    this.direccion='';
    this.email='';
    this.telefono='';
    this.codigo='';
    this.semestre_id={{$semestresel}};
    this.escuela_id=0;
    this.colegio='';
    this.modalidadadmision_id=0;
    this.modalidadestudios=1;
    this.puntaje='';
    this.estado=0;
    this.opcioningreso=0;
    this.observaciones='';
    this.escuela_id2=0;
    this.tipogestioncolegio=1;
    persona_id

*/


   create:function () {
       var url='postulantes';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, genero:this.genero, estadocivil:this.estadocivil, fechanac:this.fechanac,esdiscapacitado:this.esdiscapacitado, discapacidad:this.discapacidad, pais:this.pais, departamento:this.departamento, provincia:this.provincia, distrito:this.distrito, direccion:this.direccion, email:this.email, telefono:this.telefono, codigo:this.codigo, semestre_id:this.semestre_id, escuela_id:this.escuela_id, colegio:this.colegio, modalidadadmision_id:this.modalidadadmision_id, modalidadestudios:this.modalidadestudios, puntaje:this.puntaje, estado:this.estado, opcioningreso:this.opcioningreso, observaciones:this.observaciones, escuela_id2:this.escuela_id2, tipogestioncolegio:this.tipogestioncolegio, persona_id:this.persona_id }).then(response=>{
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




   borrar:function (postulantes) {


    
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

                var url = 'postulantes/'+postulantes.id;
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




   edit:function (postulantes) {

       /*
               fillpostulantes:{'id':'', 'codigo':'', 'descripcion':'','codnum':'','eqcodcentral':'','jurisprudencia':'','visualiza':'','activo':''},

               */

       this.fillpostulantes.id=postulantes.id;
       this.fillpostulantes.nombre=postulantes.nombre;
       this.fillpostulantes.descripcion=postulantes.descripcion;
       this.fillpostulantes.activo=postulantes.activo;


       $("#boxTitulo").text('Modalidad de Admisión: '+postulantes.nombre);
       $("#modalEditar").modal('show');

       $("#txtnomE").focus();
   },
   update:function (id) {
       var url="postulantes/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillpostulantes).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getModalidadAdmision(this.thispage);
           this.fillpostulantes={'id':'', 'nombre':'', 'descripcion':'','activo':''};
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
   baja:function (postulantes) {


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

                var url = 'postulantes/altabaja/'+postulantes.id+'/0';
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
   alta:function (postulantes) {

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

                var url = 'postulantes/altabaja/'+postulantes.id+'/1';
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