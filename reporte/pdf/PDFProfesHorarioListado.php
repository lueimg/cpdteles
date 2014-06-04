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
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// $pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFont('helvetica', '', 8);
/* QUERYS */
$lista_docentes = $_GET['docentes'];
// $docentes = explode(',', $lista_docentes);

$sql = "
select  
cupr.cprofes,
hora.chora
,CONCAT(hora.hinici,' - ',hora.hfin) dhora
,dia.dnomdia 
,cupr.ccurso
,cur.dcurso
,gra.ccarrer
,car.dcarrer
,gra.cinstit
,ins.dinstit
,gra.cfilial
,fil.dfilial
from horprop ho
inner join cuprprp cupr on cupr.ccuprpr = ho.ccurpro
inner join gracprp gra on gra.cgracpr = cupr.cgracpr
inner join diasm dia on dia.cdia = ho.cdia
inner join horam hora on hora.chora = ho.chora
inner join cursom cur on cur.ccurso = cupr.ccurso
inner join carrerm car on car.ccarrer = gra.ccarrer
inner join instita ins on ins.cinstit = gra.cinstit
inner join filialm fil on fil.cfilial= gra.cfilial
where  
cupr.cprofes in ($lista_docentes)
and ho.cestado = 1
and hora.hinici is not null
order by hora.hinici asc
";

$cn->setQuery($sql);
$horarios = $cn->loadObjectList();

//PASAR DE LINEAL A MULTIDIMENCIONAL
$grilla = array();
foreach($horarios as $row){

// $grilla[$row['cprofes']][$row['chora']][$row['dnomdia']][] = $row['cfilial'] . ' - ' .$row['cinstit'] . ' - '.$row['ccarrer'] . ' - '.$row['ccurso'];

// $grilla[$row['cprofes']][$row['chora']]['texto']= $row['dhora'];
// $grilla[$row['cprofes']][$row['chora']]['dias'][$row['dnomdia']][] = $row['dfilial'] . ' - ' .$row['dinstit'] . ' - '.$row['dcarrer'] . ' - '.$row['dcurso'];

//LA DIMENSION SOLO ES DIA
$grilla[$row['profes']][$row['dnomdia']][] = $row['dhora'] . ' - '.$row['dcurso'] . ' - '.$row['dcarrer']. ' - ' .$row['dinstit'] . $row['dfilial'];

}

// print "<pre>"; 
// print_r($grilla);
// print "</pre>";
// die();
$tr_grupo_info = '';
$tr_cursos = '';

foreach ($grilla as $profes) { // Recorrido Profesor por Profesor


$tr_horario = '';

$tr_horario .="<tr><td>LUNES</td><td>".implode('<hr>', $profes['LUNES']) . "</td></tr>";
$tr_horario .="<tr><td>MARTES</td><td>".implode('<hr>', $profes['MARTES']) . "</td></tr>";
$tr_horario .="<tr><td>MIERCOLES</td><td>".implode('<hr>', $profes['MIERCOLES']) . "</td></tr>";
$tr_horario .="<tr><td>JUEVES</td><td>".implode('<hr>', $profes['JUEVES']) . "</td></tr>";
$tr_horario .="<tr><td>VIERNES</td><td>".implode('<hr>', $profes['VIERNES']) . "</td></tr>";
$tr_horario .="<tr><td>SABADO</td><td>".implode('<hr>', $profes['SABADO']) . "</td></tr>";
$tr_horario .="<tr><td>DOMINGO</td><td>".implode('<hr>', $profes['DOMINGO']) . "</td></tr>";


// foreach ($profes as  $key => $rows ) {
// 	# code...
// 	// print '<pre>';
// 	// print_r($row);
// 	// print "</pre>";
// 	// die();
// 	$tr_horario .="<tr><td>".$key."</td><td>";
// 	$tr_horario .= implode('<hr>', $rows);
// 	$tr_horario .="</td></tr>";
	
// 	// . str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['martes'] ) ."</td><td>"
// 	// . str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['miercoles'] ) ."</td><td>"
// 	// . str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['jueves'] ) ."</td><td>"
// 	// . str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['viernes'] ) ."</td><td>"
// 	// . str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['sabado'] ) ."</td><td>"
// 	// . str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['domingo'] ) ."</td></tr>";
// 	// .$data_cursos[$row['martes']]."</td><td>"
// 	// .$data_cursos[$row['miercoles']]."</td><td>"
// 	// .$data_cursos[$row['jueves']]."</td><td>"
// 	// .$data_cursos[$row['viernes']]."</td></tr>";
// 	// print $tr_cursos;
// 	// $grupo_cursos [] = "'". $curso["ccuprpr"] . "'";
// 	// print $tr_horario;

// }


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



	

	<h3>Horario:</h3>
	<table border="1" style='width:100%' cellpadding="2" >
	<tr>
		<th style='width:20%'><b>Hora</b></th>
		<th style='width:80%'><b>Horario</b></th>
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