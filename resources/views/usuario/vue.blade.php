<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        titulo:"Configuraciones",
        subtitulo: "Gestión de Usuarios",
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
        classTitle:'fa fa-user',
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


        usuarios: [],
        permisoModulos: [],
        permisoSubModulos: [],
        tipousers: [],
        persona:[],
        user:[],
        errors:[],

        filluser:{'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','id':'', 'name':'', 'password':'', 'tipouser_id':'', 'activo':'','persona_id':'','token2':'','modifpassword':'1'},

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
        divNuevoUsuario:false,
        divEditUsuario:false,

        tipodoc:1,
        doc:'',
        nombres:'',
        apellidopat:'',
        apellidomat:'',
        genero:'M',
        estadocivil:1,
        fechanac:'',
        esdiscapacitado:0,
        discapacidad:'',
        pais:'PERÚ',
        departamento:'ANCASH',
        provincia:'HUARAZ',
        distrito:'HUARAZ',
        direccion:'',
        email:'',
        telefono:'',


        name:'',
        password:'',
        activo:1,
        tipouser_id:0,
        persona_id:'0',


        divloaderNuevo:false,
        divloaderEdit:false,
        divloaderEditUsuario:false,


        formularioCrear:false,
        mostrarPalenIni:false,

        validated:'0',
        imagen : null,


        thispage:'1',

        divprincipal:false,
        divloaderCredencial:false,


        idmodulo:0,
        idsubmodulo:0,


        formularioCredenciales:false,



    },
    created:function () {
        this.getUsuarios(this.thispage);

        
    },
    mounted: function () {
        $("#divtitulo").show('slow');
        this.divloader0=false;
        this.divprincipal=true;
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


        getUsuarios: function (page) {
            var busca=this.buscar;
            var url = 'usuario?page='+page+'&busca='+busca;

            axios.get(url).then(response=>{

                this.usuarios= response.data.usuarios.data;
                this.pagination= response.data.pagination;
                this.permisoModulos= response.data.permisoModulos;
                this.permisoSubModulos= response.data.permisoSubModulos;

                this.mostrarPalenIni=true;

                if(this.usuarios.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getUsuarios(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getUsuarios();
            this.thispage='1';
        },
        nuevoUsuario:function () {
            this.divNuevoUsuario=true;
            this.divloaderEditUsuario=false;

            this.$nextTick(function () {
                this.cancelFormUsuario();
            })
            
        },
        cerrarFormUsuario: function () {
            this.divNuevoUsuario=false;
            this.cancelFormUsuario();
        },
        cancelFormUsuario: function () {
            this.validated='0';
            this.$nextTick(function () {
                this.formularioCrear=false;
                $(".form-control").css("border","1px solid #d2d6de");
                $('#txtDNI').focus();
            })
            this.tipodoc=1;
            this.doc='';
            this.nombres='';
            this.apellidopat='';
            this.apellidomat='';
            this.genero='M';
            this.estadocivil=1;
            this.fechanac='';
            this.esdiscapacitado=0;
            this.discapacidad='';
            this.pais='PERÚ';
            this.departamento='ANCASH';
            this.provincia='HUARAZ';
            this.distrito='HUARAZ';
            this.direccion='';
            this.email='';
            this.telefono='';

            this.name='';
            this.password='';
            this.activo=1;
            this.tipouser_id=0;
            this.persona_id='0';

            this.divEditUsuario=false;


        },
        pressNuevoDNI: function() {

var url='persona/buscarDNI';

   axios.post(url,{doc:this.doc,tipodoc:this.tipodoc}).then(response=>{

       if(String(response.data.result)=='1'){

        this.nombres='';
            this.apellidopat='';
            this.apellidomat='';
            this.genero='M';
            this.estadocivil=1;
            this.fechanac='';
            this.esdiscapacitado=0;
            this.discapacidad='';
            this.pais='PERÚ';
            this.departamento='ANCASH';
            this.provincia='HUARAZ';
            this.distrito='HUARAZ';
            this.direccion='';
            this.email='';
            this.telefono='';

            this.persona_id='0';


           this.formularioCrear=true;

           this.$nextTick(function () {
                $("#txtapepat").focus();
            });

           toastr.success(response.data.msj);
       }else if (String(response.data.result)=='2') {

        this.persona_id=response.data.idPer;

    this.nombres=response.data.persona.nombres;
    this.apellidopat=response.data.persona.apellidopat;
    this.apellidomat=response.data.persona.apellidomat;
    this.genero=response.data.persona.genero;
    this.estadocivil=response.data.persona.estadocivil;
    this.fechanac=response.data.persona.fechanac;
    this.esdiscapacitado=response.data.persona.esdiscapacitado;
    this.discapacidad=response.data.persona.discapacidad;
    this.pais=response.data.persona.pais;
    this.departamento=response.data.persona.departamento;
    this.provincia=response.data.persona.provincia;
    this.distrito=response.data.persona.distrito;
    this.direccion=response.data.persona.direccion;
    this.email=response.data.persona.email;
    this.telefono=response.data.persona.telefono;


        this.formularioCrear=true;

        this.$nextTick(function () {
                $("#txtapepat").focus();
            });

        }else{
            this.nombres='';
            this.apellidopat='';
            this.apellidomat='';
            this.genero='M';
            this.estadocivil=1;
            this.fechanac='';
            this.esdiscapacitado=0;
            this.discapacidad='';
            this.pais='PERÚ';
            this.departamento='ANCASH';
            this.provincia='HUARAZ';
            this.distrito='HUARAZ';
            this.direccion='';
            this.email='';
            this.telefono='';

            this.persona_id='0';

            this.formularioCrear=false;
           $('#'+response.data.selector).focus();
           $('#'+response.data.selector).css( "border", "1px solid red" );
           toastr.error(response.data.msj);
       }
   }).catch(error=>{
       //this.errors=error.response.data
   })

},
        createUsuario:function () {
            var url='usuario';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;


            var data = new  FormData();

            data.append('tipodoc', this.tipodoc);
            data.append('doc', this.doc);
            data.append('nombres', this.nombres);
            data.append('apellidopat', this.apellidopat);
            data.append('apellidomat', this.apellidomat);
            data.append('genero', this.genero);
            data.append('estadocivil', this.estadocivil);
            data.append('fechanac', this.fechanac);
            data.append('esdiscapacitado', this.esdiscapacitado);
            data.append('discapacidad', this.discapacidad);
            data.append('pais', this.pais);
            data.append('departamento', this.departamento);
            data.append('provincia', this.provincia);
            data.append('distrito', this.distrito);
            data.append('direccion', this.direccion);
            data.append('email', this.email);
            data.append('telefono', this.telefono);

            data.append('name', this.name);
            data.append('password', this.password);
            data.append('tipouser_id', this.tipouser_id);
            data.append('persona_id', this.persona_id);
            data.append('activo', this.activo);
  

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            axios.post(url,data,config).then(response=>{

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getUsuarios(this.thispage);
                    this.errors=[];
                    this.cerrarFormUsuario();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarUsuario:function (usuario) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "¿Desea eliminar el usuario seleccionado? -- Nota: Este proceso no se podrá revertir",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, eliminar'
          }).then((result) => {


            if (result.value) {
            var url = 'usuario/'+usuario.id;
                            axios.delete(url).then(response=>{//eliminamos

                                if(response.data.result=='1'){
                                app.getUsuarios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                               toastr.error(response.data.msj);
                           }
                       });
                    }

                        }).catch(swal.noop);
        },
        editUsuario:function (usuario) {

            
            this.filluser.id=usuario.id;
            this.filluser.tipodoc=usuario.tipodoc;
            this.filluser.doc=usuario.doc;
            this.filluser.nombres=usuario.nombres;
            this.filluser.apellidopat=usuario.apellidopat;
            this.filluser.apellidomat=usuario.apellidomat;
            this.filluser.genero=usuario.genero;
            this.filluser.estadocivil=usuario.estadocivil;
            this.filluser.fechanac=usuario.fechanac;
            this.filluser.esdiscapacitado=usuario.esdiscapacitado;
            this.filluser.discapacidad=usuario.discapacidad;
            this.filluser.pais=usuario.pais;
            this.filluser.departamento=usuario.departamento;
            this.filluser.provincia=usuario.provincia;
            this.filluser.distrito=usuario.distrito;
            this.filluser.direccion=usuario.direccion;
            this.filluser.email=usuario.email;
            this.filluser.telefono=usuario.telefono;


            this.filluser.name=usuario.name;
            this.filluser.password=usuario.token2;

            this.filluser.tipouser_id=usuario.tipouser_id;
            this.filluser.persona_id=usuario.persona_id;
            this.filluser.activo=usuario.activo;

            this.divNuevoUsuario=false;
            this.divEditUsuario=true;
            this.divloaderEdit=false;

            this.filluser.modifpassword=1;


        },
        cerrarFormUsuarioE: function(){

            this.divEditUsuario=false;

            this.$nextTick(function () {
                this.filluser={'tipodoc':'', 'doc':'', 'nombres':'','apellidopat':'','apellidomat':'','genero':'','estadocivil':'','fechanac':'','esdiscapacitado':'','discapacidad':'','pais':'','departamento':'','provincia':'','distrito':'','direccion':'','email':'','telefono':'','id':'', 'name':'', 'password':'', 'tipouser_id':'', 'activo':'','persona_id':'','token2':'','modifpassword':'1'};
    
            })

        },

        modifclave: function(){

            if(this.filluser.modifpassword=='2'){
                setTimeout(function(){ $("#txtpasswordE").focus(); }, 100);
            }

        },
        updateUsuario:function (id) {


          /*   var data = new  FormData();

            data.append('idPersona', this.fillPersona.id);
            data.append('idUser', this.filluser.id);

            data.append('editDNI', this.fillPersona.dni_ruc);
            data.append('editNombres', this.fillPersona.nombre);
            data.append('editDireccion', this.fillPersona.direccion);
            data.append('editTipoPersona', this.fillPersona.tipopersona_id);

            data.append('editUsername', this.filluser.name);
            data.append('editEmail', this.filluser.email);
            data.append('editPassword',  this.filluser.password);
            data.append('idtipo', this.filluser.tipouser_id);
            data.append('activo', this.filluser.activo);
            data.append('modifpassword', this.modifpassword);
            data.append('identidad', identidad);

            data.append('_method', 'PUT');

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            var url="usuario/"+idUser; */
    


            var url="usuario/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.filluser).then(response=>{


                $("#btnSaveE").removeAttr("disabled");
                $("#btnCloseE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                    this.getUsuarios(this.thispage);
                    this.cerrarFormUsuarioE();
                    toastr.success(response.data.msj);

                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        bajaUsuario:function (usuario) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "Nota: Si se desactiva el usuario, No podrá acceder al sistema, hasta que sea activado nuevamente",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, desactivar'
          }).then((result) => {

            if (result.value) {
            var url = 'usuario/altabaja/'+usuario.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                                if(response.data.result=='1'){
                                app.getUsuarios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                               toastr.error(response.data.msj);
                           }
                       });
                    }

                        }).catch(swal.noop);
      },
      altaUsuario:function (usuario) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "Nota: Si activa el usuario, podrá acceder al sistema nuevamente",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, Activar'
          }).then((result) => {

            if (result.value) {
            var url = 'usuario/altabaja/'+usuario.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                                if(response.data.result=='1'){
                                app.getUsuarios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                               toastr.error(response.data.msj);
                           }
                       });

                     }

                        }).catch(swal.noop);
      },
      impFicha:function (usuario) {



        this.fillPersona.id=usuario.idPer;
            this.fillPersona.dni_ruc=usuario.dni_ruc;
            this.fillPersona.nombre=usuario.nombre;
            this.fillPersona.direccion=usuario.direccion;
            this.fillPersona.tipopersona_id=usuario.idtipoPer;

            this.filluser.id=usuario.idUser;
            this.filluser.name=usuario.username;
            this.filluser.email=usuario.email;

            this.filluser.tipouser_id=usuario.idtipouser;
            this.filluser.activo=usuario.activo;




            this.filluser.password='';
            this.filluser.modifpassword=1;

            this.filluser.entidad_id=usuario.entidad_id;

            this.tipoUser=usuario.tipouser;
            this.entidadvista='('+usuario.codeentidad+') '+usuario.entidad;


            $('#modalFicha').modal(); 

       /*  this.$nextTick(function () {

            if(usuario.imagen.length>0){
                $("#divImgFIcha").attr("src","{{ asset('/img/perfil/')}}"+"/"+app.fillPersona.imagen);
            }
            this.$nextTick(function () {

                $('#modalFicha').modal(); 
            })
        }) */





    },
    Imprimir:function (usuario) {
        $("#FichaUsuario").printArea();
    },
    gestionCredenciales:function (usuario) {


        this.idmodulo=0;
        this.idsubmodulo=0;

        this.formularioCredenciales=false;

            this.filluser.id=usuario.id;
            this.filluser.tipodoc=usuario.tipodoc;
            this.filluser.doc=usuario.doc;
            this.filluser.nombres=usuario.nombres;
            this.filluser.apellidopat=usuario.apellidopat;
            this.filluser.apellidomat=usuario.apellidomat;
            this.filluser.genero=usuario.genero;
            this.filluser.estadocivil=usuario.estadocivil;
            this.filluser.fechanac=usuario.fechanac;
            this.filluser.esdiscapacitado=usuario.esdiscapacitado;
            this.filluser.discapacidad=usuario.discapacidad;
            this.filluser.pais=usuario.pais;
            this.filluser.departamento=usuario.departamento;
            this.filluser.provincia=usuario.provincia;
            this.filluser.distrito=usuario.distrito;
            this.filluser.direccion=usuario.direccion;
            this.filluser.email=usuario.email;
            this.filluser.telefono=usuario.telefono;


            this.filluser.name=usuario.name;
            this.filluser.password=usuario.token2;

            this.filluser.tipouser_id=usuario.tipouser_id;
            this.filluser.persona_id=usuario.persona_id;
            this.filluser.activo=usuario.activo;



        $('#modalActualizarCredenciales').modal(); 
    },

    nuevaCredencial:function () {
        this.idmodulo=0;
        this.idsubmodulo=0;

        this.formularioCredenciales=true;
            
        },
        cerrarFormCred: function () {
            this.idmodulo=0;
        this.idsubmodulo=0;

        this.formularioCredenciales=false;
        },
        cancelFormCred: function () {
            this.idmodulo=0;
            this.idsubmodulo=0;
        },



        ActualizarCredenciales:function () {
            var url='permiso';

            $("#btnGuardarCred").attr('disabled', true);
            $("#btnCancelCred").attr('disabled', true);
            $("#btnCloseCred").attr('disabled', true);

            this.divloaderCredencial=true;

            var data = new  FormData();

            data.append('idmodulo', this.idmodulo);
            data.append('idsubmodulo', this.idsubmodulo);
            data.append('id', this.filluser.id);

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            axios.post(url,data,config).then(response=>{

                $("#btnGuardarCred").removeAttr("disabled");
                $("#btnCancelCred").removeAttr("disabled");
                $("#btnCloseCred").removeAttr("disabled");
                this.divloaderCredencial=false;

                if(response.data.result=='1'){
                    this.getUsuarios(this.thispage);
                    this.errors=[];
                    this.cerrarFormCred();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        cambioModulo:function () {
            this.idsubmodulo=0;
        },


        borrarCredencial1:function (perModulo) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "¿Desea eliminar la Credencial de Usuario Seleccionada? -- Nota: Este proceso no se podrá revertir",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, eliminar'
          }).then((result) => {


            if (result.value) {
            var url = 'permiso/'+perModulo.id;
                            axios.delete(url).then(response=>{//eliminamos

                                if(response.data.result=='1'){
                                app.getUsuarios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                               toastr.error(response.data.msj);
                           }
                       });
                    }

                        }).catch(swal.noop);
        },


        borrarCredencial2:function (perModulo,perSubModulo) {
          swal.fire({
              title: '¿Estás seguro?',
              text: "¿Desea eliminar la Credencial de Usuario Seleccionada? -- Nota: Este proceso no se podrá revertir",
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, eliminar'
          }).then((result) => {


            if (result.value) {
            var url = 'permisoDelete/'+perModulo.id+'/'+perSubModulo.id+'/'+perModulo.modulo_id+'/'+app.filluser.id;
                            axios.get(url).then(response=>{//eliminamos

                                if(response.data.result=='1'){
                                app.getUsuarios(app.thispage);//listamos
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