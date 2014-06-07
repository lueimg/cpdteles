$().ready(function(){

jqGridDocente.Docente();


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

}

//GUARDA LOS ROWS AGREGADOS AL PROFESOR
function GuardarDisponibilidad(){

}

//QUITA LOS REGISTROS AGREGADOS NO GUARDADOS
function Cancelar(){

}