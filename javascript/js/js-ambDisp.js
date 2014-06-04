$(document).ready(function(){
	
	/*dialog*/	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelect,'slct_filial','');
	institucionDAO.cargarInstitucionValida(sistema.llenaSelect,'slct_instituto','');	
	$("#slct_filial").change(function(){cargaAmbiente();});
})

cargaAmbiente=function(){
	if($.trim($("#slct_filial").val())=="")	{		
	sistema.limpiaSelect('slct_ambiente');	
	}else{	
	carreraDAO.cargaAmbiente(sistema.llenaSelect,'slct_ambiente','');	
	}
}




