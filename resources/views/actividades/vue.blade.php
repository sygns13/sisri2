<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Bioseguridad y Defensa Civil",
       subtitulo: "Registro de Actividades",
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
   classTitle:'fa fa-empire',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'active',
   classMenu11:'',
   classMenu12:'',


   divprincipal:true,

   actividades: [],
   errors:[],

   fillactividaddes:{'actividad':'', 'descripcion':'', 'oficinas':'','lugar':'','beneficiarios':'','organizadores':'','fecha':''},

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

  
   actividad:'',
   descripcion:'',
   oficinas:'',
   lugar:'',
   beneficiarios:'',
   organizadores:'',
   fecha:'',


},
created:function () {
   this.getActividades(this.thispage);
   

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

   getActividades: function (page) {
       var busca=this.buscar;
       var url = 'actividad?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.actividades= response.data.actividades.data;
           this.pagination= response.data.pagination;

           

           if(this.actividades.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getActividades(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getActividades();
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


    this.actividad='';
    this.descripcion='';
    this.oficinas='';
    this.lugar='';
    this.beneficiarios='';
    this.organizadores='';
    this.fecha='';

    this.formularioCrear=true;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtactividad').focus();
   },


   create:function () {
       var url='actividad';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{actividad:this.actividad, descripcion:this.descripcion, oficinas:this.oficinas, lugar:this.lugar, beneficiarios:this.beneficiarios, organizadores:this.organizadores, fecha:this.fecha}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getActividades(this.thispage);
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




   borrar:function (actividad) {


    
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

                var url = 'actividad/'+actividad.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getActividades(app.thispage);//listamos
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

   edit:function (actividad) {

       this.cerrarFormNuevo();


       this.fillactividaddes.id=actividad.id;
       this.fillactividaddes.actividad=actividad.actividad;
       this.fillactividaddes.descripcion=actividad.descripcion;
       this.fillactividaddes.oficinas=actividad.oficinas;
       this.fillactividaddes.lugar=actividad.lugar;
       this.fillactividaddes.beneficiarios=actividad.beneficiarios;
       this.fillactividaddes.organizadores=actividad.organizadores;
       this.fillactividaddes.fecha=actividad.fecha;


        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtactividadE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="actividad/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillactividaddes).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getActividades(this.thispage);
           this.fillactividaddes={'actividad':'', 'descripcion':'', 'oficinas':'','lugar':'','beneficiarios':'','organizadores':'','fecha':''};
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
    //window.location="actividades/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="actividad/imprimirExcel/";
   },
}
});
</script>