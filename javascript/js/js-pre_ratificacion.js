$(document).ready(function(){
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	jqGridPersona.personaIngAlum2();
	//$('#table_persona_ingalum').jqGrid('hideCol','finicio');
})


eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (id) {
        var data = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
		$('#txt_cgracpr').val(id.split("-")[1]);
		$('#txt_nombre').val(data.dnomper+" "+data.dappape+" "+data.dapmape);

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
