<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>
		<title>SGC2</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link rel="shortcut icon" href="../images/favicon.ico">

		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
		<link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />

		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>

		<script type="text/javascript" src="../javascript/sistema.js"></script>
		<script type="text/javascript" src="../javascript/templates.js"></script>

		<script type="text/javascript" src="../javascript/js/js-pre_ratificacion.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JqGridPersona.js"></script>
        <script type="text/javascript" src="../javascript/jqGrid/JQGridGrupoAcademico.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOpago.js"></script>  
        <script type="text/javascript" src="../javascript/dao/DAOplancurricular.js"></script>  
    </head>

	<body>
		<div id="capaOscura" class="capaOscura" style="display:none"></div>
		<div id="capaCargando" class="capaCargando" style="display:none"><div class="girando"><div class="estrella"></div></div></div>
		<?require_once('ifrm-header.php')?>	
		<?require_once('ifrm-nav.php')?>	
        <div class="contenido">
			<div class="cuerpo">
				<div class="secc-izq" id="secc-izq" style="width:0px;">
					<ul class="lca" style="display:none">
						<li id="list_buscar_alu" onclick="sistema.activaPanel('list_buscar_alu','panel_buscar_alu')" class="active"><span><i class="icon-gray icon-list-alt"></i> Buscar </span></li>
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_buscar_alu" style="display:block">
    					<div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>BUSCAR ALUMNO</b></div>         
                        <div class="cont-der">

                            <!-- inicio buscar -->
                            <div style="overflow:auto;">
                                <table id="table_persona_ingalum"></table>
                                <div id="pager_table_persona_ingalum"></div>
                            </div>
                            <!-- fin buscar -->

                            <div class="barra4 contentBarra t-blanco"><i class="icon-white icon-th"></i> PRE RATIFICACION DEL ALUMNO</div>
                        	<br>
                        	<table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed;" class="EditTable">
                              <tr class="FormData">
                              	<td class="t-left label" >
                                  <b>Alumno</b>
                                </td>
                                <td class="t-left">
                                  <input type="text" id="txt_nombre" class="input-large" disabled>
                                  <input type="hidden" id="txt_cingalu">
                                  <input type="hidden" id="txt_cgracpr">
                                </td>                                
                              </tr>
                              
                              <tr class="FormData">
                              	<td colspan='2'>
                            		<table><tr><td>
                                    <div style="overflow:auto;">
                                        <table id="table_grupo_academico"></table>
                                        <div id="pager_table_grupo_academico"></div>
                                    </div>
                                    </td><td>                                    
                                    <div class="corner_top ui-state-default" style="font-weight:bold">
                                    <table border="1" cellpadding="0" cellspacing="0">
                                        <tr class="" align="center">                              
                                            <td class="t-center " width="55px">CICLO</td>
                                            <td class="t-center " width="80px" >CURSO</td>
                                            <td class="t-center " width="55px" >CREDITOS</td>
                                            <td class="t-center " width="80px">ESTADO</td>
                                        </tr>
                                    </table>
                                    </div>                                    
                                    <div class="ui-widget-content_jqgrid" style="overflow: auto;height: 230px">
                                    <table id="lista_plan" cellspacing="1" cellpadding="1" border="1"> </table>
                                    </div>
                                    <div class="corner_bottom ui-state-default" style="text-align: right;height: 20px;padding: 2px;">
                                        <span class="hv_icon corner_all" style="margin:2px -3px 0px 0px;" onclick="sistema.mostrar_cerrar_buscar('txtPlanCurricular','buscarPlanCurricular')">
                                        <i id="buscarPlanCurricular" class="icon-gray icon-search"></i>
                                        </span>
                                        
                                        <span style="display:inline-block;vertical-align:top">
                                        <input id="txtPlanCurricular" class="input_buscar" type="text" style="width: 150px;display: none;" onkeyup="sistema.buscarEnTable(this.value,'lista_plan')">
                                        </span>
                                    </div>  
                                    </td></tr></table>                                  
                                </td>
                              </tr>
                            </table>

                        </div>
    				</div>
					
            	</div>
			</div>
		</div>
		

        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
