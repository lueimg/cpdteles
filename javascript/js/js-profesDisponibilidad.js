$().ready(function(){

$("#HorarioDisponible").hide();
jqGridDocente.Docente();

window.templatesHtml = {}
templatesHtml.nuevoRow =  _.template( $("#TemplateDisponible").html() );



});



function cargar_docente(){
var id=$("#table_docente").jqGrid("getGridParam",'selrow');
    if (id) {
         // var data = $("#table_docente").jqGrid('getRowData',id);
        // console.log(data);
    var data = profesDisponibilidadDAO.cargarHorario();
    $(".newrow").remove();
    data.forEach(function(el){
        //AGREGO REGISTRO
        AgregarRow();
        var indice = $("#txt_cant_dis").val();
        $("#cdispro_"+indice).val(el.cdispro);
        $("#slct_dia_"+indice).val(el.cdia);
        $("#slct_estado_"+indice).val(el.cestado);
        $("#slct_hini_h_"+indice).val(el.hini.split(":")[0]);
        $("#slct_hini_m_"+indice).val(el.hini.split(":")[1]);
        $("#slct_hfin_h_"+indice).val(el.hfin.split(":")[0]);
        $("#slct_hfin_m_"+indice).val(el.hfin.split(":")[1]);
        $(".row-"+indice).find("select").attr("disabled","true");
        $("#slct_estado_"+indice).removeAttr("disabled");
        $(".newbotones_"+indice).remove();


    });
    $("#HorarioDisponible").show("slow");


    }else {
        sistema.msjAdvertencia('Seleccione un registro a cargar');
    }

}

//AGREGA UN REGISTRO CON LISTADO DE DIAS  Y PARA QUE AGREGE HORAS
function AgregarRow(){
var tot=0;
    var htm=""; 
    tot = $("#txt_cant_dis").val()*1 + 1;
    $("#txt_cant_dis").val(tot);
    $("#diasDisponibles").append(templatesHtml.nuevoRow({id:tot}));
}

function removerRow(id){
    $(".row-"+id).remove();
}


//GUARDA LOS ROWS AGREGADOS AL PROFESOR
function GuardarDisponibilidad(){

    //validar que exista al menos 1
    var rows = $("#diasDisponibles select").length;
    // console.log(cursosActa);
    if(rows == 0){
        sistema.msjAdvertencia('Agrege al menos un horario',2500)
        return false;
    }

    //VALIDAR QUE POR REGISTRO HFIN SEA MAYOR QUE HINI

    //JUNTAR DATOS
    var data = _.map($(".newrow"),function(i){
        var el = $(i);
         var selects = _.map( el.find("select"),function(i){ return $(i).val(); });
         return el.find("input").val() + "-" + selects.join("-");
    });
    var datarows = data.join("|");

    profesDisponibilidadDAO.guardarDisponibilidad(datarows);
    
    $(".newrow").remove();
    $("#HorarioDisponible").hide("slow");


}

//QUITA LOS REGISTROS AGREGADOS NO GUARDADOS
function Cancelar(){
    $(".newrow").remove();
    $("#HorarioDisponible").hide();

}














