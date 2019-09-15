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
       
       subtitulo2: "Gestión de Cantidad de Atenciones",

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
   classTitle:'fa fa-bar-chart',
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

   atencions: [],
   errors:[],

   fillatenciones:{'anio':'', 'mes':'', 'cantidad':'','programassalud_id':'','tipoatencion':'','observaciones':''},

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

   anio:'',
   mes:'0',
   cantidad:'',
   programassalud_id:{{$programassalud->id}},
   tipobeneficiario:'1',
   observaciones:'',

    

    programasalud:{{$programassalud->id}}, 

    tipopadre:{{$programassalud->tipo}}, 


},
created:function () {
   this.getatencions(this.thispage);

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
},

methods: {



   getatencions: function (page) {
       var busca=this.buscar;
       var url = '/atencion?page='+page+'&busca='+busca+'&programasalud='+this.programasalud;

       axios.get(url).then(response=>{
           this.atencions= response.data.atencions.data;
           this.pagination= response.data.pagination;

           

           if(this.atencions.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getatencions(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getatencions();
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


    this.anio='';
    this.mes='0';
    this.cantidad='';
    this.programassalud_id={{$programassalud->id}};
    this.tipobeneficiario='1';
    this.observaciones='';

    this.formularioCrear=true;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtanio').focus();
   },




   create:function () {
       var url='/atencion';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{anio:this.anio, mes:this.mes, cantidad:this.cantidad, programassalud_id:this.programassalud_id, tipobeneficiario:this.tipobeneficiario, observaciones:this.observaciones}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getatencions(this.thispage);
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




   borrar:function (atencion) {


    
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

                var url = '/atencion/'+atencion.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getatencions(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },




   edit:function (atencion) {

       this.cerrarFormNuevo();


       this.fillatenciones.id=atencion.id;
       this.fillatenciones.anio=atencion.anio;
       this.fillatenciones.mes=atencion.mes;
       this.fillatenciones.cantidad=atencion.cantidad;
       this.fillatenciones.programassalud_id=atencion.programassalud_id;
       this.fillatenciones.tipobeneficiario=atencion.tipobeneficiario;
       this.fillatenciones.observaciones=atencion.observaciones;
     

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txtanio").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="/atencion/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillatenciones).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getatencions(this.thispage);
           this.fillatenciones={'anio':'', 'mes':'', 'cantidad':'','programassalud_id':'','tipoatencion':'','observaciones':''};
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
    //window.location="atencions/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="atencions/imprimirExcel/"+3;
   },
}
});
</script>