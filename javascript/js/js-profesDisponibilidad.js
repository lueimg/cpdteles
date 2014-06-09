$().ready(function(){

jqGridDocente.Docente();

window.templatesHtml = {}
templatesHtml.nuevoRow =  _.template( $("#TemplateDisponible").html() );

});



function cargar_docente(){
var id=$("#table_docente").jqGrid("getGridParam",'selrow');
    if (id) {
        var data = $("#table_docente").jqGrid('getRowData',id);

        



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
         return selects.join("-");
    });
    var datarows = data.join("|");

    profesDisponibilidadDAO.guardarDisponibilidad(datarows);

}

//QUITA LOS REGISTROS AGREGADOS NO GUARDADOS
function Cancelar(){

}














