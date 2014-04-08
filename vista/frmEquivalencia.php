<div id="frmEquivalencia" title="MANTENIMIENTO OPCIONES DE SISTEMA" class="corner_all" style="background: #ffffff;margin:7px;height: auto">
    <form>
        <div id="frmErr_mtn" style="display: none" align="center" class="ui-state-error ui-corner-all ">Ingrese todos los campos</div>
        <table cellspacing="1" cellpadding="2" border="0" style="table-layout:fixed" class="EditTable">
            
            <tr class="FormData">
                <td>1. Seccione un curso Refencia
                    <table>
                      <tr class="FormData">
                <td class="t-left label" >
                    <b>Instituto: </b>
                </td>
                <td class="t-left">
                    <select id="slct_instituto" style="width:120px">
                        <option value="">--Seleccione--</option>
                    </select>
                </td>
            </tr>
            <tr class="FormData">
                <td class="t-left label" >
                    <b>Carrera: </b>
                </td>
                <td class="t-left">
                    <select id="slct_carrera" style="width:120px">
                        <option value="">--Seleccione--</option>
                    </select>
                </td>
            </tr>
                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Curricula: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_curricula" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Modulo: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_modulo" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Curso: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_curso" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>2. Seleccione un curso de acta
                    <table>
                        <tr class="FormData">
                <td class="t-left label" >
                    <b>Instituto: </b>
                </td>
                <td class="t-left">
                    <select id="slct_instituto_asig" style="width:120px">
                        <option value="">--Seleccione--</option>
                    </select>
                </td>
            </tr>
            <tr class="FormData">
                <td class="t-left label" >
                    <b>Carrera: </b>
                </td>
                <td class="t-left">
                    <select id="slct_carrera_asig" style="width:120px">
                        <option value="">--Seleccione--</option>
                    </select>
                </td>
            </tr>
                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Curricula: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_curricula_asig" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Modulo: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_modulo_asig" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="FormData">
                            <td class="t-left label" >
                                <b>Curso: </b>
                            </td>
                            <td class="t-left">
                                <select id="slct_curso_asig" style="width:120px">
                                    <option value="">--Seleccione--</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="FormData">
                <td class="t-left label" >
                    <b>Tipo de Equivalencia: </b>
                </td>
                <td class="t-left">&nbsp;
                    <select id="slct_tequi" style="width:80px">
                        <option value="r">Regular</option>
                        <option value="i">Irregular</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <input type="hidden" value=""id="cequiasg">
                    <a id="btnFormEquivalencia" class="button fm-button ui-corner-all fm-button-icon-left" style="margin-top: 10px">
                        <span id="spanBtnFormEquivalencia"></span><span class="icon-hdd"></span>
                    </a>
                </td>
            </tr>
        </table>
    </form>
</div>