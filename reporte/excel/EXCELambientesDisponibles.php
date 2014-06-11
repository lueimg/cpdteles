<?php
session_start();
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

// INCORPORANDO CABECERAS PARA IMPRESION CORRECTA DE UTF-8 USANDO pack("CCC",0xef,0xbb,0xbf);
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header('Content-Disposition: attachment;filename="Ambientes'.'_'.date("Y-m-d_H-i-s").'.xls"');
header("Pragma: no-cache");
header("Expires: 0");
//echo pack("CCC",0xef,0xbb,0xbf);
//obteniendo datos a exportar

//OBTENIENDO DATOS
$filial = $_GET["filial"];
$ambientes = $_GET["ambientes"];
$institucion = $_GET["institucion"];
$where = ''; 

$sql = "SELECT dfilial from filialm where cfilial='$filial'";
$cn->setQuery($sql);
$obj=$cn->loadObject();
$dfilial = $obj->dfilial;

$tableInstitucion = '';
if(!empty($institucion)){
$sql = "select dinstit from instita where cinstit='$institucion'";
$cn->setQuery($sql);
$obj=$cn->loadObject();
$dinstit = $obj->dinstit; 
$tableInstitucion = '<tr><td colspan="2">Institucion :'.$dinstit.' </td></tr>';

}


if(!empty($ambientes))
	$where .= " and ho.cambien in ($ambientes) ";



if(!empty($institucion))
	$where .= " and ins.cinstit = '$institucion' ";


$sql  ="
select  
 hora.chora
,CONCAT(hora.hinici,' - ',hora.hfin) dhora
,dia.cdia
,dia.dnomdia 
,ho.cambien
,amb.numamb
,ins.dinstit
,ins.cinstit
from horprop ho
inner join cuprprp cupr on cupr.ccuprpr = ho.ccurpro
inner join gracprp gra on gra.cgracpr = cupr.cgracpr
inner join diasm dia on dia.cdia = ho.cdia
inner join horam hora on hora.chora = ho.chora
inner join instita ins on ins.cinstit = hora.cinstit
inner join ambienm amb on amb.cambien = ho.cambien
where  1=1
and amb.cfilial = $filial
$where
and ho.cestado = 1
and gra.ffin >= now()
order by hora.hinici asc";
$cn->setQuery($sql);
$horarios=$cn->loadObjectList();


//print "<pre>". var_dump(expression)."</pre>";

foreach ($horarios as $row ) {
	# code...

	$grilla[$row['chora']]['texto']= $row['dhora'];
	$grilla[$row['chora']]['dias'][$row['dnomdia']][] = $row["numamb"];


}



foreach ($grilla as  $row) {
	$tr_horario .="<tr><td>".$row['texto']."</td><td>"
	. @implode('<br>', $row['dias']['LUNES']) ."</td><td>"
	. @implode('<br>', $row['dias']['MARTES']) ."</td><td>"
	. @implode('<br>', $row['dias']['MIERCOLES']) ."</td><td>"
	. @implode('<br>', $row['dias']['JUEVES']) ."</td><td>"
	. @implode('<br>', $row['dias']['VIERNES']) ."</td><td>"
	. @implode('<br>', $row['dias']['SABADO']) ."</td><td>"
	. @implode('<br>', $row['dias']['DOMINGO']) ."</td></tr>";
	
}


$html = <<<EOD
<table>
<tr><td colspan="2">Filial : {$dfilial}</td></tr>
{$tableInstitucion}
</table>
<table border=1 style="vertical-align:middle">
<tr><td>Hora</td><td>LUNES</td><td>MARTES</td><td>MIERCOLES</td><td>JUEVES</td><td>VIERNES</td><td>SABADO</td><td>DOMINGO</td></tr>
{$tr_horario}
</table>

EOD;


print $html;






