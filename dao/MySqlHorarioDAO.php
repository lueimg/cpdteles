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

}
?>