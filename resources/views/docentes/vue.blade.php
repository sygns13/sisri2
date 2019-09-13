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

   filldocente:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','personalacademico':'','cargogeneral':'','descripcioncargo':'','maximogrado':'','descmaximogrado':'','universidadgrado':'','lugarmaximogrado':'','paismaximogrado':'','otrogrado':'','estadootrogrado':'','univotrogrado':'','lugarotrogrado':'','paisotrogrado':'','titulo':'','descripciontitulo':'','condicion':'','categoria':'','regimen':'','investigador':'','pregrado':'','postgrado':'','esdestacado':'','fechaingreso':'','modalidadingreso':'','observaciones':'','persona_id':'','horaslectivas':'','horasnolectivas':'','horasinvestigacion':'','horasdedicacion':'','escuela_id':'','facultad_id':'','dependencia':'','semestre_id':'','id':''},

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
    lugarmaximogrado:'Nacional',
    paismaximogrado:'',
    otrogrado:'',
    estadootrogrado:'No',
    univotrogrado:'',
    lugarotrogrado:'Nacional',
    paisotrogrado:'',
    tituloUniv:'Si',
    descripciontitulo:'',
    condicion:'Nombrado',
    categoria:'Auxiliar',
    regimen:'Tiempo completo',
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
   this.getDocentes(this.thispage);

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



   getDocentes: function (page) {
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
       this.getDocentes(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getDocentes();
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
    
    this.personalacademico='Docente';
    this.cargogeneral=0;
    this.descripcioncargo='';
    this.maximogrado=0;
    this.descmaximogrado='';
    this.universidadgrado='';
    this.lugarmaximogrado='Nacional';
    this.paismaximogrado='';
    this.otrogrado='';
    this.estadootrogrado='No';
    this.univotrogrado='';
    this.lugarotrogrado='Nacional';
    this.paisotrogrado='';
    this.tituloUniv='Si';
    this.descripciontitulo='';
    this.condicion='Nombrado';
    this.categoria='Auxiliar';
    this.regimen='Tiempo completo';
    this.investigador=1;
    this.pregrado=1;
    this.postgrado=0;
    this.esdestacado=1;
    this.fechaingreso='';
    this.modalidadingreso='';
    this.observaciones='';
    this.horaslectivas='';
    this.horasnolectivas='';
    this.horasinvestigacion='';
    this.horasdedicacion='';
    this.escuela_id=0;
    this.facultad_id=0;
    this.dependencia='';

    this.persona_id='0';

    this.formularioCrear=false;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtDNI').focus();
   },

   pressNuevoDNI: function() {

var url='persona/buscarDNI';

   axios.post(url,{doc:this.doc,tipodoc:this.tipodoc}).then(response=>{

       if(String(response.data.result)=='1'){

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

            this.persona_id='0';


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

            this.persona_id='0';

            this.formularioCrear=false;


           $('#'+response.data.selector).focus();
           $('#'+response.data.selector).css( "border", "1px solid red" );
           toastr.error(response.data.msj);
       }
   }).catch(error=>{
       //this.errors=error.response.data
   })

},



   create:function () {
       var url='docente';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, genero:this.genero, estadocivil:this.estadocivil, fechanac:this.fechanac,esdiscapacitado:this.esdiscapacitado, discapacidad:this.discapacidad, pais:this.pais, departamento:this.departamento, provincia:this.provincia, distrito:this.distrito, direccion:this.direccion, email:this.email, telefono:this.telefono, personalacademico:this.personalacademico, semestre_id:this.semestre_id, cargogeneral:this.cargogeneral, descripcioncargo:this.descripcioncargo, maximogrado:this.maximogrado, descmaximogrado:this.descmaximogrado, universidadgrado:this.universidadgrado, lugarmaximogrado:this.lugarmaximogrado, paismaximogrado:this.paismaximogrado, otrogrado:this.otrogrado, estadootrogrado:this.estadootrogrado, univotrogrado:this.univotrogrado, lugarotrogrado:this.lugarotrogrado, paisotrogrado:this.paisotrogrado, tituloUniv:this.tituloUniv, descripciontitulo:this.descripciontitulo, condicion:this.condicion, categoria:this.categoria, regimen:this.regimen, investigador:this.investigador, pregrado:this.pregrado, postgrado:this.postgrado, esdestacado:this.esdestacado, fechaingreso:this.fechaingreso, modalidadingreso:this.modalidadingreso, observaciones:this.observaciones, horaslectivas:this.horaslectivas, horasnolectivas:this.horasnolectivas, horasinvestigacion:this.horasinvestigacion, horasdedicacion:this.horasdedicacion, escuela_id:this.escuela_id, facultad_id:this.facultad_id, dependencia:this.dependencia, persona_id:this.persona_id  }).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getDocentes(this.thispage);
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




   borrar:function (docente) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Docente Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'docente/'+docente.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getDocentes(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (docente) {

       this.cerrarFormNuevo();


       this.filldocente.id=docente.id;
       this.filldocente.tipodoc=docente.tipodoc;
       this.filldocente.doc=docente.doc;
       this.filldocente.nombres=docente.nombres;
       this.filldocente.apellidopat=docente.apellidopat;
       this.filldocente.apellidomat=docente.apellidomat;
       this.filldocente.genero=docente.genero;
       this.filldocente.estadocivil=docente.estadocivil;
       this.filldocente.fechanac=docente.fechanac;
       this.filldocente.esdiscapacitado=docente.esdiscapacitado;
       this.filldocente.discapacidad=docente.discapacidad;
       this.filldocente.pais=docente.pais;
       this.filldocente.departamento=docente.departamento;
       this.filldocente.provincia=docente.provincia;
       this.filldocente.distrito=docente.distrito;
       this.filldocente.direccion=docente.direccion;
       this.filldocente.email=docente.email;
       this.filldocente.telefono=docente.telefono;

       this.filldocente.personalacademico=docente.personalacademico;
       this.filldocente.cargogeneral=docente.cargogeneral;
       this.filldocente.descripcioncargo=docente.descripcioncargo;
       this.filldocente.maximogrado=docente.maximogrado;
       this.filldocente.descmaximogrado=docente.descmaximogrado;
       this.filldocente.universidadgrado=docente.universidadgrado;
       this.filldocente.lugarmaximogrado=docente.lugarmaximogrado;
       this.filldocente.paismaximogrado=docente.paismaximogrado;
       this.filldocente.otrogrado=docente.otrogrado;
       this.filldocente.estadootrogrado=docente.estadootrogrado;
       this.filldocente.univotrogrado=docente.univotrogrado;
       this.filldocente.lugarotrogrado=docente.lugarotrogrado;
       this.filldocente.paisotrogrado=docente.paisotrogrado;
       this.filldocente.titulo=docente.titulo;
       this.filldocente.descripciontitulo=docente.descripciontitulo;
       this.filldocente.condicion=docente.condicion;
       this.filldocente.categoria=docente.categoria;
       this.filldocente.regimen=docente.regimen;
       this.filldocente.investigador=docente.investigador;
       this.filldocente.pregrado=docente.pregrado;
       this.filldocente.postgrado=docente.postgrado;
       this.filldocente.esdestacado=docente.esdestacado;
       this.filldocente.fechaingreso=docente.fechaingreso;
       this.filldocente.modalidadingreso=docente.modalidadingreso;
       this.filldocente.observaciones=docente.observaciones;
       this.filldocente.persona_id=docente.persona_id;
       this.filldocente.horaslectivas=docente.horaslectivas;
       this.filldocente.horasnolectivas=docente.horasnolectivas;
       this.filldocente.horasinvestigacion=docente.horasinvestigacion;
       this.filldocente.horasdedicacion=docente.horasdedicacion;
       this.filldocente.escuela_id=docente.escuela_id;
       this.filldocente.facultad_id=docente.facultad_id;
       this.filldocente.dependencia=docente.dependencia;
       this.filldocente.semestre_id=docente.semestre_id;



        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="docente/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.filldocente).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getDocentes(this.thispage);
           this.filldocente={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','personalacademico':'','cargogeneral':'','descripcioncargo':'','maximogrado':'','descmaximogrado':'','universidadgrado':'','lugarmaximogrado':'','paismaximogrado':'','otrogrado':'','estadootrogrado':'','univotrogrado':'','lugarotrogrado':'','paisotrogrado':'','titulo':'','descripciontitulo':'','condicion':'','categoria':'','regimen':'','investigador':'','pregrado':'','postgrado':'','esdestacado':'','fechaingreso':'','modalidadingreso':'','observaciones':'','persona_id':'','horaslectivas':'','horasnolectivas':'','horasinvestigacion':'','horasdedicacion':'','escuela_id':'','facultad_id':'','dependencia':'','semestre_id':'','id':''};
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