<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Bienestar Universitario",
       subtitulo: "Condición Económica de los Estudiantes",
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
   classMenu5:'',
   classMenu6:'active',
   classMenu7:'',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   alumnos: [],
   errors:[],

   fillalumnos:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','codigo':'','numhermanos':'','numhermanosunasam':'','puestopadre':'','puestomadre':'','ingresomensualfamiliar':'','condicionviivienda':'','tieneseguro':'','nombreseguro':'','estalaborando':'','semestre_id':'','id':'', 'persona_id':''},

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

    semestre_id:{{$semestresel}},
    
    codigo:'',
    numhermanos:'',
    numhermanosunasam:'',
    puestopadre:'',
    puestomadre:'',
    ingresomensualfamiliar:'',
    condicionviivienda:'',
    tieneseguro:'1',
    nombreseguro:'',
    estalaborando:'0',
 
    contse:{{$contse}},
    semestreNombre:'{{$semestreNombre}}',

    persona_id:'0',       


    idSubmodulo:0,
    motivoProrroga:'',
    divloaderProrroga:false 


},
created:function () {
   this.getAlumno(this.thispage);

},
mounted: function () {
   this.divloader0=false;
   this.divprincipal=true;
   $("#divtitulo").show('slow');

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



   getAlumno: function (page) {
       var busca=this.buscar;
       var url = 'condicioneconomica?page='+page+'&busca='+busca+'&semestre_id='+this.semestre_id;

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

    this.codigo='';
    this.numhermanos='';
    this.numhermanosunasam='';
    this.puestopadre='';
    this.puestomadre='';
    this.ingresomensualfamiliar='';
    this.condicionviivienda='';
    this.tieneseguro='1';
    this.nombreseguro='';
    this.estalaborando='0';

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

        this.formularioCrear=true;

        this.$nextTick(function () {
                $("#txtapepat").focus();
            });

        }else{

            this.nombres='';
            this.apellidopat='';
            this.apellidomat='';

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

    semestre_id:{{$semestresel}},
    
    codigo:'',
    escuela_id:0,
    observaciones:'',

    */

   create:function () {
       var url='condicioneconomica';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{tipodoc:this.tipodoc, doc:this.doc, nombres:this.nombres, apellidopat:this.apellidopat, apellidomat:this.apellidomat, codigo:this.codigo, numhermanos:this.numhermanos, numhermanosunasam:this.numhermanosunasam,puestopadre:this.puestopadre, puestomadre:this.puestomadre, ingresomensualfamiliar:this.ingresomensualfamiliar, condicionviivienda:this.condicionviivienda, tieneseguro:this.tieneseguro, nombreseguro:this.nombreseguro, estalaborando:this.estalaborando, semestre_id:this.semestre_id, persona_id:this.persona_id  }).then(response=>{
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
             text: "¿Desea eliminar el registro Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'condicioneconomica/'+alumno.id;
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


/*

    semestre_id:{{$semestresel}},
    
    codigo:'',
    escuela_id:0,
    observaciones:'',

    */

   edit:function (alumno) {

       this.cerrarFormNuevo();


       this.fillalumnos.id=alumno.id;
       this.fillalumnos.tipodoc=alumno.tipodoc;
       this.fillalumnos.doc=alumno.doc;
       this.fillalumnos.nombres=alumno.nombres;
       this.fillalumnos.apellidopat=alumno.apellidopat;
       this.fillalumnos.apellidomat=alumno.apellidomat;

       this.fillalumnos.semestre_id=alumno.semestre_id;
       this.fillalumnos.persona_id=alumno.persona_id;

       this.fillalumnos.codigo=alumno.codigo;
       this.fillalumnos.numhermanos=alumno.numhermanos;
       this.fillalumnos.numhermanosunasam=alumno.numhermanosunasam;
       this.fillalumnos.puestopadre=alumno.puestopadre;
       this.fillalumnos.puestomadre=alumno.puestomadre;
       this.fillalumnos.ingresomensualfamiliar=alumno.ingresomensualfamiliar;
       this.fillalumnos.condicionviivienda=alumno.condicionviivienda;
       this.fillalumnos.tieneseguro=alumno.tieneseguro;
       this.fillalumnos.nombreseguro=alumno.nombreseguro;
       this.fillalumnos.estalaborando=alumno.estalaborando;


        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtDNIE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="condicioneconomica/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillalumnos).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getAlumno(this.thispage);
           this.fillalumnos={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','codigo':'','numhermanos':'','numhermanosunasam':'','puestopadre':'','puestomadre':'','ingresomensualfamiliar':'','condicionviivienda':'','tieneseguro':'','nombreseguro':'','estalaborando':'','semestre_id':'','id':'', 'persona_id':''};
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


   nuevaProrroga:function (id) {

        this.idSubmodulo = id;
        this.motivoProrroga = '';

        $("#boxTituloProrroga").text('Submódulo: Gestión de la Condición Socioeconómica de estudiantes');
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