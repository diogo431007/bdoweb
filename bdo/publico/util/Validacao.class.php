<?php

class Validacao {

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 14:12
     *
     * @param String $nome Recebe o nome para validaÁ„o.
     * @return boolean Retorna true se o nome for verdadeiro, caso contr·rio false.
     */
    public static function validarNome($nome) {
        $exp = '/^[a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’ ]{3,40}$/';
        if (preg_match($exp, $nome)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 14:24
     *
     * @param String $cpf Recebe o cpf para validaÁ„o.
     * @return boolean Retorna true se o cpf for verdadeiro, caso contr·rio false.
     */
    public static function validarMascaraCpf($cpf) {
        $exp = '/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/';
        if (preg_match($exp, $cpf)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013
     *
     * @param type $cpf Recebe o cpf para validaÁ„o.
     * @return boolean Retorna true se o cpf for verdadeiro, caso contr·rio false.
     */
    public static function validarCpf($cpf) {

        // Verifica se um n˙mero foi informado
        if (empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $agulha = array('.', '-', '/');
        $cpf = str_replace($agulha, '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados È igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequÍncias invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF È v·lido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 14:33
     *
     * @param String $rg Recebe o rg para validaÁ„o.
     * @return boolean Retorna true se rg for verdadeiro, caso contr·rio false.
     */
    public static function validarRg($rg) {
        $exp = '/^[0-9]{0,10}$/';
        if (preg_match($exp, $rg)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/09/2013 - 15:31
     *
     * @param String $ctps Recebe o nr do ctps para validaÁ„o.
     * @return boolean Retorna true se n∫ de ctps for verdadeiro, caso contr·rio false.
     */
    public static function validarNrCtps($nr_ctps) {
        $exp = '/^[0-9]/';
        if (preg_match($exp, $nr_ctps)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 09:14
     *
     * @param String $nr_serie Recebe o nr da serie do ctps para validaÁ„o.
     * @return boolean Retorna true se o n∫ de serie for verdadeiro, caso contr·rio false.
     */
    public static function validarNrSerie($nr_serie) {
        $exp = '/^[0-9]{0,5}$/';
        if (preg_match($exp, $nr_serie)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 09:19
     *
     * @param String $id_estado Recebe o id do estado para validaÁ„o.
     * @return boolean Retorna true se o id do estado for verdadeiro, caso contr·rio false.
     */
    public static function validarIdEstado($id_estado) {
        $exp = '/^([0-2]{1})?([0-9]{1})$/';
        if (preg_match($exp, $id_estado)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 09:30
     *
     * @param String $email Recebe um email para validaÁ„o.
     * @return boolean Retorna true se o email for verdadeiro, caso contr·rio false.
     */
    public static function validarEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 09:33
     *
     * @param String $email Recebe um email nao obrigatorio para validaÁ„o.
     * @return boolean Retorna true se o email for verdadeiro, caso contr·rio false.
     */
    public static function validarEmailNaoObg($email) {
        if (empty($email)) {
            return true;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 09:19
     *
     * @param String $telefone Recebe o telefone (99) 99999-9999 para validaÁ„o.
     * @return boolean Retorna true se o telefone for verdadeiro, caso contr·rio false.
     */
    public static function validarTelefone($telefone) {
        $exp = '/^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/';
        if (preg_match($exp, $telefone)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 09:39
     *
     * @param String $telefone Recebe o telefone (99) 99999-9999 nao obrigatorio para validaÁ„o.
     * @return boolean Retorna true se o telefone for verdadeiro, caso contr·rio false.
     */
    public static function validarTelefoneNaoObg($telefone) {
        if(!$telefone)
          return true;
        $exp = '/^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/';
        if (preg_match($exp, $telefone)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 09:19
     *
     * @param String $estadoCivil Recebe o estado civil (S,C,V,P,D,O) para validaÁ„o.
     * @return boolean Retorna true se a estado civil for verdadeira, caso contr·rio false.
     */
    public static function validarEstadoCivil($estado_civil) {
        $exp = '/^[SCVDPO]{1}$/';
        if (preg_match($exp, $estado_civil)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 27/03/2015 - 10:56
     *
     * @param String $id_idade Recebe as idades (16,18,25,30,40,50) para validaÁ„o.
     * @return boolean Retorna true se a idade for verdadeira, caso contr·rio false.
     */
    public static function validarIdades($ds_idade) {
        //Verifico a express„o regular de acordo com a idade especÌfica
        if ($ds_idade === '16') {
            //Passa exatamente 16 anos
            $exp = '/^[1]{1}[6]{1}$/';
        } else if ($ds_idade === '18') {
            //Passa exatamente 18 anos
            $exp = '/^[1]{1}[8]{1}$/';
        } else if ($ds_idade === '25') {
            //Passa exatamente 25 anos
            $exp = '/^[2]{1}[5]{1}$/';
        } else if ($ds_idade === '30') {
            //Passa exatamente 30 anos
            $exp = '/^[3]{1}[0]{1}$/';
        } else if ($ds_idade === '40') {
            //Passa exatamente 40 anos
            $exp = '/^[4]{1}[0]{1}$/';
        } else if ($ds_idade === '50') {
            //Passa exatamente 50 anos
            $exp = '/^[5]{1}[0]{1}$/';
        } else {
            //Passa vazio ou seja todas as idades
            $exp = '/^[\'\']{0}$/';
        }
        if (preg_match($exp, $ds_idade)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 26/03/2015 - 15:41
     *
     * @param String $estado_civil Recebe o estado civil (S,C,V,P,D,O) para validaÁ„o.
     * @return boolean Retorna true se a estado civil for verdadeira, caso contr·rio false.
     */
    public static function validarEstadoCivilVaga($estado_civil) {
        $exp = '/^[SCVDPO]{0,1}$/';
        if (preg_match($exp, $estado_civil)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 10:00
     *
     * @param String $data Recebe a data 99/99/9999 para validaÁ„o.
     * @return boolean Retorna true se a data for verdadeira, caso contr·rio false.
     */
    public static function validarData($data) {
        if (empty($data)) {
            return false;
        }
        $arrayData = array();
        $arrayData = explode("/", $data);

        $mes = $arrayData[1];
        $dia = $arrayData[0];
        $ano = $arrayData[2];

        if (checkdate($mes, $dia, $ano)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 10:00
     *
     * @param String $data Recebe a data 99/99/9999 nao obrigatoria para validaÁ„o.
     * @return boolean Retorna true se a data for verdadeira, caso contr·rio false.
     */
    public static function validarDataNaoObg($data) {
        if (empty($data)) {
            return true;
        }
        $arrayData = array();
        $arrayData = explode("/", $data);

        $mes = $arrayData[1];
        $dia = $arrayData[0];
        $ano = $arrayData[2];

        if (checkdate($mes, $dia, $ano)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 10:15
     *
     * @param String $sexo Recebe o sexo(M,F) para validaÁ„o.
     * @return boolean Retorna true se o sexo for verdadeiro, caso contr·rio false.
     */
    public static function validarSexo($sexo) {
        if ($sexo == 'M' || $sexo == 'F' || $sexo == 'I') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 10:23
     *
     * @param String $nacionalidade Recebe a nacionalidade para validaÁ„o.
     * @return boolean Retorna true se a nacionalidade for verdadeira, caso contr·rio false.
     */
    public static function validarNacionalidade($nacionalidade) {
        $exp = '/^[a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{0,20}$/';
        if (preg_match($exp, $nacionalidade)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/03/2014 - 14:47
     *
     * @param String $nacionalidade Recebe a nacionalidade para validaÁ„o.
     * @return boolean Retorna true se a nacionalidade for verdadeira, caso contr·rio false.
     */
    public static function validarProfissao($profissao) {
        $exp = '/^[a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{0,50}$/';
        if (preg_match($exp, $profissao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 27/11/2014 - 13:36
     *
     * @param String $id_ramoatividade Recebe o id do ramo atividade para validaÁ„o.
     * @return boolean Retorna true se o id do ramo atividade for verdadeiro, caso contr·rio false.
     */
    public static function validarIdRamoAtividade($id_ramoatividade) {

        // abaixo para candidato
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_ramoatividade)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/02/2015 - 15:40
     *
     * @param String $id_empresatipo Recebe o id do tipo de empresa para validaÁ„o.
     * @return boolean Retorna true se o id do tipo de empresa for verdadeiro, caso contr·rio false.
     */
    public static function validarIdEmpresaTipo($id_empresatipo) {

        // abaixo para empresa
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_empresatipo)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 30/01/2015 - 13:49
     *
     * @param String $id_quantidadefuncionario Recebe o id da quantidade funcionario para validaÁ„o.
     * @return boolean Retorna true se o id da quantidade de funcionarios for verdadeiro, caso contr·rio false.
     */
    public static function validarIdQuantidadeFuncionario($id_quantidadefuncionario) {

        // abaixo para candidato
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_quantidadefuncionario)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 10:29
     *
     * @param String $idCidade Recebe o id da cidade para validaÁ„o.
     * @return boolean Retorna true se o id da cidade for verdadeiro, caso contr·rio false.
     */
    public static function validarIdCidadeCandidato($id_cidade) {
        if (empty($id_cidade)) {
            return false;
        }

        // abaixo para candidato
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_cidade)) {
            return true;
        } else {
            return false;
        }
    }

    //#####################N√O EST¡ SENDO USADO############################
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 27/11/2014 - 14:25
     *
     * @param String $id_microregiao Recebe o id da micro regi„o para validaÁ„o.
     * @return boolean Retorna true se o id da micro regiao for verdadeiro, caso contr·rio false.
     */
    public static function validarIdMicroRegiao($id_microregiao) {
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_microregiao)) {
            return true;
        } else {
            return false;
        }
    }

    //#####################N√O EST¡ SENDO USADO############################
    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 27/11/2014 - 14:27
     *
     * @param String $id_microregiao Recebe o id do polÌgono para validaÁ„o.
     * @return boolean Retorna true se o id do polÌgono for verdadeiro, caso contr·rio false.
     */
    public static function validarIdPoligono($id_poligono) {
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_poligono)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 27/11/2014 - 13:12
     *
     * @param String $idCidade Recebe o id da cidade para validaÁ„o.
     * @return boolean Retorna true se o id da cidade for verdadeiro, caso contr·rio false.
     */
    public static function validarIdCidadeEmpresa($id_cidade) {

        // abaixo para empresa
        $exp = '/^[0-9]{1,6}$/';

        if (preg_match($exp, $id_cidade)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 10:34
     *
     * @param String $bairro Recebe bairro para validaÁ„o.
     * @return boolean Retorna true se o bairro for verdadeiro, caso contr·rio false.
     */
    public static function validarBairro($bairro) {
        $exp = '/^[0-9a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\-\/\.\,\& ]{2,255}$/';
        if (preg_match($exp, $bairro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Giuseppe Menti <giuseppe.menti@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 1.1
     * @since 04/05/2013 - 11:18
     *
     * @param String $idBairro Recebe o id do bairro para validaÁ„o.
     * @return boolean Retorna true se o id do bairro for verdadeiro, caso contr·rio false.
     */
    public static function validarIdBairroCandidato($id_bairro) {

        // abaixo para candidato
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_bairro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 10:43
     *
     * @param String $ds_logradouro Recebe o logradouro para validaÁ„o.
     * @return boolean Retorna true se o logradouro for verdadeiro, caso contr·rio false.
     */
    public static function validarDsLogradouro($ds_logradouro) {
        //$exp = '/^[0-9a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{0,40}$/';
        $exp = '/^[0-9a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\-\/\.\,\& ]{1,255}$/';
        if (preg_match($exp, $ds_logradouro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 11:03
     *
     * @param String $nr_logradouro Recebe o n∫ do logradouro para validaÁ„o.
     * @return boolean Retorna true se o n∫ do logradouro for verdadeiro, caso contr·rio false.
     */
    public static function validarNrLogradouro($nr_logradouro) {
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $nr_logradouro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 11:06
     *
     * @param String $ds_complemento Recebe o complemento para validaÁ„o.
     * @return boolean Retorna true se o complemento for verdadeiro, caso contr·rio false.
     */
    public static function validarDsComplemento($ds_complemento) {
        $exp = '/^[0-9a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’,\.\-\∫ ]{0,25}$/';
        if (preg_match($exp, $ds_complemento)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 11:15
     *
     * @param String $id_cbo Recebe o id do cbo para validaÁ„o.
     * @return boolean Retorna true se o id do cbo for verdadeiro, caso contr·rio false.
     */
    public static function validarIdCbo($id_cbo) {
        $exp = '/^[0-9]{1,10}$/';
        if (preg_match($exp, $id_cbo)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 11:18
     *
     * @param String $id_deficiencia Recebe o id da deficiencia para validaÁ„o.
     * @return boolean Retorna true se o id da deficiencia for verdadeiro, caso contr·rio false.
     */
    public static function validarIdDeficiencia($id_deficiencia) {
        $exp = '/^[0-9]{0,3}$/';
        if (preg_match($exp, $id_deficiencia)) {
            return true;
        } else {
            return false;
        }
    }

    public static function testatDeficiencia($id_deficiencia) {
        if (empty($id_deficiencia)) {
            return 'null';
        } else {
            return $id_deficiencia;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 11:22
     *
     * @param String $mensagem Recebe uma mensagem para validaÁ„o.
     * @return boolean Retorna true se a mensagem for verdadeira, caso contr·rio false.
     */
    public static function validarMensagem($mensagem) {
        $exp = '/^[a-zA-Z0-9Á«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’!?:;,.\-\/ ]{0,5000}$/m';
        if (preg_match($exp, $mensagem)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/09/2013 - 09:35
     *
     * @param String $valor Recebe o valor a ser convertido em caracteres aplic·veis em entidades html.
     * @return String Retorna o valor conertido em caracteres aplic·veis em entidades html.
     */
    public static function converterHtml($valor) {
        return htmlentities($valor);
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 26/09/2013 - 12:57
     *
     * @param String $data Recebe a data no formato dd/mm/aaaa
     * @return String Retorna a data no formato aaaa-mm-dd
     */
    public static function explodirData($data) {
        $arrayData = array();
        $arrayData = explode("/", $data);
        $d = array($arrayData[2], $arrayData[1], $arrayData[0]);
        $nData = implode("-", $d);
        return $nData;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 26/09/2013 - 13:52
     *
     * @param String $login Recebe um login para validaÁ„o.
     * @return boolean Retorna true se o login for verdadeiro, caso contr·rio false.
     */
    public static function validarLogin($login) {
        $exp = '/^[0-9a-zA-Z.]{4,20}$/';
        if (preg_match($exp, $login) || filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 26/09/2013 - 13:55
     *
     * @param String $senha Recebe uma senha para validaÁ„o.
     * @return boolean Retorna true se a senha for verdadeira, caso contr·rio false.
     */
    public static function validarSenha($senha) {
        $exp = '/^[0-9a-zA-Z]{6,12}$/';
        if (preg_match($exp, $senha)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 26/09/2013 - 13:55
     *
     * @param String $id_formacao Recebe id_formacao para validacao.
     * @return boolean Retorna true se o id for verdadeiro, caso contr·rio false.
     */
    public static function validarFormacao($id_formacao) {
        $exp = '/^[0-9]{1,3}$/';
        if (preg_match($exp, $id_formacao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 26/09/2013 - 13:55
     *
     * @param String $id_formacao Recebe id_formacao para validacao.
     * @return boolean Retorna true se o id for verdadeiro, caso contr·rio false.
     */
    public static function validarSubarea($id_subarea) {
        $exp = '/^[1-8]$/';
        if (preg_match($exp, $id_subarea)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 30/09/2013 - 11:14
     *
     * @param String $nm_escola Recebe nome da escola para validaÁ„o.
     * @return boolean Retorna true se a escola for verdadeira, caso contr·rio false.
     */
    public static function validarNmEscola($nm_escola) {
        $exp = '/^[0-9a-zA-Z.Á«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{0,255}$/';
        if (preg_match($exp, $nm_escola)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 30/09/2013 - 11:14
     *
     * @param String $nm_escola Recebe nome da escola obrigatorio para validaÁ„o.
     * @return boolean Retorna true se a escola for verdadeira, caso contr·rio false.
     */
    public static function validarNmEscolaObg($nm_escola) {
        $exp = '/^[0-9a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{2,30}$/';
        if (preg_match($exp, $nm_escola)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 23/03/2015 - 11:22
     *
     * @param String $ds_qualificao Recebe nome da escola para validaÁ„o.
     * @return boolean Retorna true se decriÁ„o for verdadeira, caso contr·rio false.
     */
    public static function validarDsQualificacao($ds_qualificacao) {
        $exp = '/^[0-9a-zA-Z.Á«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{2,255}$/';
        if (preg_match($exp, $ds_qualificacao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 23/03/2015 - 11:34
     *
     * @param String $nm_instituicao Recebe nome da escola para validaÁ„o.
     * @return boolean Retorna true se instituiÁ„o for verdadeira, caso contr·rio false.
     */
    public static function validarNmInstituicao($nm_instituicao) {
        $exp = '/^[0-9a-zA-Z.Á«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{2,255}$/';
        if (preg_match($exp, $nm_instituicao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 30/09/2013 - 11:30
     *
     * @param String $data Recebe a data de termino de uma formacao para validacao.
     * @return boolean Retorna true se a data for verdadeira, caso contr·rio false.
     */
    public static function validarDtTermino($data) {
        if (empty($data)) {
            return true;
        } else {
            $arrayData = array();
            $arrayData = explode("/", $data);

            $mes = $arrayData[1];
            $dia = $arrayData[0];
            $ano = $arrayData[2];

            if (checkdate($mes, $dia, $ano)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 01/10/2013 - 14:46
     *
     * @param String $data Recebe a data no formato aaaa-mm-dd
     * @return String Retorna a data no formato dd/mm/aaaa
     */
//    public static function explodirDataMySql($data){
//        $arrayData = array();
//        $arrayData = explode("-", $data);
//        $d = array($arrayData[2], $arrayData[1], $arrayData[0]);
//        $nData = implode("/", $d);
//        return $nData;
//    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 02/10/2013 - 11:58
     *
     * @param int $qtd_horas Recebe a quantidade de horas.
     * @return boolean Retorna true se a quantidade passar na validacao, caso contr·rio false.
     */
    public static function validarQtdHoras($qtd_horas) {
        $exp = '/^[0-9]{0,5}$/';
        if (preg_match($exp, $qtd_horas)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 04/10/2013 - 11:58
     *
     * @param String $id_candidato_formacao Recebe o id do CandidatoFormacaoVO para validaÁ„o.
     * @return boolean Retorna true se o id do CandidatoFormacaoVO for verdadeiro, caso contr·rio false.
     */
    public static function validarIdCandidatoFormacao($id_candidato_formacao) {
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_candidato_formacao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 20/03/2014 - 11:20
     *
     * @param String $id_candidato_formacao Recebe o id do CandidatoFormacaoVO para validaÁ„o.
     * @return boolean Retorna true se o id do CandidatoFormacaoVO for verdadeiro, caso contr·rio false.
     */
    public static function validarIdCandidatoSubarea($id_candidatosubarea) {
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_candidatosubarea)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 13/03/2015 - 11:44
     *
     * @param String $id_candidato Recebe o id do CandidatoVO para validaÁ„o.
     * @return boolean Retorna true se o id do CandidatoVO for verdadeiro, caso contr·rio false.
     */
    public static function validarIdCandidato($id_candidato) {
        $exp = '/^[0-9]{1,6}$/';
        if (preg_match($exp, $id_candidato)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 08/10/2013 - 10:29
     *
     * @param String $nm_empresa Recebe uma empresa para validaÁ„o.
     * @return boolean Retorna true se a empresa for verdadeira, caso contr·rio false.
     */
    public static function validarNmEmpresa($nm_empresa) {
        //$exp = '/^[a-zA-Z0-9Á·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\:\;\,\. ]{2,60}$/';
        $exp = '/^[0-9a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\-\/\.\,\& ]{2,255}$/';
        if (preg_match($exp, $nm_empresa)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 08/10/2013 - 11:06
     *
     * @param String $data Recebe a data no formato dd/mm/aaaa nao obrigatoria
     * @return String Retorna a data no formato 'aaaa-mm-dd' ou null
     */
    public static function explodirDataNaoObg($data) {
        if (empty($data)) {
            return 'null';
        }
        $arrayData = array();
        $arrayData = explode("/", $data);
        $d = array($arrayData[2], $arrayData[1], $arrayData[0]);
        $nData = "'" . implode("-", $d) . "'";
        return $nData;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 02/10/2013 - 11:58
     *
     * @param int $qtd_horas Recebe a quantidade de horas.
     * @return String Retorna 'null' se a qtd_horas estiver vazia.
     */
    public static function testarQtdHoras($qtd_horas) {
        if (empty($qtd_horas)) {
            return 'null';
        } else {
            return $qtd_horas;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 08/10/2013 - 11:11
     *
     * @param String $data Recebe a data no formato aaaa-mm-dd nao obrigatoria
     * @return String Retorna a data no formato dd/mm/aaaa
     */
    public static function explodirDataMySqlNaoObg($data) {
        if ($data == null) {
            return null;
        }
        $arrayData = array();
        $arrayData = explode("-", $data);
        $d = array($arrayData[2], $arrayData[1], $arrayData[0]);
        $nData = implode("/", $d);
        return $nData;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 09/10/2013 - 11:22
     *
     * @param string $valor Recebe o valor a ser criptografado
     * @return strign Retorna o valor como um numero hexadecimal de 32 caracteres.
     */
    public static function criptografar($valor) {
        return md5($valor);
    }

    /**
     * @author Tais Damian <tais.damian@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 10/10/2013 - 10:29
     *
     * @param int $tamanho Recebe a quantidade de caracter
     * @param boolean $maiusculas Recebe um booleano para ativar maiusculas
     * @param boolean $numeros Recebe um booleano para ativar minusculas
     * @param boolean $simbolos Recebe um booleano para ativar simbolos
     * @return string Retorna uma senha randonica
     */
    public static function gerarSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
        // Caracteres de cada tipo
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        // Vari·veis internas
        $retorno = '';
        $caracteres = '';
        // Agrupamos todos os caracteres que poder„o ser utilizados
        $caracteres .= $lmin;
        if ($maiusculas)
            $caracteres .= $lmai;
        if ($numeros)
            $caracteres .= $num;
        if ($simbolos)
            $caracteres .= $simb;
        // Calculamos o total de caracteres possÌveis
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            // Criamos um n˙mero aleatÛrio de 1 atÈ $len para pegar um dos caracteres
            $rand = mt_rand(1, $len);
            // Concatenamos um dos caracteres na vari·vel $retorno
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 10:15
     *
     * @param String $nm_fantasia Recebe um nome fantasia para validacao
     * @return boolean Retorna true se o nome fantasia for verdadeiro, caso contr·rio false.
     */
    public static function validarNmFantasia($nm_fantasia) {
        $exp = '/^[a-zA-Z0-9Á«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\:\;\,\.\&\!\@\#\$\%\*\-\_\(\)\=\"\'\£\¢\¨\™\∫ ]{0,255}$/';
        if (preg_match($exp, $nm_fantasia)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 10:30
     *
     * @param String $cnpj Recebe um cnpj para validacao
     * @return boolean Retorna true se o cnpj for verdadeiro, caso contr·rio false.
     */
    public static function validarCnpj($cnpj) {
        //checa a mascara
        $exp = '/^([0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2})$/';
        if (!preg_match($exp, $cnpj)) {
            return false;
        }

        // Elimina possivel mascara
        $agulha = array('.', '-', '/');
        $cnpj = str_replace($agulha, '', $cnpj);

        // Verifica se o numero de digitos informados È igual a 11
        if (strlen($cnpj) != 14) {
            return false;
        }

        $soma1 = ($cnpj[0] * 5) +
                ($cnpj[1] * 4) +
                ($cnpj[2] * 3) +
                ($cnpj[3] * 2) +
                ($cnpj[4] * 9) +
                ($cnpj[5] * 8) +
                ($cnpj[6] * 7) +
                ($cnpj[7] * 6) +
                ($cnpj[8] * 5) +
                ($cnpj[9] * 4) +
                ($cnpj[10] * 3) +
                ($cnpj[11] * 2);

        $resto = $soma1 % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;

        $soma2 = ($cnpj[0] * 6) +
                ($cnpj[1] * 5) +
                ($cnpj[2] * 4) +
                ($cnpj[3] * 3) +
                ($cnpj[4] * 2) +
                ($cnpj[5] * 9) +
                ($cnpj[6] * 8) +
                ($cnpj[7] * 7) +
                ($cnpj[8] * 6) +
                ($cnpj[9] * 5) +
                ($cnpj[10] * 4) +
                ($cnpj[11] * 3) +
                ($cnpj[12] * 2);

        $resto = $soma2 % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        if (($cnpj[12] == $digito1) && ($cnpj[13] == $digito2)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 11:20
     *
     * @param String $cep Recebe um cep para validaÁ„o.
     * @return boolean Retorna true se o cep for verdadeiro, caso contr·rio false.
     */
    public static function validarCep($cep) {
        $exp = '/^[0-9]{0,5}-[0-9]{0,3}$/';
        if (preg_match($exp, $cep)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 12:12
     *
     * @param String $site Recebe um site para validaÁ„o.
     * @return boolean Retorna true se o site for verdadeiro, caso contr·rio false.
     */
    public static function validarSite($site) {
        //$exp = '/^((http[s]?:\/\/|ftp:\/\/)?(www\.)?[a-zA-Z0-9-\.]+\.(com|org|net|mil|edu|ca|co.uk|com.au|gov|br))?$/';
        //$exp_ = '/^((HTTP[S]?:\/\/|FTP:\/\/)?(WWW\.)?[a-zA-Z0-9-\.]+\.(COM|ORG|NET|MIL|EDU|CA|CO.UK|COM.AU|GOV|BR))?$/';
//        if(preg_match($exp,$site)){
//            return true;
//        }else{
//            return false;
//        }
        return $site;
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 13:52
     *
     * @param String $nr_inscricao Recebe um numero de inscricao municipal para validaÁ„o.
     * @return boolean Retorna true se o numero da inscricao municipal for verdadeiro, caso contr·rio false.
     */
    public static function validarNrIncricaoMunicipal($nr_inscricao) {
        $exp = '/^[0-9]{0,25}$/';
        if (preg_match($exp, $nr_inscricao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 14/10/2013 - 13:58
     *
     * @param String $nr_inscricao Recebe um numero de inscricao municipal para validaÁ„o.
     * @param String $uf Recebe um id_estado
     * @return boolean Retorna true se o numero da inscricao municipal for verdadeiro, caso contr·rio false.
     */
    public static function validarNrIncricaoEstadual($nr_inscricao, $uf) {
        if ($uf == '1') {
            $exp = '/^([0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{3}\-[0-9]{2})?$/';
        } else if ($uf == '2') {
            $exp = '/^([0-9]{9})?$/';
        } else if ($uf == '3') {
            $exp = '/^([0-9]{2}\.[0-9]{3}\.[0-9]{3}\-[0-9]{1})?$/';
        } else if (uf === '4') {
            $exp = '/^([0-9]{9})?$/';
        } else if (uf === '5') {
            $exp = '/^([0-9]{3}\.[0-9]{3}\.[0-9]{2}\-[0-9]{1})?$/';
        } else if (uf === '6') {
            $exp = '/^([0-9]{8}\-[0-9]{1})?$/';
        } else if (uf === '7') {
            $exp = '/^([0-9]{11}\-[0-9]{2})?$/';
        } else if (uf === '8') {
            $exp = '/^([0-9]{3}\.[0-9]{3}\.[0-9]{2}\-[0-9]{1})?$/';
        } else if (uf === '9') {
            $exp = '/^([0-9]{2}\.[0-9]{3}\.[0-9]{3}\-[0-9]{1})?$/';
        } else if (uf === '10') {
            $exp = '/^([0-9]{9})?/';
        } else if (uf === '11') {
            $exp = '/^([0-9]{3}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4})?$/';
        } else if (uf === '12') {
            $exp = '/^([0-9]{9})?/';
        } else if (uf === '13') {
            $exp = '/^([0-9]{9})?/';
        } else if (uf === '14') {
            $exp = '/^([0-9]{2}\-[0-9]{6}\-[0-9]{1})?$/';
        } else if (uf === '15') {
            $exp = '/^([0-9]{8}\-[0-9]{1})?$/';
        } else if (uf === '16') {
            $exp = '/^([0-9]{2}\.[0-9]{1}\.[0-9]{3}\.[0-9]{7}\-[0-9]{1})?$/';
        } else if (uf === '17') {
            $exp = '/^([0-9]{9})?/';
        } else if (uf === '18') {
            $exp = '/^([0-9]{8}\-[0-9]{2})?$/';
        } else if (uf === '19') {
            $exp = '/^([0-9]{2}\.[0-9]{3}\.[0-9]{2}\-[0-9]{1})?$/';
        } else if (uf === '20') {
            $exp = '/^([0-9]{2}\.[0-9]{3}\.[0-9]{3}\-[0-9]{1})?$/';
        } else if (uf === '21') {
            $exp = '/^([0-9]{3}\.[0-9]{5}\-[0-9]{1})?$/';
        } else if (uf === '22') {
            $exp = '/^([0-9]{8}\-[0-9]{1})?$/';
        } else if (uf === '23') {
            $exp = '/^([0-9]{3}\-[0-9]{7})?$/';
        } else if (uf === '24') {
            $exp = '/^([0-9]{3}\.[0-9]{3}\.[0-9]{3})?$/';
        } else if (uf === '25') {
            $exp = '/^([0-9]{9}\-[0-9]{1})?$/';
        } else if (uf === '26') {
            $exp = '/^([0-9]{3}\.[0-9]{3}\.[0-9]{3}\.[0-9]{3})?$/';
        } else {
            $exp = '/^([0-9]{11})?/';
        }
        if (preg_match($exp, $nr_inscricao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 13:37
     *
     * @param String $filtro Recebe o filtro dificiencia para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroDeficiencia($filtro) {
        $exp = '/^[0-9]{0,2}$/';
        if ($filtro == 'I' || $filtro == 'N' || $filtro == 'T' || preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 14:07
     *
     * @param String $filtro Recebe o filtro uf para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroIdEstado($filtro) {
        $exp = '/^([0-2]{1})?([0-9]{1})?$/';
        if (preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 14:28
     *
     * @param String $filtro Recebe o filtro cidade para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroIdCidade($filtro) {
        $exp = '/^[0-9]{0,6}$/';
        if (preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 14:36
     *
     * @param String $filtro Recebe o filtro formacao para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroIdFormacao($filtro) {
        $exp = '/^[1-8]?$/';
        if (preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 14:39
     *
     * @param String $filtro Recebe o filtro estado civil para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroEstadoCivil($filtro) {
        $exp = '/^[SCVDPO]?$/';
        if (preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 14:42
     *
     * @param String $filtro Recebe o filtro faixa etaria para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroFaixaEtaria($filtro) {
        $exp = '/^[1-6]?$/';
        if (preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 14:46
     *
     * @param String $filtro Recebe o filtro genero para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroGenero($filtro) {
        $exp = '/^[MF]?$/';
        if (preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 11/04/2014 - 11:31
     *
     * @param String $filtro Recebe o filtro status para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroStatus($filtro) {
        $exp = '/^[SNV]$/';
        if (preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/10/2013 - 14:46
     *
     * @param String $filtro Recebe o filtro genero para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarSubareas($filtro) {
        $exp = '/^[0-9]{1,2}$/';
        if (preg_match($exp, $filtro)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/02/2013 - 12:05
     *
     * @param String $filtro Recebe o filtro genero para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarAdicional($exp, $valor) {
        if (preg_match($exp, $valor)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 25/02/2013 - 08:32
     *
     * @param String $filtro Recebe o filtro genero para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarBeneficio($exp, $valor) {
        if (preg_match($exp, $valor)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 24/03/2013 - 11:05
     *
     * @param String $filtro Recebe o filtro genero para validaÁ„o.
     * @return boolean Retorna true se o filtro for verdadeiro, caso contr·rio false.
     */
    public static function validarAoFormacao($exp, $valor) {
        if (preg_match($exp, $valor)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 22/10/2013 - 11:32
     *
     * @param String $status Recebe o status(S,N) para validaÁ„o.
     * @return boolean Retorna true se o status for verdadeiro, caso contr·rio false.
     */
    public static function validarStatus($status) {
        $exp = '/^[SNI]$/';
        if (preg_match($exp, $status)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 29/10/2013 - 14:42
     *
     * @param String $ds_assunto Recebe o assunto do contato
     * @return boolean Retorna true se o assunto for verdadeiro, caso contr·rio false.
     */
    public static function validarAssunto($ds_assunto) {
        if ($ds_assunto == 'InformaÁ„o' || $ds_assunto == 'ReclamaÁ„o' || $ds_assunto == 'Sugest„o' || $ds_assunto == 'Linha de Conduta' || $ds_assunto == 'Esqueci Minha Senha') {
            return true;
        } else {
            false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 29/10/2013 - 14:45
     *
     * @param String $mensagem Recebe uma mensagem para validaÁ„o.
     * @return boolean Retorna true se a mensagem for verdadeira, caso contr·rio false.
     */
    public static function validarMensagemContato($mensagem) {
        $exp = '/[a-zA-Z0-9Á«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\!\?\:\;\,\.\-\+\=\@ ]{0,}/m';
        if (preg_match($exp, $mensagem)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 11/11/2013 - 11:59
     *
     * @param String $id_candidato Recebe o id do candidato para validaÁ„o.
     * @return boolean Retorna true se o id do candidato for verdadeiro, caso contr·rio false.
     */
    public static function validarAdmitido($id_candidato) {
        $exp = '/^[0-9]{1,5}$/';
        if (preg_match($exp, $id_candidato)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 13/11/2013 - 10:32
     *
     * @param type $var Recebe uma variavel qualquer
     * @return boolean Retorna true se a variavel estiver vazia, caso contr·rio false.
     */
    public static function validarVazio($var) {
        if (empty($var)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 13/11/2013 - 10:32
     *
     * @param type $var Recebe uma variavel qualquer
     * @return boolean Retorna true se a variavel for nula, caso contr·rio false.
     */
    public static function validarNulo($var) {
        if (is_null($var)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 18/11/2013 - 09:37
     *
     * @param String $filtro Recebe o filtro dificiencia
     * @return boolean Retorna true se o valor do filtro for indiferente, caso contr·rio false.
     */
    public static function validarDeficienciaVazio($filtro) {
        if ($filtro == 'I') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Tais Damian <tais.damian@canoastec.rs.gov.br>
     * @version Banco de Curriculos 2.0
     * @since 19/12/2013 - 09:23
     *
     * @param String $ds_curso Recebe nome do curso para validaÁ„o.
     * @return boolean Retorna true se o curso for verdadeiro, caso contr·rio false.
     */
    public static function validarCursoCand($ds_curso) {
        $exp = '/^[0-9a-zA-Z.Á«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{0,200}$/';
        if (preg_match($exp, $ds_curso)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Tais Damian <tais.damian@canoastec.rs.gov.br>
     * @version Banco de Curriculos 2.0
     * @since 19/12/2013 - 09:23
     *
     * @param String $ds_semestre Recebe nome do curso para validaÁ„o.
     * @return boolean Retorna true se o semestre for verdadeiro, caso contr·rio false.
     */
    public static function validarSemestreCand($ds_semestre) {
        $exp = '/^[0-9a-zA-Z.Á«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’\- ]{0,200}$/';
        if (preg_match($exp, $ds_semestre)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Curriculos 2.0
     * @since 01/04/2014 - 12:12
     *
     * @param Float $valor Recebe o valor do salario no formato decimal para validaÁ„o.
     * @return $converterValor retorna o valor padr„o de inserÁ„o no banco de dados.
     */
    public static function converterMoedaMysql($valor) {
        $recebeValor = $valor;
        $converterValor = str_replace('.', '', $recebeValor);
        $converterValor = str_replace(',', '.', $converterValor);
        return $converterValor;
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Curriculos 2.0
     * @since 01/04/2014 - 12:18
     *
     * @param Float $valor Recebe o valor do salario no formato decimal para validaÁ„o.
     * @return $converterValor retorna o valor padr„o de inserÁ„o no banco de dados.
     */
    public static function converterMoedaPhp($valor) {
        return number_format($valor, 2, ',', '.');
    }

    /**
     * @author Ricardo K.Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 01/04/2014 - 10:41
     *
     * @param String $Real Recebe o valor para validaÁ„o.
     * @return boolean Retorna true se o valor for verdadeiro, caso contr·rio false.
     */
    public static function validarMoedaReal($Real) {
        //$exp = '/^[-+]?\\d{1,3}(\\.\\d{3})*,\\d{2}$/';
        $exp = '/^[0-9]{1,3}([.]([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/';
        if (preg_match($exp, $Real)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 31/03/2014 - 14:41
     *
     * @param String $atribuicao Recebe atribuiÁ„o para validaÁ„o.
     * @return boolean Retorna true se a atribuiÁ„o for verdadeiro, caso contr·rio false.
     */
    public static function validarAtribuicao($atribuicao) {

        $exp = '/^[0-9a-zA-ZÁ«·ÈÌÛ˙‡‚ÍÓÙ˚„ı¡…Õ”⁄¿¬ Œ‘€√’!?\-\,\:\.\%\+\$\@\s ]{0,}$/m';
        if (preg_match($exp, $atribuicao)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 07/04/2014 - 09:36
     *
     * @param String $qt_vaga Recebe a quantidade de vagas para validaÁ„o.
     * @return String retorna "Nenhuma" se o $qt_vaga for igual a 'NULL'
     * caso contr·rio retorna qt_vaga.
     */
    public static function validarQtdVaga($qt_vaga) {
        if ($qt_vaga == NULL) {
            return 'Nenhuma';
        } else {
            return $qt_vaga;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 22/10/2013 - 11:32
     *
     * @param String $status Recebe o status(E,C,D,P,B) para validaÁ„o.
     * @return boolean Retorna true se o status for verdadeiro, caso contr·rio false.
     */
    public static function validarStatusEncaminhado($status) {
        $exp = '/^[ECDPB]$/';
        if (preg_match($exp, $status)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Alisson Vieira <alisson.vieira@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 31/03/2015 - 11:35
     *
     * @param String $status Recebe o status(A,B,C,D,E) para validaÁ„o.
     * @return boolean Retorna true se o status for verdadeiro, caso contr·rio false.
     */
    public static function validarCNH($status) {
        $exp = '/^[ABCDE]{0,3}$/';
        if (preg_match($exp, $status)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @version Banco de Oportunidades 2.0
     * @since 22/10/2013 - 11:32
     *
     * @param String $status Recebe o status(E,C,D) para validaÁ„o.
     * @return boolean Retorna true se o status for verdadeiro, caso contr·rio false.
     */
    public static function validarFiltroStatusEncaminhado($status) {
        $exp = '/^[ECDPB]{0,1}$/';
        if (preg_match($exp, $status)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 14/08/2014 - 14:00
     *
     * @param String $exo Recebe a express„o regular.
     * @param String $valor Recebe o valor a ser validado.
     * @return boolean Retorna true se o valor for verdadeiro, caso contr·rio false.
     */
    public static function validarGenerico($exp, $valor) {
        if (preg_match($exp, $valor)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author Ricardo K. Cruz <ricardo.cruz@canoastec.rs.gov.br>
     * @since 16/09/2014 - 11:11
     *
     * @param string $valor Recebe um valor para verificar se nao È uma string 'null'
     * @return null Retorna null se a string for null
     */
    public static function testarNull($valor) {
        if ($valor == null || $valor == 'null') {
            return null;
        } else {
            return $valor;
        }
    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 08/10/2013 - 11:11
     *
     * @param String $data Recebe a data no formato aaaa-mm-dd ou aaaa-mm-dd hh:mm:ss (neste caso precisa passar $flag=true)
     * @param boolean $flag Recebe true para separar o horario da data caso o $data seja um DATETIME
     * @return String Retorna a data no formato dd/mm/aaaa
     */
//    public static function explodirDataMySql($data, $flag=false){
//
//        if($data == null || $data == 'null'){
//            return null;
//        }
//        $arrayData = array();
//
//        if($flag){
//            $arrayData = explode(" ", $data);
//            $data = $arrayData[0];
//        }
//
//        $arrayData = explode("-", $data);
//
//        //$arrayData = explode("-", $data);
//        $d = array($arrayData[2], $arrayData[1], $arrayData[0]);
//        $nData = implode("/", $d);
//
//        $nData = str_replace("'", '', $nData);
//
//        return $nData;
//    }

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 08/10/2013 - 11:11
     *
     * @param String $data Recebe a data no formato aaaa-mm-dd ou aaaa-mm-dd hh:mm:ss (neste caso precisa passar $flag=true)
     * @param boolean $flag Recebe true para separar o horario da data caso o $data seja um DATETIME
     * @param boolean $hora Recebe true para retornar a hora junto caso a data seja um DATETIME
     * @return String Retorna a data no formato dd/mm/aaaa ou dd/mm/aaaa HH:MM:ss
     */
    public static function explodirDataMySql($data, $flag = false, $hora = false) {

        if ($data == null || $data == 'null') {
            return null;
        }

        $arrayData = array();

        if ($flag) {
            $arrayData = explode(" ", $data);
            $data = $arrayData[0];
            $hora = $arrayData[1];
        }

        $arrayData = explode("-", $data);

        //$arrayData = explode("-", $data);
        $d = array($arrayData[2], $arrayData[1], $arrayData[0]);
        $nData = implode("/", $d);

        $nData = str_replace("'", '', $nData);

        if (!$hora)
            return $nData;
        else
            return $nData . " " . $hora;
    }

}

?>
