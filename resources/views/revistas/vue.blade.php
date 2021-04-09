<script type="text/javascript">
    let app = new Vue({
el: '#app',
data:{
       titulo:"Investigación",
       subtitulo: "Gestigón de Revistas y Publicaciones",
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
   classTitle:'fa fa-newspaper-o',
   classMenu0:'',
   classMenu1:'',
   classMenu2:'',
   classMenu3:'',
   classMenu4:'active',
   classMenu5:'',
   classMenu6:'',
   classMenu7:'',
   classMenu8:'',
   classMenu9:'',
   classMenu10:'',
   classMenu11:'',
   classMenu12:'',


   divprincipal:false,

   revistas: [],
   errors:[],

   fillrevista:{'tipoPublicacion':'', 'tituloR':'', 'descripcion':'','escuela_id':'','fechaPublicado':'','indexada':'','lugarIndexada':'','numero':'','rutadoc':'','archivonombre':''},


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


   tipoPublicacion:'REVISTA',
   tituloR:'',
   descripcion:'',
   escuela_id:0,
   fechaPublicado:'',
   indexada:1,
   lugarIndexada:'',
   numero:'',
   rutadoc:'',
   archivonombre:'',
   

        imagen : null,
        archivo : null,
        newNombreArchivo : '',
        uploadReady: true,

        imagenE : null,
        archivoE : null,
        uploadReadyE: false,

        oldImg:'',
        oldFile:'',

        file:'',
        image:'',
        nameAdjunto:'',
        urlAdjunto:'',
        iflink:false,
        nameAdjuntoE:'',

     
        divNuevoAutor:false,
        autores:[],

        persona_id:0,
        cargo:'',
        revistaspublicacion_id:'',
        divloaderNuevoAutor:false,

        autoresRegis:[],

        autoresRevistas:[],


},
created:function () {
   this.getRevistas(this.thispage);

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


    getArchivo(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivo=null;
                }
                else{
                this.archivo = event.target.files[0];
                }
            },

            getArchivoE(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivoE=null;
                }
                else{
                this.archivoE = event.target.files[0];
                }
            },

   getRevistas: function (page) {
       var busca=this.buscar;
       var url = 'revistasPubli?page='+page+'&busca='+busca;

       axios.get(url).then(response=>{
           this.revistas= response.data.revistas.data;
           this.pagination= response.data.pagination;
           this.autoresRevistas= response.data.autoresRevistas;

           

           if(this.revistas.length==0 && this.thispage!='1'){
               var a = parseInt(this.thispage) ;
               a--;
               this.thispage=a.toString();
               this.changePage(this.thispage);
           }
       })
   },

   changePage:function (page) {
       this.pagination.current_page=page;
       this.getRevistas(page);
       this.thispage=page;
   },
   buscarBtn: function () {
       this.getRevistas();
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


    this.tipoPublicacion='REVISTA';
    this.tituloR='';
    this.descripcion='';
    this.escuela_id=0;
    this.fechaPublicado='';
    this.indexada=1;
    this.lugarIndexada='';
    this.numero='';
    this.rutadoc='';
    this.archivonombre='';

   this.imagen=null;
        this.archivo=null;
        this.uploadReady = false
        this.$nextTick(() => {
          this.uploadReady = true;

    this.formularioCrear=true;

       $(".form-control").css("border","1px solid #d2d6de");

       $('#cbuescuela_id').focus();

    })
   },



   create:function () {
       var url='revistasPubli';
       $("#btnGuardar").attr('disabled', true);
       $("#btnCancel").attr('disabled', true);
       $("#btnClose").attr('disabled', true);
       this.divloaderNuevo=true;

       $(".form-control").css("border","1px solid #d2d6de");

       var data = new  FormData();

data.append('titulo', this.tituloR);
data.append('tipoPublicacion', this.tipoPublicacion);
data.append('descripcion', this.descripcion);
data.append('escuela_id', this.escuela_id);
data.append('fechaPublicado', this.fechaPublicado);
data.append('indexada', this.indexada);
data.append('lugarIndexada', this.lugarIndexada);
data.append('numero', this.numero);
data.append('archivonombre', this.archivonombre);
data.append('archivo', this.archivo);
data.append('rutadoc', this.rutadoc);


const config = { headers: { 'Content-Type': 'multipart/form-data' } };

/*var formData = new FormData($("#formulario")[0]);
console.log(formData);*/

axios.post(url,data, config).then(response=>{

           //console.log(response.data);

           $("#btnGuardar").removeAttr("disabled");
           $("#btnCancel").removeAttr("disabled");
           $("#btnClose").removeAttr("disabled");
           this.divloaderNuevo=false;

   
           if(String(response.data.result)=='1'){
               this.getRevistas(this.thispage);
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




   borrar:function (revista) {


    
        swal.fire({
             title: '¿Estás seguro?',
             text: "¿Desea eliminar el Registro de la Investigación Seleccionada? -- Nota: este proceso no se podrá revertir.",
             type: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si, eliminar'
           }).then((result) => {

            if (result.value) {

                var url = 'revistasPubli/'+revista.id;
                axios.delete(url).then(response=>{//eliminamos

                if(response.data.result=='1'){
                    app.getRevistas(app.thispage);//listamos
                    toastr.success(response.data.msj);//mostramos mensaje
                }else{
                    // $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
                })
                }

                   
               }).catch(swal.noop);  
   },


/*

  fillrevista:{'tipoPublicacion':'', 'tituloR':'', 'descripcion':'','escuela_id':'','fechaPublicado':'','indexada':'','lugarIndexada':'','numero':'','rutadoc':'','archivonombre':''},

  */

   edit:function (investigacion) {

    this.uploadReadyE=false;
          this.$nextTick(() => {
            this.imagenE=null;
            this.archivoE=null;
            this.uploadReadyE=true;
            this.$nextTick(() => {
                

             });
          });

       this.cerrarFormNuevo();

       this.fillrevista.id=investigacion.id;
       this.fillrevista.tipoPublicacion=investigacion.tipoPublicacion;
       this.fillrevista.titulo=investigacion.titulo;
       this.fillrevista.descripcion=investigacion.descripcion;
       this.fillrevista.escuela_id=investigacion.escuela_id;
       this.fillrevista.fechaPublicado=investigacion.fechaPublicado;
       this.fillrevista.indexada=investigacion.indexada;
       this.fillrevista.lugarIndexada=investigacion.lugarIndexada;
       this.fillrevista.numero=investigacion.numero;
       this.fillrevista.rutadoc=investigacion.rutadoc;
       this.fillrevista.archivonombre=investigacion.archivonombre;

       this.oldFile=investigacion.rutadoc;

      

        this.divEdit=true;

        this.$nextTick(function () {
            $("#txttituloE").focus();
        });
       

       
   },

   cerrarFormE:function(){
        this.divEdit=false;
   },

   update:function (id) {
       var url="revistasPubli/"+id;
       $("#btnSaveE").attr('disabled', true);
       $("#btnCloseE").attr('disabled', true);
       this.divloaderEdit=true;


       var data = new  FormData();


data.append('id', this.fillrevista.id);
data.append('titulo', this.fillrevista.titulo);
data.append('tipoPublicacion', this.fillrevista.tipoPublicacion);
data.append('descripcion', this.fillrevista.descripcion);
data.append('escuela_id', this.fillrevista.escuela_id);
data.append('fechaPublicado', this.fillrevista.fechaPublicado);
data.append('indexada', this.fillrevista.indexada);
data.append('lugarIndexada', this.fillrevista.lugarIndexada);
data.append('numero', this.fillrevista.numero);
data.append('archivonombre', this.fillrevista.archivonombre);
data.append('archivo', this.archivoE);
data.append('rutadoc', this.fillrevista.rutadoc);

data.append('oldfile', this.oldFile);

data.append('_method', 'PUT');
         

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            axios.post(url, data, config).then(response=>{

           $("#btnSaveE").removeAttr("disabled");
           $("#btnCloseE").removeAttr("disabled");
           this.divloaderEdit=false;
           
           if(response.data.result=='1'){   
           this.getRevistas(this.thispage);
           this.fillrevista={'tipoPublicacion':'', 'tituloR':'', 'descripcion':'','escuela_id':'','fechaPublicado':'','indexada':'','lugarIndexada':'','numero':'','rutadoc':'','archivonombre':''};
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





























   


   getAutors: function () {
       var busca=this.buscar;
       var url = 'personas/obtenerDatos';

       axios.get(url).then(response=>{
           this.autores= response.data.autores;
       })
   },

   getAutorsInvest: function (id) {
       var busca=this.buscar;
       var url = 'personas/obtenerAutors/'+id;

       axios.get(url).then(response=>{
           this.autoresRegis= response.data.autoresRegis;


       })
   },

  



   gestautores:function (revista) {

    this.getAutors();
    this.getAutorsInvest(revista.id);

    this.divNuevoAutor=false;

    this.fillrevista.id=revista.id;
       this.fillrevista.tipoPublicacion=revista.tipoPublicacion;
       this.fillrevista.titulo=revista.titulo;
       this.fillrevista.descripcion=revista.descripcion;
       this.fillrevista.escuela_id=revista.escuela_id;
       this.fillrevista.fechaPublicado=revista.fechaPublicado;
       this.fillrevista.indexada=revista.indexada;
       this.fillrevista.lugarIndexada=revista.lugarIndexada;
       this.fillrevista.numero=revista.numero;
       this.fillrevista.rutadoc=revista.rutadoc;
       this.fillrevista.archivonombre=revista.archivonombre;


       this.oldFile=revista.rutadoc;

       this.tipoAutor='AUTOR';
       this.cargo='';
       this.persona_id=0;

       $("#cbsautor").select2();
       this.$nextTick(function () {
       $("#cbsautor").val("0").trigger('change');
       $('.select2').css("width","100%");
    });


$("#boxTituloInvest").text('Revista o Publicación: '+revista.titulo);
$("#modalAutores").modal('show');


},


nuevoAutor:function () {
       this.divNuevoAutor=true;
       //$("#txtespecialidad").focus();
       //$('#txtespecialidad').focus();
       this.$nextTick(function () {
       this.cancelFormNuevoAutor();
     })
       
   },

   cerrarFormNuevoAutor: function () {
       this.divNuevoAutor=false;
       this.cancelFormNuevoAutor();
   },
   cancelFormNuevoAutor: function () {
       
       this.tipoAutor='AUTOR';
       this.cargo='';

       $("#cbsautor").select2();
       $('#cbsautor').val('0').trigger('change');
       $(".form-control").css("border","1px solid #d2d6de");
   },


   createAutor:function () {

this.persona_id=$("#cbsautor").val();
var url='autor';
$("#btnGuardarAutor").attr('disabled', true);
$("#btnCancelAutor").attr('disabled', true);
$("#btnCloseAutor").attr('disabled', true);
this.divloaderNuevoAutor=true;
$(".form-control").css("border","1px solid #d2d6de");
axios.post(url,{revistaspublicacion_id:this.fillrevista.id, cargo:this.cargo,persona_id:this.persona_id}).then(response=>{
    //console.log(response.data);

    $("#btnGuardarAutor").removeAttr("disabled");
    $("#btnCancelAutor").removeAttr("disabled");
    $("#btnCloseAutor").removeAttr("disabled");
    this.divloaderNuevoAutor=false;


    if(String(response.data.result)=='1'){
        this.getAutorsInvest(this.fillrevista.id);
        this.getRevistas(this.thispage);
        this.errors=[];
        this.cerrarFormNuevoAutor();
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

borrarAutor:function (revista) {


    
swal.fire({
     title: '¿Estás seguro?',
     text: "¿Desea borrar el Autor Seleccionado? -- Nota: este proceso no se podrá revertir.",
     type: 'info',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Si, eliminar'
   }).then((result) => {

    if (result.value) {

        var url = 'autor/'+revista.id;
        axios.delete(url).then(response=>{//eliminamos

        if(response.data.result=='1'){
            app.getAutorsInvest(app.fillrevista.id);//listamos
            app.getRevistas(app.thispage);
            toastr.success(response.data.msj);//mostramos mensaje
        }else{
            // $('#'+response.data.selector).focus();
            toastr.error(response.data.msj);
        }
        })
        }

           
       }).catch(swal.noop);  
},






   descargarPlantilla:function(){
    //window.location="investigacions/imprimirExcel/"+buscar+"/"+fech+"/"+fec1+"/"+fec2+"/"+tipoP+"";
    window.location="investigacions/imprimirExcel/"+3;
   },
}
});
</script>