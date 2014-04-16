<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/*crea obj conexion*/
require_once 'PHPWord.php';

$cn=MySqlConexion::getInstance();


/* QUERYS*/
$cgracpr=$_GET['cgracpr'];
$cingalu=$_GET['cingalu'];
$semestre=$_GET['csemaca'];
$cfilial=$_GET['cfilial'];
$cinstit=$_GET['cinstit'];
$alumno="";

if(trim($cingalu)!=""){
$listAlum=str_replace(",","','",$cingalu);
$alumno=" AND co.cingalu in ('".$listAlum."')";
}

$sql="	Select i.cingalu,ins.durllog,fi.dfilial,i.dcoduni,replace(i.dcodlib,'-','') as dcodlib,co.cconmat,gr.csemaca,ca.dcarrer,ca.durlcam,pe.dnomper,pe.dappape,pe.dapmape,ci.dciclo,
		GROUP_CONCAT(concat(
			cu.codicur,'|',cu.dcurso,'|',dg.ncredit) SEPARATOR '^^') as cursos,
		(select CONCAT(co.nprecio,'|',rr.fvencim)
		from recacap rr 
		INNER JOIN concepp co on (co.cconcep=rr.cconcep)
		WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
		and (co.cctaing like '701.01%' or co.cctaing like '701.02%')
		and rr.testfin in ('C','P')
		limit 0,1
		) as matricula_fecha,
		(select CONCAT(co.nprecio,'|',rr.fvencim)
		from recacap rr 
		INNER JOIN concepp co on (co.cconcep=rr.cconcep)
		WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
		and (co.cctaing like '708%')
		and rr.testfin in ('C','P')
		limit 0,1
		) as inscripcion,
		(select GROUP_CONCAT(concat(cr.ccuota,'|',cr.fvencim,'|',IF(con.ctaprom>=cr.ccuota,con.mtoprom,con.nprecio)) SEPARATOR '^^') as pagos
		from cropaga cr		
		INNER JOIN concepp con on (con.cconcep=cr.cconcep)		
		where cr.cconcep in 
			( Select rr.cconcep
			FROM recacap rr
			INNER JOIN concepp con2 on (con2.cconcep=rr.cconcep)		
			WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
			and con2.cctaing like '701.03%'
			and rr.testfin in ('C','P')
			)
		and cr.cgruaca=co.cgruaca
		GROUP BY cr.cgruaca,cr.cconcep) as pension,fi.dfilial,gr.finicio,fi.ddirfil,fi2.dfilial as dfilial_est,
		concat(fi2.ddirfil,' | Tel/cel: ',fi2.ntelfil) as direccion_estudio
		from ingalum i
		INNER JOIN postulm po ON (po.cingalu=i.cingalu and po.cperson=i.cperson)
		INNER JOIN filialm fi2 ON (fi2.cfilial=po.cfilial)
		INNER JOIN filialm fi ON (fi.cfilial=i.cfilial)
		INNER JOIN conmatp co ON (i.cingalu=co.cingalu)
		INNER JOIN personm pe ON (pe.cperson=i.cperson)
		INNER JOIN gracprp gr ON (gr.cgracpr=co.cgruaca)
		INNER JOIN instita ins on (ins.cinstit=gr.cinstit)
		LEFT JOIN cuprprp dg ON (dg.cgracpr=gr.cgracpr)
		LEFT JOIN cursom cu ON (cu.ccurso=dg.ccurso)
		INNER JOIN cicloa ci ON (ci.cciclo=gr.cciclo)
		INNER JOIN carrerm ca ON (ca.ccarrer=gr.ccarrer)
		where co.cgruaca in ('".str_replace(",","','",$cgracpr)."')	
		".$alumno."
		GROUP BY co.cingalu,co.cgruaca";
$cn->setQuery($sql);
$alumno=$cn->loadObjectList();

// print json_encode($alumno);


// Create a new PHPWord Object
$PHPWord = new PHPWord();

// Every element you want to append to the word document is placed in a section. So you need a section:
$section = $PHPWord->createSection();

// After creating a section, you can append elements:
// $section->addText('Hello world!');

// You can directly style your text by giving the addText function an array:
// $section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true,'align'=>'center',));

// If you often need the same style again you can create a user defined style to the word document
// and give the addText function the name of the style:
// $PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
// $section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');

// // You can also putthe appended element to local object an call functions like this:
// $myTextElement = $section->addText('Hello World!');
// $myTextElement->setBold();
// $myTextElement->setName('Verdana');
// $myTextElement->setSize(22);




foreach($alumno as $rs){ // Inicio de Recorrido
	$section->addText(json_encode($rs));
	$detfechamatric=explode("|",$rs['matricula_fecha']);
	$rs['matricula']=$detfechamatric[0];
	$rs['fecha_matric']=$detfechamatric[1];
	$detfechainscrip=explode("|",$rs['inscripcion']);
	$monto_inscripcion=$detfechainscrip[0];
	$fecha_inscripcion=$detfechainscrip[1];

// ->setCellValue('F3',$rs['dcodlib'])
// 			->setCellValue('F4',$rs['dnomper']." ".$rs['dappape']." ".$rs['dapmape'])
// 			->setCellValue('F5',$rs['dfilial'])
// 			->setCellValue('F6',$rs['dcarrer'])


$section->addText('CONSTANCIA DE PRE-MATRICULA', array('bold'=>true, 'size'=>11, 'name'=>'Calibri', ),array('align'=>'center'));
$section->addText('', array('bold'=>true, 'size'=>11, 'name'=>'Calibri', ),array('align'=>'center'));
$section->addText('CODIGO					:'.$rs['dcodlib'], array('bold'=>true, 'size'=>11, 'name'=>'Calibri', ));
$section->addText('APELLIDOS Y NOMBRE				:'.$rs['dnomper']." ".$rs['dappape']." ".$rs['dapmape'], array('bold'=>true, 'size'=>11, 'name'=>'Calibri', ));
$section->addText('LOCAL DE ESTUDIOS				:'.$rs['dfilial'], array('bold'=>true, 'size'=>11, 'name'=>'Calibri', ));
$section->addText('CARRERA PROFESIONAL			:'.$rs['dcarrer'], array('bold'=>true, 'size'=>11, 'name'=>'Calibri', ));
$section->addText('FECHA DE MATRICULA				:', array('bold'=>true, 'size'=>11, 'name'=>'Calibri', ));
$section->addText('FECHA DE INICIO DE CLASES			:', array('bold'=>true, 'size'=>11, 'name'=>'Calibri', ));


$dcursos=explode("^^",$rs['cursos']);
$detcic=explode(" ",$rs['dciclo']);
	$section->addText(json_encode($dcursos));
	$section->addText(json_encode($detcic));

if(trim($rs['cursos'])==""){
// $objPHPExcel->getActiveSheet()->setCellValue('A11','PROCESO DE CONVALIDACIÓN');
// $objPHPExcel->getActiveSheet()->mergeCells('A11:E11');
// $objPHPExcel->getActiveSheet()->getStyle('A11:E11')->applyFromArray($styleAlignmentBold);
// $posfin=12;
}
else{
for($i=11;$i<(11+count($dcursos));$i++){ //Antiguo era hasta el 16
	$ddc=explode("|",$dcursos[($i-11)]);
	// $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$detcic[0]);
	// $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$ddc[1]);
	// $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setWrapText(true);
	// $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(21.5); // altura
	// $objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':D'.$i);	
	// $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$ddc[2]);
	// $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$ddc[0]); // se agrego recientemente
	}
$posfin=$i;
}





}






// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$nombre = 'PreMatricula.docx';
$objWriter->save($nombre);

header ("Location:$nombre");
// print "hola";




