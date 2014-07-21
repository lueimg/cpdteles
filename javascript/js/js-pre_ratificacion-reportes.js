$(document).ready(function(){




    $('#tablecurso').dialog({
        autoOpen: false,
        show: 'fade', hide: 'fade',
        modal: true,
        width: 'auto', height: 'auto'
    });


});

verHorario=function(cod){
grupoAcademicoDAO.cargarDetalleGrupo(sistema.llenaSelect,'slct_seccion','',cod);

}

VerHorarioGeneral=function(){

}