<?php

class servletEquivalencia extends controladorComandos {

    public function doPost() {
        $daoEquivalencia = creadorDAO::getEquivalenciaDAO();
        switch ($_POST['action']):
            
            case 'cargarCarreras':
                $post = array();
                $post = (trim($_POST['cinstit']));

                echo json_encode($daoEquivalencia->cargarCarreras($post));
                break;
            case 'cargarModulos':
                $post = array();
                $post = (trim($_POST['ccarrer']));

                echo json_encode($daoEquivalencia->cargarModulos($post));
                break;
            case 'cargarCursos':
                $post = array();
                $post["cmodulo"] = (trim($_POST['cmodulo']));
                $post["ccurric"] = (trim($_POST['ccurric']));

                echo json_encode($daoEquivalencia->cargarCursos($post));
                break;
            case 'cargarCurriculas':
                $post = array();
                $post["cinstit"] = (trim($_POST['cinstit']));
                $post["ccarrer"] = (trim($_POST['ccarrer']));

                echo json_encode($daoEquivalencia->cargarCurriculas($post));
                break;
            case 'addEquivalencia':
                //$post = array();
                $post = $_POST['post'];
                //$post["ccarrer"] = (trim($_POST['ccarrer']));

                echo json_encode($daoEquivalencia->addEquivalencia($post));
                break;
            default:
                echo json_encode(array('rst' => 3, 'msg' => 'Action no encontrado1'));
        endswitch;
    }

    public function doGet() {
        $daoEquivalencia = creadorDAO::getEquivalenciaDAO();
        switch ($_GET['action']):
            case 'jqgrid_equivalencia':
                $page = $_GET["page"];
                $limit = $_GET["rows"];
                $sidx = $_GET["sidx"];
                $sord = $_GET["sord"];

                $where = "";
                $param = array();

                if (isset($_GET['cequivalencia'])) {
                    if (trim($_GET['id']) != '') {
                        $where.=" AND c.cequivalencia LIKE '%" . trim($_GET['cequivalencia']) . "%' ";
                    }
                }

                if (isset($_GET['dinstit'])) {
                    if (trim($_GET['dinstit']) != '') {
                        $where.=" AND c2.dinstit like '%" . trim($_GET['dinstit']) . "%' ";
                    }
                }

                if (isset($_GET['dturno'])) {
                    if (trim($_GET['dturno']) != '') {
                        $where.=" AND (SELECT t.dturno FROM turnoa AS t WHERE t.cturno= c.cturno ) like '%" . trim($_GET['dturno']) . "%' ";
                    }
                }

                if (isset($_GET['hinici'])) {
                    if (trim($_GET['hinici']) != '') {
                        $where.=" AND c.hinici LIKE '%" . trim($_GET['hinici']) . "%' ";
                    }
                }

                if (isset($_GET['hfin'])) {
                    if (trim($_GET['hfin']) != '') {
                        $where.=" AND c.hfin LIKE '%" . trim($_GET['hfin']) . "%' ";
                    }
                }

                if (isset($_GET['tequivalenciario'])) {
                    if (trim($_GET['tequivalenciario']) != '') {
                        $where.=" AND c.tequivalenciari =  '" . trim($_GET['tequivalenciario']) . "' ";
                    }
                }

                if (isset($_GET['claequivalencia'])) {
                    if (trim($_GET['claequivalencia']) != '') {
                        $where.=" AND c.tequivalencia =  '" . trim($_GET['claequivalencia']) . "' ";
                    }
                }

                if (isset($_GET['estado'])) {
                    if (trim($_GET['estado']) != '') {
                        $where.=" AND c.cestado =  '" . trim($_GET['estado']) . "' ";
                    }
                }

                if (isset($_GET['cinstit'])) {
                    if (trim($_GET['cinstit']) != '') {
                        $where.=" AND c.cinstit =  '" . trim($_GET['cinstit']) . "' ";
                    }
                }

                if (!$sidx)
                    $sidx = 1;

                $row = $daoEquivalencia->JQGridCountEquivalencia($where);
                $count = $row[0]['count'];
                if ($count > 0) {
                    $total_pages = ceil($count / $limit);
                } else {
                    $limit = 0;
                    $total_pages = 0;
                }

                if ($page > $total_pages)
                    $page = $total_pages;

                $start = $page * $limit - $limit;

                $response = array("page" => $page, "total" => $total_pages, "records" => $count);
                $data = $daoEquivalencia->JQGRIDRowsEquivalencia($sidx, $sord, $start, $limit, $where);
                $dataRow = array();
                for ($i = 0; $i < count($data); $i++) {
                    array_push($dataRow, array("id" => $data[$i]['cequisag'], "cell" => array(
                            $data[$i]['dtitulo'],
                            $data[$i]['ccurric'],
                            $data[$i]['dciclo'],
                            $data[$i]['cciclo'],
                            $data[$i]['dcurso'],
                            $data[$i]['ccurso'],
                            $data[$i]['dtituloa'],
                            $data[$i]['ccurrica'],
                            $data[$i]['dcicloa'],
                            $data[$i]['ccicloa'],
                            $data[$i]['dcursoa'],
                            $data[$i]['ccursoa'],
                            $data[$i]['estide'],
                        )
                            )
                    );
                }
                $response["rows"] = $dataRow;
                echo json_encode($response);
                break;
            default:
                echo json_encode(array('rst' => 3, 'msg' => 'Action no encontrado'));
        endswitch;
    }

}

?>
