<?php
header ('Content-type: text/html; charset=ISO-8859-1');
include_once './ControleSessao.class.php';
include_once './Servicos.class.php';
include_once './Validacao.class.php';

if(isset($_POST['op'])){
    switch ($_POST['op']) {
        //buscar cidades pelo id_estado
        case 1:
            if(isset($_POST['id_estado'])){
                $id_estado = $_POST['id_estado'];
                $arrayCidades = array();
                $arrayCidades = Servicos::buscarCidadesPorIdEstado($id_estado);
                $option = '';
                foreach ($arrayCidades as $c) {
                    $option .= "<option value='$c->id_cidade'>$c->nm_cidade</option>";
                }
                echo $option;
            }
            break;

        //buscar profissao
        case 2:
            if(isset($_POST['query'])){
                $query = $_POST['query'];
                $arrayCbos = array();
                $arrayCbos = Servicos::buscarCboComFiltro($query);
                echo $arrayCbos;
            }
            break;

        //buscar subarea por id_area
        case 3:
            if(isset($_POST['id_area'])){
                $id_area = $_POST['id_area'];
                //$arrayCidades = array();
                //$arraySubarea = Servicos::buscarCidadesPorIdEstado($id_estado);
                $arraySubarea = Servicos::buscarSubareasPorIdArea($id_area);
                $option = '';
                foreach ($arraySubarea as $sa) {
                    //$option .= "<option value='$sa->id_subarea'>$sa->nm_subarea</option>";
                    $check .= "<input type='checkbox' name='subareas[]' value='$sa->id_subarea'/>$sa->nm_subarea";
                }
                echo utf8_encode($check);
            }
            break;

        case 4:
            if(isset($_POST['vaga'])){
                ControleSessao::abrirSessao();
                ControleSessao::inserirVariavel('cadVaga', true);
            }
            break;

        case 5:
            if(isset($_POST['cancelar'])){
                ControleSessao::abrirSessao();

                ControleSessao::destruirVariavel('post');
                ControleSessao::destruirVariavel('cadVaga');

            }
            break;
        case 6:
            if(isset($_POST['id_cidade'])){
                $id_cidade = $_POST['id_cidade'];
                $arrayBairros = array();
                $arrayBairros = Servicos::buscarBairrosPorIdCidade($id_cidade);
                $option = '';
                foreach ($arrayBairros as $b) {
                    $option .= "<option value='$b->id_bairro'>$b->nm_bairro</option>";
                }
                echo $option;
            }
            break;

        default:
            ControleSessao::destruirSessao();
            header('Location:../../index.php');
            break;
    }
}else{
    ControleSessao::destruirSessao();
    header('Location:../../index.php');
}
?>
