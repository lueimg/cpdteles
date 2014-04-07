$(document).ready(function() {
    $("#nav-mantenimientos").addClass("ui-corner-all active");
    institucionDAO.cargarInstitucionValida(sistema.llenaSelect, "slct_instituto", "");
    //carreraDAO.cargarCarrera(sistema.llenaSelect, "slct_carrera", "");
    
    jQGridEquivalencia.Equivalencia();
    
    $("#slct_instituto").change(function(){
        equivalenciaDAO.cargarCarreras(sistema.llenaSelect, "slct_carrera", "");
    });
    
    
    $("#slct_carrera").change(function(){
        equivalenciaDAO.cargarCurriculas(sistema.llenaSelect, "slct_curricula", "");
        equivalenciaDAO.cargarModulos(sistema.llenaSelect, "slct_modulo", "");
        /* cargas para actas */
        equivalenciaDAO.cargarCurriculas(sistema.llenaSelect, "slct_curricula_asig", "");
        equivalenciaDAO.cargarModulos(sistema.llenaSelect, "slct_modulo_asig", "");
    });
    $("#slct_modulo").change(function(){
        cargarCursos();
    });
    $("#slct_curricula").change(function(){
        cargarCursos();
    });
    
    $("#slct_modulo_asig").change(function(){
        cargarCursos_asig();
    });
    $("#slct_curricula_asig").change(function(){
        cargarCursos_asig();
    });
    
    
    $('#frmEquivalencia').dialog({
        autoOpen: false,
        show: 'fade', hide: 'fade',
        modal: true,
        width: 'auto', height: 'auto'
    });

});
cargarCursos=function(){
    
    var modulo =$("#slct_modulo").val();
    var curricula =$("#slct_curricula").val();
    equivalenciaDAO.cargarCursos(sistema.llenaSelect, "slct_curso", "");   
}

cargarCursos_asig=function(){
    
    var modulo =$("#slct_modulo_asig").val();
    var curricula =$("#slct_curricula_asig").val();
    equivalenciaDAO.cargarCursos_asig(sistema.llenaSelect, "slct_curso_asig", "");   
}

add_equivalencia_jqgrid = function() {
    $("select").val("");
    $('#btnFormEquivalencia').attr('onclick', 'nuevoEquivalencia()');
    $('#spanBtnFormEquivalencia').html('Guardar');
    $('#frmEquivalencia').dialog('open');
}


// campos a enviar al ajax para insertar
nuevoEquivalencia = function() {
    var a = new Array();
    a[0] = sistema.requeridoSlct('slct_curso');
    a[1] = sistema.requeridoSlct('slct_curso_asig');

    for (var i = 0; i < 2; i++) {
        if (!a[i]) {
            return false;
            break;
        }
    }
    equivalenciaDAO.addEquivalencia();
    //si valida todo envia a insertar persona
//	personalDAO.InsertarPersonal();
}

edit_hora_jqgrid = function() {
    var id = $("#table_hora").jqGrid("getGridParam", 'selrow');
    $("#frmEquivalencia .form i").remove();
    if (id) {
        var data = $("#table_hora").jqGrid('getRowData', id);
        $('#id_hora').val(id);
        $('#slct_instituto').val(data.cinstit);
        $('#slct_turno').val(data.cturno);
        $('#txt_hini').val(data.hinici.substring(0, 2));
        $('#txt_mini').val(data.hinici.substring(5, 3));
        $('#txt_hfin').val(data.hfin.substring(0, 2));
        $('#txt_mfin').val(data.hfin.substring(5, 3));
        $('#slct_thorari').val(data.thorari);
        $('#slct_chora').val(data.thora);
        $('#slct_estado').val(data.cestado);
        $('#frmEquivalencia input[type="text"],#frmEquivalencia select').attr('disabled', 'true');
        $('#slct_estado').removeAttr('disabled');
        $('#btnFormEquivalencia').attr('onclick', 'modificarOpcion()');
        $('#spanBtnFormEquivalencia').html('Modificar');
        $('#frmEquivalencia').dialog('open');
    } else {
        sistema.msjAdvertencia('Seleccione <b>Equivalencia</b> a Editar')
    }
}

modificarOpcion = function() {
    var a = new Array();
    a[0] = sistema.requeridoTxt('slct_instituto');
    a[1] = sistema.requeridoTxt('slct_turno');
    a[2] = sistema.requeridoTxt('txt_hini');
    a[3] = sistema.requeridoTxt('txt_mini');
    a[4] = sistema.requeridoTxt('txt_hfin');
    a[5] = sistema.requeridoTxt('txt_mfin');
    a[6] = sistema.requeridoSlct('slct_thorari');
    a[7] = sistema.requeridoSlct('slct_chora');
    a[8] = sistema.requeridoSlct('slct_estado');
    for (var i = 0; i < 9; i++) {
        if (!a[i]) {
            return false;
            break;
        }
    }
    horaDAO.editEquivalencia();
}

    