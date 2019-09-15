<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Bienestar Universitario",
       @if(intval($programassalud->tipo)==1)
       subtitulo: "Programa de Salud {{$programassalud->nombre}}",
	@elseif(intval($programassalud->tipo)==2)
        subtitulo: "Campaña de Salud {{$programassalud->nombre}}",
	@endif
       
       subtitulo2: "Gestión de Médicos",

   subtitle2:true,

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
   classTitle:'fa fa-user-md',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'',
   classMenu5:'',
   classMenu6:'active',
   classMenu7:'',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   medicos: [],
   errors:[],

   fillmedicos:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','persona_id':'', 'especialidad':'', 'fechaingreso':'','fechainiciocontrato':'','fechafincontrato':'','acargo':'','programassalud_id':'','observaciones':'','tipo':''},

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



    especialidad:'',
    fechaingreso:'',
    fechainiciocontrato:'',
    fechafincontrato:'',
    acargo:0,
    programassalud_id:{{$programassalud->id}},
    observaciones:'',
    tipo:1,

    persona_id:'0',      

    programasalud:{{$programassalud->id}}, 

    tipopadre:{{$programassalud->tipo}}, 


},
created:function () {
   this.getMedicos(this.thispage);

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



   getMedicos: function (page) {
       var busca=this.buscar;
       var url = '/medico?page='+page+'&busca='+busca+'&programasalud='+this.programasalud;

       axios.get(url).then(response=>{
           this.medicos= response.data.medicos.data;
           this.pagination= response.data.pagination;

           

           if(this.medicos.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getMedicos(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getMedicos();
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

    this.especialidad='';
    this.fechaingreso='';
    this.fechainiciocontrato='';
    this.fechafincontrato='';
    this.acargo=0;
    this.programassalud_id={{$programassalud->id}};
    this.observaciones='';
    this.tipo=1;
    this.programasalud={{$programassalud->id}}; 

    this.persona_id='0';

    this.formularioCrear=false;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtDNI').focus();
   },

   pressNuevoDNI: function() {

var url='/persona/buscarDNI';

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

    this.especialidad='';
    this.fechaingreso='';
    this.fechainiciocontrato='';
    this.fechafincontrato='';
    this.acargo=0;
    this.programassalud_id={{$programassalud->id}};
    this.observaciones='';
    this.tipo=1;
    this.programasalud={{$programassalud->id}}; 

    */

   create:function () {
       var url='/medico';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, genero:this.genero, estadocivil:this.estadocivil, fechanac:this.fechanac,esdiscapacitado:this.esdiscapacitado, discapacidad:this.discapacidad, pais:this.pais, departamento:this.departamento, provincia:this.provincia, distrito:this.distrito, direccion:this.direccion, email:this.email, telefono:this.telefono, especialidad:this.especialidad, fechaingreso:this.fechaingreso, fechainiciocontrato:this.fechainiciocontrato, acargo:this.acargo, programassalud_id:this.programassalud_id, observaciones:this.observaciones, tipo:this.tipo, programasalud:this.programasalud, persona_id:this.persona_id,fechafincontrato:this.fechafincontrato}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getMedicos(this.thispage);
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




   borrar:function (medico) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Registro Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = '/medico/'+medico.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getMedicos(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (medico) {

       this.cerrarFormNuevo();


       this.fillmedicos.id=medico.id;
       this.fillmedicos.tipodoc=medico.tipodoc;
       this.fillmedicos.doc=medico.doc;
       this.fillmedicos.nombres=medico.nombres;
       this.fillmedicos.apellidopat=medico.apellidopat;
       this.fillmedicos.apellidomat=medico.apellidomat;
       this.fillmedicos.genero=medico.genero;
       this.fillmedicos.estadocivil=medico.estadocivil;
       this.fillmedicos.fechanac=medico.fechanac;
       this.fillmedicos.esdiscapacitado=medico.esdiscapacitado;
       this.fillmedicos.discapacidad=medico.discapacidad;
       this.fillmedicos.pais=medico.pais;
       this.fillmedicos.departamento=medico.departamento;
       this.fillmedicos.provincia=medico.provincia;
       this.fillmedicos.distrito=medico.distrito;
       this.fillmedicos.direccion=medico.direccion;
       this.fillmedicos.email=medico.email;
       this.fillmedicos.telefono=medico.telefono;

       this.fillmedicos.persona_id=medico.persona_id;
       this.fillmedicos.especialidad=medico.especialidad;
       this.fillmedicos.fechaingreso=medico.fechaingreso;
       this.fillmedicos.fechainiciocontrato=medico.fechainiciocontrato;
       this.fillmedicos.fechafincontrato=medico.fechafincontrato;
       this.fillmedicos.acargo=medico.acargo;
       this.fillmedicos.programassalud_id=medico.programassalud_id;
       this.fillmedicos.observaciones=medico.observaciones;
       this.fillmedicos.tipo=medico.tipo;


        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="/medico/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillmedicos).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getMedicos(this.thispage);
           this.fillmedicos={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','persona_id':'', 'especialidad':'', 'fechaingreso':'','fechainiciocontrato':'','fechafincontrato':'','acargo':'','programassalud_id':'','observaciones':'','tipo':''};
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
    //window.location="medicos/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="medicos/imprimirExcel/"+3;
   },
}
});
</script>