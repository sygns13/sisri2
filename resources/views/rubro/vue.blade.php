<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Mantenimiento",
       subtitulo: "Gestión de Rubros",
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
   classTitle:'fa fa-qrcode ',
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

   categorias: [],
   rubros: [],
   errors:[],

   fillRubro:{'id':'', 'descripcion':'', 'code':'','estado':'','categoria_id':''},

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

   newRubro:'',
   newCodigo:'',
   newEstado:'1',
   newCategoria:'',



},
created:function () {
   this.getRubro(this.thispage);

   $("#cbsCategoriaE").select2();
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
   getRubro: function (page) {
       var busca=this.buscar;
       var url = 'rubro?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.rubros= response.data.rubros.data;
           this.pagination= response.data.pagination;
           this.categorias= response.data.categorias;

           if(this.rubros.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getRubro(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getRubro();
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
       $('#txtdesc').focus();
       this.newRubro='';
       this.newCodigo='';
       this.newEstado='1';

       this.newCategoria='';

       $("#cbsCategoria").select2();
       $('#cbsCategoria').val('').trigger('change');

       $(".form-control").css("border","1px solid #d2d6de");
   },
   create:function () {

       this.newCategoria=$("#cbsCategoria").val();
       var url='rubro';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{descripcion:this.newRubro, code:this.newCodigo, estado:this.newEstado, categoria_id:this.newCategoria}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getRubro(this.thispage);
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
   borrarrubro:function (rubro) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Rubro Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'rubro/'+rubro.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getRubro(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   editrubro:function (rubro) {

       this.fillRubro.id=rubro.id;
       this.fillRubro.descripcion=rubro.descripcion;
       this.fillRubro.code=rubro.code;
       this.fillRubro.estado=rubro.estado;
       this.fillRubro.categoria_id=rubro.categoria_id;
       
       $("#cbsCategoriaE").select2();
       this.$nextTick(function () {
       $("#cbsCategoriaE").val( this.fillRubro.categoria_id).trigger('change');
       $('.select2').css("width","100%");
        });

       $("#boxTitulo").text('Rubro: '+rubro.descripcion);
       $("#modalEditar").modal('show');

       $("#txtdescE").focus();
   },
   updateRubro:function (id) {
       var url="rubro/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       this.fillRubro.categoria_id=$("#cbsCategoriaE").val();

       axios.put(url, this.fillRubro).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getRubro(this.thispage);
           this.fillLocal={'id':'', 'descripcion':'', 'code':'','estado':'','categoria_id':''};
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
   bajarubro:function (rubro) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar el Rubro seleccionado",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'rubro/altabaja/'+rubro.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getRubro(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altarubro:function (rubro) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar el Rubro seleccionado",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'rubro/altabaja/'+rubro.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getRubro(app.thispage);//listamos
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