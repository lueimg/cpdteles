<?php
set_time_limit(0);
ini_set('memory_limit','512M');
//$idencuesta=$_GET['idenc'];
//$empresa=$_GET['empresa'];

/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

/****TCPDF Libreria****/
require_once '../../php/includes/tcpdf/config/lang/spa.php';
require_once '../../php/includes/tcpdf/tcpdf.php';

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//hoja A4

/*****CONFIGURACION PDF****/
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Segura');

// remove default header
$pdf->setPrintHeader(false);//elimina cabecera

// remove default footer
$pdf->setPrintFooter(false);//elimina pie

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// $pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFont('helvetica', '', 8);
/* QUERYS */
$lista_grupo = $_GET['docentes'];
$grupos = explode(',', $lista_grupo);

$sql = "
select  
cupr.cprofes,
hora.chora,
hora.hinici ini , hora.hfin fin
,dia.dnomdia 
,cupr.ccurso
,gra.ccarrer
,gra.cinstit
,gra.cfilial
from horprop ho
left join cuprprp cupr on cupr.ccuprpr = ho.ccurpro
left join gracprp gra on gra.cgracpr = cupr.cgracpr
left join diasm dia on dia.cdia = ho.cdia
left join horam hora on hora.chora = ho.chora 
where  
cupr.cprofes in (2)
AND cupr.ffinpre > now()
and ho.cestado = 1
and hora.hinici is not null
order by hora.hinici asc
";

$cn->setQuery($sql);
$horarios = $cn->loadObjectList();

//PASAR DE LINEAL A MULTIDIMENCIONAL
$grilla = array();
foreach($horarios as $row){

$grilla[$row['cprofes']][$row['chora']][$row['dnomdia']][] = $row['cfilial'] . ' - ' .$row['cinstit'] . ' - '.$row['ccarrer'] . ' - '.$row['ccurso'];
}



foreach ($grilla as $profes) { // Inicio de Recorrido



foreach ($horario as  $row) {
	# code...
	// print '<pre>';
	// print_r($row);
	// print "</pre>";
	$tr_horario .="<tr><td>".$row['ini']. ' - '.$row['fin']."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['lunes'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['martes'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['miercoles'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['jueves'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['viernes'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['sabado'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['domingo'] ) ."</td></tr>";
	// .$data_cursos[$row['martes']]."</td><td>"
	// .$data_cursos[$row['miercoles']]."</td><td>"
	// .$data_cursos[$row['jueves']]."</td><td>"
	// .$data_cursos[$row['viernes']]."</td></tr>";
	// print $tr_cursos;
	// $grupo_cursos [] = "'". $curso["ccuprpr"] . "'";
	// print $tr_horario;

}
/***********ADD A PAGE************/
$pdf->AddPage('L', 'A4');





$html = <<<EOD
<style>
body{

}
.textleft{
 text-align:left;
}
.textright{
text-align:right;
font-weight:bold;
}

.textcenter{
	text-align:center;
}

.tdcabecera{
	text-align:center;
	font-weight:bold;


}
</style>
<div style='text-align:center'><h1>Horario Académico Programado</h1></div>

<table class="cabecera" style='width:100%' cellpadding="2">
	<tr>
		<td style="text-align:left;">

			<table class="grupo_info" border="1" style='width:100%' cellpadding="2" >
					{$tr_grupo_info}
				</table>
		

		</td>
		<td style="text-align:left">

				<table class="prefesores_info" border="1" style='width:100%' cellpadding="3" >
					<tr>
						<th><b>Curso</b></th>
						<th><b>Profesor</b></th>
						<th><b>Creditos</b></th>
					</tr>
					{$tr_cursos}
				</table>
		</td>
	</tr>

</table>

	

	<h3>Horario:</h3>
	<table border="1" style='width:100%' cellpadding="2" >
	<tr>
	<th><b>Hora</b></th>
	<th><b>Lunes</b></th>
	<th><b>Martes</b></th>
	<th><b>Miercoles</b></th>
	<th><b>Jueves</b></th>
	<th><b>Viernes</b></th>
	<th><b>Sabado</b></th>
	<th><b>Domingo</b></th>
	</tr>
	{$tr_horario}
	</table>

EOD;


$pdf->writeHTML($html, true, false, true, false, '');
/*******FIN PROCESO*******/
// reset pointer to the last page
$pdf->lastPage();

}

// print $html;








//Close and output PDF document
$pdf->Output('HorariosGrupo.pdf', 'I');
?>