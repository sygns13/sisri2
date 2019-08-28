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
        classMenu5:'active',
        classMenu6:'',
        classMenu7:'',
        classMenu8:'',


        usuarios: [],
        tipousers: [],
        persona:[],
        user:[],
        errors:[],
        fillPersona:{'id':'', 'dni_ruc':'', 'nombre':'', 'direccion':'', 'tipopersona_id':''},

        filluser:{'id':'', 'name':'', 'email':'', 'password':'', 'tipouser_id':'', 'activo':'','entidad_id':''},

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

        newDNI:'',
        newNombres:'',
        newDireccion:'',

        newTipoUser:'',
        newTipoPersona:'',
        newEstado:'1',

        newUsername:'',
        newEmail:'',
        newPassword:'',


        divloaderNuevo:false,

        divloaderEdit:false,

        divloaderEditUsuario:false,


        formularioCrear:false,
        mostrarPalenIni:false,

        validated:'0',
        imagen : null,

        idPersona:'0',
        idUser:'0',
        tipoUser:'',

        thispage:'1',

        divprincipal:false,

        modifpassword:1,


        entidads:[],


        mostrarentidad:false,
        mostrarentidad2:false,

        entidadvista:'',


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

        cambiartipo: function () {

            if(this.newTipoUser==4){
            this.mostrarentidad=true;
            this.$nextTick(function () {
                $("#cbsEntidad").select2();
                $('#cbsEntidad').val('').trigger('change');
                this.$nextTick(function () {
                $('#cbsEntidad').select2('open');
            });
            });

        }else{
            this.mostrarentidad=false;
        }
        },
        cambiartipo2: function () {

if(this.filluser.tipouser_id==4){
this.mostrarentidad2=true;
this.$nextTick(function () {
    $("#cbsEntidadE").select2();
    $('#cbsEntidadE').val('').trigger('change');
    this.$nextTick(function () {
    $('#cbsEntidadE').select2('open');
});
});

}else{
this.mostrarentidad2=false;
}
},


cambiartipo3: function () {

if(this.filluser.tipouser_id==4){
this.mostrarentidad2=true;
this.$nextTick(function () {
    $("#cbsEntidadE").select2();
    
    this.$nextTick(function () {
        $('#cbsEntidadE').val(app.filluser.entidad_id).trigger('change');  
});
});

}else{
this.mostrarentidad2=false;
}
},
        getUsuarios: function (page) {
            var busca=this.buscar;
            var url = 'usuario?page='+page+'&busca='+busca;

            axios.get(url).then(response=>{

                this.usuarios= response.data.usuarios.data;
                this.tipousers= response.data.tipousers;
                this.tipopersonas= response.data.tipopersonas;
                this.pagination= response.data.pagination;
                this.entidads= response.data.entidads;
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
                $('#txtDNI').focus();
            })
            this.newDNI='';
            this.newNombres='';
            this.newDireccion='';

            this.newUsername='';
            this.newEmail='';
            this.newPassword='';
            this.formularioCrear=false;
            this.idPersona='0';
            this.persona=[];
            this.idUser='0';
            this.user=[];

            this.newTipoUser='';
            this.newEstado='1';
            this.divEditUsuario=false;


        },
        pressNuevoDNI: function (dni) {

            if(dni.length!=8){
                alertify.error('Complete los 08 dígitos correspondientes del DNI');
            }
            else{

                var url = 'usuario/verpersona/'+dni;

                axios.get(url).then(response=>{

                    this.idUser=response.data.idUser;
                    if(this.idUser=="0")
                    {
                        this.idPersona=response.data.id;
                        this.persona=response.data.persona;
                        if(this.idPersona !='0'){
                  
                        $.each(this.persona, function( index, dato ) {

                        app.newDNI=dato.dni_ruc;
                        app.newNombres=dato.nombre;
                        app.newDireccion=dato.direccion;
                        app.newTipoPersona=dato.tipopersona_id;

                        });

                        this.$nextTick(function () {
                            this.formularioCrear=true;
                            this.$nextTick(function () {
                                this.validated='1';
                                $('#txtnombres').focus();
                            })
                        })

                    }else{
                            this.formularioCrear=true;
                            this.$nextTick(function () {
                                this.validated='1';
                                $('#txtnombres').focus();

                            })
                        }
                    }
            else{
               
            swal.fire({
                title: 'Usuario Registrado',
                text: 'Ya se encuentra registrado el usuario con el DNI: '+dni,
                type: 'info',
                confirmButtonText: 'Aceptar'
            });
                this.cancelFormUsuario();
            }
     });             
            }
        },
        createUsuario:function () {
            var url='usuario';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;

            var identidad=$("#cbsEntidad").val();

            if (typeof identidad === "undefined") {
                identidad=0;
                }

            var data = new  FormData();

            data.append('idPersona', this.idPersona);
            data.append('idUser', this.idUser);
            data.append('newDNI', this.newDNI);
            data.append('newNombres', this.newNombres);
            data.append('newDireccion', this.newDireccion);
            data.append('newUsername', this.newUsername);
            data.append('newEmail', this.newEmail);
            data.append('newPassword', this.newPassword);
            data.append('newEstado', this.newEstado);
            data.append('newTipoUser', this.newTipoUser);
            data.append('newTipoPersona', this.newTipoPersona);
            data.append('identidad', identidad);

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
            var url = 'usuario/'+usuario.idUser;
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

            this.divNuevoUsuario=false;
            this.divEditUsuario=true;
            this.divloaderEdit=false;


            this.filluser.password='';
            this.modifpassword=1;

            this.filluser.entidad_id=usuario.entidad_id;
            this.$nextTick(function () {

                if(this.filluser.tipouser_id==4){
                    app.cambiartipo3();
                }
             this.validated='1';
             $('#txtnombresE').focus();

        })

        },
        cerrarFormUsuarioE: function(){

            this.divEditUsuario=false;

            this.$nextTick(function () {
                this.fillPersona={'id':'', 'dni_ruc':'', 'nombre':'', 'direccion':'', 'tipopersona_id':''};
                this.filluser={'id':'', 'name':'', 'email':'', 'password':'', 'tipouser_id':'', 'activo':'','entidad_id':''};
                this.modifpassword=1;
            })

        },

        modifclave: function(){

            if(this.modifpassword=='2'){
                setTimeout(function(){ $("#txtclaveE").focus(); }, 100);
            }

        },
        updateUsuario:function (idPer,idUser) {

            var identidad=$("#cbsEntidadE").val();

            if (typeof identidad === "undefined") {
                identidad=0;
                }

            var data = new  FormData();

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

            var url="usuario/"+idUser;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.post(url, data, config).then(response=>{

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
            var url = 'usuario/altabaja/'+usuario.idUser+'/0';
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
            var url = 'usuario/altabaja/'+usuario.idUser+'/1';
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
            this.modifpassword=1;

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
}
});
</script>