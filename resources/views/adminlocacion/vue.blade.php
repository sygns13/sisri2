<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Gestión y Soporte",
       subtitulo: "Personal Administrativo por Locación de Servicios",
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
   classTitle:'fa fa-users',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'',
   classMenu5:'active',
   classMenu6:'',
   classMenu7:'',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   adminlocaservs: [],
   errors:[],

   filladminlocaservs:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','id':'','persona_id':'','local_id':'','tipoDependencia':'','dependencia':'','facultad':'','escuela':'','cargo':'','descripcionCargo':'','grado':'','descripcionGrado':'','esTitulado':'','descripcionTitulo':'','lugarGrado':'','paisGrado':'','fechaIngreso':'','observaciones':'','estado':'','condicionLaboral':'','fechaFinContrato':'','regimenLaboral':'','fechaInicioContrato':'', 'correoinstitucional' : ''},


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


    
    local_id:0,
    tipoDependencia:0,
    dependencia:'',
    facultad:'0',
    escuela:'0',
    cargo:'0',
    descripcionCargo:'',
    grado:0,
    descripcionGrado:'',
    esTitulado:1,
    descripcionTitulo:'',
    lugarGrado:'Nacional',
    paisGrado:'',
    fechaIngreso:'',
    observaciones:'',
    estado:1,
    condicionLaboral:'',
    fechaFinContrato:'',
    regimenLaboral:'',
    fechaInicioContrato:'',

    correoinstitucional : '',

    persona_id:'0',  


    divNuevoImporte:false,
    divloaderNuevoImporte:false,
    uploadReady: true,
    archivo:[],   

    idSubmodulo:0,
    motivoProrroga:'',
    divloaderProrroga:false 



},
created:function () {
   this.getadminlocaservs(this.thispage);

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



   getadminlocaservs: function (page) {
       var busca=this.buscar;
       var url = 'locacionservicio?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.adminlocaservs= response.data.adminlocacions.data;
           this.pagination= response.data.pagination;

           

           if(this.adminlocaservs.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getadminlocaservs(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getadminlocaservs();
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

    this.local_id=0;
    this.tipoDependencia=0;
    this.dependencia='';
    this.facultad='0';
    this.escuela='0';
    this.cargo='0';
    this.descripcionCargo='';
    this.grado=0;
    this.descripcionGrado='';
    this.esTitulado=1;
    this.descripcionTitulo='';
    this.lugarGrado='Nacional';
    this.paisGrado='';
    this.fechaIngreso='';
    this.observaciones='';
    this.estado=1;
    this.condicionLaboral='';
    this.fechaFinContrato='';
    this.regimenLaboral='';
    this.fechaInicioContrato='';

    this.correoinstitucional = '';



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
            this.correoinstitucional = '';

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
        this.correoinstitucional = response.data.persona.correoinstitucional;


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
            this.correoinstitucional = '';

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


/*

      this.local_id=0;
    this.tipoDependencia=0;
    this.dependencia='';
    this.facultad='0';
    this.escuela='0';
    this.cargo='0';
    this.descripcionCargo='';
    this.grado=0;
    this.descripcionGrado='';
    this.esTitulado=1;
    this.descripcionTitulo='';
    this.lugarGrado='Nacional';
    this.paisGrado='';
    this.fechaIngreso='';
    this.observaciones='';
    this.estado=1;
    this.condicionLaboral='Nombrado';
    this.fechaFinContrato='';
    this.regimenLaboral='';
    this.fechaInicioContrato='';


    this.tipo=1;

    */

   create:function () {
       var url='locacionservicio';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, genero:this.genero, estadocivil:this.estadocivil, fechanac:this.fechanac,esdiscapacitado:this.esdiscapacitado, discapacidad:this.discapacidad, pais:this.pais, departamento:this.departamento, provincia:this.provincia, distrito:this.distrito, direccion:this.direccion, email:this.email, telefono:this.telefono, persona_id:this.persona_id, local_id:this.local_id, tipoDependencia:this.tipoDependencia, dependencia:this.dependencia, facultad:this.facultad, escuela:this.escuela, cargo:this.cargo, descripcionCargo:this.descripcionCargo, grado:this.grado, descripcionGrado:this.descripcionGrado, esTitulado:this.esTitulado, descripcionTitulo:this.descripcionTitulo, lugarGrado:this.lugarGrado, paisGrado:this.paisGrado, fechaIngreso:this.fechaIngreso, observaciones:this.observaciones, estado:this.estado, condicionLaboral:this.condicionLaboral, fechaFinContrato:this.fechaFinContrato, regimenLaboral:this.regimenLaboral, fechaInicioContrato:this.fechaInicioContrato, correoinstitucional: this.correoinstitucional }).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getadminlocaservs(this.thispage);
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




   borrar:function (adminlocaserv) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Registro de Personal de Locación de Servicios Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'locacionservicio/'+adminlocaserv.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getadminlocaservs(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (adminlocaserv) {

       this.cerrarFormNuevo();


       this.filladminlocaservs.id=adminlocaserv.id;
       this.filladminlocaservs.tipodoc=adminlocaserv.tipodoc;
       this.filladminlocaservs.doc=adminlocaserv.doc;
       this.filladminlocaservs.nombres=adminlocaserv.nombres;
       this.filladminlocaservs.apellidopat=adminlocaserv.apellidopat;
       this.filladminlocaservs.apellidomat=adminlocaserv.apellidomat;
       this.filladminlocaservs.genero=adminlocaserv.genero;
       this.filladminlocaservs.estadocivil=adminlocaserv.estadocivil;
       this.filladminlocaservs.fechanac=adminlocaserv.fechanac;
       this.filladminlocaservs.esdiscapacitado=adminlocaserv.esdiscapacitado;
       this.filladminlocaservs.discapacidad=adminlocaserv.discapacidad;
       this.filladminlocaservs.pais=adminlocaserv.pais;
       this.filladminlocaservs.departamento=adminlocaserv.departamento;
       this.filladminlocaservs.provincia=adminlocaserv.provincia;
       this.filladminlocaservs.distrito=adminlocaserv.distrito;
       this.filladminlocaservs.direccion=adminlocaserv.direccion;
       this.filladminlocaservs.email=adminlocaserv.email;
       this.filladminlocaservs.telefono=adminlocaserv.telefono;
       this.filladminlocaservs.correoinstitucional=adminlocaserv.correoinstitucional;

       this.filladminlocaservs.persona_id=adminlocaserv.persona_id;
       this.filladminlocaservs.local_id=adminlocaserv.local_id;
       this.filladminlocaservs.tipoDependencia=adminlocaserv.tipoDependencia;
       this.filladminlocaservs.dependencia=adminlocaserv.dependencia;
       this.filladminlocaservs.facultad=adminlocaserv.facultad;
       this.filladminlocaservs.escuela=adminlocaserv.escuela;
       this.filladminlocaservs.cargo=adminlocaserv.cargo;
       this.filladminlocaservs.descripcionCargo=adminlocaserv.descripcionCargo;
       this.filladminlocaservs.grado=adminlocaserv.grado;
       this.filladminlocaservs.descripcionGrado=adminlocaserv.descripcionGrado;
       this.filladminlocaservs.esTitulado=adminlocaserv.esTitulado;
       this.filladminlocaservs.descripcionTitulo=adminlocaserv.descripcionTitulo;
       this.filladminlocaservs.lugarGrado=adminlocaserv.lugarGrado;
       this.filladminlocaservs.paisGrado=adminlocaserv.paisGrado;
       this.filladminlocaservs.fechaIngreso=adminlocaserv.fechaIngreso;
       this.filladminlocaservs.observaciones=adminlocaserv.observaciones;
       this.filladminlocaservs.estado=adminlocaserv.estado;
       this.filladminlocaservs.condicionLaboral=adminlocaserv.condicionLaboral;
       this.filladminlocaservs.regimenLaboral=adminlocaserv.regimenLaboral;
       this.filladminlocaservs.fechaFinContrato=adminlocaserv.fechaFinContrato;
       this.filladminlocaservs.fechaInicioContrato=adminlocaserv.fechaInicioContrato;
      

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="locacionservicio/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.filladminlocaservs).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getadminlocaservs(this.thispage);
           this.filladminlocaservs={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','id':'','persona_id':'','local_id':'','tipoDependencia':'','dependencia':'','facultad':'','escuela':'','cargo':'','descripcionCargo':'','grado':'','descripcionGrado':'','esTitulado':'','descripcionTitulo':'','lugarGrado':'','paisGrado':'','fechaIngreso':'','observaciones':'','estado':'','condicionLaboral':'','fechaFinContrato':'','regimenLaboral':'','fechaInicioContrato':'' , 'correoinstitucional' : ''};
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


   nuevaExportación:function () {
            this.divNuevoImporte=true;
            //$("#txtespecialidad").focus();
            //$('#txtespecialidad').focus();
            this.$nextTick(function () {
            this.cancelFormImporteForm();
          })
            
        },


        cerrarFormImportacion: function () {
            this.divNuevoImporte=false;
            this.cancelFormImporteForm();
        },
        cancelFormImporteForm: function () {
                    this.uploadReady = false
                        this.$nextTick(() => {
                            this.uploadReady = true;

                        })
        },

        getArchivo:function(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivo=null;
                }
                else{
                this.archivo = event.target.files[0];
                }
            },

    
            createImportacion:function () {
            var url='locacionservicioR/importardata1';
            $("#btnGuardarImporte").attr('disabled', true);
            $("#btnCancelImporte").attr('disabled', true);
            $("#btnCloseImporte").attr('disabled', true);
            this.divloaderNuevoImporte=true;

            var data = new  FormData();
            data.append('archivo', this.archivo);
            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            axios.post(url, data, config).then(response=>{
                //console.log(response.data);

                $("#btnGuardarImporte").removeAttr("disabled");
                $("#btnCancelImporte").removeAttr("disabled");
                $("#btnCloseImporte").removeAttr("disabled");
                this.divloaderNuevoImporte=false;

                //console.log(response.data.result);

                if(String(response.data.result)=='1'){
                    this.getadminlocaservs(this.thispage);
                    this.errors=[];
                    this.cerrarFormImportacion();
                    toastr.success(response.data.msj);
                }else{
                    //console.log(response.data.msj);
                    //toastr.error(response.data.errorFinal);
                    this.cancelFormImporteForm();
                     swal.fire(response.data.errtitulo, response.data.msj, "error");
                }
            }).catch(error=>{
                //this.errors=error.response.data
            })
        },

        nuevaProrroga:function (id) {

            this.idSubmodulo = id;
            this.motivoProrroga = '';

            $("#boxTituloProrroga").text('Submódulo: Gestión de Personal Locador de Servicios');
            $("#modalProrroga").modal('show');
            $("#motivoProrroga").focus();
            },


            solicitarProrroga:function () {
            var url="prorroga";
            $("#btnSaveProrroga").attr('disabled', true);
            $("#btnCancelProrroga").attr('disabled', true);
            this.divloaderProrroga=true;

            axios.post(url, {idSubmodulo:this.idSubmodulo, motivoProrroga:this.motivoProrroga }).then(response=>{

            $("#btnSaveProrroga").removeAttr("disabled");
            $("#btnCancelProrroga").removeAttr("disabled");
            this.divloaderProrroga=false;

            if(response.data.result=='1'){   
            $("#modalProrroga").modal('hide');
            //toastr.success(response.data.msj);
            Swal.fire(
            'Solicitud Registrada',
            response.data.msj,
            'success'
            );

            }else{
            $('#'+response.data.selector).focus();
            toastr.error(response.data.msj);
            }

            }).catch(error=>{
            //this.errors=error.response.data
            })
            },
}
});
</script>