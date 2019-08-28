<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Reporte de Tablas Maestras",
       subtitulo: "Conceptos de Pago",
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
   classTitle:'fa fa-money',
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

   rubros: [],
   entidads: [],
   precios: [],
   errors:[],

   fillPrecio:{'id':'', 'descripcion':'', 'codigo':'','estado':'','monto':'','rubro_id':'','entidad_id':''},

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
   divloaderNuevo:false,
   divloaderEdit:false,

   thispage:'1',

   newPrecio:'',
   newCodigo:'',
   newMonto:'',
   newEntidad:'',
   newRubro:'',
   newEstado:'1',

   dataimp:[],
},
created:function () {
   this.getPrecio(this.thispage);

   $("#cbsfacultadE").select2();
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
   getPrecio: function (page) {
       var busca=this.buscar;
       var url = 'precio?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.precios= response.data.precios.data;
           this.pagination= response.data.pagination;
           this.rubros= response.data.rubros;
           this.entidads= response.data.entidads;

           if(this.precios.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getPrecio(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getPrecio();
       this.thispage='1';
   },
   

   imprimirReporte(){


var url="precio/buscarDatosImp";

this.divloaderNuevo=true;
$("#btncrearReporte").attr('disabled', true);
axios.post(url,{busca:this.buscar}).then(response=>{

    this.divloaderNuevo=false;
    $("#btncrearReporte").removeAttr("disabled");
   this.dataimp= response.data.dataimp;

   this.$nextTick(function () {

    var options = { extraHead : '<style rel="stylesheet" type="text/css" media="print">@page { size: landscape; } body {-webkit-print-color-adjust: exact; } #divImp{width: 30cm!important; } .saltoDePagina{ display:block; page-break-before:always;} #btncrearArea{display: none!important;} #btnvolver1{display: none!important;} #btnvolver2{display: none!important;} #tablaNoPrint{display: none!important;} #tablaPrint{display: block!important;} #titulo1{padding-top: 0px!important;} .logorep{ top:0mm!important;} #tablerep2{width:9cm;} #titulo7{display: block!important;} #tablelast{width:50%!important;} .divResult{display: none!important;}</style>', strict:false  };

    $("#divImp").printArea(options);
    });


}).catch(error=>{
   this.errors=error.response.data
})



},
   
   
   
   
   
}
});
</script>