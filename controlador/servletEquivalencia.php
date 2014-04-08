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
      case 'EditarEquivalencia':
        //$post = array();
        $post = $_POST['post'];
        //$post["ccarrer"] = (trim($_POST['ccarrer']));

        echo json_encode($daoEquivalencia->EditarEquivalencia($post));
        break;
      case 'EliminarEquivalencia':
        //$post = array();
        $post = $_POST['post'];
        //$post["ccarrer"] = (trim($_POST['ccarrer']));

        echo json_encode($daoEquivalencia->EliminarEquivalencia($post));
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

        if (isset($_GET['dtitulo'])) {
          if (trim($_GET['dtitulo']) != '') {
            $where.=" AND c.dtitulo LIKE '%" . trim($_GET['dtitulo']) . "%' ";
          }
        }

        if (isset($_GET['dciclo'])) {
          if (trim($_GET['dciclo']) != '') {
            $where.=" AND m.dmodulo like '%" . trim($_GET['dciclo']) . "%' ";
          }
        }

        if (isset($_GET['dcurso'])) {
          if (trim($_GET['dcurso']) != '') {
            $where.=" AND cu.dcurso like '%" . trim($_GET['dcurso']) . "%' ";
          }
        }
        
        if (isset($_GET['dtituloa'])) {
          if (trim($_GET['dtituloa']) != '') {
            $where.=" AND ca.dtitulo LIKE '%" . trim($_GET['dtituloa']) . "%' ";
          }
        }

        if (isset($_GET['dcicloa'])) {
          if (trim($_GET['dcicloa']) != '') {
            $where.=" AND ma.dmodulo like '%" . trim($_GET['dcicloa']) . "%' ";
          }
        }

        if (isset($_GET['dcursoa'])) {
          if (trim($_GET['dcursoa']) != '') {
            $where.=" AND cua.dcurso like '%" . trim($_GET['dcursoa']) . "%' ";
          }
        }
        
        if (isset($_GET['estide'])) {
          if (trim($_GET['estide']) != '') {
            $where.=" AND estide = '" . trim($_GET['estide']) . "' ";
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
                  $data[$i]['cestide'],
                  $data[$i]['inst'],
                  $data[$i]['carrer'],
                  $data[$i]['insta'],
                  $data[$i]['carrera'],
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
