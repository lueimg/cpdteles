var profesDisponibilidadDAO={
	url:'../controlador/controladorSistema.php',
	guardarDisponibilidad : function(datos){
		$.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'profesDisponibilidad',
            	accion:'guardarDisponibilidad',
            	cprofes:$("#table_docente").jqGrid("getGridParam",'selrow'),
            	datos:datos,
            	cfilialx:$("#hd_idFilial").val(),
				usuario: $("#hd_idUsuario").val()
							
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando(); 
                sistema.msjOk(obj.msj); 

            	            
            },
            error: this.msjErrorAjax
        });
	},
	msjErrorAjax:function(){
		sistema.cierraCargando(); 
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }

}