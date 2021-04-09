<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Mantenimiento",
       subtitulo: "Gestión de Conceptos de Pago",
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
        this.newPrecio='';
        this.newCodigo='';
        this.newMonto='';
        this.newEntidad='';
        this.newRubro='';
        this.newEstado='1';

       $("#cbsEntidad").select2();
       $('#cbsEntidad').val('').trigger('change');

       $("#cbsRubro").select2();
       $('#cbsRubro').val('').trigger('change');

       $(".form-control").css("border","1px solid #d2d6de");
   },
   create:function () {

       this.newEntidad=$("#cbsEntidad").val();
       this.newRubro=$("#cbsRubro").val();

       var url='precio';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{descripcion:this.newPrecio, codigo:this.newCodigo, estado:this.newEstado, monto:parseFloat(this.newMonto).toFixed(2), rubro_id:this.newRubro, entidad_id:this.newEntidad}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getPrecio(this.thispage);
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
   borrarprecio:function (precio) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Concepto de Pago  Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'precio/'+precio.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getPrecio(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   editprecio:function (precio) {

       this.fillPrecio.id=precio.id;
       this.fillPrecio.descripcion=precio.descripcion;
       this.fillPrecio.codigo=precio.codigo;
       this.fillPrecio.estado=precio.estado;
       this.fillPrecio.monto=parseFloat(precio.monto).toFixed(2)
       this.fillPrecio.rubro_id=precio.rubro_id;
       this.fillPrecio.entidad_id=precio.entidad_id;


       $("#cbsRubroE").select2();
       this.$nextTick(function () {
       $("#cbsRubroE").val(precio.rubro_id).trigger('change');
       $('.select2').css("width","100%");
    });
       

    $("#cbsEntidadE").select2();
    this.$nextTick(function () {
       $("#cbsEntidadE").val(precio.entidad_id).trigger('change');
       $('.select2').css("width","100%");
    });

       $("#boxTitulo").text('Concepto de Pago: '+precio.descripcion);
       $("#modalEditar").modal('show');

       $("#txtdescE").focus();
   },
   updatePrecio:function (id) {
       var url="precio/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       this.fillPrecio.rubro_id=$("#cbsRubroE").val();
       this.fillPrecio.entidad_id=$("#cbsEntidadE").val();

       axios.put(url, this.fillPrecio).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getPrecio(this.thispage);
           this.fillLocal={'id':'', 'descripcion':'', 'codigo':'','estado':'','monto':'','rubro_id':'','entidad_id':''};
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
   bajaprecio:function (precio) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar el Concepto de Pago seleccionado",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'precio/altabaja/'+precio.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getPrecio(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altaprecio:function (precio) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar el Concepto de Pago seleccionado",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'precio/altabaja/'+precio.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getPrecio(app.thispage);//listamos
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