<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Tablas Maestras",
       subtitulo: "{{$facultad->nombre}}",
       subtitulo2: "Principal",

   subtitle2:true,
   subtitulo2:"Datos de Facultad",

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
   classTitle:'fa fa-mortar-board',
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

   locals: [],
   datosfacultad: [],
   errors:[],

   fillDatosfacultad:{'id':'', 'nombre':'', 'cantidad':'','cantidad2':'','tipodato_id':'','facultad_id':'','semestre_id':'','tiporeg':''},

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

   semestre_id:0,
   nombre:'',
   cantidad:'',
   cantidad2:'',


   tiporeg:0,
   tipo:0,

},
created:function () {
   this.getDatosFacultad(this.thispage);

   $("#cbslocalE").select2();
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
   getDatosFacultad: function () {
       var busca=this.buscar;
       var url = '/datosfacultad?idFacu='+{{$facultad->id}}+'&busca='+busca;

       axios.get(url).then(response=>{
           this.datosfacultad= response.data.datosfacultad;

           if(this.datosfacultad.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },
   changePage:function (page) {
       this.pagination.current_page=page;
       this.getDatosFacultad(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getDatosFacultad();
       this.thispage='1';
   },
   nuevo:function (tip,nombre,t) {

       this.tiporeg=tip;
       this.tipo=t;

       /* console.log(tip);
       console.log(t);
       console.log(t); */
       
       $("#boxTituloN").text(nombre);
       $("#modalGuardar").modal('show');

       this.$nextTick(function () {
       this.cancelFormNuevo();
     })
       
   },

   cancelFormNuevo: function () {
    this.semestre_id=0;
    this.nombre='';
    this.cantidad='';
    this.cantidad2='';
       $(".form-control").css("border","1px solid #d2d6de");
   },
   create:function () {

       //alert("llega aca");

       var url='/datosfacultad';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
      
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");

       axios.post(url,{facultad_id:{{$facultad->id}}, tipodato_id:this.tipo, semestre_id:this.semestre_id, nombre:this.nombre, cantidad:this.cantidad, cantidad2:this.cantidad2,tiporeg:this.tiporeg}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getDatosFacultad(this.thispage);
               this.errors=[];
               $("#modalGuardar").modal('hide');
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
   borrar:function (datos,tipo) {


    
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

                var url = '/datosfacultad/'+datos.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getDatosFacultad(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },
   edit:function (datosFacultad,t) {

       this.fillDatosfacultad.id=datosFacultad.id;
       this.fillDatosfacultad.nombre=datosFacultad.nombre;
       this.fillDatosfacultad.cantidad=datosFacultad.cantidad;
       this.fillDatosfacultad.cantidad2=datosFacultad.cantidad2;
       this.fillDatosfacultad.tipodato_id=datosFacultad.tipodato_id;
       this.fillDatosfacultad.facultad_id=datosFacultad.facultad_id;
       this.fillDatosfacultad.semestre_id=datosFacultad.semestre_id;
       this.fillDatosfacultad.tiporeg=t;

       this.tiporeg=t;

      
      

       $("#boxTitulo").text("Editar "+datosFacultad.tipodato);
       $("#modalEditar").modal('show');

       $("#modalEditar").modal('show');

       $("#txtfacE").focus();
   },
   update:function (id) {
       var url="/datosfacultad/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       this.fillDatosfacultad.local_id=$("#cbslocalE").val();

       axios.put(url, this.fillDatosfacultad).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getDatosFacultad(this.thispage);
           this.fillLocal={'id':'', 'nombre':'', 'cantidad':'','cantidad2':'','tipodato_id':'','facultad_id':'','semestre_id':'','tiporeg':''};
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
   bajafacultad:function (facultad) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar la Facultad seleccionada",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'facultad/altabaja/'+facultad.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getDatosFacultad(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altafacultad:function (facultad) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar la Facultad seleccionada",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'facultad/altabaja/'+facultad.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getDatosFacultad(app.thispage);//listamos
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