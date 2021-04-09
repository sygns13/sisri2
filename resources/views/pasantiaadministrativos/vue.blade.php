<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Convenios e Intercambio de Administrativos",
       subtitulo: "Personal Administrativo UNASAM Pasantías e Intercambios",
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
   classTitle:'fa fa-plane',
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

   alumnos: [],
   errors:[],

   fillalumnos:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','escuela_id':'','modalidads':'','concepto':'','paispasantia':'','institucionpasantia':'','fechainicio':'','fechafinal':'','monto':'','resolucions':'','tipo':'','dependencia':'','observaciones':''},

   tipoGeneral:3,

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
    modalidads:'',
    concepto:'',
    paispasantia:'',
    institucionpasantia:'',
    fechainicio:'',
    fechafinal:'',
    monto:'',
    resolucions:'',
    tipo:3,
    dependencia:'',
    observaciones:'',



    persona_id:'0',       


},
created:function () {
   this.getAlumno(this.thispage);

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




   getAlumno: function (page) {
       var busca=this.buscar;
       var url = 'pasantia?page='+page+'&busca='+busca+'&tipo='+this.tipoGeneral;

       axios.get(url).then(response=>{
           this.alumnos= response.data.alumnos.data;
           this.pagination= response.data.pagination;

           

           if(this.alumnos.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getAlumno(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getAlumno();
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
    this.modalidads='';
    this.concepto='';
    this.paispasantia='';
    this.institucionpasantia='';
    this.fechainicio='';
    this.fechafinal='';
    this.monto='';
    this.resolucions='';
    this.tipo=3;
    this.dependencia='';
    this.observaciones='';


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
    this.modalidads='';
    this.concepto='';
    this.paispasantia='';
    this.institucionpasantia='';
    this.fechainicio='';
    this.fechafinal='';
    this.monto='';
    this.resolucions='';
    this.tipo=3;
    this.dependencia='';
    this.observaciones='';

    */

   create:function () {
       var url='pasantia';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, genero:this.genero, estadocivil:this.estadocivil, fechanac:this.fechanac,esdiscapacitado:this.esdiscapacitado, discapacidad:this.discapacidad, pais:this.pais, departamento:this.departamento, provincia:this.provincia, distrito:this.distrito, direccion:this.direccion, email:this.email, telefono:this.telefono, escuela_id:this.escuela_id, modalidads:this.modalidads, concepto:this.concepto, paispasantia:this.paispasantia, institucionpasantia:this.institucionpasantia, fechafinal:this.fechafinal, fechainicio:this.fechainicio, monto:this.monto, resolucions:this.resolucions, tipo:this.tipo, dependencia:this.dependencia, observaciones:this.observaciones}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getAlumno(this.thispage);
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




   borrar:function (alumno) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Registro de Pasantía Seleccionada? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'pasantia/'+alumno.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getAlumno(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (alumno) {

       this.cerrarFormNuevo();


       this.fillalumnos.id=alumno.id;
       this.fillalumnos.tipodoc=alumno.tipodoc;
       this.fillalumnos.doc=alumno.doc;
       this.fillalumnos.nombres=alumno.nombres;
       this.fillalumnos.apellidopat=alumno.apellidopat;
       this.fillalumnos.apellidomat=alumno.apellidomat;
       this.fillalumnos.genero=alumno.genero;
       this.fillalumnos.estadocivil=alumno.estadocivil;
       this.fillalumnos.fechanac=alumno.fechanac;
       this.fillalumnos.esdiscapacitado=alumno.esdiscapacitado;
       this.fillalumnos.discapacidad=alumno.discapacidad;
       this.fillalumnos.pais=alumno.pais;
       this.fillalumnos.departamento=alumno.departamento;
       this.fillalumnos.provincia=alumno.provincia;
       this.fillalumnos.distrito=alumno.distrito;
       this.fillalumnos.direccion=alumno.direccion;
       this.fillalumnos.email=alumno.email;
       this.fillalumnos.telefono=alumno.telefono;


       /*

    this.escuela_id=0;
    this.modalidads='';
    this.concepto='';
    this.pais='';
    this.institucion='';
    this.fechainicio='';
    this.fechafinal='';
    this.monto='';
    this.resolucions='';
    this.tipo=3;
    this.dependencia='';
    this.observaciones='';

    */

       this.fillalumnos.escuela_id=alumno.escuela_id;
       this.fillalumnos.modalidads=alumno.modalidads;
       this.fillalumnos.concepto=alumno.concepto;
       this.fillalumnos.paispasantia=alumno.paispasantia;
       this.fillalumnos.institucionpasantia=alumno.institucionpasantia;
       this.fillalumnos.fechainicio=alumno.fechainicio;
       this.fillalumnos.fechafinal=alumno.fechafinal;
       this.fillalumnos.monto=alumno.monto;
       this.fillalumnos.resolucions=alumno.resolucions;
       this.fillalumnos.tipo=alumno.tipo;
       this.fillalumnos.dependencia=alumno.dependencia;
       this.fillalumnos.observaciones=alumno.observaciones;
       this.fillalumnos.persona_id=alumno.persona_id;
   

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="pasantia/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillalumnos).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getAlumno(this.thispage);
           this.fillalumnos={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','escuela_id':'','modalidads':'','concepto':'','paispasantia':'','institucionpasantia':'','fechainicio':'','fechafinal':'','monto':'','resolucions':'','tipo':'','dependencia':'','observaciones':''};
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
    //window.location="alumnos/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="alumnos/imprimirExcel/"+3;
   },
}
});
</script>