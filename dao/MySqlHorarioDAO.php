<?
class MySqlHorarioDAO{
    public function cargarDia(){
        $sql="  SELECT cdia AS id,dnomdia AS nombre
                FROM diasm";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Dias cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Dias','data'=>$data,'sql'=>$sql);
        }
    }   

    public function cargarHora($array){
        $sql="  SELECT h.chora AS id,CONCAT('Turno:',t.`dturno`,' | ',h.hinici,'-',h.hfin) AS nombre
                FROM horam h
                INNER JOIN turnoa t ON (h.`cturno`=t.`cturno`)
                WHERE cinstit='".$array['cinstit']."'
                AND thora='1'
                AND cestado='1'
                ORDER BY h.`hinici`";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Horas cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Horas','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarTipoAmbiente(){
        $sql="  SELECT ctipamb AS id, dtipamb AS nombre
                FROM tipamba
                WHERE cestado='1'
                ORDER BY nombre";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Tipo de Ambiente cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Tipo de Ambiente','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarAmbiente($array){
        $sql="  SELECT cambien AS id,numamb AS nombre
                FROM ambienm
                WHERE ctipamb='".$array['ctipamb']."'
                AND cfilial='".$array['cfilial']."'
                AND cestado='1'";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Ambiente cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Ambiente','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarTiempoTolerancia(){
        $sql="  SELECT ctietol AS id,CONCAT(mintol,' MIN') AS nombre
                FROM tietolm
                WHERE cestado='1'";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Tiempo Tolerancia cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Tiempo Tolerancia','data'=>$data,'sql'=>$sql);
        }
    }

    public function guardarHorarios($array){
        $db=creadorConexion::crear('MySql');

        $db->iniciaTransaccion();
        $sql="UPDATE cuprprp
              SET cprofes='".$array['cprofes']."'
              ,finipre=".$array['finipre']."
              ,ffinpre=".$array['ffinpre']."
              ,finivir=".$array['finivir']."
              ,ffinvir=".$array['ffinvir']."
              ,cusuari='".$array['cusuari']."'
              ,fusuari=now()
              WHERE ccuprpr='".$array['ccuprpr']."'";

            $db->setQuery($sql);
            if(!$db->executeQuery()){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
            }
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
            }

        $datos=explode("^^",$array['datos']);
        $detdatact=explode("|",$datos[0]);
        for($i=0;$i<count($detdatact);$i++){
            $dd=explode("_",$detdatact[$i]);

            $sqlinsert="UPDATE horprop SET
                        cdia='".$dd[0]."',
                        chora='".$dd[1]."',
                        ctipcla='".$dd[2]."',
                        cambien='".$dd[4]."',
                        fusuari=NOW(),
                        cusuari='".$array['cusuari']."',
                        ctietol='".$dd[5]."',
                        cestado='".$dd[6]."'
                        WHERE chorpro='".$dd[7]."'";
            $db->setQuery($sqlinsert);
            if(!$db->executeQuery()){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsert);exit();
            }
            if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsert,$array['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsert);exit();
            }
        }

        $detdatins=explode("|",$datos[1]);
        for($i=0;$i<count($detdatins);$i++){
            $dd=explode("_",$detdatins[$i]);

            $sqlinsert="INSERT INTO horprop (cdia,chora,ccurpro,ctipcla,cambien,fusuari,cusuari,ctietol,cestado,cdetgra)
                        VALUES ('".$dd[0]."','".$dd[1]."','".$array['ccuprpr']."','".$dd[2]."','".$dd[4]."',now(),'".$array['cusuari']."','".$dd[5]."','1','".$array['cdetgra']."')";
            $db->setQuery($sqlinsert);
            if(!$db->executeQuery()){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsert);exit();
            }
            if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsert,$array['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsert);exit();
            }
        }

        $db->commitTransaccion();
        return array('rst'=>'1','msj'=>'Cambios guardados correctamente');exit();                
            
    }

}
?>