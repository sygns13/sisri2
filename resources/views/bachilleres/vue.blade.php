<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Grados y Títulos",
       subtitulo: "Bachilleres",
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

   fillbachilleres:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','escuela_id':'','nombreGrado':'','programaEstudios':'','fechaEgreso':'','idioma':'','modalidadObtencion':'','numResolucion':'','fechaResol':'','numeroDiploma':'','autoridadRector':'','fechaEmision':'','observaciones':'','persona_id':'','tipo':'','trabajoinvestigacion':''},

   tipoGeneral:1,

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
    

    tipo:1,

    persona_id:'0',      

    tipoGeneral:1, 

    divNuevoImporte:false,
    divloaderNuevoImporte:false,
    uploadReady: true,
    archivo:[],


},
created:function () {
   this.getBachilleres(this.thispage);

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



   getBachilleres: function (page) {
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
       this.getBachilleres(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getBachilleres();
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


    this.tipo=1;

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


    this.tipo=1;

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
               this.getBachilleres(this.thispage);
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
             text: "¿Desea eliminar el Registro de Bachiller Seleccionado? -- Nota: este proceso no se podrá revertir.",
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
                    app.getBachilleres(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (bachiller) {

       this.cerrarFormNuevo();


       this.fillbachilleres.id=bachiller.id;
       this.fillbachilleres.tipodoc=bachiller.tipodoc;
       this.fillbachilleres.doc=bachiller.doc;
       this.fillbachilleres.nombres=bachiller.nombres;
       this.fillbachilleres.apellidopat=bachiller.apellidopat;
       this.fillbachilleres.apellidomat=bachiller.apellidomat;
       this.fillbachilleres.genero=bachiller.genero;
       this.fillbachilleres.estadocivil=bachiller.estadocivil;
       this.fillbachilleres.fechanac=bachiller.fechanac;
       this.fillbachilleres.esdiscapacitado=bachiller.esdiscapacitado;
       this.fillbachilleres.discapacidad=bachiller.discapacidad;
       this.fillbachilleres.pais=bachiller.pais;
       this.fillbachilleres.departamento=bachiller.departamento;
       this.fillbachilleres.provincia=bachiller.provincia;
       this.fillbachilleres.distrito=bachiller.distrito;
       this.fillbachilleres.direccion=bachiller.direccion;
       this.fillbachilleres.email=bachiller.email;
       this.fillbachilleres.telefono=bachiller.telefono;

       this.fillbachilleres.escuela_id=bachiller.escuela_id;
       this.fillbachilleres.nombreGrado=bachiller.nombreGrado;
       this.fillbachilleres.programaEstudios=bachiller.programaEstudios;
       this.fillbachilleres.fechaEgreso=bachiller.fechaEgreso;
       this.fillbachilleres.idioma=bachiller.idioma;
       this.fillbachilleres.modalidadObtencion=bachiller.modalidadObtencion;
       this.fillbachilleres.numResolucion=bachiller.numResolucion;
       this.fillbachilleres.fechaResol=bachiller.fechaResol;
       this.fillbachilleres.numeroDiploma=bachiller.numeroDiploma;
       this.fillbachilleres.autoridadRector=bachiller.autoridadRector;
       this.fillbachilleres.fechaEmision=bachiller.fechaEmision;
       this.fillbachilleres.observaciones=bachiller.observaciones;
       this.fillbachilleres.persona_id=bachiller.persona_id;
       this.fillbachilleres.tipo=bachiller.tipo;
       this.fillbachilleres.trabajoinvestigacion=bachiller.trabajoinvestigacion;
      

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

       axios.put(url, this.fillbachilleres).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getBachilleres(this.thispage);
           this.fillbachilleres={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','escuela_id':'','nombreGrado':'','programaEstudios':'','fechaEgreso':'','idioma':'','modalidadObtencion':'','numResolucion':'','fechaResol':'','numeroDiploma':'','autoridadRector':'','fechaEmision':'','observaciones':'','persona_id':'','tipo':'','trabajoinvestigacion':''};
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
            var url='bachiller/importardata1';
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
                    this.getBachilleres(this.thispage);
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
}
});
</script>