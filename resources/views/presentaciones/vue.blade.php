<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Proyección Social",
       subtitulo: "Taller {{$taller->nombre}}",
       subtitulo2: "Gestión de presentacions",

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
   classTitle:'fa fa-street-view',
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

   presentacions: [],
   errors:[],

   fillpresentacions:{'fecha':'', 'asistentes':'', 'detalle':'','taller_id':'','observaciones':''},

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


   fecha:'',
   asistentes:'',
   detalle:'',
   taller_id:{{$taller->id}},
   observaciones:'',

    taller:{{$taller->id}}, 


},
created:function () {
   this.getpresentacions(this.thispage);

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

filters: {
  fecha: function (value) {
    if (!value) return ''
    value = value.toString()
    return value.slice(8)+"/"+value.slice(5,7)+"/"+value.slice(0,4)
  },

  mescotejar:function (value) {
    if (!value) return ''
    value = parseInt(value.toString());
    switch (value) {
        case 1:
                return "ENERO";
            break;
        case 2:
                return "FEBRERO";
            break;
        case 3:
                return "MARZO";
            break;
        case 4:
                return "ABRIL";
            break;
        case 5:
                return "MAYO";
            break;
        case 6:
                return "JUNIO";
            break;
        case 7:
                return "JULIO";
            break;
        case 8:
                return "AGOSTO";
            break;
        case 8:
                return "AGOSTO";
            break;
        case 9:
                return "SETIEMBRE";
            break;
        case 10:
                return "OCTUBRE";
            break;
        case 11:
                return "NOVIEMBRE";
            break;
    
        case 12:
                return "DICIEMBRE";
            break;
    
        default:
                return "";
            break;
    }

    return value
  },
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



   getpresentacions: function (page) {
       var busca=this.buscar;
       var url = '/presentacion?page='+page+'&busca='+busca+'&taller='+this.taller;

       axios.get(url).then(response=>{
           this.presentacions= response.data.presentacions.data;
           this.pagination= response.data.pagination;

           

           if(this.presentacions.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getpresentacions(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getpresentacions();
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


    this.fecha='';
    this.asistentes='';
    this.detalle='';
    this.taller_id={{$taller->id}};
    this.observaciones='';

    this.formularioCrear=true;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtfecha').focus();
   },




   create:function () {
       var url='/presentacion';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{detalle:this.detalle, fecha:this.fecha, asistentes:this.asistentes, taller_id:this.taller_id,  observaciones:this.observaciones}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getpresentacions(this.thispage);
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




   borrar:function (presentacion) {


    
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

                var url = '/presentacion/'+presentacion.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getpresentacions(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (presentacion) {

       this.cerrarFormNuevo();


       this.fillpresentacions.id=presentacion.id;
       this.fillpresentacions.fecha=presentacion.fecha;
       this.fillpresentacions.asistentes=presentacion.asistentes;
       this.fillpresentacions.detalle=presentacion.detalle;
       this.fillpresentacions.taller_id=presentacion.taller_id;
       this.fillpresentacions.observaciones=presentacion.observaciones;
     

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtfechaE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="/presentacion/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillpresentacions).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getpresentacions(this.thispage);
           this.fillpresentacions={'fecha':'', 'asistentes':'', 'detalle':'','taller_id':'','observaciones':''};
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
    //window.location="presentacions/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="presentacions/imprimirExcel/"+3;
   },
}
});
</script>