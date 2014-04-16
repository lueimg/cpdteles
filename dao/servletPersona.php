<?
class servletPersona extends controladorComandos{
	public function doPost(){
		$daoPersona=creadorDAO::getPersonaDAO();
		switch ($_POST['accion']){
			case 'ListarFiltro':
				echo json_encode($daoPersona->ListarFiltro());
			break;
                    case 'ListarFiltrobyID':
				echo json_encode($daoPersona->ListarFiltrobyID());
			break;
			case 'ListarVendedor':
				$data=array();
				$data['dapepat']=trim($_POST['dapepat']);
				$data['dapemat']=trim($_POST['dapemat']);
				$data['dnombre']=trim($_POST['dnombre']);
				$data['tvended']=trim($_POST['tvended']);
				echo json_encode($daoPersona->ListarVendedor($data));
			break;
			case 'InsertarPersona':				
				$data=array();
				$data['dnomper']=trim($_POST['dnomper']);
				$data['dappape']=trim($_POST['dappape']);
				$data['dapmape']=trim($_POST['dapmape']);
				$data['ndniper']=trim($_POST['ndniper']);
				$data['email1']=trim($_POST['email1']);
				$data['ntelpe2']=trim($_POST['ntelpe2']);
				$data['ntelper']=trim($_POST['ntelper']);
				$data['ntellab']=trim($_POST['ntellab']);
				$data['cestciv']=trim($_POST['cestciv']);
				$data['tipdocper']='DNI';
				$data['fnacper']=trim($_POST['fnacper']);
				$data['tsexo']=trim($_POST['tsexo']);
				$data['coddpto']=trim($_POST['coddpto']);
				$data['codprov']=trim($_POST['codprov']);
				$data['coddist']=trim($_POST['coddist']);
				$data['ddirper']=trim($_POST['ddirper']);
				$data['ddirref']=trim($_POST['ddirref']);
				$data['cdptlab']=trim($_POST['cdptlab']);
				$data['cprvlab']=trim($_POST['cprvlab']);
				$data['cdislab']=trim($_POST['cdislab']);
				$data['ddirlab']=trim($_POST['ddirlab']);
				$data['dnomlab']=trim($_POST['dnomlab']);
				$data['tcolegi']=trim($_POST['tcolegi']);
				$data['dcolpro']=trim($_POST['dcolpro']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
				echo json_encode($daoPersona->InsertarPersona($data));
			break;
			case 'ActualizarPersona':				
				$data=array();
				$data['cperson']=trim($_POST['cperson']);
				$data['dnomper']=trim($_POST['dnomper']);
				$data['dappape']=trim($_POST['dappape']);
				$data['dapmape']=trim($_POST['dapmape']);
				$data['ndniper']=trim($_POST['ndniper']);
				$data['email1']=trim($_POST['email1']);
				$data['ntelpe2']=trim($_POST['ntelpe2']);
				$data['ntelper']=trim($_POST['ntelper']);
				$data['ntellab']=trim($_POST['ntellab']);
				$data['cestciv']=trim($_POST['cestciv']);
				$data['tipdocper']='DNI';
				$data['fnacper']=trim($_POST['fnacper']);
				$data['tsexo']=trim($_POST['tsexo']);
				$data['coddpto']=trim($_POST['coddpto']);
				$data['codprov']=trim($_POST['codprov']);
				$data['coddist']=trim($_POST['coddist']);
				$data['ddirper']=trim($_POST['ddirper']);
				$data['ddirref']=trim($_POST['ddirref']);
				$data['cdptlab']=trim($_POST['cdptlab']);
				$data['cprvlab']=trim($_POST['cprvlab']);
				$data['cdislab']=trim($_POST['cdislab']);
				$data['ddirlab']=trim($_POST['ddirlab']);
				$data['dnomlab']=trim($_POST['dnomlab']);
				$data['tcolegi']=trim($_POST['tcolegi']);
				$data['dcolpro']=trim($_POST['dcolpro']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
				echo json_encode($daoPersona->ActualizarPersona($data));
			break;
			case 'InsertarTrabajador':				
				$data=array();
				$data['dnombre']=trim($_POST['dnombre']);
				$data['dapepat']=trim($_POST['dapepat']);
				$data['dapemat']=trim($_POST['dapemat']);
				$data['ndocper']=trim($_POST['ndocper']);
				$data['demail']=trim($_POST['demail']);
				$data['tdocper']='DNI';
				$data['fingven']=trim($_POST['fingven']);
				$data['tsexo']=trim($_POST['tsexo']);
				$data['coddpto']=trim($_POST['coddpto']);
				$data['codprov']=trim($_POST['codprov']);
				$data['coddist']=trim($_POST['coddist']);
				$data['ddirecc']=trim($_POST['ddirecc']);
				$data['tvended']=trim($_POST['tvended']);
				$data['codintv']=trim($_POST['codintv']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['dtelefo']=trim($_POST['dtelefo']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cestado']=trim($_POST['cestado']);
                $data['copeven']=trim($_POST['copeven']);
				echo json_encode($daoPersona->InsertarTrabajador($data));
			break;
			case 'ActualizarTrabajador':				
				$data=array();
				$data['cvended']=trim($_POST['cvended']);
				$data['dnombre']=trim($_POST['dnombre']);
				$data['dapepat']=trim($_POST['dapepat']);
				$data['dapemat']=trim($_POST['dapemat']);
				$data['ndocper']=trim($_POST['ndocper']);
				$data['demail']=trim($_POST['demail']);
				$data['tdocper']='DNI';
				$data['fingven']=trim($_POST['fingven']);
				$data['tsexo']=trim($_POST['tsexo']);
				$data['coddpto']=trim($_POST['coddpto']);
				$data['codprov']=trim($_POST['codprov']);
				$data['coddist']=trim($_POST['coddist']);
				$data['ddirecc']=trim($_POST['ddirecc']);
				$data['tvended']=trim($_POST['tvended']);
				$data['codintv']=trim($_POST['codintv']);
				$data['cinstit']=trim($_POST['cinstit']);
				$data['dtelefo']=trim($_POST['dtelefo']);
				$data['cusuari']=trim($_POST['cusuari']);
				$data['cfilial']=trim($_POST['cfilial']);
				$data['cestado']=trim($_POST['cestado']);
                $data['copeven']=trim($_POST['copeven']);
				echo json_encode($daoPersona->ActualizarTrabajador($data));
			break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoPersona=creadorDAO::getPersonaDAO();
		switch ($_GET['accion']){
			case 'jqgrid_personaIngAlum':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
				if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND i.cestado='".trim($_GET['cestado'])."' ";
                }
                if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }
				if(isset($_GET['dcarrer']) && trim($_GET['dcarrer'])!=''){
                    $where.=" AND upper(ca.dcarrer) LIKE '%".strtoupper(trim($_GET['dcarrer']))."%' ";
                }
				if(isset($_GET['cinicio']) && trim($_GET['cinicio'])!=''){
                    $where.=" AND upper(g.cinicio)='".strtoupper(trim($_GET['cinicio']))."'";
                }
				if(isset($_GET['finicio']) && trim($_GET['finicio'])!=''){
                    $where.=" AND date(g.finicio)='".strtoupper(trim($_GET['finicio']))."'";
                }
				if(isset($_GET['csemaca']) && trim($_GET['csemaca'])!=''){
                    $where.=" AND upper(g.csemaca) LIKE '%".strtoupper(trim($_GET['csemaca']))."%' ";
                }
				if(isset($_GET['dfilial']) && trim($_GET['dfilial'])!=''){
                    $where.=" AND upper(f.dfilial) LIKE '%".strtoupper(trim($_GET['dfilial']))."%' ";
                }
				if(isset($_GET['dinstit']) && trim($_GET['dinstit'])!=''){
                    $where.=" AND upper(ins.dinstit) LIKE '%".strtoupper(trim($_GET['dinstit']))."%' ";
                }

                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountPersonaIngAlum($where);
                $count=$row[0]['count'];
                if($count>0) {
                        $total_pages=ceil($count/$limit);
                }else {
                        $limit=0;
                        $total_pages=0;
                }

                if($page>$total_pages) $page=$total_pages;

                $start=$page*$limit-$limit;

                $response=array("page"=>$page,"total"=>$total_pages,"records"=>$count);
				
				$data=$daoPersona->JQGRIDRowsPersonaIngAlum($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cingalu']."-".$data[$i]['cgracpr'],"cell"=>array(
							$data[$i]['cestado'],
							$data[$i]['dfilial'],
							$data[$i]['dinstit'],
							$data[$i]['dcarrer'],
							$data[$i]['cinicio'],
							$data[$i]['finicio'],
							$data[$i]['dhorari'],
							$data[$i]['csemaca'],
                    		$data[$i]['cperson'],                            
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
                            $data[$i]['cingalu']														
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_personaConcepto':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
				if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }
				if(isset($_GET['dcarrer']) && trim($_GET['dcarrer'])!=''){
                    $where.=" AND upper(ca.dcarrer) LIKE '%".strtoupper(trim($_GET['dcarrer']))."%' ";
                }
				if(isset($_GET['csemaca']) && trim($_GET['csemaca'])!=''){
                    $where.=" AND upper(g.csemaca) LIKE '%".strtoupper(trim($_GET['csemaca']))."%' ";
                }
				if(isset($_GET['dfilial']) && trim($_GET['dfilial'])!=''){
                    $where.=" AND upper(f.dfilial) LIKE '%".strtoupper(trim($_GET['dfilial']))."%' ";
                }
				if(isset($_GET['dinstit']) && trim($_GET['dinstit'])!=''){
                    $where.=" AND upper(ins.dinstit) LIKE '%".strtoupper(trim($_GET['dinstit']))."%' ";
                }
				if(isset($_GET['nmonrec']) && trim($_GET['nmonrec'])!=''){
                    $where.=" AND r.nmonrec='".strtoupper(trim($_GET['nmonrec']))."' ";
                }
				if(isset($_GET['dconcep']) && trim($_GET['dconcep'])!=''){
                    $where.=" AND upper(con.dconcep) LIKE '%".strtoupper(trim($_GET['dconcep']))."%' ";
                }

                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountPersonaConcepto($where);
                $count=$row[0]['count'];
                if($count>0) {
                        $total_pages=ceil($count/$limit);
                }else {
                        $limit=0;
                        $total_pages=0;
                }

                if($page>$total_pages) $page=$total_pages;

                $start=$page*$limit-$limit;

                $response=array("page"=>$page,"total"=>$total_pages,"records"=>$count);
				
				$data=$daoPersona->JQGRIDRowsPersonaConcepto($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cingalu']."-".$data[$i]['cgracpr'],"cell"=>array(
							$data[$i]['dfilial'],
							$data[$i]['dinstit'],
							$data[$i]['dcarrer'],
							$data[$i]['csemaca'],
                    		$data[$i]['cperson'],                            
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
							$data[$i]['cconcep'],
							$data[$i]['dconcep'],
							$data[$i]['nmonrec'],
                            $data[$i]['cingalu']														
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_persona':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
                if(isset($_GET['dnomper']) && trim($_GET['dnomper'])!=''){
                    $where.=" AND upper(p.dnomper) LIKE '%".strtoupper(trim($_GET['dnomper']))."%' ";
                }
                if(isset($_GET['dappape']) && trim($_GET['dappape'])!=''){
                    $where.=" AND upper(p.dappape) LIKE '%".strtoupper(trim($_GET['dappape']))."%' ";
                }
                if(isset($_GET['dapmape']) && trim($_GET['dapmape'])!=''){
                    $where.=" AND upper(p.dapmape) LIKE '%".strtoupper(trim($_GET['dapmape']))."%' ";
                }
                if(isset($_GET['ndniper']) && trim($_GET['ndniper'])!=''){
                    $where.=" AND upper(p.ndniper) LIKE '%".strtoupper(trim($_GET['ndniper']))."%' ";
                }

                if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountPersona($where);
                $count=$row[0]['count'];
                if($count>0) {
                        $total_pages=ceil($count/$limit);
                }else {
                        $limit=0;
                        $total_pages=0;
                }

                if($page>$total_pages) $page=$total_pages;

                $start=$page*$limit-$limit;

                $response=array("page"=>$page,"total"=>$total_pages,"records"=>$count);
				
				$data=$daoPersona->JQGRIDRowsPersona($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cperson'],"cell"=>array(
                            $data[$i]['dappape'],
                            $data[$i]['dapmape'],
							$data[$i]['dnomper'],
                            $data[$i]['ndniper'],
							$data[$i]['email1'],
							$data[$i]['ntelpe2'],
							$data[$i]['ntelper'],
							$data[$i]['ntellab'],
							$data[$i]['cestciv'],
							$data[$i]['tipdocper'],
							$data[$i]['fnacper'],
							$data[$i]['tsexo'],
							$data[$i]['coddpto'],
							$data[$i]['codprov'],
							$data[$i]['coddist'],
							$data[$i]['ddirper'],
							$data[$i]['ddirref'],
							$data[$i]['cdptlab'],
							$data[$i]['cprvlab'],
							$data[$i]['cdislab'],
							$data[$i]['ddirlab'],
							$data[$i]['dnomlab'],
							$data[$i]['tcolegi'],
							$data[$i]['dcolpro'],
							$data[$i]['ddepart'],
							$data[$i]['dprovin'],
							$data[$i]['ddistri'],
							$data[$i]['depalab'],
							$data[$i]['provlab'],
							$data[$i]['distlab']
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			case 'jqgrid_trabajador':
				$page=$_GET["page"];
                $limit=$_GET["rows"];
                $sidx=$_GET["sidx"];
                $sord=$_GET["sord"];

                $where="";
                if(isset($_GET['dnombre']) && trim($_GET['dnombre'])!=''){
                    $where.=" AND upper(v.dnombre) LIKE '%".strtoupper(trim($_GET['dnombre']))."%' ";
                }
                if(isset($_GET['dapepat']) && trim($_GET['dapepat'])!=''){
                    $where.=" AND upper(v.dapepat) LIKE '%".strtoupper(trim($_GET['dapepat']))."%' ";
                }
                if(isset($_GET['dapemat']) && trim($_GET['dapemat'])!=''){
                    $where.=" AND upper(v.dapemat) LIKE '%".strtoupper(trim($_GET['dapemat']))."%' ";
                }
                if(isset($_GET['ndocper']) && trim($_GET['ndocper'])!=''){
                    $where.=" AND upper(v.ndocper) LIKE '%".strtoupper(trim($_GET['ndocper']))."%' ";
                }				
				if(isset($_GET['tvended']) && trim($_GET['tvended'])!=''){
                    $where.=" AND upper(v.tvended)='".strtoupper(trim($_GET['tvended']))."' ";
                }
				if(isset($_GET['codintv']) && trim($_GET['codintv'])!=''){
                    $where.=" AND upper(v.codintv)='".strtoupper(trim($_GET['codintv']))."' ";
                }
				if(isset($_GET['cestado']) && trim($_GET['cestado'])!=''){
                    $where.=" AND upper(v.cestado)='".strtoupper(trim($_GET['cestado']))."' ";
                }
				
				if(!$sidx)$sidx=1 ; 

                $row=$daoPersona->JQGridCountTrabajador($where);
                $count=$row[0]['count'];
                if($count>0) {
                        $total_pages=ceil($count/$limit);
                }else {
                        $limit=0;
                        $total_pages=0;
                }

                if($page>$total_pages) $page=$total_pages;

                $start=$page*$limit-$limit;

                $response=array("page"=>$page,"total"=>$total_pages,"records"=>$count);
				
				$data=$daoPersona->JQGRIDRowsTrabajador($sidx, $sord, $start, $limit, $where);
                $dataRow=array();
                for($i=0;$i<count($data);$i++){
                    array_push($dataRow, array("id"=>$data[$i]['cvended'],"cell"=>array(
							$data[$i]['codintv'],
							$data[$i]['dapepat'],
                            $data[$i]['dapemat'],
							$data[$i]['dnombre'],
                            $data[$i]['ndocper'],
							$data[$i]['demail'],
							$data[$i]['dtelefo'],							
							$data[$i]['tdocper'],							
							$data[$i]['tsexo'],
							$data[$i]['coddpto'],
							$data[$i]['codprov'],							
							$data[$i]['coddist'],
							$data[$i]['ddirecc'],
							$data[$i]['fingven'],							
							$data[$i]['cinstit'],
							$data[$i]['tvended'],
							$data[$i]['cestado'],
                            $data[$i]['copeven'],
                            )
                        )
                    );
                }
                $response["rows"]=$dataRow;
                echo json_encode($response);

				break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>