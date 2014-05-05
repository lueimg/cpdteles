$().ready(function(){


	cencapDAO.cargarFiliales(sistema.llenaSelect,"slct_filial","");
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,"slct_instituto","");
		/*datepicker*/
	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});


$('#frmProfes').dialog({
		autoOpen : false,
        show : 'fade',hide : 'fade',
        modal:true,
        width:'auto',height:'auto'
	});


jqGridDocente.DocenteMante();
jqGridPersona.persona();

});


ListarPersona=function(){
	var dis=$("#mantenimiento_persona").css("display");
	if(dis=='none'){
	$("#mantenimiento_persona").css("display",'');
	}
	else{
	$("#mantenimiento_persona").css("display",'none');
	}
    $('#frmProfes').dialog("option", "position", "center");

}

cargar_persona_jqgrid=function(){
	var id="";	
	id=$("#table_persona").jqGrid("getGridParam",'selrow');
	
    if (id) {
        var data = $("#table_persona").jqGrid('getRowData',id);
        $('#cperson').val(id);
        $('#txt_persona').val(data.dappape + ' '+ data.dapmape + ', ' +  data.dnomper  );
  //       $('#txt_materno_c').val(data.dapmape);
		// $('#txt_nombre_c').val(data.dnomper);
		// $('#txt_email_c').val(data.email1);        
  //       $('#txt_celular_c').val(data.ntelpe2);
		// $('#txt_telefono_casa_c').val(data.ntelper);
		// $('#txt_telefono_oficina_c').val(data.ntellab);
		// $('#slct_estado_civil_c').val(data.cestciv);
		// $('#txt_dni_c').val(data.ndniper);
		// $('#slct_sexo_c').val(data.tsexo);
		// $('#txt_fecha_nacimiento_c').val(data.fnacper);
		// $('#slct_departamento_c').val(data.coddpto);
		// if(data.coddpto!=''){
		// ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c',data.codprov);	
		// ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c','slct_distrito_c',data.coddist);		
		// }
		// $('#txt_colegio_c').val(data.dcolpro);
		// $('#slct_Tipo_c').val(data.tcolegi);

		$("#mantenimiento_persona").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Persona</b> a Cargar')
	}
}

function docente_agregar(){
$('#frmProfes').dialog('open');	
}

function GuardarDocente(){
	
}









