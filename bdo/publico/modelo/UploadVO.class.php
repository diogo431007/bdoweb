<?php

class UploadVO {

    private $tamanho;
    private $tipo;
    private $nome;
    private $nomeTemporario;
    private $erro;
    private $diretorio;
    private $formatos;
    private $tamanhoMaximo;

    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 13:50
     * @version Banco de Oportunidades 2.0
     * 
     * @param file $arquivo Recebe a imagem que sera upada
     */
    public function __construct($arquivo) {
        $this->nome = $arquivo['name'];
        $this->tamanho = $arquivo['size'];
        $this->nomeTemporario = $arquivo['tmp_name'];
        $this->tipo = $arquivo['type'];
        $this->erro = $arquivo['error'];
        $this->tamanhoMaximo = 1048576;
        $this->formatos = array();
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 14:03
     * @version Banco de Oportunidades 2.0
     * 
     * @param string $a Recebe o nome do atributo que será retornado.
     * @return type Retorna um atributo da classe.
     */
    public function __get($a) {
        return $this->$a;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 14:08
     * @version Banco de Oportunidades 2.0
     * 
     * @param string $a Recebe o nome do atributo que será setado
     * @param type $v Recebe o novo valor do atributo
     */
    public function __set($a, $v) {
        $this->$a = $v;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 14:13
     * @version Banco de Oportunidades 2.0
     * 
     * @return boolean Retorna true se o tamanho do arquivo nao for maior que o limite
     */
    public function verificarTamanho() {
        return $this->tamanho <= $this->tamanhoMaximo;
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 14:20
     * @version Banco de Oportunidades 2.0
     * 
     * @return boolean Retorna true se a extensao do arquivo estiver no array de extensoes aceitas
     */
    public function verificarTipo() {
        return in_array($this->tipo, $this->formatos);
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 14:28
     * @version Banco de Oportunidades 2.0
     * 
     * @return string Retorna a mensagem de erro do arquivo
     */
    public function obterErro() {
        switch ($this->erro) {
            case 1: return 'Ultrapassou limite de tamanho do servidor';
            case 2: return 'Ultrapassou limite de arquivo do formulario';
            case 3: return 'O upload não foi concluído';
            case 4: return 'O upload não foi efetuado';
        }
    }
    
    /**
     * @author Douglas Neves <douglas.carlos@canoastec.rs.gov.br>
     * @since 04/11/2013 - 15:03
     * @version Banco de Oportunidades 2.0
     * 
     * @param int $largura Recebe a nova largura da imagem
     * @param string $novonome Recebe o novo nome da imagem
     */
    public function upload($largura, $novonome) {

        /*
        if ($this->tipo == "image/jpeg") {
            $img = imagecreatefromjpeg($this->nomeTemporario);
        } else if ($this->tipo == "image/png") {
            $img = imagecreatefrompng($this->nomeTemporario);
        }
        */
        $img = imagecreatefromjpeg($this->nomeTemporario);

        $x = imagesx($img);
        $y = imagesy($img);
        $altura = ($largura * $y) / $x;

        $nova = imagecreatetruecolor($largura, $altura);
        imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
        
        /*
        if ($this->tipo == "image/jpeg") {
            $local = $this->diretorio . "/$novonome" . ".jpg";
        } else if ($this->tipo == "image/png") {
            $local = $this->diretorio . "/$novonome" . ".png";
        }
        */
        $local = $this->diretorio . "/$novonome" . ".jpg";
        
        imagejpeg($nova, $local);
        imagedestroy($img);
        imagedestroy($nova);
    }

}

?>
