var grupoAcademicoDAO={
	url:'../controlador/controladorSistema.php',
	cargarGrupoAcademicoMatri:function(evento){
		var cfil="";
		var cins="";var cmod="";
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		if($("#slct_local_instituto").val()!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		cmod=$("#slct_local_instituto").val().split("-")[1];
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargarGrupoAcademicoMatri',
				cfilial:cfil,
				cinstit:cins,
				cmodali:cmod,
				csemaca:$("#slct_semestre").val(),
				cciclo:$("#cciclo").val()				
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando(); 
            	evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
	},
    cargarGrupoAcademico: function(evento){
		var cfil="";
		var cins="";var cmod="";
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		if($("#slct_local_instituto").val()!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		cmod=$("#slct_local_instituto").val().split("-")[1];
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargar_grupo_academico',
				cfilial:cfil,
				cinstit:cins,
				cmodali:cmod,
				csemaca:$("#slct_semestre").val(),
				cciclo:$("#cciclo").val()				
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando(); 
            	evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },
	cargarGrupoAcademico2: function(evento){
		$.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargar_grupo_academico2',
				cfilial:$("#slct_filial").val().join(","),
				cinstit:$("#slct_instituto").val(),
				csemaca:$("#slct_semestre").val(),
				cciclo:$("#slct_ciclo").val()				
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando(); 
            	evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },cargarGrupoAcademicoR: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargar_grupo_academico2',
                cfilial:$("#slct_filial").val().join(","),
                cinstit:$("#slct_instituto").val().join(","),
                csemaca:$("#slct_semestre").val().join(","),
                cciclo:$("#slct_ciclo").val()               
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando(); 
                evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },
    cargarGrupoAcademicoR2: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargar_grupo_academico2',
                cfilial:$("#slct_filial").val().join(","),
                cinstit:$("#slct_instituto").val().join(","),
                fechini:$("#txt_fecha_inicio").val(),
                fechfin:$("#txt_fecha_fin").val(),
                csemaca:$("#slct_semestre").val(),
                cciclo:$("#slct_ciclo").val()               
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando(); 
                evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },
	cargarAlumnos: function(evento,ids){
		$.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargarAlumnos',
				id:ids
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
	},
	cargarCursosProgramados: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargar_cursos_programados',
				cgracpr:$("#slct_horario").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
    },	
	guardarGruposAcademicos: function(dias){
		
		$.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'guardar_grupos_academicos',
				fechainiciosemestre:$("#fechainiciosemestre").val(),
				fechafinsemestre:$("#fechafinsemestre").val(),
				cfilial:$("#slct_filial").val().join(","),
				cinstit:$("#slct_instituto").val(),
				cmodali:"",
				ccarrer:$("#slct_carrera").val(),
				ctipcar:2,
				ccurric:$("#slct_curricula").val(),
				csemaca:$("#slct_semestre").val(),
				cciclo:$("#slct_ciclo").val(),
				cinicio:$("#slct_inicio").val(),
				cturno:$("#slct_turno").val(),
				chora:$("#slct_horario").val(),
				dias: dias,
				finicio:$("#txt_fecha_inicio").val(),
				ffinal:$("#txt_fecha_final").val(),
				nmetmat:$("#txt_meta_mat").val(),
				cfilialx:$("#hd_idFilial").val(),
				usuario: $("#hd_idUsuario").val()				
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando();                
				if(obj.rst=='1'){
					limpiarSelects();
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
    guardarGruposAcademicosG: function(dias){
        
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'guardar_grupos_academicos',
                fechainiciosemestre:$("#fechainiciosemestre").val(),
                fechafinsemestre:$("#fechafinsemestre").val(),
                cfilial:$("#slct_filial").val().join(","),
                cinstit:$("#slct_instituto").val(),
                cmodali:"",
                ccarrer:$("#slct_carrera").val().join(","),
                ctipcar:2,
                //ccurric:$("#slct_curricula").val(),
                csemaca:$("#slct_semestre").val(),
                cciclo:$("#slct_ciclo").val(),
                cinicio:$("#slct_inicio").val(),
                cturno:$("#slct_turno").val(),
                chora:$("#slct_horario").val(),
                dias: dias,
                finicio:$("#txt_fecha_inicio").val(),
                ffinal:$("#txt_fecha_final").val(),
                nmetmat:$("#txt_meta_mat").val(),
                cfilialx:$("#hd_idFilial").val(),
                usuario: $("#hd_idUsuario").val()               
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();                
                if(obj.rst=='1'){
                    limpiarSelects();
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
	ActualizarGrupoAcademico: function(dias){
  	$.ajax({
		url : this.url,
		type : 'POST',
		//async:false,//no ejecuta otro ajax hasta q este termine
		dataType : 'json',
		data : {
			comando:'grupo_academico',
			accion:'ActualizarGrupoAcademico',
			cgruaca:$("#cgruaca").val(),        
			cturno:$("#slct_turno_edit").val(),
			chora:$("#slct_horario_edit").val(),
			nmetmat:$("#txt_meta_mat_edit").val(),
			dias: dias,
			fechainiciosemestre:$("#fechainiciosemestre").val(),
			fechafinsemestre:$("#fechafinsemestre").val(),
			finicio:$("#txt_fecha_inicio_edit").val(),
			ffinal:$("#txt_fecha_final_edit").val(),
			cfilialx:$("#hd_idFilial").val(),
			usuario: $("#hd_idUsuario").val()        
            },
        beforeSend : function ( ) {
        	sistema.abreCargando();
        },
        success : function ( obj ) {
        sistema.cierraCargando();                
        	if(obj.rst=='1'){
				$('#frmGruposAca').dialog('close');
				ListarGrupos();
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
  cargarCursosAcademicos: function(evento,ids){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargarCursosAcademicos',
                cgracpr:ids
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarHorarioProgramado: function(evento,id){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargarHorarioProgramado',
                ccuprpr:id
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
    },
	msjErrorAjax:function(){
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }
}