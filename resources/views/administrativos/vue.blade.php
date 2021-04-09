<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Gestión y Soporte",
       subtitulo: "Personal Administrativo",
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

   administrativos: [],
   errors:[],

   filladministrativos:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','id':'','persona_id':'','local_id':'','tipoDependencia':'','dependencia':'','facultad':'','escuela':'','cargo':'','descripcionCargo':'','grado':'','descripcionGrado':'','esTitulado':'','descripcionTitulo':'','lugarGrado':'','paisGrado':'','fechaIngreso':'','observaciones':'','estado':'','condicion':'','fechaSalida':'', 'correoinstitucional' : ''},


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
    condicion:'Nombrado',
    fechaSalida:'',

    correoinstitucional : '',

    persona_id:'0',      



},
created:function () {
   this.getAdministrativos(this.thispage);

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



   getAdministrativos: function (page) {
       var busca=this.buscar;
       var url = 'administrativo?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.administrativos= response.data.administrativos.data;
           this.pagination= response.data.pagination;

           

           if(this.administrativos.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getAdministrativos(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getAdministrativos();
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
    this.condicion='Nombrado';
    this.fechaSalida='';

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

      local_id:0,
    tipoDependencia:0,
    dependencia:'',
    facultad:'',
    escuela:'',
    cargo:'',
    descripcionCargo:'',
    grado:0,
    descripcionGrado:'',
    esTitulado:1,
    descripcionTitulo:'',
    lugarGrado:'',
    paisGrado:'',
    fechaIngreso:'',
    observaciones:'',
    estado:1,
    condicion:'Nombrado',
    fechaSalida:'',


    this.tipo=1;

    */

   create:function () {
       var url='administrativo';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, genero:this.genero, estadocivil:this.estadocivil, fechanac:this.fechanac,esdiscapacitado:this.esdiscapacitado, discapacidad:this.discapacidad, pais:this.pais, departamento:this.departamento, provincia:this.provincia, distrito:this.distrito, direccion:this.direccion, email:this.email, telefono:this.telefono, persona_id:this.persona_id, local_id:this.local_id, tipoDependencia:this.tipoDependencia, dependencia:this.dependencia, facultad:this.facultad, escuela:this.escuela, cargo:this.cargo, descripcionCargo:this.descripcionCargo, grado:this.grado, descripcionGrado:this.descripcionGrado, esTitulado:this.esTitulado, descripcionTitulo:this.descripcionTitulo, lugarGrado:this.lugarGrado, paisGrado:this.paisGrado, fechaIngreso:this.fechaIngreso, observaciones:this.observaciones, estado:this.estado, condicion:this.condicion, fechaSalida:this.fechaSalida, correoinstitucional: this.correoinstitucional}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getAdministrativos(this.thispage);
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




   borrar:function (administrativo) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Registro de Personal Administrativo Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'administrativo/'+administrativo.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getAdministrativos(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (administrativo) {

       this.cerrarFormNuevo();


       this.filladministrativos.id=administrativo.id;
       this.filladministrativos.tipodoc=administrativo.tipodoc;
       this.filladministrativos.doc=administrativo.doc;
       this.filladministrativos.nombres=administrativo.nombres;
       this.filladministrativos.apellidopat=administrativo.apellidopat;
       this.filladministrativos.apellidomat=administrativo.apellidomat;
       this.filladministrativos.genero=administrativo.genero;
       this.filladministrativos.estadocivil=administrativo.estadocivil;
       this.filladministrativos.fechanac=administrativo.fechanac;
       this.filladministrativos.esdiscapacitado=administrativo.esdiscapacitado;
       this.filladministrativos.discapacidad=administrativo.discapacidad;
       this.filladministrativos.pais=administrativo.pais;
       this.filladministrativos.departamento=administrativo.departamento;
       this.filladministrativos.provincia=administrativo.provincia;
       this.filladministrativos.distrito=administrativo.distrito;
       this.filladministrativos.direccion=administrativo.direccion;
       this.filladministrativos.email=administrativo.email;
       this.filladministrativos.telefono=administrativo.telefono;
       this.filladministrativos.correoinstitucional=administrativo.correoinstitucional;

       this.filladministrativos.persona_id=administrativo.persona_id;
       this.filladministrativos.local_id=administrativo.local_id;
       this.filladministrativos.tipoDependencia=administrativo.tipoDependencia;
       this.filladministrativos.dependencia=administrativo.dependencia;
       this.filladministrativos.facultad=administrativo.facultad;
       this.filladministrativos.escuela=administrativo.escuela;
       this.filladministrativos.cargo=administrativo.cargo;
       this.filladministrativos.descripcionCargo=administrativo.descripcionCargo;
       this.filladministrativos.grado=administrativo.grado;
       this.filladministrativos.descripcionGrado=administrativo.descripcionGrado;
       this.filladministrativos.esTitulado=administrativo.esTitulado;
       this.filladministrativos.descripcionTitulo=administrativo.descripcionTitulo;
       this.filladministrativos.lugarGrado=administrativo.lugarGrado;
       this.filladministrativos.paisGrado=administrativo.paisGrado;
       this.filladministrativos.fechaIngreso=administrativo.fechaIngreso;
       this.filladministrativos.observaciones=administrativo.observaciones;
       this.filladministrativos.estado=administrativo.estado;
       this.filladministrativos.condicion=administrativo.condicion;
       this.filladministrativos.fechaSalida=administrativo.fechaSalida;
      

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="administrativo/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.filladministrativos).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getAdministrativos(this.thispage);
           this.filladministrativos={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','id':'','persona_id':'','local_id':'','tipoDependencia':'','dependencia':'','facultad':'','escuela':'','cargo':'','descripcionCargo':'','grado':'','descripcionGrado':'','esTitulado':'','descripcionTitulo':'','lugarGrado':'','paisGrado':'','fechaIngreso':'','observaciones':'','estado':'','condicion':'','fechaSalida':'', 'correoinstitucional' : ''};
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
    //window.location="administrativos/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="administrativos/imprimirExcel/"+3;
   },
}
});
</script>