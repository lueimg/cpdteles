$(document).ready(function() {
    $("#nav-mantenimientos").addClass("ui-corner-all active");
    institucionDAO.cargarInstitucionValida(sistema.llenaSelect, "slct_instituto", "");
    
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
    
    
    
    
    
    $('#frmEquivalencia').dialog({
        autoOpen: false,
        show: 'fade', hide: 'fade',
        modal: true,
        width: 'auto', height: 'auto'
    });
// TEMPLATES
// LOS TEMPLATES USADOS SE ENCUENTRAN EN FRMEQUIVALENCIA.PHP

window.templatesHtml = {}
templatesHtml.nuevoCursoActa =  _.template( $("#TemplateCurso").html() );

});

limpiarSelect=function(select){
  $("#"+select).val("");
}

cargarCursos=function(){
    
    var modulo =$("#slct_modulo").val();
    var curricula =$("#slct_curricula").val();
    equivalenciaDAO.cargarCursos(sistema.llenaSelect, "slct_curso", "");   
}

cargarCursos_asig=function(id){
    
    var modulo =$("#slct_modulo_asig_"+id).val();
    var curricula =$("#slct_curricula_asig_"+id).val();
    equivalenciaDAO.cargarCursos_asig(id,sistema.llenaSelect, "slct_curso_asig_"+id, "");   
}

add_equivalencia_jqgrid = function() {
    $("select").val("");
    // $('#btnFormEquivalencia').attr('onclick', 'nuevoEquivalencia()');
    // $('#spanBtnFormEquivalencia').html('Guardar');
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

GuardarCambiosEquivalencia = function(){
    //validar que exista al menos 1
    var cursosActa = $("#frmEquivalencia #cursosActa select").length;
    // console.log(cursosActa);
    if(cursosActa == 0){
        // console.log('agregar equivalencia');
        sistema.msjAdvertencia('Agrege al menos un curso de Acta',2500)
        return false;
    }
    //REVISAR SELECTS
    var selects = $("#frmEquivalencia [id^='slct']");
    for(var i = 0 ; i <= selects.length ; i++){
        if( !sistema.requeridoSlct($(selects[i]).attr('id')) ){
            return false;
            break;
        }
    }
   

    // mapear todos los select de _asig_id
    
   // equivalenciaDAO.addEquivalencia();


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



AgregarCurso = function(){
    var tot=0;
    var htm=""; 
    tot = $("#txt_cant_cur").val()*1 + 1;
    $("#txt_cant_cur").val(tot);
    $("#cursosActa").append(templatesHtml.nuevoCursoActa({id:tot}));

    $('#frmEquivalencia').dialog("option", "position", "center");
    //SE AGREGAN LOS DATOS
    institucionDAO.cargarInstitucionValida(sistema.llenaSelect, "slct_instituto_asig_"+tot, "");

    $("#slct_instituto_asig_"+tot).change(function(){
        equivalenciaDAO.cargarCarreras_asig(tot ,sistema.llenaSelect, "slct_carrera_asig_"+tot, "");
        limpiarSelect("slct_curso_asig_"+tot);
        limpiarSelect("slct_modulo_asig_"+tot);
        limpiarSelect("slct_curricula_asig_"+tot);
    });
    $("#slct_carrera_asig_"+tot).change(function(){
        equivalenciaDAO.cargarCurriculas_asig(tot,sistema.llenaSelect, "slct_curricula_asig_"+tot, "");
        equivalenciaDAO.cargarModulos_asig(tot,sistema.llenaSelect, "slct_modulo_asig_"+tot, "");
        limpiarSelect("slct_curso_asig_"+tot);
    });
    
    $("#slct_modulo_asig_"+tot).change(function(){
        cargarCursos_asig(tot);
    });
    $("#slct_curricula_asig_"+tot).change(function(){
        cargarCursos_asig(tot);
    });


}


RemoverCurso = function (i){
    $(i).parent().parent().parent().remove();
    $('#frmEquivalencia').dialog("option", "position", "center");

}




















    