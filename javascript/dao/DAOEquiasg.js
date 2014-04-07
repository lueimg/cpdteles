var equivalenciaDAO = {
    url: '../controlador/controladorSistema.php',
    comando: 'equivalencia',
    cargarCarreras: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCarreras',
                cinstit: $('#slct_instituto').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCurriculas: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCurriculas',
                cinstit: $('#slct_instituto').val(),
                ccarrer: $('#slct_carrera').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarModulos: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarModulos',
                //cinstit: $('#slct_instituto').val(),
                ccarrer: $('#slct_carrera').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCursos: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCursos',
                //cinstit: $('#slct_instituto').val(),
                ccurric: $('#slct_curricula').val(),
                cmodulo: $('#slct_modulo').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCursos_asig: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCursos',
                //cinstit: $('#slct_instituto').val(),
                ccurric: $('#slct_curricula_asig').val(),
                cmodulo: $('#slct_modulo_asig').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    addEquivalencia: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:this.comando,
            	action:'addEquivalencia',
                post:{
            	comando:this.comando,
            	action:'addEquivalencia',
                ccurric:$('#slct_curricula').val(),
                cmodulo :$('#slct_modulo').val(),
                ccurso :$("#slct_curso").val() ,
                ccurria:$('#slct_curricula_asig').val(),
                cmoduloa :$('#slct_modulo_asig').val(),
                ccursoa :$("#slct_curso_asig").val() ,
                estide :$("#slct_tequi").val() ,
                cusuari:$('#hd_idUsuario').val(),
		cfilialx:$('#hd_idFilial').val()
                }
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmEquivalencia').dialog('close');
                    $("#table_hora").trigger('reloadGrid');
                    sistema.msjOk(obj.msj);
					
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },
    msjErrorAjax: function() {
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }
}