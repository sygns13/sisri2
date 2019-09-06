<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Gestión Académica",
       subtitulo: "Docentes",
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
   classTitle:'fa fa-user-secret',
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

   docentes: [],
   errors:[],

   filldocentes:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','personalacademico':'','cargogeneral':'','descripcioncargo':'','maximogrado':'','descmaximogrado':'','universidadgrado':'','lugarmaximogrado':'','paismaximogrado':'','otrogrado':'','estadootrogrado':'','univotrogrado':'','lugarotrogrado':'','paisotrogrado':'','titulo':'','descripciontitulo':'','condicion':'','categoria':'','regimen':'','investigador':'','pregrado':'','postgrado':'','esdestacado':'','fechaingreso':'','modalidadingreso':'','observaciones':'','persona_id':'','horaslectivas':'','horasnolectivas':'','horasinvestigacion':'','horasdedicacion':'','escuela_id':'','facultad_id':'','dependencia':'','semestre_id':'','id':''},

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

    personalacademico:'Docente',
    cargogeneral:0,
    descripcioncargo:'',
    maximogrado:0,
    descmaximogrado:'',
    universidadgrado:'',
    lugarmaximogrado:'',
    paismaximogrado:'',
    otrogrado:'',
    estadootrogrado:'',
    univotrogrado:'',
    lugarotrogrado:'',
    paisotrogrado:'',
    titulo:'',
    descripciontitulo:'',
    condicion:'',
    categoria:'',
    regimen:'',
    investigador:1,
    pregrado:1,
    postgrado:0,
    esdestacado:1,
    fechaingreso:'',
    modalidadingreso:'',
    observaciones:'',
    horaslectivas:'',
    horasnolectivas:'',
    horasinvestigacion:'',
    horasdedicacion:'',
    escuela_id:0,
    facultad_id:0,
    dependencia:'',
    
    semestre_id:{{$semestresel}},
    contse:{{$contse}},
    semestreNombre:'{{$semestreNombre}}',



    persona_id:'0',       


},
created:function () {
   this.getPostulante(this.thispage);

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



   getPostulante: function (page) {
       var busca=this.buscar;
       var url = 'docente?page='+page+'&busca='+busca+'&semestre_id='+this.semestre_id;

       axios.get(url).then(response=>{
           this.docentes= response.data.docentes.data;
           this.pagination= response.data.pagination;

           

           if(this.docentes.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getPostulante(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getPostulante();
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



   create:function () {
       var url='docentes';
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
               this.getPostulante(this.thispage);
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




   borrar:function (postulante) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Postulante Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'docentes/'+postulante.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getPostulante(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (postulante) {

       this.cerrarFormNuevo();


       this.filldocentes.id=postulante.id;
       this.filldocentes.tipodoc=postulante.tipodoc;
       this.filldocentes.doc=postulante.doc;
       this.filldocentes.nombres=postulante.nombres;
       this.filldocentes.apellidopat=postulante.apellidopat;
       this.filldocentes.apellidomat=postulante.apellidomat;
       this.filldocentes.genero=postulante.genero;
       this.filldocentes.estadocivil=postulante.estadocivil;
       this.filldocentes.fechanac=postulante.fechanac;
       this.filldocentes.esdiscapacitado=postulante.esdiscapacitado;
       this.filldocentes.discapacidad=postulante.discapacidad;
       this.filldocentes.pais=postulante.pais;
       this.filldocentes.departamento=postulante.departamento;
       this.filldocentes.provincia=postulante.provincia;
       this.filldocentes.distrito=postulante.distrito;
       this.filldocentes.direccion=postulante.direccion;
       this.filldocentes.email=postulante.email;
       this.filldocentes.telefono=postulante.telefono;
       this.filldocentes.codigo=postulante.codigo;
       this.filldocentes.semestre_id=postulante.semestre_id;
       this.filldocentes.escuela_id=postulante.escuela_id;
       this.filldocentes.colegio=postulante.colegio;
       this.filldocentes.modalidadadmision_id=postulante.modalidadadmision_id;
       this.filldocentes.modalidadestudios=postulante.modalidadestudios;
       this.filldocentes.puntaje=postulante.puntaje;
       this.filldocentes.estado=postulante.estado;
       this.filldocentes.opcioningreso=postulante.opcioningreso;
       this.filldocentes.observaciones=postulante.observaciones;
       this.filldocentes.escuela_id2=postulante.escuela_id2;
       this.filldocentes.tipogestioncolegio=postulante.tipogestioncolegio;
       this.filldocentes.persona_id=postulante.persona_id;



        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="docentes/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.filldocentes).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getPostulante(this.thispage);
           this.filldocentes={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','codigo':'','semestre_id':'','escuela_id':'','colegio':'','modalidadadmision_id':'','modalidadestudios':'','puntaje':'','estado':'','opcioningreso':'','observaciones':'','escuela_id2':'','tipogestioncolegio':'','persona_id':'','id':''};
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
    //window.location="docentes/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="docentes/imprimirExcel/"+3;
   },
}
});
</script>