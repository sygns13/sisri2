<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Tablas Maestras",
       subtitulo: "Gestión de Locales",
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
   classTitle:'fa fa-building-o',
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
   errors:[],

   fillLocal:{'id':'', 'nombre':'', 'direccion':'','activo':'','distrito_id':''},

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

   newlocal:'',
   newDir:'',
   newEstado:'1',

   distrito_id:0,
   provincia_id:0,
   departamento_id:0,
   paise_id:0,

   paises: [],
   departamentos: [],
   provincias: [],
   distritos: [],



   paisesE: [],
   departamentosE: [],
   provinciasE: [],
   distritosE: [],


   distrito_idE:0,
   provincia_idE:0,
   departamento_idE:0,
   paise_idE:0,



},
created:function () {
   this.getLocal(this.thispage);
   this.getPais();
   this.paise_id=1;
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
   getLocal: function (page) {
       var busca=this.buscar;
       var url = 'local?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.locals= response.data.locals.data;
           this.pagination= response.data.pagination;

           

           if(this.locals.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   getPais: function () {
       var url = 'pais';

       axios.get(url).then(response=>{
           this.paises= response.data.paises;
           this.paisesE= response.data.paises;
           this.departamento_id=0;

           this.$nextTick(function () {
            this.selectPais();
            })
           
      })
   },

   selectPais:function () {
          var url = 'local/cambiarPais/'+this.paise_id+'';
                            axios.get(url).then(response=>{
                                this.departamentos=response.data.departamentos;
                                this.provincias=[],
                                this.distritos=[],
                                this.departamento_id=0;
                                this.provincia_id=0;
                                this.distrito_id=0;
                       });


      },

    
      selectDepartamento:function () {
          var url = 'local/cambiarDepartamento/'+this.departamento_id+'';
                            axios.get(url).then(response=>{
                                this.provincias=response.data.provincias;
                                this.distritos=[],
                                this.provincia_id=0;
                                this.distrito_id=0;
                       });


      },

      selectProvincia:function () {
          var url = 'local/cambiarProvincia/'+this.provincia_id+'';
                            axios.get(url).then(response=>{
                                this.distritos=response.data.distritos;
                                this.distrito_id=0;
                       });


      },


   changePage:function (page) {
       this.pagination.current_page=page;
       this.getLocal(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getLocal();
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

    this.paise_id=1;
    this.$nextTick(function () {
       this.selectPais();
    })
       
       $('#txtnom').focus();
       this.newlocal='';
       this.newDir='';
       this.newEstado='1';

       $(".form-control").css("border","1px solid #d2d6de");

       $('#txtnom').focus();
   },
   create:function () {
       var url='local';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{nombre:this.newlocal, direccion:this.newDir, estado:this.newEstado, distrito_id:this.distrito_id}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getLocal(this.thispage);
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
   borrarlocal:function (local) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Local Seleccionado? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'local/'+local.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getLocal(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },


   selectPaisE:function () {
          var url = 'local/cambiarPais/'+this.paise_idE+'';
                            axios.get(url).then(response=>{
                                this.departamentosE=response.data.departamentos;
                                this.provinciasE=[],
                                this.distritosE=[],
                                this.departamento_idE=0;
                                this.provincia_idE=0;
                                this.fillLocal.distrito_id=0;
                       });


      },

    
      selectDepartamentoE:function () {
          var url = 'local/cambiarDepartamento/'+this.departamento_idE+'';
                            axios.get(url).then(response=>{
                                this.provinciasE=response.data.provincias;
                                this.distritosE=[],
                                this.provincia_idE=0;
                                this.fillLocal.distrito_id=0;
                       });


      },

      selectProvinciaE:function () {
          var url = 'local/cambiarProvincia/'+this.provincia_idE+'';
                            axios.get(url).then(response=>{
                                this.distritosE=response.data.distritos;
                                this.fillLocal.distrito_id=0;
                       });


      },


      selectPaisEI:function () {
          var url = 'local/cambiarPais/'+this.paise_idE+'';
                            axios.get(url).then(response=>{
                                this.departamentosE=response.data.departamentos;
                                this.provinciasE=[];
                                this.distritosE=[];
    
                       });


      },

    
      selectDepartamentoEI:function () {
          var url = 'local/cambiarDepartamento/'+this.departamento_idE+'';
                            axios.get(url).then(response=>{
                                this.provinciasE=response.data.provincias;
                                this.distritosE=[];
   
                       });


      },

      selectProvinciaEI:function () {
          var url = 'local/cambiarProvincia/'+this.provincia_idE+'';
                            axios.get(url).then(response=>{
                                this.distritosE=response.data.distritos;

                       });


      },



   editlocal:function (local) {

       /*
               filllocal:{'id':'', 'codigo':'', 'descripcion':'','codnum':'','eqcodcentral':'','jurisprudencia':'','visualiza':'','activo':''},

               */

       this.fillLocal.id=local.id;
       this.fillLocal.nombre=local.nombre;
       this.fillLocal.direccion=local.direccion;
       this.fillLocal.activo=local.activo;
       this.fillLocal.distrito_id=local.distrito_id;

       this.paise_idE=local.idPa;

       this.$nextTick(function () {
        this.selectPaisEI();
        this.departamento_idE=local.idDep;

        this.$nextTick(function () {
            this.selectDepartamentoEI();
            this.provincia_idE=local.idProv;

            this.$nextTick(function () {
                this.selectProvinciaEI();
                this.distrito_idE=local.idDis;
                this.fillLocal.distrito_id=local.idDis;
               
            })

        })

     })

       $("#boxTitulo").text('Local: '+local.nombre);
       $("#modalEditar").modal('show');

       $("#txtnomE").focus();
   },
   updateLocal:function (id) {
       var url="local/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCancelE").attr('disabled', true);
       this.divloaderEdit=true;

       axios.put(url, this.fillLocal).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCancelE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getLocal(this.thispage);
           this.fillLocal={'id':'', 'nombre':'', 'direccion':'','activo':'','distrito_id':''};
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
   bajalocal:function (local) {


    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea desactivar este Local",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Desactivar'
           }).then((result) => {

            if (result.value) {

                var url = 'local/altabaja/'+local.id+'/0';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getLocal(app.thispage);//listamos
                           toastr.success(response.data.msj);//mostramos mensaje
                       }else{
                          // $('#'+response.data.selector).focus();
                           toastr.error(response.data.msj);
                       }
                       });
                }

                   
               }).catch(swal.noop);  

   },
   altalocal:function (local) {

    swal.fire({
             title: '¿Estás seguro?',
             text: "Desea activar el Local",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, Activar'
           }).then((result) => {

            if (result.value) {

                var url = 'local/altabaja/'+local.id+'/1';
                       axios.get(url).then(response=>{//eliminamos

                       if(response.data.result=='1'){
                           app.getLocal(app.thispage);//listamos
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