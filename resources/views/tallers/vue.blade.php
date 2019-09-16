<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Proyección Social",
       subtitulo: "Talleres",
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
   classTitle:'fa fa-star-half-o',
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

   tallers: [],
   docentes: [],
   errors:[],

   filltalleres:{'id':'','nombre':'','descripcion':'','docente_id':'','semestre_id':''},

  
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
    docente_id:0,

    
    contse:{{$contse}},
    semestreNombre:'{{$semestreNombre}}',


},
created:function () {
   this.gettallers(this.thispage);

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



   gettallers: function (page) {
       var busca=this.buscar;
       var url = 'taller?page='+page+'&busca='+busca+'&semestre_id='+this.semestre_id;

       axios.get(url).then(response=>{
           this.tallers= response.data.tallers.data;
           this.pagination= response.data.pagination;
           this.docentes= response.data.docentes;

           

           if(this.tallers.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.gettallers(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.gettallers();
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
    this.docente_id=0;
    this.semestre_id={{$semestresel}};


    this.formularioCrear=true;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtnombre').focus();
   },

  


   create:function () {
       var url='taller';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{nombre:this.nombre, descripcion:this.descripcion, docente_id:this.docente_id, semestre_id:this.semestre_id}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.gettallers(this.thispage);
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




   borrar:function (taller) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Taller Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'taller/'+taller.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.gettallers(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (taller) {

       this.cerrarFormNuevo();


       this.filltalleres.id=taller.id;
       this.filltalleres.nombre=taller.nombre;
       this.filltalleres.descripcion=taller.descripcion;
       this.filltalleres.docente_id=taller.docente_id;
       this.filltalleres.semestre_id=taller.semestre_id;

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtnombreE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="taller/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.filltalleres).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.gettallers(this.thispage);
           this.filltalleres={'id':'','nombre':'','descripcion':'','docente_id':'','semestre_id':''};
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
    //window.location="tallers/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="tallers/imprimirExcel/"+3;
   },
}
});
</script>