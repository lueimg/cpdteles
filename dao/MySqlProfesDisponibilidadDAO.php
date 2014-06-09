<?php 
class MySqlProfesDisponibilidadDAO{
    
    public function guardarDisponibilidad($post){
        
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        /****verifico que registro no exista******/
        
        //RECEPCION DE DATA
        $datos  = $post["datos"];
        $cprofe = $post["cprofes"];
        $datos_array = explode('|', $datos);
        $inserts_ids = array();
        // print_r($datos_array);
        // die();
        foreach ($datos_array as $row) {
            # code...
            $data_array = explode("-", $row);
            $sql = " INSERT INTO disprom set "
                 ." cprofes = '". $post["cprofes"] ."'" 
                 ." ,cdia = '". $data_array[0] ."'" 
                 ." ,hini = '".$data_array[1].":".$data_array[2] ."'" 
                 ." ,hfin = '". $data_array[3].":".$data_array[4] ."'" 
                 ." ,cestado = '". 1 ."'" 
                 ." ,cusucre = '". $post["cusuari"] ."'" 
                 ." ,fusucre = now() " 
                 ." ,cusumod = '". $post["cusuari"] ."'" 
                 ." ,fusumod = now() " 
            ;
            // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql);
            // $sql = "INSERT INTO equisag (ccurric,ccurso,cmodulo,gruequi,ccurria,ccursoa,cmoduloa,estide,cusuari,fusuari,cusuariu,fusuariu) 
            //                 values( '". $post["ccurric"] ."' ,'". $post["ccurso"] ."','". $post["cmodulo"] ."',0, '". $data_array[2] ."','". $data_array[3] ."'
            //                     ,'". $data_array[4] ."','". $post["estide"] ."',1,'". $post["cusuari"] ."')";

            $db->setQuery($sql);
            
            if($id = $db->executeQuery_returnid()){
                if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
                }

                // $db->commitTransaccion();
                // return array('rst'=>'1','msj'=>'Equivalencias Ingresadas','sql'=>$sql,'id'=>$id);
                $inserts_ids[] = $id; // GUARDA LOS IDS REGISTRADOS

            }else{
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al procesar Query , no retorno id','sql'=>$sql);
            }// FIN EXECUTE QUERY
        }// FIN FOREACH
            $db->commitTransaccion();
            return array('rst'=>'1','msj'=>'Horario Ingresado','sql'=>$sql,'ids'=>$inserts_ids);

    }//fin public functions

    
    
}
?>