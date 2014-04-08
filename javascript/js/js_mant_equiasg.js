$(document).ready(function() {
    $("#nav-mantenimientos").addClass("ui-corner-all active");
    institucionDAO.cargarInstitucionValida(sistema.llenaSelect, "slct_instituto", "");
    institucionDAO.cargarInstitucionValida(sistema.llenaSelect, "slct_instituto_asig", "");
    //carreraDAO.cargarCarrera(sistema.llenaSelect, "slct_carrera", "");
    
    jQGridEquivalencia.Equivalencia();
    
    $("#slct_instituto").change(function(){
        equivalenciaDAO.cargarCarreras(sistema.llenaSelect, "slct_carrera", "");
        limpiarSelect("slct_curso");
        limpiarSelect("slct_modulo");
        limpiarSelect("slct_curricula");
    });
    
    
    
    
    $("#slct_carrera").change(function(){
        equivalenciaDAO.cargarCurriculas(sistema.llenaSelect, "slct_curricula", "");
        equivalenciaDAO.cargarModulos(sistema.llenaSelect, "slct_modulo", "");
        limpiarSelect("slct_curso");
        
    });
    
    $("#slct_modulo").change(function(){
        cargarCursos();
    });
    $("#slct_curricula").change(function(){
        cargarCursos();
    });
    
    
    $("#slct_instituto_asig").change(function(){
        equivalenciaDAO.cargarCarreras_asig(sistema.llenaSelect, "slct_carrera_asig", "");
        limpiarSelect("slct_curso_asig");
        limpiarSelect("slct_modulo_asig");
        limpiarSelect("slct_curricula_asig");
    });
    $("#slct_carrera_asig").change(function(){
        equivalenciaDAO.cargarCurriculas_asig(sistema.llenaSelect, "slct_curricula_asig", "");
        equivalenciaDAO.cargarModulos_asig(sistema.llenaSelect, "slct_modulo_asig", "");
        limpiarSelect("slct_curso_asig");
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

limpiarSelect=function(select){
  $("#"+select).val("");
}

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


edit_equivalencia_jqgrid=function(){
  
  
   var id = $("#table_hora").jqGrid("getGridParam", 'selrow');
    $("#frmEquivalencia .form i").remove();
    if (id) {
        var data = $("#table_hora").jqGrid('getRowData', id);
        $('#cequiasg').val(id);
       //CARGANDO DATOS 1 SECCION DE SELECTS 
        $("#slct_instituto").val(data.inst).trigger("change");
        $("#slct_carrera").val(data.carrer).trigger("change");
        $("#slct_curricula").val(data.ccurric).trigger("change");
        $("#slct_modulo").val(data.cciclo).trigger("change");
        $("#slct_curso").val(data.ccurso);
        
        //CARGANDO DATOS 1 SECCION DE SELECTS 
        $("#slct_instituto_asig").val(data.insta).trigger("change");
        $("#slct_carrera_asig").val(data.carrera).trigger("change");
        $("#slct_curricula_asig").val(data.ccurrica).trigger("change");
        $("#slct_modulo_asig").val(data.ccicloa).trigger("change");
        $("#slct_curso_asig").val(data.ccursoa);
        
        $("#slct_tequi").val(data.cestide);
        
        $('#btnFormEquivalencia').attr('onclick', 'modificarEquivalencia()');
        $('#spanBtnFormEquivalencia').html('Modificar');
        $('#frmEquivalencia').dialog('open');
    } else {
        sistema.msjAdvertencia('Seleccione <b>Equivalencia</b> a Editar')
    }
  
}

modificarEquivalencia = function(){
  var a = new Array();
    a[0] = sistema.requeridoSlct('slct_curso');
    a[1] = sistema.requeridoSlct('slct_curso_asig');

    for (var i = 0; i < 2; i++) {
        if (!a[i]) {
            return false;
            break;
        }
    }
    equivalenciaDAO.EditarEquivalencia();
}

delete_equivalencia_jqgrid = function(){
  var id = $("#table_hora").jqGrid("getGridParam", 'selrow');
    $("#frmEquivalencia .form i").remove();
    if (id) {
   
      var respuesta =  window.confirm("Esta segurio de eliminar esta equivalencia");
      if(respuesta){
        equivalenciaDAO.EliminarEquivalencia(id);
      }
    }else {
        sistema.msjAdvertencia('Seleccione <b>Equivalencia</b> a Editar')
    }
}


    