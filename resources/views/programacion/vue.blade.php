<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
    titulo:"Configuraciones",
        subtitulo: "Gestión y Programación de Submódulos",
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
   classTitle:'fa fa-calendar',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'',
   classMenu8:'',
   classMenu9:'active',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   submodulos: [],
   errors:[],

   fillsubmodulo:{'id':'', 'idModulo':'','modulo':'','submodulo':'','estado':'','fechaini':'','fechafin':'','idProgramacion':'','tituloProgramacion':'','descripcionProgramacion':'','fechainiProgramacion':'','fechafinProgramacion':'','activoProgramacion':''},


   divNuevo:false,
   divloaderNuevo:false,
   divloaderEdit:false,


   idmodulo:0,  
   idsubmodulo:0, 
   titulo:'', 
   fechaini:'', 
   fechafin:'', 
   descripcion:'', 



},
created:function () {
   this.getModulos(this.thispage);
},
mounted: function () {
   this.divloader0=false;
   this.divprincipal=true;
   //$("#divtitulo").show('slow');

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
   getModulos: function (page) {
       var busca=this.buscar;
       var url = 'programacions';

       axios.get(url).then(response=>{
           this.submodulos= response.data.submodulos;
       })
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
       $('#cbumodulo').focus();
       this.idmodulo=0;  
       this.idsubmodulo=0; 
       this.titulo=''; 
       this.fechaini=''; 
       this.fechafin=''; 
       this.descripcion=''; 

       $(".form-control").css("border","1px solid #d2d6de");

       $('#cbumodulo').focus();
   },

   programar:function () {

        swal.fire({
            title: '¿Estás seguro?',
            text: "¿Desea registrar la Programación? -- Nota: Si algún Módulo cuenta con una programación registrada, esta será reemplazada por esta nueva programación.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, registrar'
        }).then((result) => {

            if (result.value) {

                this.create();
                }

                
            }).catch(swal.noop);  
        },
   create:function () {
       var url='programacions';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;
       $(".form-control").css("border","1px solid #d2d6de");
       axios.post(url,{idmodulo:this.idmodulo, idsubmodulo:this.idsubmodulo, titulo:this.titulo, fechaini:this.fechaini, fechafin:this.fechafin, descripcion:this.descripcion}).then(response=>{
           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getModulos(this.thispage);
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
   borrar:function (submodulo) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar la Programación? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'programacions/'+submodulo.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getModulos(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },


   cambioModulo:function () {
        this.idsubmodulo=0;
    },


    baja:function (submodulo) {


    swal.fire({
            title: '¿Estás seguro?',
            text: "Desea cerrar Manualmente el Módulo -- Con este estado el módulo estará cerrado sin importar su programación",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Cerrar Módulo'
        }).then((result) => {

            if (result.value) {

                
                    var url = 'programacion/altabaja/'+submodulo.id+'/0';
                    axios.get(url).then(response=>{//eliminamos

                    if(response.data.result=='1'){
                        app.getModulos(app.thispage);//listamos
                        toastr.success(response.data.msj);//mostramos mensaje
                    }else{
                        // $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);
                    }
                    });
                }

                
            }).catch(swal.noop);  

    },
    alta:function (submodulo) {

    swal.fire({
            title: '¿Estás seguro?',
            text: "Desea abrir Manualmente el Módulo -- Con este estado el módulo estará abierto sin importar su programación",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Abrir Módulo'
        }).then((result) => {

            if (result.value) {

                var url = 'programacion/altabaja/'+submodulo.id+'/1';
                    axios.get(url).then(response=>{//eliminamos

                    if(response.data.result=='1'){
                        app.getModulos(app.thispage);//listamos
                        toastr.success(response.data.msj);//mostramos mensaje
                    }else{
                        // $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);
                    }
                    });
                }

                
            }).catch(swal.noop);  

    },
    programada:function (submodulo) {

    swal.fire({
            title: '¿Estás seguro?',
            text: "Desea activar la Programación del Módulo -- Con este estado el módulo estará abierto o cerrado según sus fechas programadas",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Activar Programación'
        }).then((result) => {

            if (result.value) {

                if(submodulo.idProgramacion != '0'){

                var url = 'programacion/altabaja/'+submodulo.id+'/2';
                    axios.get(url).then(response=>{//eliminamos

                    if(response.data.result=='1'){
                        app.getModulos(app.thispage);//listamos
                        toastr.success(response.data.msj);//mostramos mensaje
                    }else{
                        // $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);
                    }
                    });
                }
                else{
                    //toastr.warning("No puede activar la programación ya que no tiene ninguna programación para el módulo seleccionado, por favor registre una programación para que pueda activarla");

                    Swal.fire('No puede activar la programación ya que no tiene ninguna programación para el módulo seleccionado, por favor registre una programación para este módulo', '', 'info')
                }
                }

                
            }).catch(swal.noop);  

    }


   /*
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
           this.getModulos(this.thispage);
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
  ,*/
}
});
</script>