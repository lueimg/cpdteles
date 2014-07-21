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
$("#tablaHorario").html("");

var cgruaca = $("#table_grupo_academico").jqGrid("getGridParam",'selrow');
grupoAcademicoDAO.cargarDetalleGrupo(sistema.llenaSelect,'slct_seccion','',cgruaca);
$('#vistaReportes').dialog('open');

window.verHorario.ccuprp = "'" + ccuprp + "'";

}

VerHorarioGeneral=function(){

}