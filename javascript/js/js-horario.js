$(document).ready(function(){

	$('#nav-reportes').addClass('active');//aplica estilo al menu activo				
	institucionDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');	      
	$('#btn_listar').click(function(){VisualizarGrupos()});
	
	$("#slct_filial,#slct_instituto").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();

	$("#btnFormHorario").click(function(){guardarHorario()});

	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});

	//jqGridDocente.docente();
})

VisualizarGrupos=function(){
	$("#v_lista_grupo").css("display","none");
	$("#v_lista_alumnos").css("display","none");
	grupoAcademicoDAO.cargarGrupoAcademicoR2(VisualizarGruposHTML);
}

VisualizarGruposHTML=function(obj){
	var htm="";	
	for(i=0;i<obj.length;i++){
	htm+="<tr id='trg-"+obj[i].id.split(",").join("-")+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_grupos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
	htm+="<td width='90' class='t-center'>"+obj[i].dfilial+"</td>";
	htm+="<td width='100' class='t-center'>"+obj[i].dinstit+"</td>";
	htm+="<td width='210' class='t-center'>"+obj[i].dcurric+"</td>";
	htm+="<td width='170' class='t-left'>"+obj[i].dcarrer+"</td>";
	htm+="<td width='120' class='t-center'>"+obj[i].dturno+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].cinicio+"</td>";
	htm+="<td width='160' class='t-center'>"+obj[i].finicio+" / "+obj[i].ffin+"</td>";
	htm+="<td width='160' class='t-left'>"+obj[i].horario+"</td>";
	htm+="<td width='30' class='t-left'>"+obj[i].total+"</td>";
	htm+="<td width='30' class='t-left'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="GenerarHorario('+"'"+obj[i].id+"',''"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-zoom-in"></i>'+
        '       </a>'+
        ' 	</div>'+
		'</td>';
	htm+="</tr>";
	}
	if(obj.length>0){
	$("#v_lista_grupo").css("display","");
	}
	$("#lista_grupos").html(htm);	
}

GenerarHorario=function(ids){
grupoAcademicoDAO.cargarCursosAcademicos(VisualizarCursosHTML,ids);
ToogleFiltro();
}

RegresarGrupo=function(){
ToogleFiltro();
}

ToogleFiltro=function(){
$('#filtro').toggle("slow");
$('#horario').toggle("slow");
}

VisualizarCursosHTML=function(obj){
var htm="";	
var datos="";	
	for(i=0;i<obj.length;i++){
	datos=obj[i].dcurso+'_'+obj[i].nombre+'_'+obj[i].cprofes+'_'+obj[i].finipre+'_'+obj[i].ffinpre+'_'+obj[i].finivir+'_'+obj[i].ffinvir;
	htm+="<tr id='trg-"+obj[i].ccuprpr+"' class='ui-widget-content jqgrow ui-row-ltr' "+ 
			 "onClick='sistema.selectorClass(this.id,"+'"'+"lista_cursos"+'"'+");' "+
			 "onMouseOut='sistema.mouseOut(this.id)' onMouseOver='sistema.mouseOver(this.id)'>";
	htm+="<td width='250' class='t-center'>"+obj[i].dcurso+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].finipre+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].ffinpre+"</td>";
	htm+="<td width='80' class='t-left'>"+obj[i].finivir+"</td>";
	htm+="<td width='80' class='t-center'>"+obj[i].ffinvir+"</td>";
	htm+="<td width='250' class='t-center'>"+obj[i].nombre+"</td>";
	htm+="<td width='30' class='t-left'>"+
		'	<div style="margin:15px 0px 10px 0px;">'+
		'		<a onClick="ActualizaHorario('+"'"+obj[i].ccuprpr+"','"+datos+"'"+')" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">'+
        '        	<i class="icon-white icon-pencil"></i>'+
        '       </a>'+
        ' 	</div>'+
		'</td>';
	htm+="</tr>";
	}
	if(obj.length>0){
	$("#v_lista_curso").css("display","");
	}
	$("#lista_cursos").html(htm);
}

ActualizaHorario=function(id,datos){
	var d=new Array();
	d=datos.split('_');

	$('#ccuprpr').val(id);
	$('#txt_curso').val(d[0]);
	$('#txt_docente').val(d[1]);
	$('#cprofes').val(d[2]);
	$('#txt_fecha_ini_pre').val(d[3]);
	$('#txt_fecha_fin_pre').val(d[4]);
	$('#txt_fecha_ini_vir').val(d[5]);
	$('#txt_fecha_fin_vir').val(d[6]);

	grupoAcademicoDAO.cargarHorarioProgramado(VisualizarHorarioProgramadoHtml,id);
	$("#actualizacion").css("display","");	
}

VisualizarHorarioProgramadoHtml=function(obj){

}

guardarHorario=function(){
	$("#actualizacion").css("display","none");		
}


ListarDocente=function(){
	var dis=$("#mantenimiento_docente").css("display");
	if(dis=='none'){
	$("#mantenimiento_docente").css("display",'');
	}
	else{
	$("#mantenimiento_docente").css("display",'none');
	}
}
