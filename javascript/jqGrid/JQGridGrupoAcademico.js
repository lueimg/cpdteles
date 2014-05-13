var jQGridGrupoAcademico={
    type:'json',
    idLayerMessage:'layerMessage',
    GrupoAcademico: function(){
        var gridC=$('#table_grupo_academico').jqGrid({
            url:'../controlador/controladorSistema.php?comando=grupo_academico&action=jqgrid_grupo_academico',
            datatype:this.type,
            gridview:true,
            height:230,
            colNames:[
                'Turno',
                'Carrera',
                'Ciclo',
                "Inicio",
                "Fecha Inicio",
                "Horario",
                "Meta. Matri",
                "Ins. Sin Posib. Matri",
                "Ins. Con Posib. Matri",
                "Matricula",
                "Vacantes",
                "Indice"
            ],
            colModel:[               

        {name:'dturno',index:'dturno',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true}, 
        {name:'dcarrer',index:'dcarrer',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'csemaca',index:'csemaca',align:'center',width:50,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'cinicio',index:'cinicio',align:'center',width:40,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'finicio',index:'finicio',align:'center',width:70,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'horario',index:'horario',align:'left',width:220,editable:true,editrules:{required:true},sorttype:"text"},   
        {name:'nmetmat',index:'nmetmat',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
        {name:'menor',index:'menor',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
        {name:'mayor',index:'mayor',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
        {name:'totalmatriculados',index:'totalmatriculados',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
        {name:'vacantes',index:'vacantes',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
        {name:'indices',index:'indices',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
            ],
            rowNum:10,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_grupo_academico',
            sortname:'c.dcarrer',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_grupo_academico").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_grupo_academico').jqGrid('navGrid','#pager_table_grupo_academico',{edit:false,add:false,del:false,view:false,search:false});
        
        // Agregango boton custom
        $("#table_grupo_academico").jqGrid('navButtonAdd',"#pager_table_grupo_academico",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
        //fin boton custom
    }
}


