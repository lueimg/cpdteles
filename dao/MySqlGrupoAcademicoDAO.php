<?
class MySqlGrupoAcademicoDAO{
	public function cargarGrupoAcademicoMatri($data){
	$validaadmin="";
	if($data['validaadmin']==''){
	//$validaadmin=" AND date(g.finicio) + INTERVAL 7 day >=curdate() ";
	}
	$sql="SELECT  f.dfilial,ins.dinstit,t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,g.ffin,concat( 
		(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
		from diasm d 
		where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
		' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(DISTINCT(IF(g.trgrupo='R',g.cgracpr,null))) as id,
			(select count(*)
			from gracprp g2
			inner join conmatp co on (co.cgruaca=g2.cgracpr)
			where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
			) as total,cu.dtitulo as dcurric,nmetmat,
			(select count(*)
			from gracprp g2
			inner join conmatp co on (co.cgruaca=g2.cgracpr)
			inner join (select r2.cingalu,r2.cgruaca
									from recacap r2	
									inner join concepp co2 on (co2.cconcep=r2.cconcep)
									inner join conmatp conm2 on (conm2.cingalu=r2.cingalu and conm2.cgruaca=r2.cgruaca)
									where (r2.ccuota='' or r2.ccuota=1)
									and r2.testfin='P'
									and co2.cctaing like '701.03%'
									and (IF(substring(conm2.dproeco,1,3)='Pro',(co2.mtoprom/2),co2.nprecio/2))>=r2.nmonrec
									GROUP BY r2.cgruaca,r2.cingalu
									) rec on (rec.cingalu=co.cingalu and rec.cgruaca=co.cgruaca)
			WHERE (FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(g.cgracpr SEPARATOR ','))  >  0)					
			) as mayor,
			(select count(*)
			from gracprp g2
			inner join conmatp co on (co.cgruaca=g2.cgracpr)
			inner join (select r2.cingalu,r2.cgruaca
									from recacap r2	
									inner join concepp co2 on (co2.cconcep=r2.cconcep)
									inner join conmatp conm2 on (conm2.cingalu=r2.cingalu and conm2.cgruaca=r2.cgruaca)
									where (r2.ccuota='' or r2.ccuota=1)
									and r2.testfin='P'
									and co2.cctaing like '701.03%'
									and (IF(substring(conm2.dproeco,1,3)='Pro',(co2.mtoprom/2),co2.nprecio/2))<r2.nmonrec
									GROUP BY r2.cgruaca,r2.cingalu
									) rec on (rec.cingalu=co.cingalu and rec.cgruaca=co.cgruaca)
			WHERE (FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(g.cgracpr SEPARATOR ','))  >  0)					
			) as menor
		FROM gracprp g 
		INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
		INNER JOIN filialm f on (f.cfilial=g.cfilial)
		INNER JOIN instita ins on (ins.cinstit=g.cinstit)
		INNER JOIN turnoa t on (g.cturno=t.cturno) 
		INNER JOIN horam h on (h.chora=g.chora) 
		INNER JOIN carrerm c on (c.ccarrer=g.ccarrer) 		
		WHERE g.cciclo='".$data['cciclo']."' 
		AND g.cfilial='".$data['cfilial']."' 
		and g.cinstit='".$data['cinstit']."'
		AND g.csemaca='".$data['csemaca']."'
		AND g.cesgrpr in ('3')
		".$validaadmin."
		GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
		order by total desc,mayor desc,menor desc,c.dcarrer,g.cinicio,g.finicio";
		$db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos Academicos cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Grupos Academicos','data'=>$data,'sql'=>$sql);
        }
	}

	public function JQGridCountGrupoAcademico($where){
		$db=creadorConexion::crear('MySql');
        $sql="SELECT  count(count) as count
        	  FROM (SELECT count(*) as count
					FROM gracprp g 	
					inner join carrerm c on (g.ccarrer=c.ccarrer)					
					WHERE g.cesgrpr in ('3')
					 ".$where."	            
		            GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin) a";
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
	}

	public function JQGRIDRowsGrupoAcademico($sidx, $sord, $start, $limit, $where){		
		$sql = "SELECT  f.dfilial,ins.dinstit,t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,g.ffin,concat( 
				(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				from diasm d 
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
				' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(DISTINCT(IF(g.trgrupo='R',g.cgracpr,null))) as id,
					cu.dtitulo as dcurric, ci.dciclo
				FROM gracprp g 
				INNER JOIN cicloa ci on (ci.cciclo=g.cciclo)
				INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
				INNER JOIN filialm f on (f.cfilial=g.cfilial)
				INNER JOIN instita ins on (ins.cinstit=g.cinstit)
				INNER JOIN turnoa t on (g.cturno=t.cturno) 
				INNER JOIN horam h on (h.chora=g.chora) 
				INNER JOIN carrerm c on (c.ccarrer=g.ccarrer) 		
				WHERE g.cesgrpr in ('3')
				 ".$where."	            
	            GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
				ORDER BY ".$sidx." ".$sord." 		  
	            LIMIT ".$limit." OFFSET ".$start;

        $db=creadorConexion::crear('MySql');	
        //var_dump($sql);exit();
        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
	}

	public function cargarGrupoAcademico($data){
        $sql="	SELECT  t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,concat( 
				(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				from diasm d 
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
				' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(DISTINCT(IF(g.trgrupo='R',g.cgracpr,null))) as id ,nmetmat,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
					) as total,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					inner join (select r2.cingalu,r2.cgruaca
											from recacap r2	
											where (r2.ccuota='' or r2.ccuota=1)
											and testfin='P'
											GROUP BY r2.cgruaca,r2.cingalu
											) rec on (rec.cingalu=co.cingalu and rec.cgruaca=g2.cgracpr)
					where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
					) as deben
				FROM gracprp g 
				inner join turnoa t on (g.cturno=t.cturno) 
				INNER JOIN horam h on (h.chora=g.chora) 				
				inner JOIN carrerm c on (c.ccarrer=g.ccarrer) 
				inner join cropaga cr on (cr.cgruaca=g.cgracpr) 
				WHERE g.cciclo='".$data['cciclo']."' 
				AND g.cfilial='".$data['cfilial']."' 
				and g.cinstit='".$data['cinstit']."'
				AND g.csemaca='".$data['csemaca']."'				
				AND g.cesgrpr='3' 
				GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
				order by 9 desc ,10 desc";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos Academicos cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Grupos Academicos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarGrupoAcademico2($data){
		$fil=str_replace(",","','",$data['cfilial']);
		$ins=str_replace(",","','",$data['cinstit']);
		$sem=str_replace(",","','",$data['csemaca']);
		$fechini=$data['fechini'];
		$fechfin=$data['fechfin'];
		
		$filtro='';
		if(strlen($sem)==6){$filtro=" AND g.csemaca='".$sem."' ";}
		elseif(trim($sem)!=''){$filtro=" AND CONCAT(g.csemaca,' | ',g.cinicio) in ('".$sem."') ";}

		if($data['fechini']!='' and $data['fechfin']!=''){
			$filtro.=" AND date(g.finicio) between '".$fechini."' and '".$fechfin."' ";
		}

        $sql="	SELECT  f.dfilial,ins.dinstit,t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,g.ffin,concat( 
				(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				from diasm d 
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
				' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(distinct(g.cgracpr)) as id,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
					) as total,cu.dtitulo as dcurric
				FROM gracprp g 
				INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
				INNER JOIN filialm f on (f.cfilial=g.cfilial)
				INNER JOIN instita ins on (ins.cinstit=g.cinstit)
				inner join turnoa t on (g.cturno=t.cturno) 
				INNER JOIN horam h on (h.chora=g.chora) 
				inner JOIN carrerm c on (c.ccarrer=g.ccarrer) 
				WHERE g.cciclo='".$data['cciclo']."' 
				AND g.cfilial in ('".$fil."') 
				and g.cinstit in ('".$ins."') 
				".$filtro."
				AND g.cesgrpr in ('3','4')
				GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
				order by c.dcarrer,g.cinicio,g.finicio";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos Academicos cargados','data'=>$data,'sql'=>$sql);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Grupos Academicos','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarAlumnos($r){
	$sql="	select c.cgruaca as id,i.cingalu,UPPER(p.dappape) as dappape,UPPER(p.dapmape) as dapmape,UPPER(p.dnomper) as dnomper,if(i.cestado='1','Activo','Retirado') as cestado
			from personm p
			INNER JOIN ingalum i on (p.cperson=i.cperson)
			INNER JOIN conmatp c on (c.cingalu=i.cingalu)
			where c.cgruaca in 
			('".str_replace(",","','",$r['id'])."');";
		$db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Alumno Cargado','data'=>$data,'sql'=>$sql);
        }
		else{
            return array('rst'=>'2','msj'=>'No cargaron los alumnos','data'=>$data,'sql'=>$sql);
        }
	}
	
	public function cargarCursosProgramados($data){
		$sql="	select cu.ccuprpr,c.dcurso,ci.dciclo,cu.ncredit
				from cuprprp cu,cursom c,gracprp gr,cicloa ci
				where cu.ccurso=c.ccurso 
				and gr.cgracpr=cu.cgracpr
				and ci.cciclo=gr.cciclo
				and cu.cgracpr='".$data['cgracpr']."'
				order by c.dcurso;";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos Academicos cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Grupos Academicos','data'=>$data,'sql'=>$sql);
        }
	}
	
	public function GuardarGruposAcademicos($data){
            $db=creadorConexion::crear('MySql');
            $sqlmodal = "SELECT cmodali
					 FROM instita
					 WHERE cinstit='".$data['cinstit']."'";
		$db->setQuery($sqlmodal);
		$cmodali=$db->loadObject();
                $data['cmodali'] = $cmodali->cmodali;
                
		$filiales=explode(',',$data['cfilial']);
		$carreras=explode(',',$data['ccarrer']);
		$respuesta="";
		$valorvalidado=false;
		$fechasinicio=explode(",",$data['fechainiciosemestre']);
		$fechasfin=explode(",",$data['fechafinsemestre']);
		for($i=0;$i<=count($fechasinicio);$i++){
			if($fechasinicio[$i]<=$data["finicio"] and $data["ffinal"]<=$fechasfin[$i]){
			$valorvalidado=true;
			break;
			}
		}		

		
		
		$db->iniciaTransaccion();
		if($valorvalidado==true){
			for($j=0;$j<count($carreras);$j++){
				$sqlcurricula="	SELECT ccurric
								FROM curricm
								where ccarrer='".$carreras[$j]."'
								and cestado=1
								order by ccurric desc
								limit 0,1";
				$db->setQuery($sqlcurricula);
				$datacurric=$db->loadObjectList();

				for($i=0;$i<count($filiales);$i++){
					$validagrupo="SELECT * 
								  FROM gracprp 
								  WHERE cfilial='".$filiales[$i]."' 
								  and csemaca='".$data["csemaca"]."' 
								  and cinstit='".$data['cinstit']."' 
								  and ctipcar='".$data['ctipcar']."' 
								  and cmodali='".$data['cmodali']."' 
								  and cinicio='".$data["cinicio"]."' 
								  and cfrecue='".$data['dias']."' 
								  and chora='".$data["chora"]."' 
								  and ccarrer='".$carreras[$j]."' 
								  and cciclo='".$data['cciclo']."' 
								  and ccurric='".$datacurric[0]["ccurric"]."'
								  and trgrupo='R'";
												
				$db->setQuery($validagrupo);
				$datag=$db->loadObjectList();		
					if(count($datag)==0){
						$grupos=$db->generarCodigo('gracprp','cgracpr',12,$data['usuario']);
						$sql="INSERT INTO gracprp (cgracpr,csemaca,cfilial,cinstit,ctipcar,cmodali,cinicio,cturno,cfrecue,chora,ccarrer,cciclo,dseccio,ccurric,cesgrpr,fingrpr,finicio,ffin,dmotest,fesgrpr,cperson,cusuari,fusuari,ttiptra,trgrupo,nmetmat) VALUES 
							('$grupos',
							'".$data["csemaca"]."',
							'".$filiales[$i]."',
							'".$data['cinstit']."',
							'".$data['ctipcar']."',
							'".$data['cmodali']."',
							'".$data["cinicio"]."',
							'".$data["cturno"]."',
							'".$data['dias']."',
							'".$data["chora"]."',
							'".$carreras[$j]."',
							'".$data['cciclo']."',
							'1',
							'".$datacurric[0]["ccurric"]."',
							'3',
							'".$data["finicio"]."',
							'".$data["finicio"]."',
							'".$data["ffinal"]."',
							'".$data['usuario']."',
							'".$data['ffinal']."',
							'','".$data['usuario']."',now(),'I','R','".$data['nmetmat']."');";
						$db->setQuery($sql);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
						}

						$sql="INSERT into detgrap (cgracpr,ncapaci,dseccio,fusucre,cusucre) VALUES 
							('$grupos',							
							'".$data['nmetmat']."',
							'A',
							now(),
							'".$data['usuario']."');";
						$db->setQuery($sql);
						if(!$db->executeQuery()){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
						}
						if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
							$db->rollbackTransaccion();
							return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
						}

						$cursos="SELECT ccurso,ncredit 
								FROM placurp 
								WHERE cciclo = '".$data['cciclo']."' 
								AND ccurric = '".$datacurric[0]["ccurric"]."'
								AND cestado='1'";
						$db->setQuery($cursos);
						$datac=$db->loadObjectList();
						if(count($datac)>0){
							foreach($datac as $c){
							$cursos=$db->generarCodigo('cuprprp','ccuprpr',12,$data['usuario']);
							$sql="INSERT INTO cuprprp (ccuprpr,cgracpr,ccurric,ccurso,finipre,ffinpre,finivir,ffinvir,cusuari,fusuari,cfilial,ncredit) 
								VALUES ('$cursos', 
								'".$grupos."',
								'".$datacurric[0]["ccurric"]."',
								'".$c["ccurso"]."',";
								if($data2[0]['cmodali']=='1'){
							$sql.="
								'".$data["finicio"]."',
								'".$data["ffinal"]."',
								null,
								null,";
								}
								else{
							$sql.="
								null,
								null,
								'".$data["finicio"]."',
								'".$data["ffinal"]."',";
								}
							
							$sql.="
								'".$data["usuario"]."',
								now(),
								'".$filiales[$i]."',
								'".$c["ncredit"]."')";
							$db->setQuery($sql);
								if(!$db->executeQuery()){
									$db->rollbackTransaccion();
									return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
								}
								if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
									$db->rollbackTransaccion();
									return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
								}
							}
						}
						else{
							$db->rollbackTransaccion();
							return array('rst'=>'2','msj'=>'No hay Plan Curricular para el Ciclo y Curricula seleccionada.','sql'=>$cursos." => ".$sqlcurricula);exit();
						}
					}
					else{
					$db->rollbackTransaccion();
					return array('rst'=>'2','msj'=>'Grupo Academico Existente.','sql'=>$cursos);exit();
					}
				}
			}
		}
		else{		
		$db->rollbackTransaccion();
		return array('rst'=>'2','msj'=>'Fechas del grupo no se encuentran dentro del rango de las fechas del semestre.','sql'=>$cursos);exit();
		}
			
		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Se registro correctamente',"sql"=>$sql);exit();		
	}
	
	public function ActualizarGrupoAcademico($data){
	$db=creadorConexion::crear('MySql');
	$valorvalidado=false;
	$fechasinicio=explode(",",$data['fechainiciosemestre']);
	$fechasfin=explode(",",$data['fechafinsemestre']);
		for($i=0;$i<=count($fechasinicio);$i++){
			if($fechasinicio[$i]<=$data["finicio"] and $data["ffinal"]<=$fechasfin[$i]){
			$valorvalidado=true;
			break;
			}
		}

		$arraydatos=explode(",",",A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T");

		if($data['valores']!=''){


		$valores=explode("|",$data['valores']);
			for($i=1;$i<count($valores);$i++){
				$dval=explode("-",$valores[$i]);
				if($dval[0]=="si"){
					$sql="insert into detgrap (cgracpr,ncapaci,dseccio,cusucre,fusucre) 
						  values('".$data["cgruaca"]."','".$dval[1]."','".$arraydatos[$i]."','".$data["usuario"]."',now())";
				}
				else{
					$sql="UPDATE detgrap 
						  SET ncapaci='".$dval[1]."'
						  ,cestado='".$dval[2]."'
						  ,cusumod='".$data['usuario']."'
						  ,fusumod=now() 
						  WHERE dseccio='".$arraydatos[$i]."'
						  AND cgracpr='".$data['cgruaca']."'";
				}
				$db->setQuery($sql);	
			
				if(!$db->executeQuery()){
					$db->rollbackTransaccion();
					return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
				}
			}

		}


	//if($valorvalidado==true){
		//DATOS DEL GRUPO ACTUAL
		$sqlGrupo = "select * from gracprp where cgracpr = '".$data["cgruaca"]."'";
		$db->setQuery($sqlGrupo);
		$grupo=$db->loadObject();
		//PREGUNTAR SI EL GRUPO NUEVO YA EXISTE
		$validagrupo = "select * from gracprp where csemaca = '".$grupo->csemaca."' ";
		$validagrupo .=" and cfilial ='".$grupo->cfilial."'  ";
		$validagrupo .=" and cinstit = '".$grupo->cinstit."' ";
		$validagrupo .=" and ctipcar = '".$grupo->ctipcar."' ";
		$validagrupo .=" and cmodali = '".$grupo->cmodali."' ";
		$validagrupo .=" and cinicio = '".$grupo->cinicio."' ";
		$validagrupo .=" and cturno = '".$data["cturno"]."' ";
		$validagrupo .=" and cfrecue = '".$data["dias"]."' ";
		$validagrupo .=" and chora = '".$data["chora"]."' ";
		$validagrupo .=" and ccarrer = '".$grupo->ccarrer."' ";
		$validagrupo .=" and cciclo = '".$grupo->cciclo."' ";
		$validagrupo .=" and ccurric = '".$grupo->ccurric."' ";
		$validagrupo .=" and finicio = '".$data["finicio"]."' ";
		$validagrupo .=" and ffin = '".$data["ffinal"]."' ";
		$validagrupo .=" and nmetmat = '".$data["nmetmat"]."' ";
		
		$db->setQuery($validagrupo);
		$datag=$db->loadObjectList();		
			if(count($datag)>0){			
				$db->commitTransaccion();
   				return array('rst'=>'1','msj'=>'Cambios guardados correctamente; ');exit();
			}
		//Actualizar curso primero antes de cambiar grupos.	
		$sql = "UPDATE cuprprp SET  ";
		$sql .="  finipre = '".$data["finicio"]."' ,";
		$sql .="  ffinpre = '".$data["ffinal"]."' ,";
		$sql .="  finivir = '".$data["finicio"]."' ,";
		$sql .="  ffinvir = '".$data["ffinal"]."' ,";	
		$sql .="  cusuari = '".$data["usuario"]."' ,";	
		$sql .="  fusuari = NOW() ";
		$sql .= "where cgracpr in (	select cgracpr 
									from gracprp
									WHERE csemaca = '".$grupo->csemaca."' ";
							$sql .=" and cfilial ='".$grupo->cfilial."'  ";
							$sql .=" and cinstit = '".$grupo->cinstit."' ";
							$sql .=" and ctipcar = '".$grupo->ctipcar."' ";
							$sql .=" and cmodali = '".$grupo->cmodali."' ";
							$sql .=" and cinicio = '".$grupo->cinicio."' ";
							$sql .=" and cturno = '".$grupo->cturno."' ";
							$sql .=" and cfrecue = '".$grupo->cfrecue."' ";
							$sql .=" and chora = '".$grupo->chora."' ";
							$sql .=" and ccarrer = '".$grupo->ccarrer."' ";
							$sql .=" and cciclo = '".$grupo->cciclo."' ";
							$sql .=" and ccurric = '".$grupo->ccurric."' ";
							$sql .=" and finicio = '".$grupo->finicio."' ";
							$sql .=" and ffin = '".$grupo->ffin."' )";
		$db->setQuery($sql);	
		
		if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
		
		//ACTUALIZAR GRUPO
		$sql = "UPDATE gracprp SET  ";
		$sql .="  cturno = '".$data["cturno"]."' ,";
		$sql .="  cfrecue = '".$data["dias"]."' ,";
		$sql .="  chora = '".$data["chora"]."' ,";
		$sql .="  finicio = '".$data["finicio"]."' ,";
		$sql .="  ffin = '".$data["ffinal"]."' , ";
		$sql .="  fingrpr = '".$data["finicio"]."' ,";
		$sql .="  fesgrpr = '".$data["ffinal"]."' , ";
		$sql .="  nmetmat = '".$data["nmetmat"]."' ,";
		$sql .="  cusuari = '".$data["usuario"]."' ,";	
		$sql .="  fusuari = NOW() ";
		$sql .= "where csemaca = '".$grupo->csemaca."' ";
		$sql .=" and cfilial ='".$grupo->cfilial."'  ";
		$sql .=" and cinstit = '".$grupo->cinstit."' ";
		$sql .=" and ctipcar = '".$grupo->ctipcar."' ";
		$sql .=" and cmodali = '".$grupo->cmodali."' ";
		$sql .=" and cinicio = '".$grupo->cinicio."' ";
		$sql .=" and cturno = '".$grupo->cturno."' ";
		$sql .=" and cfrecue = '".$grupo->cfrecue."' ";
		$sql .=" and chora = '".$grupo->chora."' ";
		$sql .=" and ccarrer = '".$grupo->ccarrer."' ";
		$sql .=" and cciclo = '".$grupo->cciclo."' ";
		$sql .=" and ccurric = '".$grupo->ccurric."' ";
		$sql .=" and finicio = '".$grupo->finicio."' ";
		$sql .=" and ffin = '".$grupo->ffin."' ";
		$db->setQuery($sql);
		$db->iniciaTransaccion();
		
		if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
		}
		if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
		}
	/*}
	else{
		$db->rollbackTransaccion();
		return array('rst'=>'2','msj'=>'Fechas del grupo no se encuentran dentro del rango de las fechas del semestre.','sql'=>$cursos);exit();
	}*/
	
   $db->commitTransaccion();
   return array('rst'=>'1','msj'=>'Cambios guardados correctamente; ');exit();
  }

  public function cargarCursosAcademicos($array){
  		$array['cgracpr']=str_replace(',',"','",$array['cgracpr']);
		$sql="	SELECT c.`ccuprpr`,cu.`dcurso`,ifnull(c.`finipre`,'') as finipre,ifnull(c.`ffinpre`,'') as ffinpre,ifnull(c.`finivir`,'') as finivir,ifnull(c.`ffinvir`,'') as ffinvir,
				IFNULL(CONCAT(pe.`dappape`,' ',pe.`dapmape`,', ',pe.`dnomper`),'') AS nombre,IFNULL(c.cprofes,'') cprofes,
				g.cinstit,g.cfilial 
				FROM gracprp g
				INNER JOIN cuprprp c ON (c.`cgracpr`=g.`cgracpr`)
				INNER JOIN cursom cu ON (cu.`ccurso`=c.`ccurso`)
				LEFT JOIN profesm p ON (p.`cprofes`=c.`cprofes`)
				LEFT JOIN personm pe ON (pe.`cperson`=p.`cperson`)
				WHERE g.cgracpr IN ('".$array['cgracpr']."')
				AND trgrupo='R'
				order by cu.dcurso";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cursos Academicos cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Cursos Academicos','data'=>$data,'sql'=>$sql);
        }
  }

  public function cargarHorarioProgramado($array){  		
		$sql="	SELECT h.`chorpro`,h.`ccurpro`,h.ctietol,h.ctipcla,h.`chora`,h.`cdia`,a.`ctipamb`,h.`cambien`,
				concat(d.dnemdia,' | ',ho.hinici,' - ',ho.hfin,' | Turno: ',tu.dnemtur) as horario,
				IF(h.ctipcla='T','Teorico','Practica') AS tipo,ti.`mintol`,t.`dtipamb`,a.`numamb`, 
				concat(dappape,' ',dapmape,', ',dnomper) as dprofes,h.cprofes
				FROM horprop h
				INNER JOIN diasm d ON (d.`cdia`=h.`cdia`)
				INNER JOIN horam ho ON (ho.`chora`=h.`chora`)
				inner join turnoa tu on (tu.cturno=ho.cturno)
				INNER JOIN ambienm a ON (a.`cambien`=h.`cambien`)
				INNER JOIN tipamba t ON (t.`ctipamb`=a.`ctipamb`)
				INNER JOIN tietolm ti ON (ti.`ctietol`=h.`ctietol`)
				INNER JOIN profesm p ON (h.cprofes=p.cprofes)
				INNER JOIN personm pe ON (pe.cperson=p.cperson)
				WHERE h.ccurpro='".$array['ccuprpr']."'
				AND h.cdetgra='".$array['cdetgra']."'";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Horarios cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Horarios','data'=>$data,'sql'=>$sql);
        }
  }

  public function cargarDetalleGrupo($array){
  		$array['cgracpr']=str_replace(',',"','",$array['cgracpr']);
		$sql="	SELECT cdetgra as id, dseccio as nombre 
				FROM detgrap
				WHERE cgracpr in ('".$array['cgracpr']."')";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Secciones cargados','data'=>$data);
        }
		else{
            return array('rst'=>'2','msj'=>'No existen Secciones','data'=>$data,'sql'=>$sql);
        }
  }
  
}
?>