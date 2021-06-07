<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Proyección Social",
       subtitulo: "Eventos Culturales",
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
   classTitle:'fa fa-video-camera',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'active',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   eventos: [],
   errors:[],

   fillevento:{'id':'','nombre':'','descripcion':'','lugarpresentacion':'','fechainicio':'','fechafinal':'','semestre_id':'','entidad':'','observaciones':''},

  
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
   formularioCrear:true,



    semestre_id:{{$semestresel}},
    
    nombre:'',
    descripcion:'',
    lugarpresentacion:'',
    fechainicio:'',
    fechafinal:'',
    entidad:'',
    observaciones:'',
    
    contse:{{$contse}},
    semestreNombre:'{{$semestreNombre}}',

    idSubmodulo:0,
    motivoProrroga:'',
    divloaderProrroga:false   


},
created:function () {
   this.geteventos(this.thispage);

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



   geteventos: function (page) {
       var busca=this.buscar;
       var url = 'evento?page='+page+'&busca='+busca+'&semestre_id='+this.semestre_id;

       axios.get(url).then(response=>{
           this.eventos= response.data.eventos.data;
           this.pagination= response.data.pagination;

           

           if(this.eventos.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.geteventos(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.geteventos();
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



    this.nombre='';
    this.descripcion='';
    this.lugarpresentacion='';
    this.fechainicio='';
    this.fechafinal='';
    this.entidad='';
    this.observaciones='';


    this.formularioCrear=true;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtnombre').focus();
   },

  


   create:function () {
       var url='evento';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{nombre:this.nombre, descripcion:this.descripcion, lugarpresentacion:this.lugarpresentacion, fechainicio:this.fechainicio, fechafinal:this.fechafinal, semestre_id:this.semestre_id, entidad:this.entidad, observaciones:this.observaciones }).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.geteventos(this.thispage);
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




   borrar:function (evento) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Evento Cultural Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'evento/'+evento.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.geteventos(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (evento) {

       this.cerrarFormNuevo();


       this.fillevento.id=evento.id;
       this.fillevento.nombre=evento.nombre;
       this.fillevento.descripcion=evento.descripcion;
       this.fillevento.lugarpresentacion=evento.lugarpresentacion;
       this.fillevento.fechainicio=evento.fechainicio;
       this.fillevento.fechafinal=evento.fechafinal;
       this.fillevento.semestre_id=evento.semestre_id;
       this.fillevento.entidad=evento.entidad;
       this.fillevento.observaciones=evento.observaciones;

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtnombreE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="evento/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillevento).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.geteventos(this.thispage);
           this.fillevento={'id':'','nombre':'','descripcion':'','lugarpresentacion':'','fechainicio':'','fechafinal':'','semestre_id':'','entidad':'','observaciones':''};
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

        $("#boxTituloProrroga").text('Submódulo: Gestión de Eventos Culturales');
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