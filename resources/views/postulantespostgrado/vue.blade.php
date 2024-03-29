<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Gestión Académica",
       subtitulo: "Postulantes de Postgrado",
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

   fillpostulantes:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','codigo':'','semestre_id':'','escuela_id':'','colegio':'','modalidadadmision_id':'','modalidadestudios':'','puntaje':'','estado':'','opcioningreso':'','observaciones':'','escuela_id2':'','tipogestioncolegio':'','persona_id':'','id':'','tipo':'','grado':'','nombreGrado':'','universidadCulminoPregrado':''},

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
    tipo:2,
    grado:3,
    nombreGrado:'',
    universidadCulminoPregrado:'',


    contse:{{$contse}},
    semestreNombre:'{{$semestreNombre}}',



    persona_id:'0',  

    tipoGen:'2',  

    divNuevoImporte:false,
    divloaderNuevoImporte:false,
    uploadReady: true,
    archivo:[], 
    
    idSubmodulo:0,
    motivoProrroga:'',
    divloaderProrroga:false


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

    cambiarSemestre:function(){

        this.semestreNombre=$("#txtseme"+this.semestre_id).val();

        this.$nextTick(function () {
            this.buscarBtn();
            });

    },



   getPostulante: function (page) {
       var busca=this.buscar;
       var url = 'postulantes?page='+page+'&busca='+busca+'&semestre_id='+this.semestre_id+'&tipo='+this.tipoGen;

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
    this.grado=3;
    this.nombreGrado='';
    this.universidadCulminoPregrado='';

    this.tipo=2;
    this.tipoGen=2;


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
    this.grado=3;
    this.nombreGrado='';
    this.universidadCulminoPregrado='';


*/

   create:function () {
       var url='postulantes';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, genero:this.genero, estadocivil:this.estadocivil, fechanac:this.fechanac,esdiscapacitado:this.esdiscapacitado, discapacidad:this.discapacidad, pais:this.pais, departamento:this.departamento, provincia:this.provincia, distrito:this.distrito, direccion:this.direccion, email:this.email, telefono:this.telefono, codigo:this.codigo, semestre_id:this.semestre_id, escuela_id:this.escuela_id, colegio:this.colegio, modalidadadmision_id:this.modalidadadmision_id, modalidadestudios:this.modalidadestudios, puntaje:this.puntaje, estado:this.estado, opcioningreso:this.opcioningreso, observaciones:this.observaciones, escuela_id2:this.escuela_id2, tipogestioncolegio:this.tipogestioncolegio, persona_id:this.persona_id, tipo:this.tipo,grado:this.grado, nombreGrado:this.nombreGrado, universidadCulminoPregrado:this.universidadCulminoPregrado,   }).then(response=>{
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

                var url = 'postulantes/'+postulante.id;
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


       this.fillpostulantes.id=postulante.id;
       this.fillpostulantes.tipodoc=postulante.tipodoc;
       this.fillpostulantes.doc=postulante.doc;
       this.fillpostulantes.nombres=postulante.nombres;
       this.fillpostulantes.apellidopat=postulante.apellidopat;
       this.fillpostulantes.apellidomat=postulante.apellidomat;
       this.fillpostulantes.genero=postulante.genero;
       this.fillpostulantes.estadocivil=postulante.estadocivil;
       this.fillpostulantes.fechanac=postulante.fechanac;
       this.fillpostulantes.esdiscapacitado=postulante.esdiscapacitado;
       this.fillpostulantes.discapacidad=postulante.discapacidad;
       this.fillpostulantes.pais=postulante.pais;
       this.fillpostulantes.departamento=postulante.departamento;
       this.fillpostulantes.provincia=postulante.provincia;
       this.fillpostulantes.distrito=postulante.distrito;
       this.fillpostulantes.direccion=postulante.direccion;
       this.fillpostulantes.email=postulante.email;
       this.fillpostulantes.telefono=postulante.telefono;
       this.fillpostulantes.codigo=postulante.codigo;
       this.fillpostulantes.semestre_id=postulante.semestre_id;
       this.fillpostulantes.escuela_id=postulante.escuela_id;
       this.fillpostulantes.colegio=postulante.colegio;
       this.fillpostulantes.modalidadadmision_id=postulante.modalidadadmision_id;
       this.fillpostulantes.modalidadestudios=postulante.modalidadestudios;
       this.fillpostulantes.puntaje=postulante.puntaje;
       this.fillpostulantes.estado=postulante.estado;
       this.fillpostulantes.opcioningreso=postulante.opcioningreso;
       this.fillpostulantes.observaciones=postulante.observaciones;
       this.fillpostulantes.escuela_id2=postulante.escuela_id2;
       this.fillpostulantes.tipogestioncolegio=postulante.tipogestioncolegio;
       this.fillpostulantes.persona_id=postulante.persona_id;
       this.fillpostulantes.tipo=postulante.tipo;
       this.fillpostulantes.grado=postulante.grado;
       this.fillpostulantes.nombreGrado=postulante.nombreGrado;
       this.fillpostulantes.universidadCulminoPregrado=postulante.universidadCulminoPregrado;


/*
    this.grado=3;
    this.nombreGrado='';
    this.universidadCulminoPregrado='';


*/



        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="postulantes/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillpostulantes).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getPostulante(this.thispage);
           this.fillpostulantes={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','codigo':'','semestre_id':'','escuela_id':'','colegio':'','modalidadadmision_id':'','modalidadestudios':'','puntaje':'','estado':'','opcioningreso':'','observaciones':'','escuela_id2':'','tipogestioncolegio':'','persona_id':'','id':'','tipo':'','grado':'','nombreGrado':'','universidadCulminoPregrado':''};
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
            var url='postulantesR/importardata';
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
                    this.getPostulante(this.thispage);
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

            $("#boxTituloProrroga").text('Submódulo: Gestión de Postulantes de Postgrado');
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