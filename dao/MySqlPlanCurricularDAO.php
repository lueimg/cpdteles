<?php
class MySqlPlanCurricularDAO{
   
    
    public function cargarPlancurricular($r){
		
        $sql="SELECT
            c.dnemoni,
			p.ccurso,
            p.ncredit,
            p.nhotecu,
            p.nhoprcu,
                p.ccurric AS ccur,
                c.dcurso  AS nombre,
                p.ccurso  AS curso,
                p.cmodulo AS cmod,
				c.codicur,
                p.cestado AS estado,
                p.dreqcur AS req,
                p.ncredit AS creditos,
                p.nhotecu as hteoria,
                p.nhoprcu as hpractica,
                (SELECT GROUP_CONCAT(d.dcurso SEPARATOR '<br>')
				FROM cursom d
				WHERE FIND_IN_SET (d.ccurso,REPLACE(p.dreqcur,'|',','))  >  0) AS reqs  
                FROM placurp AS p
                LEFT JOIN cursom AS c
                  ON c.ccurso = p.ccurso            
WHERE 1=1  AND ccurric =".$r['ccur']." AND cmodulo =".$r['cmod']."";
        $db=creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cursos cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen cursos','data'=>$data);
        }
    }
    
    public function listarPlanCurricular($post){
        $db=creadorConexion::crear('MySql');
        $sql1="  sselect g.ccurric
                from ingalum i
                inner join conmatp c on (i.cingalu=c.cingalu)
                inner join gracprp g on (c.cgruaca=g.cgracpr)
                where i.cingalu='".$post['cingalu']."'
                order by fmatric DESC
                limit 0,1";
        $db->setQuery($sql1);
        $data1=$db->loadObjectList();        

        $sql="  select m.dmodulo,c.dcurso,p.ncredit,
                    (select GROUP_CONCAT(cu.dcurso SEPARATOR '<br>') 
                    from cursom cu 
                    where FIND_IN_SET (cu.ccurso,p.dreqcur)  >  0) as requisito
                from placurp p
                inner join moduloa m on (p.cmodulo=m.cmodulo)
                inner join cursom c on (p.ccurso=c.ccurso)
                where ccurric='".$data1[0]['ccurric']."'
                and p.cestado='1'
                order by  m.dmodulo";
        

        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Plan Curricular cargado','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Plan Curricular','data'=>$data);
        }
    }
    
    public function actualizarPlancurricular($post){
       
	   
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        $sql="update placurp set ncredit='".$post["ncredi"]."',cestado='".$post["estado"]."', dreqcur='".$post["ccurre"]."', nhotecu='".$post["nroteo"]."', nhoprcu='".$post["nropra"]."',fusuari=now(),cusuari='".$post['cusuari']."'  where ccurric='".$post["ccurri"]."' and ccurso='".$post["ccurso"]."' and cmodulo = '".$post["cmodul"]."'  ";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Plan curricular Actualizado',"sql"=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query',"sql"=>$sql);
        }
    }
    
    public function insertarPlancurricular($post){
       
        $db=creadorConexion::crear('MySql');	
	$db->iniciaTransaccion();	
        /****verifico que registro no exista******/
        $sqlVal="SELECT * FROM placurp where ccurric='".$post["ccurri"]."' and ccurso='".$post["ccurso"]."' and cmodulo = '".$post["cmodul"]."'   limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Curso del Plan curricular</b> ya existe'));exit();}
        /********************/	
        
        //cciclo
        $csql = "SELECT c.cciclo 
                FROM moduloa  as m
                LEFT JOIN cicloa as c on c.nromcic = m.nrommod
                WHERE cmodulo ='".$post["cmodul"]."' ";
        
        $db->setQuery($csql);
        $cobj=$db->loadObject();        
	$cciclo = "";
        if(!empty($cobj->cciclo))
            $cciclo = $cobj->cciclo;
        else
            $cciclo = "01";
        
        $sql="insert into placurp(ccurric,ccurso,cmodulo,ncredit,dreqcur,cestado,cciclo,cusuari,nhotecu,nhoprcu,fusuari) values('".$post["ccurri"]."','".$post["ccurso"]."','".$post["cmodul"]."','".$post["ncredi"]."','".$post["ccurre"]."','".$post["estado"]."','".$cciclo."','".$post["cusuari"]."',".$post["nroteo"].",".$post["nropra"].",NOW())";
        $db->setQuery($sql);
		
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Plan curricular Ingresado',"sql"=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query',"sql"=>$csql,"sql"=>$sql);
        }   
    }
    public function JQGridCountPlancurricular ( $where ) {
       $db=creadorConexion::crear('MySql');
        $sql=" SELECT COUNT(*) AS count FROM placurp AS p
                LEFT JOIN cursom AS c
                  ON c.ccurso = p.ccurso WHERE 1=1 ".$where;
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        //var_dump($sql);exit();
        if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
    }
    public function JQGRIDRowsPlancurricular ( $sidx, $sord, $start, $limit, $where) {
        $sql = "
            SELECT
                p.ccurric,
                c.dcurso as nombre,
                p.cestado as estado
                FROM placurp AS p
                LEFT JOIN cursom AS c
                  ON c.ccurso = p.ccurso
            WHERE 1=1 ".$where."
            ORDER BY  ".$sidx." ".$sord."
            LIMIT ".$limit." OFFSET ".$start;
       
        $db=creadorConexion::crear('MySql');	

        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        return $data;
        
    }
    
    public function guardarcurricular($post){
        
        $db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT * FROM curricm where dtitulo='".$post["dtitulo"]."' and dresolu='".$post["dresolu"]."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>La curricula</b> ya existe'));exit();}
        /********************/	
        
        //next id 
        $csql = "SELECT (ccurric + 1) AS id FROM curricm ORDER BY ccurric DESC LIMIT 1 ";
        $db->setQuery($csql);
        $cobj=$db->loadObject();
        $next_id = $cobj->id;
        
        $sql="
            insert into curricm (ccurric,dtitulo,ccarrer,cestado,fcrecur,fusuari,cusuari,dresolu) 
            values('$next_id','".$post["dtitulo"]."','".$post["ccarrer"]."','1',now(),now(),'".$post["cusuari"]."','".$post["dresolu"]."')";
        $db->setQuery($sql);
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Curricula Registrada',"sql"=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query',"sql"=>$csql,"sql"=>$sql);
        }
    
        }

    }
?>
