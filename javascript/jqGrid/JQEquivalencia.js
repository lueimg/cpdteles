var jQGridEquivalencia = {
    type: 'json',
    idLayerMessage: 'layerMessage',
    Equivalencia: function() {
        var gridC = $('#table_hora').jqGrid({
            url: '../controlador/controladorSistema.php?comando=equivalencia&action=jqgrid_equivalencia',
            datatype: this.type,
            gridview: true,
            height: 345,
            colNames: [
                "Curricula",
                "ccurric",
                "Ciclo",
                "cciclo",
                "Curso",
                "ccurso",
                "Curricula Asignada",
                "ccurrica",
                "Ciclo Asig",
                "ccicloa",
                "Curso Asig",
                "ccursoa",
                'Identificador',
                'cestide',
                'inst',
                'carrer',
                'insta',
                'carrera'
            ],
            colModel: [
                //{name:'chora',index:'chora',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text"},
                {name: 'dtitulo', index: 'dtitulo', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text"},
                {name: 'ccurric', index: 'ccurric', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'dciclo', index: 'dciclo', align: 'center', width: 60, editable: true, editrules: {required: true}, sorttype: "text"},
                {name: 'cciclo', index: 'cciclo', align: 'center', width: 60, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'dcurso', index: 'dcurso', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text"},
                {name: 'ccurso', index: 'ccurso', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'dtituloa', index: 'dtituloa', align: 'center', width: 180, editable: true, editrules: {required: true}, sorttype: "text"}, //" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
                {name: 'ccurrica', index: 'ccurrica', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'dcicloa', index: 'dcicloa', align: 'center', width: 60, editable: true, editrules: {required: true}, sorttype: "text"}, //" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
                {name: 'ccicloa', index: 'ccicloa', align: 'left', width: 60, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'dcursoa', index: 'dcursoa', align: 'center', width: 180, editable: true, editrules: {required: true}, sorttype: "text"}, //" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
                {name: 'ccursoa', index: 'ccursoa', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'estide', index: 'estide', align: 'left', width: 120, editable: true, editrules: {required: true}, stype: "select", edittype: "select", editoptions: {value: " : ;r:Regular;i:Irregular"}},
                {name: 'cestide', index: 'cestide', align: 'left', width: 60, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'inst', index: 'inst', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'carrer', index: 'carrer', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'insta', index: 'insta', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
                {name: 'carrera', index: 'carrera', align: 'left', width: 180, editable: true, editrules: {required: true}, sorttype: "text", hidden: true},
        
        ],  
            rowNum: 15,
            //rowList:[5,10],
            rownumbers: true,
            pager: '#pager_table_hora',
            sortname: 'e.cequisag',
            sortorder: 'asc',
            loadui: "block"
        });

        $("#table_hora").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_hora').jqGrid('navGrid', '#pager_table_hora', {edit: false, add: false, del: false, view: false, search: false});

        //Agregando boton Insert
        $('#table_hora').jqGrid('navButtonAdd', 'pager_table_hora', {
            caption: "",
            title: "Agregar Equivalencia de cursos",
            buttonicon: 'ui-icon-plus',
            onClickButton: function() {
                add_equivalencia_jqgrid();
            }
        });

        $('#table_hora').jqGrid('navButtonAdd', 'pager_table_hora', {
            caption: "",
            title: "Editar Equivalencia de cursos",
            buttonicon: 'ui-icon-pencil',
            onClickButton: function() {
                edit_equivalencia_jqgrid();
            }
        });
        
        $('#table_hora').jqGrid('navButtonAdd', 'pager_table_hora', {
            caption: "",
            title: "Editar Equivalencia de cursos",
            buttonicon: 'icon-remove',
            onClickButton: function() {
                delete_equivalencia_jqgrid();
            }
        });
        
        
        // Agregango boton custom
        $("#table_hora").jqGrid('navButtonAdd', "#pager_table_hora", {
            caption: "",
            title: "Buscar Registro",
            buttonicon: 'icon-search',
            onClickButton: function() {
                gridC[0].toggleToolbar()
            }
        });
        //fin boton custom
    }
}


