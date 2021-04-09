<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Tablas Maestras",
       subtitulo: "Gestión de Bancos",
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
   classTitle:'fa fa-bank',
   classMenu0:'',
   classMenu1:'active',
   classMenu2:'',
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

   bancos: [],
   errors:[],

   fillBanco:{'id':'', 'nombre':'','activo':''},

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

   newbanco:'',
   newactivo:'1',



},
created:function () {
   this.getBanco(this.thispage);
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
   getBanco: function (page) {
       var busca=this.buscar;
       var url = 'banco?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.bancos= response.data.bancos.data;
           this.pagination= response.data.pagination;

           if(this.bancos.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getBanco(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getBanco();
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
       $('#txtnom').focus();
       this.newbanco='';
       this.newactivo='1';

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtnom').focus();
   },
   create:function () {
       var url='banco';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{nombre:this.newbanco, activo:this.newactivo}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getBanco(this.thispage);
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
   borrarbanco:function (banco) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Banco Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'banco/'+banco.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getBanco(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   editbanco:function (banco) {

       this.fillBanco.id=banco.id;
       this.fillBanco.nombre=banco.nombre;
       this.fillBanco.activo=banco.activo;

       $("#boxTitulo").text('Banco: '+banco.nombre);
       $("#modalEditar").modal('show');

       $("#txtnomE").focus();
   },
   updateBanco:function (id) {
       var url="banco/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillBanco).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getBanco(this.thispage);
           this.fillBanco={'id':'', 'nombre':'','activo':''};
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
                           app.getBanco(app.thispage);//listamos
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
                           app.getBanco(app.thispage);//listamos
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