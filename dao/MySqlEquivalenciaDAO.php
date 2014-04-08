<?php

class MySqlEquivalenciaDAO {

    public function cargarCarreras($post) {
        $db = creadorConexion::crear('MySql');
        
        /*         * **verifico que registro no exista***** */
        $sqlVal = "select ca.cinstit , ca.ccarrer id, ca.dcarrer nombre
                    from curricm cu
                    inner join carrerm ca on cu.ccarrer = ca.ccarrer
                    where cinstit = '$post'";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Carreras cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Carreras','data'=>$data,'sql'=>$sqlVal);
        }
        
    }
    
    public function cargarModulos($post) {
        $db = creadorConexion::crear('MySql');
        
        /*         * **verifico que registro no exista***** */
        $sqlVal = "select  cmodulo id, dmodulo nombre
                    from moduloa
                    where ccarrer = '$post'";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Modulos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Modulos','data'=>$data,'sql'=>$sqlVal);
        }
        
    }
    
    public function cargarCurriculas($post) {
        $db = creadorConexion::crear('MySql');
        
        /*         * **verifico que registro no exista***** */
        $sqlVal = "select cu.ccurric id , cu.dtitulo nombre
                    from curricm cu
                    inner join carrerm ca on cu.ccarrer = ca.ccarrer
                    where cinstit = '".$post["cinstit"] ."'  and ca.ccarrer = '".$post["ccarrer"] ."' ";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Curriculas cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen curriculas','data'=>$data,'sql'=>$sqlVal);
        }
    }
    
    public function cargarCursos($post) {
        $db = creadorConexion::crear('MySql');
        
        $sqlVal = "SELECT c.ccurso id , c.dcurso nombre
                    FROM placurp p
                    inner join cursom c on c.ccurso = p.ccurso
                    where p.ccurric = '".$post["ccurric"] ."' and p.cmodulo = '".$post["cmodulo"] ."' ";
        $db->setQuery($sqlVal);
        $data = $db->loadObjectList();

        if (count($data) > 0) {
            return array('rst'=>'1','msj'=>'Cursos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Cursos','data'=>$data,'sql'=>$sqlVal);
        }
    }
    
    public function addEquivalencia($post){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cequisag 
				 FROM equisag 
				 WHERE ccurric='".$post["ccurric"]."' 
				   And ccurso ='".$post["ccurso"]."'
				   And cmodulo ='".$post["cmodulo"]."'
				   And ccurria   ='".$post["ccurria"]."'
				   And ccursoa='".$post["ccursoa"]."'
				   And cmodulo  ='".$post["cmodulo"]."'
				   AND estide='".$post["estide"]."' and cestado = 1 limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Equivalencia</b> ya existe'));exit();}
        /********************/	
		$sqlver1="SELECT RIGHT(CONCAT('000000',CONVERT( IFNULL(MAX(cequisag),'0')+1, CHAR)),9) As cequisag
				  FROM equisag";
		$db->setQuery($sqlver1);
		$cequisag=$db->loadObjectList();	 
		
        $sql="INSERT INTO equisag (cequisag, ccurric, ccurso, cmodulo , ccurria, ccursoa, cmoduloa, estide,cestado, cusuari, fusuari, cusuariu, fusuariu) 
			  VALUES	('".$cequisag[0]['cequisag']."'
						,'".$post["ccurric"]."'
						,'".$post["ccurso"]."'
						,'".$post["cmodulo"]."'
						,'".$post["ccurria"]."'
						,'".$post["ccursoa"]."'
						,'".$post["cmoduloa"]."'
						,'".$post["estide"]."'
						,'1'
						,'".$post["cusuari"]."'
						,now()"."
						,'".$post["cusuari"]."'
						,now())";
        $db->setQuery($sql);
		
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Equivalencia Ingresada','sql'=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
        }   
    }
    
    public function EditarEquivalencia($post){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        $sqlVal="SELECT cequisag 
				 FROM equisag 
				 WHERE ccurric='".$post["ccurric"]."' 
				   And ccurso ='".$post["ccurso"]."'
				   And cmodulo ='".$post["cmodulo"]."'
				   And ccurria   ='".$post["ccurria"]."'
				   And ccursoa='".$post["ccursoa"]."'
				   And cmodulo  ='".$post["cmodulo"]."'
				   AND estide='".$post["estide"]."' and cestado = 1  and cequisag !='".$post['id']."' limit 1";
        $db->setQuery($sqlVal);
        $data=$db->loadObjectList();
		
        if(count($data)>0){echo json_encode(array('rst'=>'2','msj'=>'<b>Equivalencia</b> ya existe'));exit();}
        /********************/	
		   $sql="update equisag set 
						 ccurric = '".$post["ccurric"]."'
						,ccurso = '".$post["ccurso"]."'
						,cmodulo = '".$post["cmodulo"]."'
						,ccurria = '".$post["ccurria"]."'
						,ccursoa = '".$post["ccursoa"]."'
						,cmoduloa = '".$post["cmoduloa"]."'
						,estide = '".$post["estide"]."'
						,cusuariu = '".$post["cusuari"]."'
						,fusuariu = now()  where cequisag =  '".$post["id"]."'";
        $db->setQuery($sql);
		
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Equivalencia Actualizada','sql'=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
        }   
    }
    
    
    public function EliminarEquivalencia($post){
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        
		   $sql="update equisag set 
						cestado = 0
            ,cusuariu = '".$post["cusuari"]."'
						,fusuariu = now()  where cequisag =  '".$post["id"]."'";
        $db->setQuery($sql);
		
        if($db->executeQuery()){
			if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
			}
			$db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Equivalencia Actualizada','sql'=>$sql);
        }else{
			$db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query','sql'=>$sql);
        }   
    }
    
    public function JQGridCountEquivalencia($where) {
        $db = creadorConexion::crear('MySql');
        $sql = " SELECT COUNT(*) AS count FROM equisag e
                inner join curricm c on c.ccurric = e.ccurric
                inner join curricm ca on ca.ccurric = e.ccurria
                inner join cursom cu on cu.ccurso = e.ccurso
                inner join cursom cua on cua.ccurso = e.ccursoa
                left join moduloa m on m.cmodulo = e.cmodulo
                left join moduloa ma on ma.cmodulo = e.cmoduloa
                inner join carrerm car on car.ccarrer = c.ccarrer
								inner join carrerm cara on cara.ccarrer = ca.ccarrer
                where e.cestado  = 1  " . $where;

        $db->setQuery($sql);
        $data = $db->loadObjectList();
        //var_dump($sql);exit();
        if (count($data) > 0) {
            return $data;
        } else {
            return array(array('COUNT' => 0));
        }
    }

    public function JQGRIDRowsEquivalencia($sidx, $sord, $start, $limit, $where) {
        $sql = "select 
                e.cequisag,
                c.ccurric,
                c.dtitulo,
                cu.ccurso,
                cu.dcurso,
                m.cmodulo cciclo,
                m.dmodulo dciclo,
                ca.ccurric  ccurrica,
                ca.dtitulo  dtituloa,
                cua.ccurso ccursoa,
                cua.dcurso dcursoa,
                ma.cmodulo ccicloa,
                ma.dmodulo dcicloa,
                IF(estide = 'r','Regular','Irregular') estide,
                estide cestide,
								car.cinstit inst,
								car.ccarrer carrer,
								cara.cinstit insta,
                cara.ccarrer carrera
                FROM equisag e
                inner join curricm c on c.ccurric = e.ccurric
                inner join curricm ca on ca.ccurric = e.ccurria
                inner join cursom cu on cu.ccurso = e.ccurso
                inner join cursom cua on cua.ccurso = e.ccursoa
                left join moduloa m on m.cmodulo = e.cmodulo
                left join moduloa ma on ma.cmodulo = e.cmoduloa
                inner join carrerm car on car.ccarrer = c.ccarrer
								inner join carrerm cara on cara.ccarrer = ca.ccarrer
                where e.cestado  = 1 "
                . $where . " ORDER BY  " . $sidx . " " . $sord . " LIMIT " . $limit . " OFFSET " . $start;
        //print $sql;    
        $db = creadorConexion::crear('MySql');

        $db->setQuery($sql);
        $data = $db->loadObjectList();
        return $data;
    }

}

?>
