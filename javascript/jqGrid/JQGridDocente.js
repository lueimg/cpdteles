var jqGridDocente={
	type:'json',	
	Docente:function(){
		var gridTU=$('#table_docente').jqGrid({
			url:'../controlador/controladorSistema.php?comando=docente&accion=jqgrid_docente&cestado=1',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','Fecha Ingreso'],
			colModel:[				
				{name:'dappape',index:'dappape',align:'left',width:150},
				{name:'dapmape',index:'dapmape',align:'left',width:150},
				{name:'dnomper',index:'dnomper',align:'left',width:150},
				{name:'ndniper',index:'ndniper',align:'center',width:100},				
                {name:'fingreso',index:'fingreso',align:'left',width:100},
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_docente',
			sortname:'pe.dappape,pe.dapmape,pe.dnomper',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_docente').jqGrid('navGrid','#pager_table_docente',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_docente").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara		
        $("#table_docente").jqGrid('navButtonAdd',"#pager_table_docente",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_docente").jqGrid('navButtonAdd',"#pager_table_docente",{
            caption:"",
            title:"Cargar", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_docente();
            } 
        }); 
	}
}