<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Bienestar Universitario",
       subtitulo: "Gestión de Programas de Salud",
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
   classTitle:'fa fa-medkit',
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

   programassaluds: [],
   errors:[],

   fillprogramassalud:{'id':'', 'nombre':'','descripcion':'','tipo':'','cantidadAtenciones':'','fechaini':'','fechafin':'','lugar':''},

   tipogen:2,

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

   nombre:'',
   descripcion:'',
   cantidadAtenciones:'',
   fechaini:'',
   fechafin:'',
   lugar:'',
   tipo:2,



},
created:function () {
   this.getProgramasSaluds(this.thispage);
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
   getProgramasSaluds: function (page) {
       var busca=this.buscar;
       var url = 'programasalud?page='+page+'&busca='+busca+'&tipo='+this.tipogen;

       axios.get(url).then(response=>{
           this.programassaluds= response.data.programassaluds.data;
           this.pagination= response.data.pagination;

           if(this.programassaluds.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getProgramasSaluds(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getProgramasSaluds();
       this.thispage='1';
   },
   nuevo:function () {
       this.divNuevo=true;
       //$("#txtespecialidad").focus();
       //$('#txtespecialidad').focus();
       this.$nextTick(function () {
       this.cancelFormNuevo();
     })
       
   },
   cerrarFormNuevo: function () {
       this.divNuevo=false;
       this.cancelFormNuevo();
   },
   cancelFormNuevo: function () {
       $('#txtnombre').focus();

        this.nombre='';
        this.descripcion='';
        this.cantidadAtenciones='';
        this.fechaini='';
        this.fechafin='';
        this.lugar='';
        this.tipo=2;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtnombre').focus();
   },
   create:function () {
       var url='programasalud';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{nombre:this.nombre, descripcion:this.descripcion, tipo:this.tipo,cantidadAtenciones:this.cantidadAtenciones, fechaini:this.fechaini, fechafin:this.fechafin, lugar:this.lugar  }).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getProgramasSaluds(this.thispage);
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
   borrar:function (programasalud) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar la Campaña de Salud Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'programasalud/'+programasalud.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getProgramasSaluds(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   editar:function (programasalud) {

       this.fillprogramassalud.id=programasalud.id;
       this.fillprogramassalud.nombre=programasalud.nombre;
       this.fillprogramassalud.descripcion=programasalud.descripcion;
       this.fillprogramassalud.tipo=programasalud.tipo;
       this.fillprogramassalud.cantidadAtenciones=programasalud.cantidadAtenciones;
       this.fillprogramassalud.fechaini=programasalud.fechaini;
       this.fillprogramassalud.fechafin=programasalud.fechafin;
       this.fillprogramassalud.lugar=programasalud.lugar;


       $("#boxTitulo").text('Campaña de Salud: '+programasalud.nombre);
       $("#modalEditar").modal('show');

       $("#txtnombreE").focus();
   },
   update:function (id) {
       var url="programasalud/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillprogramassalud).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getProgramasSaluds(this.thispage);
           this.fillprogramassalud={'id':'', 'nombre':'','descripcion':'','tipo':'','cantidadAtenciones':'','fechaini':'','fechafin':'','lugar':''};
           this.errors=[];
           $("#modalEditar").modal('hide');
           toastr.success(response.data.msj);

           }else{
               $('#'+response.data.selector).focus();
               toastr.error(response.data.msj);
           }

       }).catch(error=>{
           this.errors=error.response.data
       })
   },



   bajabanco:function (banco) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar este Banco",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'banco/altabaja/'+banco.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getProgramasSaluds(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altabanco:function (banco) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar el Banco",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'banco/altabaja/'+banco.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getProgramasSaluds(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
}
});
</script>