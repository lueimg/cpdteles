$(document).ready(function(){

	$('#nav-reportes').addClass('active');//aplica estilo al menu activo				
	institucionDAO.cargarCiclo(sistema.llenaSelect,'slct_ciclo','');
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');	    

    horarioDAO.cargarDia(sistema.llenaSelect,'slct_dia','');
    horarioDAO.cargarTipoAmbiente(sistema.llenaSelect,'slct_tipo_ambiente','');
	horarioDAO.cargarTiempoTolerancia(sistema.llenaSelect,'slct_tiempo_tolerancia','');

	$('#btn_listar').click(function(){VisualizarGrupos()});
	
	$("#slct_filial,#slct_instituto").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();

	$("#btnFormHorario").click(function(){guardarHorario()});
	$("#btnAgregarHorario").click(function(){AgregarHorario('')});
	

	$(':text[id^="txt_fecha"]').datepicker({
		dateFormat:'yy-mm-dd',
		dayNamesMin:['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Anterior'
	});

	jqGridDocente.Docente();
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
$("#actualizacion").css("display","none");
}

VisualizarCursosHTML=function(obj){
var htm="";	
var datos="";	
	for(i=0;i<obj.length;i++){
	datos=obj[i].dcurso+'_'+obj[i].nombre+'_'+obj[i].cprofes+'_'+obj[i].finipre+'_'+obj[i].ffinpre+'_'+obj[i].finivir+'_'+obj[i].ffinvir+'_'+obj[i].cinstit+'_'+obj[i].cfilial;
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

	$("#detalle_actualizacion .agregado").remove();
	$("#detalle_actualizacion .fijo").remove();

	$('#ccuprpr').val(id);
	$('#txt_curso').val(d[0]);
	$('#txt_docente').val(d[1]);
	$('#cprofes').val(d[2]);
	$('#txt_fecha_ini_pre').val(d[3]);
	$('#txt_fecha_fin_pre').val(d[4]);
	$('#txt_fecha_ini_vir').val(d[5]);
	$('#txt_fecha_fin_vir').val(d[6]);
	$('#cinstit').val(d[7]);
	$('#cfilial').val(d[8]);
	horarioDAO.cargarHora(sistema.llenaSelect,'slct_hora','');
	grupoAcademicoDAO.cargarHorarioProgramado(VisualizarHorarioProgramadoHtml,id);	
	$("#actualizacion").css("display","");	

}

VisualizarHorarioProgramadoHtml=function(obj){
	var pos=0;
	$.each(obj,function(index,value){
		AgregarHorario('X');
		pos=$("#txt_cant_hor").val()*1;
		$("#slct_dia_"+pos).val(value.cdia);
		$("#slct_hora_"+pos).val(value.chora);
		$("#slct_tipo_"+pos).val(value.ctipcla);
		$("#slct_tipo_ambiente_"+pos).val(value.ctipamb);
		ActualizaAmbiente(value.ctipamb,'slct_tipo_ambiente_'+pos,value.cambien);
		$("#slct_tiempo_tolerancia_"+pos).val(value.ctietol);
		$("#chk_"+pos).attr("value",value.chorpro);
	});	
}

AgregarHorario=function(ide){
	var agregado='fijo';
	var disabled='';
	if(ide==''){
		agregado='agregado';
		disabled='disabled';
	}	
	var tot=0;
	var htm="";	
	tot = $("#txt_cant_hor").val()*1 + 1;
	$("#txt_cant_hor").val(tot);
	htm=''+
	'<tr id="trel_'+tot+'" class="FormData '+agregado+'"> '+                                      
	    '<td class="t-left">'+ 
	      '<select id="slct_dia_'+tot+'" style="width:120px">'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+                              
	    '<td class="t-left">'+ 
	      '<select id="slct_hora_'+tot+'" class="input-large">'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+                             
	    '<td class="t-left">'+ 
	      '<select id="slct_tipo_'+tot+'" style="width:120px">'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '<option value="T">Teórico</option>'+ 
	      '<option value="P">Práctico</option>'+ 
	      '</select>'+ 
	    '</td>'+ 
	    '<td class="t-left">'+ 
	      '<select id="slct_tipo_ambiente_'+tot+'" class="input-large" onChange="ActualizaAmbiente(this.value,this.id);">'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+                              
	    '<td class="t-left">'+ 
	      '<select id="slct_ambiente_'+tot+'" class="input-large">'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+                                                                       
	    '<td class="t-left">'+ 
	      '<select id="slct_tiempo_tolerancia_'+tot+'" style="width:120px">'+ 
	      '<option value="">--Seleccione--</option>'+ 
	      '</select>'+ 
	    '</td>         '+                              
	    '<td class="t-left">&nbsp;'+ 
	      '<select id="slct_estado_'+tot+'" '+disabled+'>'+ 
	      '<option value="1" selected=selected>Activo</option>'+ 
	      '<option value="0">Inactivo</option>'+ 
	      '</select>'+ 
	    '</td>';
	    if(ide==''){
	    htm+='<td class="t-left"><span class="formBotones" style="">'+ 
			'<a class="btn btn-azul sombra-3d t-blanco" onclick="$('+"'"+'#trel_'+tot+"'"+').remove();" href="javascript:void(0)">'+ 
			'<i class="icon-white icon-remove"></i>			'+ 
			'</a>'+ 
			'</span></td>'+ 
	'</tr>';
	    }
	    else{
	    htm+='<td><input type="checkbox" id="chk_'+tot+'"></td></tr>';
	    }
	    
	$("#detalle_actualizacion").append(htm);
	$("#slct_dia_"+tot).html($("#slct_dia").html());
	$("#slct_dia_"+tot).val('');
	$("#slct_hora_"+tot).html($("#slct_hora").html());
	$("#slct_hora_"+tot).val('');
	$("#slct_tipo_ambiente_"+tot).html($("#slct_tipo_ambiente").html());
	$("#slct_tipo_ambiente_"+tot).val('');
	$("#slct_ambiente_"+tot).html($("#slct_ambiente").html());
	$("#slct_ambiente_"+tot).val('');
	$("#slct_tiempo_tolerancia_"+tot).html($("#slct_tiempo_tolerancia").html());
	$("#slct_tiempo_tolerancia_"+tot).val('');
}

guardarHorario=function(){
	
	if($("#txt_fecha_ini_pre").val()==''){
		sistema.msjAdvertencia('Ingrese fecha de Inicio Presencial');
		$("#txt_fecha_ini_pre").focus();
	}
	else if($("#txt_fecha_fin_pre").val()==''){
		sistema.msjAdvertencia('Ingrese fecha Fin Presencial');
		$("#txt_fecha_fin_pre").focus();
	}
	else if($("#txt_fecha_ini_vir").val()==''){
		sistema.msjAdvertencia('Ingrese fecha de Inicio Virtual');
		$("#txt_fecha_ini_vir").focus();
	}
	else if($("#txt_fecha_fin_vir").val()==''){
		sistema.msjAdvertencia('Ingrese fecha Fin Virtual');
		$("#txt_fecha_fin_vir").focus();
	}
	else{

		var error="";		
		var id="";
		var datos="";
		var datos2="";
		var datosf="";

		datos=$("#detalle_actualizacion .fijo").map(function(index, element) {
			id=this.id.split("_")[1];
			if($("#chk_"+id).attr("checked")){			
	            if($("#slct_dia_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Día",200);
				$("#slct_dia_"+id).focus();
				}
				else if($("#slct_hora_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Hora",200);
				$("#slct_hora_"+id).focus();
				}
				else if($("#slct_tipo_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Tipo Horario",200);
				$("#slct_tipo_"+id).focus();
				}
				else if($("#slct_tipo_ambiente_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Tipo Ambiente",200);
				$("#slct_tipo_ambiente_"+id).focus();
				}
				else if($("#slct_ambiente_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Ambiente",200);
				$("#slct_ambiente_"+id).focus();
				}
				else if($("#slct_tiempo_tolerancia_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Tiempo Tolerancia",200);
				$("#slct_tiempo_tolerancia_"+id).focus();
				}
				else if($("#slct_estado_"+id).val()=='' && error==""){
				error="ok";
				sistema.msjAdvertencia("Seleccionar Estado",200);
				$("#slct_estado_"+id).focus();
				}
				else{
				return $("#slct_dia_"+id).val()+'_'+$("#slct_hora_"+id).val()+'_'+$("#slct_tipo_"+id).val()+'_'+$("#slct_tipo_ambiente_"+id).val()+'_'+$("#slct_ambiente_"+id).val()+'_'+$("#slct_tiempo_tolerancia_"+id).val()+'_'+$("#slct_estado_"+id).val()+'_'+$("#chk_"+id).val();
				}
			}
        }).get().join('|');

		datos2=$("#detalle_actualizacion .agregado").map(function(index, element) {
			id=this.id.split("_")[1];

            if($("#slct_dia_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Día",200);
			$("#slct_dia_"+id).focus();
			}
			else if($("#slct_hora_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Hora",200);
			$("#slct_hora_"+id).focus();
			}
			else if($("#slct_tipo_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Tipo Horario",200);
			$("#slct_tipo_"+id).focus();
			}
			else if($("#slct_tipo_ambiente_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Tipo Ambiente",200);
			$("#slct_tipo_ambiente_"+id).focus();
			}
			else if($("#slct_ambiente_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Ambiente",200);
			$("#slct_ambiente_"+id).focus();
			}
			else if($("#slct_tiempo_tolerancia_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Tiempo Tolerancia",200);
			$("#slct_tiempo_tolerancia_"+id).focus();
			}
			else if($("#slct_estado_"+id).val()=='' && error==""){
			error="ok";
			sistema.msjAdvertencia("Seleccionar Estado",200);
			$("#slct_estado_"+id).focus();
			}
			else{
			return $("#slct_dia_"+id).val()+'_'+$("#slct_hora_"+id).val()+'_'+$("#slct_tipo_"+id).val()+'_'+$("#slct_tipo_ambiente_"+id).val()+'_'+$("#slct_ambiente_"+id).val()+'_'+$("#slct_tiempo_tolerancia_"+id).val();			
			}
        }).get().join('|');
		
		datosf=datos+'^^'+datos2;

		if(error==""){
		$("#actualizacion").css("display","none");
		horarioDAO.guardarHorarios(datosf);
		}
	}			
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

cargar_docente=function(){
	var id=$("#table_docente").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_docente").jqGrid('getRowData',id);
        $('#cprofes').val(id);
        $('#txt_docente').val(data.dappape+' '+data.dapmape+', '+data.dnomper);
		        
		$("#mantenimiento_docente").css("display",'none');
    }else {
	    sistema.msjAdvertencia('Seleccione un registro a cargar');
	}
}

ActualizaAmbiente=function(valor,id,selector){	
	horarioDAO.cargarAmbiente(sistema.llenaSelect,'slct_ambiente_'+id.split("_")[3],selector,valor);
}