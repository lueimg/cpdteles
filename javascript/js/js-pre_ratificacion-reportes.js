$(document).ready(function(){
window.verhorario = {}




    $('#vistaReportes').dialog({
        autoOpen: false,
        show: 'fade', hide: 'fade',
        modal: true,
        width: 'auto', height: 'auto'
    });


$("#slct_seccion").change(function(){
	// # cargar horario
	var seccion = $(this).val();
	grupoAcademicoDAO.GAGetHorario(seccion, window.verHorario.ccuprp);

});




});

verHorario=function(ccuprp){
	$("#slct_seccion").show();
$("#tablaHorario").html("");

var cgruaca = $("#table_grupo_academico").jqGrid("getGridParam",'selrow');
grupoAcademicoDAO.cargarDetalleGrupo(sistema.llenaSelect,'slct_seccion','',cgruaca);
$('#vistaReportes').dialog('open');

window.verHorario.ccuprp = "'" + ccuprp + "'";

}

VerHorarioGeneral=function(){
$("#slct_seccion").hide();
$("#tablaHorario").html("");

// OBTENER FILAS REGISGTRADAS
var cursos = []
$("#lista_curso_alumno tr").each(function(){
	cursos.push( "'" + $(this).attr('id').split("curso_alumno_")[1] +  "'" );
});
data_cursos = cursos.join();

var secciones = []
grupoAcademicoDAO.GAGetHorarioGeneral(secciones, data_cursos);
$('#vistaReportes').dialog('open');



}