$(document).ready(function(){
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	jqGridPersona.personaIngAlum2();
	jQGridGrupoAcademico.GrupoAcademico();
	jQGridPlanCurricular.PlanCurricular();
	//$('#table_persona_ingalum').jqGrid('hideCol','finicio');
})


eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (id) {
        var data = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
		$('#txt_cgracpr').val(id.split("-")[1]);
		$('#txt_nombre').val(data.dnomper+" "+data.dappape+" "+data.dapmape);
		$("#table_plan_curricular").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=curricula&action=jqgrid_listar_plancurricular&cingalu='+$('#txt_cingalu').val()}); 
		$("#table_plan_curricular").trigger('reloadGrid');
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Alumno</b>')
	}
}

verPago=function(){

}

ListadoPlan=function(){

}

ListadoCursos=function(){

}
