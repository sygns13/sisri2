<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Grados y Títulos",
       subtitulo: "Maestros",
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
   classMenu2:'',
   classMenu3:'active',
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

   graduados: [],
   errors:[],

   fillmaestros:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','escuela_id':'','nombreGrado':'','programaEstudios':'','fechaEgreso':'','idioma':'','modalidadObtencion':'','numResolucion':'','fechaResol':'','numeroDiploma':'','autoridadRector':'','fechaEmision':'','observaciones':'','persona_id':'','tipo':'','trabajoinvestigacion':''},

   

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


    
    escuela_id:0,
    nombreGrado:'',
    programaEstudios:'',
    fechaEgreso:'',
    idioma:'Inglés',
    modalidadObtencion:'',
    numResolucion:'',
    fechaResol:'',
    numeroDiploma:'',
    autoridadRector:'',
    fechaEmision:'',
    observaciones:'',
    trabajoinvestigacion:'',
    

    tipo:3,

    persona_id:'0',      

    tipoGeneral:3, 


},
created:function () {
   this.getMaestros(this.thispage);

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



   getMaestros: function (page) {
       var busca=this.buscar;
       var url = 'graduado?page='+page+'&busca='+busca+'&tipo='+this.tipoGeneral;

       axios.get(url).then(response=>{
           this.graduados= response.data.graduados.data;
           this.pagination= response.data.pagination;

           

           if(this.graduados.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getMaestros(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getMaestros();
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

    this.escuela_id=0;
    this.nombreGrado='';
    this.programaEstudios='';
    this.fechaEgreso='';
    this.idioma='Inglés';
    this.modalidadObtencion='';
    this.numResolucion='';
    this.fechaResol='';
    this.numeroDiploma='';
    this.autoridadRector='';
    this.fechaEmision='';
    this.observaciones='';
    this.trabajoinvestigacion='';


    this.tipo=3;

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


/*

      this.escuela_id=0;
    this.nombreGrado='';
    this.programaEstudios='';
    this.fechaEgreso='';
    this.idioma='';
    this.modalidadObtencion='';
    this.numResolucion='';
    this.fechaResol='';
    this.numeroDiploma='';
    this.autoridadRector='';
    this.fechaEmision='';
    this.observaciones='';
    this.trabajoinvestigacion=';


    this.tipo=3;

    */

   create:function () {
       var url='graduado';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, genero:this.genero, estadocivil:this.estadocivil, fechanac:this.fechanac,esdiscapacitado:this.esdiscapacitado, discapacidad:this.discapacidad, pais:this.pais, departamento:this.departamento, provincia:this.provincia, distrito:this.distrito, direccion:this.direccion, email:this.email, telefono:this.telefono, escuela_id:this.escuela_id, nombreGrado:this.nombreGrado, programaEstudios:this.programaEstudios, fechaEgreso:this.fechaEgreso, idioma:this.idioma, modalidadObtencion:this.modalidadObtencion, numResolucion:this.numResolucion, fechaResol:this.fechaResol, numeroDiploma:this.numeroDiploma, autoridadRector:this.autoridadRector, fechaEmision:this.fechaEmision, observaciones:this.observaciones, trabajoinvestigacion:this.trabajoinvestigacion, tipo:this.tipo, persona_id:this.persona_id}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getMaestros(this.thispage);
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




   borrar:function (graduado) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Registro de Maestro Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'graduado/'+graduado.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getMaestros(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (maestro) {

       this.cerrarFormNuevo();


       this.fillmaestros.id=maestro.id;
       this.fillmaestros.tipodoc=maestro.tipodoc;
       this.fillmaestros.doc=maestro.doc;
       this.fillmaestros.nombres=maestro.nombres;
       this.fillmaestros.apellidopat=maestro.apellidopat;
       this.fillmaestros.apellidomat=maestro.apellidomat;
       this.fillmaestros.genero=maestro.genero;
       this.fillmaestros.estadocivil=maestro.estadocivil;
       this.fillmaestros.fechanac=maestro.fechanac;
       this.fillmaestros.esdiscapacitado=maestro.esdiscapacitado;
       this.fillmaestros.discapacidad=maestro.discapacidad;
       this.fillmaestros.pais=maestro.pais;
       this.fillmaestros.departamento=maestro.departamento;
       this.fillmaestros.provincia=maestro.provincia;
       this.fillmaestros.distrito=maestro.distrito;
       this.fillmaestros.direccion=maestro.direccion;
       this.fillmaestros.email=maestro.email;
       this.fillmaestros.telefono=maestro.telefono;

       this.fillmaestros.escuela_id=maestro.escuela_id;
       this.fillmaestros.nombreGrado=maestro.nombreGrado;
       this.fillmaestros.programaEstudios=maestro.programaEstudios;
       this.fillmaestros.fechaEgreso=maestro.fechaEgreso;
       this.fillmaestros.idioma=maestro.idioma;
       this.fillmaestros.modalidadObtencion=maestro.modalidadObtencion;
       this.fillmaestros.numResolucion=maestro.numResolucion;
       this.fillmaestros.fechaResol=maestro.fechaResol;
       this.fillmaestros.numeroDiploma=maestro.numeroDiploma;
       this.fillmaestros.autoridadRector=maestro.autoridadRector;
       this.fillmaestros.fechaEmision=maestro.fechaEmision;
       this.fillmaestros.observaciones=maestro.observaciones;
       this.fillmaestros.persona_id=maestro.persona_id;
       this.fillmaestros.tipo=maestro.tipo;
       this.fillmaestros.trabajoinvestigacion=maestro.trabajoinvestigacion;
      

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="graduado/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillmaestros).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getMaestros(this.thispage);
           this.fillmaestros={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','escuela_id':'','nombreGrado':'','programaEstudios':'','fechaEgreso':'','idioma':'','modalidadObtencion':'','numResolucion':'','fechaResol':'','numeroDiploma':'','autoridadRector':'','fechaEmision':'','observaciones':'','persona_id':'','tipo':'','trabajoinvestigacion':''};
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
    //window.location="graduados/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="graduados/imprimirExcel/"+3;
   },
}
});
</script>