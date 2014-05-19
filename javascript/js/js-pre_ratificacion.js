$(document).ready(function(){
	$('#nav-servicios').addClass('active');//aplica estilo al menu activo
	jqGridPersona.personaIngAlum2();
	jQGridGrupoAcademico.GrupoAcademico();
	//$('#table_persona_ingalum').jqGrid('hideCol','finicio');
})


eventoClick=function(){
var id=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');	
    if (id) {
        var data = $("#table_persona_ingalum").jqGrid('getRowData',id);
        $('#txt_cingalu').val(id.split("-")[0]);
		$('#txt_cgracpr').val(id.split("-")[1]);
		$('#txt_nombre').val(data.dnomper+" "+data.dappape+" "+data.dapmape);
		curriculaDAO.listarPlanCurricular(HTMLlistarPlanCurricular);
    }else {
	    sistema.msjAdvertencia('Seleccione <b>Alumno</b>')
	}
}

HTMLlistarPlanCurricular=function(obj){
var htm='';
	for(i=0;i<obj.length;i++){
	htm+="<tr class='ui-widget-content jqgrow ui-row-ltr' onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
	htm+="<td width='90' class='t-center'>"+obj[i].dmodulo+"</td>";
	htm+="<td width='100' class='t-center'>"+obj[i].dcurso+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].ncredit+"</td>";
	htm+="<td width='150' class='t-left'>"+obj[i].requisito+"</td>";
	htm+="<td width='150' class='t-left'>Hola</td>";
	htm+="</tr>";
	}
$('#lista_plan').html(htm);
}

verPago=function(){

}

ListadoPlan=function(){

}

ListadoCursos=function(){

}
