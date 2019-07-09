<?php 
require_once 'header.php';
if(in_array(S_RELATORIO , $_SESSION[SESSION_ACESSO])){
    
    if($_POST){
        
        $query_montada;
        if($_POST['filtro_codigo']){
            $query_montada.= " and c.id_candidato = ".$_POST['filtro_codigo'];
        }        
        if($_POST['filtro_nome']){
            $query_montada.= " and c.nm_candidato like '%".$_POST['filtro_nome']."%'"; 
        }
        if($_POST['cidade_cand']){
            $query_montada.= " and c.id_cidade = ".$_POST['cidade_cand'];
        }
        if($_POST['filtro_faixa_etaria']){
            $idade = "(YEAR(now()) - YEAR(c.dt_nascimento) - if( DATE_FORMAT(now(), '%m%d') > DATE_FORMAT(c.dt_nascimento, '%m%d') ,0 , -1))";
            if($_POST['filtro_faixa_etaria'] == 1){
                $query_montada.= " and $idade between 15 and 19";
            }else if($_POST['filtro_faixa_etaria'] == 2){
                $query_montada.= " and $idade between 20 and 24";
            }else if($_POST['filtro_faixa_etaria'] == 3){
                $query_montada.= " and $idade between 25 and 29";
            }else if($_POST['filtro_faixa_etaria'] == 4){
                $query_montada.= " and $idade between 30 and 34";
            }else if($_POST['filtro_faixa_etaria'] == 5){
                $query_montada.= " and $idade between 35 and 39";
            }else if($_POST['filtro_faixa_etaria'] == 6){
                $query_montada.= " and $idade >= 40";
            }
        }
        if($_POST['filtro_genero']){
            $query_montada.= " and ao_sexo = '".$_POST['filtro_genero']."'";
        }
        if($_POST['filtro_deficiencia']){
            if($_POST['filtro_deficiencia'] === 'i'){
                //nao concatena nada na query
            }else if($_POST['filtro_deficiencia'] === 'n'){
                $query_montada.= " and id_deficiencia is null";
            }else if($_POST['filtro_deficiencia'] === 't'){
                $query_montada.= " and id_deficiencia is not null";
            }else{
                $query_montada.= " and id_deficiencia = ".$_POST['filtro_deficiencia'];
            }
        }
        if(!empty($_POST['filtro_escolaridade'])){
            $query_montada.= " and cf.id_formacao = ".$_POST['filtro_escolaridade'];
        }
        if(!empty($_POST['filtro_profissao'])){
            $query_montada.= " and cp.id_profissao = ".$_POST['filtro_profissao'];
        }
        if(!empty($_POST['filtro_estado_civil'])){
            $query_montada.= " and ds_estado_civil = '".$_POST['filtro_estado_civil']."'";
        }        
        
        $sql = "SELECT
                    DISTINCT c.id_candidato,
                    c.nm_candidato,
                    c.ds_email,
                    c.nr_telefone,
                    c.nr_celular                 
                FROM
                    candidato c
                LEFT JOIN
                    candidatoformacao cf ON (c.id_candidato = cf.id_candidato)
                LEFT JOIN
                    candidatoprofissao cp ON (c.id_candidato = cp.id_candidato)
                LEFT JOIN
                    cidade cid ON (c.id_cidade = cid.id_cidade)
                WHERE
                    1 = 1
                    ".$query_montada."
                ORDER BY c.nm_candidato ASC";
        
        //echo$sql;
       
    }
?>
<link   rel="stylesheet" href="css/modal.css" type="text/css" >
<div id="conteudo">
    <!--<img id="cabecalho-logo" alt="Brasão da Prefeitura" src="imagens/Orange wave.png">-->
    <div class="subtitulo">Banco de Oportunidades</div>
    <div id="principal">
        <ul>
                <?php  if(in_array(S_RELATORIO_ESTATISTICAS , $_SESSION[SESSION_ACESSO])){?>
                    <li>
                        <a href="#parte-04"><span>Estatísticas Gráficas</span></a>
                    </li>
                <?php } ?>
                <?php  if(in_array(S_RELATORIO , $_SESSION[SESSION_ACESSO])){?>
                    <li>
                        <a href="#parte-00"><span>Busca de Currículos</span></a>
                    </li>
                <?php } ?>
                <?php  if(in_array(S_LOG_ACESSO , $_SESSION[SESSION_ACESSO])){?>
                    <li>
                        <a href="#parte-01"><span>Logs de Acesso</span></a>
                    </li>
                <?php } ?>
                <?php if(in_array(S_RELATORIO_ADMISSAO, $_SESSION[SESSION_ACESSO])){?>
                    <li>
                        <a href="#parte-02"><span>Admissões</span></a>
                    </li>
                <?php } ?>
                <?php  if(in_array(S_RELATORIO_VAGA , $_SESSION[SESSION_ACESSO])){?>
                    <li>
                        <a href="#parte-03"><span>Vagas</span></a>
                    </li>
                <?php } ?>
                <?php  if(in_array(S_RELATORIO_PERIODO , $_SESSION[SESSION_ACESSO])){?>
                    <li>
                        <a href="#parte-05"><span>Período</span></a>
                    </li>
                <?php } ?>
        </ul>
        <?php if(in_array(S_RELATORIO_ESTATISTICAS , $_SESSION[SESSION_ACESSO])){?>
        <div id="parte-04">
            <?php
            $sqlGeral = mysql_query("select c.id_candidato, c.dt_validade from candidato c where c.dt_validade >= now() and MONTH(c.dt_cadastro) = MONTH(NOW())");
                                                $total_curriculos = mysql_num_rows($sqlGeral);
                                                //echo $total_curriculos;
            ?>
            <table id="container_geral" style="min-width:900px; height:400px; margin: 0 auto" align="center">
                <!-- ESTATÍSTICAS GRÁFICAS -->
                <tr>
                    <td>
                        <script>
                             <?php
                            $mes = date('m'); 
                            ?>
                            //Cria um array de meses
                            meses = new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
                            //Pega o mês e ano atual para montar o gráfico
                            hoje = new Date();
                            mes = hoje.getMonth();
                            ano = hoje.getFullYear();

                            $(function () {
                                //Seta a cor dos gráficos
                                Highcharts.setOptions({
                                    colors: ['#A0BF5F', '#C45653', '#5587C1', '#866AA7', '#EE7228', '#015754', '#B00067', '#F96E74'] //Cor dos gráficos, definido pela ordem dos dados
                                });
                                $('#container_geral').highcharts({
                                    chart: {
                                        type: 'column' //Tipo do Gráfico: bar, line, column, spline, area, areaspline, pie, scatter
                                        //marginLeft: 300 //Margin do gráfico para a esquerda
                                    },
                                    title: {
                                        text: 'Dados Gerais', //Título do Gráfico
                                        //x: 140 //Posição X do titulo
                                        style: {
                                            color: '#EE7228'
                                            //fontWeight: 'bold'
                                        }
                                    },
                                    subtitle: {
                                        text: 'Situação Atual' //Subtítulo do Gráfico
                                        //x: 140 //Posição X do subtitulo
                                    },
                                    legend: {
                                        align: 'left', //Onde a legenda vai ser alinhada
                                        verticalAlign: 'top', //Onde a legenda vai ser alinhada na vertical
                                        x: 0, //Posição X da legenda
                                        y: 100, //Posição Y da legenda
                                        //borderWidth: 2, //Largura da borda da legenda
                                        layout: 'vertical', //Estilo da legenda: Vertical | Horizontal
                                        //itemWidth: 400 //Espaçamento dos itens dentro da legenda
                                        itemStyle: {
                                            fontFamily: 'nexa_boldregular',
                                            fontSize: '14px'
                                        }
                                    },
                                    xAxis: {
                                        categories: [meses[mes] + '/' + ano] //Categoria do gráfico - mês/ano
                                    },
                                    yAxis: {
                                        title: {
                                            text: '' //Texto abaixo do gráfico
                                        },
                                        labels: {
                                            formatter: function() {
                                                return this.value.toFixed(0); //Formata o label para número inteiro (0) = 0 | (1) = 0.0 e assim adiante
                                            }
                                        }
                                    },
                                    series: [{
                                        //TOTAL DE CONTRATAÇÕES
                                        name: 'Contratações', //Label
                                        data: [<?php
                                                $sqlGeral = mysql_query("select vc.id_vagacandidato, vc.ao_status, vc.dt_status from vagacandidato vc where vc.ao_status = 'C' and MONTH(vc.dt_status) = MONTH(NOW())");
                                                //Conta quantos registros possuem na tabela
                                                $total_contratacoes = mysql_num_rows($sqlGeral);
                                                echo $total_contratacoes; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //TOTAL DE VAGAS
                                        name: 'Vagas', //Label
                                        data: [<?php
                                                $sqlGeral = mysql_query("select v.id_vaga, v.ao_ativo, v.dt_cadastro from vaga v where v.ao_ativo = 'S' and MONTH(v.dt_cadastro) = MONTH(NOW())");
                                                $total_vagas = mysql_num_rows($sqlGeral);
                                                echo $total_vagas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //TOTAL DE CANDIDATOS
                                        name: 'Currículos', //Label
                                        data: [<?php
                                                $sqlGeral = mysql_query("select c.id_candidato, c.dt_validade from candidato c where c.dt_validade >= now() and MONTH(c.dt_cadastro) = MONTH(NOW())");
                                                $total_curriculos = mysql_num_rows($sqlGeral);
                                                echo $total_curriculos; ?>]//Mostra o valor no gráfico
                                    }, { 
                                        //CANDIDATOS ENCAMINHADOS
                                        name: 'Candidatos Encaminhados', //Label
                                        data: [<?php
                                                $sqlGeral = mysql_query("select ce.id_vagacandidato, ce.ao_status, ce.dt_status from vagacandidato ce where ce.ao_status = 'E' and MONTH(ce.dt_status) = MONTH(NOW())");
                                                $total_candidatosenc = mysql_num_rows($sqlGeral);
                                                echo $total_candidatosenc; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //CANDIDATOS DISPENSADOS
                                        name: 'Candidatos Dispensados', //Label
                                        data: [<?php
                                                $sqlGeral = mysql_query("select cd.id_vagacandidato, cd.ao_status, cd.dt_status from vagacandidato cd where cd.ao_status = 'D' and MONTH(cd.dt_status) = MONTH(NOW())");
                                                $total_candidatosdis = mysql_num_rows($sqlGeral);
                                                echo $total_candidatosdis; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //EMPRESAS LIBERADAS
                                        name: 'Empresas Liberadas', //Label
                                        data: [<?php
                                                $sqlGeral = mysql_query("select el.id_empresa, el.ao_liberacao, el.dt_cadastro from empresa el where el.ao_liberacao = 'S' and MONTH(el.dt_cadastro) = MONTH(NOW())");
                                                $total_empresasl = mysql_num_rows($sqlGeral);
                                                echo $total_empresasl; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //EMPRESAS NÃO LIBERADAS
                                        name: 'Empresas Não Liberadas', //Label
                                        data: [<?php
                                                $sqlGeral = mysql_query("select enl.id_empresa, enl.ao_liberacao, enl.dt_cadastro from empresa enl where enl.ao_liberacao = 'N' and MONTH(enl.dt_cadastro) = MONTH(NOW())");
                                                $total_empresasnl = mysql_num_rows($sqlGeral);
                                                echo $total_empresasnl; ?>]//Mostra o valor no gráfico 
                                    }, {
                                        //TOTAL DE CURRÍCULOS
                                        name: 'Candidatos', //Label
                                        data: [<?php
                                                $sqlGeral = mysql_query("select ca.id_candidato, ca.dt_cadastro from candidato ca");
                                                $total_candidatos = mysql_num_rows($sqlGeral);
                                                echo $total_candidatos; ?>]//Mostra o valor no gráfico 
                                    }]
                                });
                            });
                        </script>
                    </td>
                </tr>
            </table>
            <hr>
            <!-- GRÁFICO DE CANDIDATOS -->
            <table id="container_candidato" style="min-width:900px; height:300px; margin: 0 auto" align="center">
                <tr>
                    <td>
                        <script>
                           $(function () {
                               //Seta a cor dos gráficos
                                Highcharts.setOptions({
                                    colors: ['#A0BF5F', '#866AA7', '#EE7228'] //Contratações, Vagas, Candidatos, Empresas Liberadas, Empresas Não Liberadas
                                });
                                $('#container_candidato').highcharts({
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        marginLeft: 10 //Margin do gráfico para a esquerda
                                    },
                                    legend: {
                                        align: 'left', //Onde a legenda vai ser alinhada
                                        verticalAlign: 'top', //Onde a legenda vai ser alinhada na vertical
                                        x: 0, //Posição X da legenda
                                        y: 150, //Posição Y da legenda
                                        //borderWidth: 2, //Largura da borda da legenda
                                        layout: 'vertical', //Estilo da legenda: Vertical | Horizontal
                                        //itemWidth: 400 //Espaçamento dos itens dentro da legenda
                                        itemStyle: {
                                            fontFamily: 'nexa_boldregular',
                                            fontSize: '14px'
                                        }
                                    },
                                    title: {
                                        text: 'Candidatos',
                                        style: {
                                            color: '#EE7228',
                                            fontWeight: 'bold'
                                        }
                                    },
                                    subtitle: {
                                        text: 'Total'
                                    },
                                    tooltip: {
                                        pointFormat: '<b>{point.percentage:.1f}%</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            showInLegend: true,
                                            dataLabels: {
                                                enabled: false, //Habilita ou desabilita a descrição de cada parte no gráfico 
                                                format: '<b>{point.name}</b>: {point.percentage:.1f} %' //Formata com porcentagem
                                            }
                                        }
                                    },
                                    series: [{
                                        type: 'pie',
                                        name: '',
                                        data: [
                                            ['Contratações',
                                                <?php
                                                //TOTAL DE CONTRATAÇÕES
                                                $sqlCand = mysql_query("select vc.id_vagacandidato, vc.ao_status from vagacandidato vc where vc.ao_status = 'C'");
                                                //Conta quantos registros possuem na tabela
                                                $total_contratacoes = mysql_num_rows($sqlCand);
                                                echo $total_contratacoes; ?>],//Mostra o valor no gráfico

                                            ['Candidatos Encaminhados',
                                                <?php
                                                //CANDIDATOS ENCAMINHADOS
                                                $sqlCand = mysql_query("select vce.id_vagacandidato, vce.ao_status from vagacandidato vce where vce.ao_status = 'E'");
                                                $total_candidatosenc = mysql_num_rows($sqlCand);
                                                echo $total_candidatosenc; ?>],//Mostra o valor no gráfico

                                            ['Candidatos Dispensados',
                                                <?php
                                                //CANDIDATOS DISPENSADOS
                                                $sqlCand = mysql_query("select vcd.id_vagacandidato, vcd.ao_status from vagacandidato vcd where vcd.ao_status = 'D'");
                                                $total_candidatosdis = mysql_num_rows($sqlCand);
                                                echo $total_candidatosdis; ?>]//Mostra o valor no gráfico                                                                                                                  
                                        ]
                                    }]
                                });
                            });
                        </script>
                    </td>
                </tr>
            </table>
            <hr>
            <table id="container_visualizacoes" style="min-width:900px; height:400px; margin: 0 auto" align="center">
                <!-- VISUALIZAÇÕES -->
                <tr>
                    <td>
                        <script>
                            <?php
                            $ano = date('y'); 
                            ?>
                            $(function () {
                                //Seta a cor dos gráficos
                                Highcharts.setOptions({
                                    colors: ['#A0BF5F', '#C45653', '#5587C1', '#866AA7', '#EE7228', '#015754', '#B00067', '#FEFA03', '#00FDD4', '#F96E74', '#FD00F7', '#FA0403'] //Cor dos gráficos, definido pela ordem dos dados
                                });
                                $('#container_visualizacoes').highcharts({
                                    chart: {
                                        type: 'bar', //Tipo do Gráfico: bar, line, column, spline, area, areaspline, pie, scatter
                                        marginLeft: 300 //Margin do gráfico para a esquerda
                                    },
                                    title: {
                                        text: 'Acessos', //Título do Gráfico
                                        //x: 145 //Posição X do titulo
                                        style: {
                                            color: '#EE7228',
                                            fontWeight: 'bold'
                                        }
                                    },
                                    subtitle: {
                                        text: 'Total' //Subtítulo do Gráfico
                                        //x: 145 //Posição X do subtitulo
                                    },
                                    legend: {
                                        align: 'left', //Onde a legenda vai ser alinhada
                                        verticalAlign: 'top', //Onde a legenda vai ser alinhada na vertical
                                        x: 0, //Posição X da legenda
                                        y: 100, //Posição Y da legenda
                                        //borderWidth: 2, //Largura da borda da legenda
                                        //itemWidth: 340, //Espaçamento dos itens dentro da legenda
                                        reversed: true,      
                                        layout: 'vertical', //Estilo da legenda: Vertical | Horizontal
                                        itemStyle: {
                                            fontFamily: 'nexa_boldregular',
                                            fontSize: '14px'
                                        }
                                    },
                                    xAxis: {
                                        categories: [ano] //Categoria do gráfico - mês/ano
                                    },
                                    yAxis: {
                                        title: {
                                            text: '' //Texto abaixo do gráfico
                                        },
                                        labels: {
                                            formatter: function() {
                                                return this.value.toFixed(0); //Formata o label para número inteiro (0) = 0 | (1) = 0.0 e assim adiante
                                            }
                                        }
                                    },
                                    series: [{
                                        //DEZEMBRO
                                        name: 'Dezembro', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-12-01 00:00:00' and '$ano-12-31 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //NOVEMBRO
                                        name: 'Novembro', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-11-01 00:00:00' and '$ano-11-31 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //OUTUBRO
                                        name: 'Outubro', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-10-01 00:00:00' and '$ano-10-31 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, { 
                                        //SETEMBRO
                                        name: 'Setembro', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-09-01 00:00:00' and '$ano-09-30 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //AGOSTO
                                        name: 'Agosto', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-08-01 00:00:00' and '$ano-08-31 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //JULHO
                                        name: 'Julho', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-07-01 00:00:00' and '$ano-07-31 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //JUNHO
                                        name: 'Junho', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-06-01 00:00:00' and '$ano-06-30 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //MAIO
                                        name: 'Maio', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-05-01 00:00:00' and '$ano-05-31 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //ABRIL
                                        name: 'Abril', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-04-01 00:00:00' and '$ano-04-30 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //MARÇO
                                        name: 'Março', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-03-01 00:00:00' and '$ano-03-31 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //FEVEREIRO
                                        name: 'Fevereiro', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-02-01 00:00:00' and '$ano-02-29 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }, {
                                        //JANEIRO
                                        name: 'Janeiro', //Label
                                        data: [<?php
                                                $sqlVisita = mysql_query("select v.id_visita from visita v where v.dt_visita between '$ano-01-01 00:00:00' and '$ano-01-31 23:59:59'");
                                                $total_visitas = mysql_num_rows($sqlVisita);
                                                echo $total_visitas; ?>]//Mostra o valor no gráfico
                                    }]
                                });
                            });
                        </script>
                    </td>
                </tr>
            </table>
        </div>
    <?php } ?>
    <?php  if(in_array(S_RELATORIO , $_SESSION[SESSION_ACESSO])){?>
    <div id="parte-00"> 
        <div class="relatorio_filtro">
            <form name="relatorioFiltro" id="relatorioFiltro" action="" method="post">
                <fieldset>
                    <legend class="legend">Filtros</legend>
                    
                    <table class="tabela_relatorio">
                        
                        <tr>                            
                            <td width="8%" align="left">
                                <label class="filtro_label">Código:</label>
                            </td>
                            <td width="25%">
                                <input value="<?php if($_POST['filtro_codigo']){ echo $_POST['filtro_codigo'];} ?>" type="text" name="filtro_codigo" id="filtro_codigo" class="campo largura">
                            </td>
                            
                            <td width="8%" align="left">
                                <label class="filtro_label">Nome:</label>
                            </td>
                            <td width="25%">
                                <input value="<?php if($_POST['filtro_nome']){ echo $_POST['filtro_nome'];} ?>" type="text" name="filtro_nome" id="filtro_nome" class="campo largura">
                            </td>                         
                        </tr>                       
                        
                        <tr>
                            <td width="10%" align="left">
                                <label class="filtro_label">Deficiência:</label>
                            </td>
                            <td width="35%">
                                <select name="filtro_deficiencia" id="filtro_deficiencia" class="campo largura">
                                    <option value="i" selected>Indiferente</option>
                                    <option value="n" <?php if($_POST['filtro_deficiencia'] == 'n'){echo 'selected';} ?>>Nenhuma</option>
                                    <option value="t" <?php if($_POST['filtro_deficiencia'] == 't'){echo 'selected';} ?>>Todas</option>
                                    <?php
                                    $sql_def = "SELECT 
                                                    d.id_deficiencia,
                                                    d.nm_deficiencia
                                                FROM 
                                                    deficiencia d 
                                                ORDER BY 
                                                    nm_deficiencia";
                                    $query_def = mysql_query($sql_def);
                                    while ($row_def = mysql_fetch_object($query_def)) {
                                    ?>    
                                    <option value="<?php echo $row_def->id_deficiencia; ?>" <?php if($_POST['filtro_deficiencia'] == $row_def->id_deficiencia){echo 'selected';} ?>>
                                        <?php echo $row_def->nm_deficiencia; ?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            
                            <td align="left">
                                <label class="filtro_label">Estado:</label>
                            </td>
                            <td>
                                <select name="estado_cand" id="estado_cand" class="campo largura">
                                    <option value="">Selecione</option>
                                    <?php
                                    $sqlUf = "SELECT * FROM estado ORDER BY nm_estado";
                                    $query = mysql_query($sqlUf);
                                    while ($rowUf = mysql_fetch_object($query)) {
                                    ?>
                                    <option value="<?php echo $rowUf->id_estado;?>" <?php if ($_POST['estado_cand'] == $rowUf->id_estado) echo "selected" ?>>
                                        <?php
                                        echo $rowUf->nm_estado;
                                        ?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left">
                                <label class="filtro_label">Escolaridade:</label>
                            </td>
                            <td>
                                <select name="filtro_escolaridade" id="filtro_escolaridade" class="campo largura">
                                    <option value="" selected>Todos</option>
                                    <?php
                                    $sql_esc = "SELECT
                                                    *
                                                FROM
                                                    formacao
                                                ORDER BY
                                                    id_formacao ASC";
                                    $query_esc = mysql_query($sql_esc);
                                    while ($row_esc = mysql_fetch_object($query_esc)) {
                                    ?>
                                    <option value="<?php echo $row_esc->id_formacao; ?>" <?php if($_POST['filtro_escolaridade'] == $row_esc->id_formacao){echo 'selected';} ?>>
                                        <?php echo $row_esc->nm_formacao; ?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            
                            <td align="left">
                                <label class="filtro_label">Cidade:</label>
                            </td>
                            <td>
                                <select name="cidade_cand" id="cidade_cand" class="campo largura">
                                    <?php
                                    if($_POST['cidade_cand']){
                                        $sqlCidade = "SELECT * FROM cidade WHERE id_estado IN (SELECT id_estado FROM cidade WHERE id_cidade = ".$_POST['cidade_cand'].")";
                                        $queryCidade = mysql_query($sqlCidade);
                                        if($queryCidade){
                                            $cidades = '';
                                            while ($rowCidade = mysql_fetch_object($queryCidade)) {
                                                if($rowCidade->id_cidade == $_POST['cidade_cand']){
                                                    $cidades.= "<option selected value='$rowCidade->id_cidade'>".$rowCidade->nm_cidade."</option>";
                                                }
                                                $cidades.= "<option value='$rowCidade->id_cidade'>".$rowCidade->nm_cidade."</option>";
                                            }
                                            echo $cidades;
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left">
                                <label class="filtro_label">Estado Civil:</label>
                            </td>
                            <td>
                                <select name="filtro_estado_civil" id="filtro_estado_civil" class="campo largura">
                                    <option value="">Todos</option>
                                    <option value="S" <?php if($_POST['filtro_estado_civil'] == 'S'){echo 'selected';} ?>>Solteiro</option>
                                    <option value="C" <?php if($_POST['filtro_estado_civil'] == 'C'){echo 'selected';} ?>>Casado</option>
                                    <option value="V" <?php if($_POST['filtro_estado_civil'] == 'V'){echo 'selected';} ?>>Viúvo</option>
                                    <option value="D" <?php if($_POST['filtro_estado_civil'] == 'D'){echo 'selected';} ?>>Divorciado</option>
                                    <option value="P" <?php if($_POST['filtro_estado_civil'] == 'P'){echo 'selected';} ?>>Separado</option>
                                    <option value="O" <?php if($_POST['filtro_estado_civil'] == 'O'){echo 'selected';} ?>>Outros</option>
                                </select>
                            </td>
                            
                            <td align="left">
                                <label class="filtro_label">Faixa Etária</label>
                            </td>
                            <td>
                                <select name="filtro_faixa_etaria" id="filtro_faixa_etaria" class="campo largura">
                                    <option value="" selected>Todos</option>
                                    <option value="1" <?php if($_POST['filtro_faixa_etaria'] == '1'){echo 'selected';} ?>>15 - 19</option>
                                    <option value="2" <?php if($_POST['filtro_faixa_etaria'] == '2'){echo 'selected';} ?>>20 - 24</option>
                                    <option value="3" <?php if($_POST['filtro_faixa_etaria'] == '3'){echo 'selected';} ?>>25 - 29</option>
                                    <option value="4" <?php if($_POST['filtro_faixa_etaria'] == '4'){echo 'selected';} ?>>30 - 34</option>
                                    <option value="5" <?php if($_POST['filtro_faixa_etaria'] == '5'){echo 'selected';} ?>>35 - 39</option>
                                    <option value="6" <?php if($_POST['filtro_faixa_etaria'] == '6'){echo 'selected';} ?>>40 - ...</option>
                                </select>
                            </td>
                       </tr>
                            
                       <tr>
                           <td align="left">
                                <label class="filtro_label">Profissão:</label>
                           </td>
                           <td>
                               <select name="filtro_profissao" id="filtro_profissao" class="campo largura">
                                   <option value="" selected>Selecione</option>
                                   <?php
                                   $sql_pro = "SELECT
                                                    p.*
                                                FROM
                                                    profissao p
                                                WHERE
                                                    p.ao_ativo = 'S'
                                                ORDER BY
                                                    p.nm_profissao ASC";
                                   
                                   $query_pro = mysql_query($sql_pro);
                                   
                                   while ($row_pro = mysql_fetch_object($query_pro)) {
                                   ?>
                                   <option value="<?php echo $row_pro->id_profissao; ?>" <?php if($_POST['filtro_profissao'] == $row_pro->id_profissao){echo 'selected';} ?>>
                                       <?php echo $row_pro->nm_profissao; ?>
                                   </option>
                                   <?php
                                   }
                                   ?>
                                   
                               </select>
                           </td>
                           
                           <td align="left">
                                <label class="filtro_label">Gênero:</label>
                            </td>
                            <td>
                                <input type="radio" name="filtro_genero" id="filtro_genero_i" class="campo" value="" checked>
                                <label class="filtro_label">Indiferente</label>
                                
                                <input type="radio" name="filtro_genero" id="filtro_genero_m" class="campo" value="M" <?php if($_POST['filtro_genero'] == 'M'){echo 'checked';} ?>>
                                <label class="filtro_label">Homem</label>
                                
                                <input type="radio" name="filtro_genero" id="filtro_genero_f" class="campo" value="F" <?php if($_POST['filtro_genero'] == 'F'){echo 'checked';} ?>>
                                <label class="filtro_label">Mulher</label>
                            </td>
                       </tr>
                    </table>
                </fieldset>
                <table>
                    <tr>
                        <td align="left">
                            <input type="submit" value="Buscar" name="btn_filtro" id="btn_filtro" class="botao"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="relatorio_resultado">
            <?php
            if($_POST){
                $query_rel = mysql_query($sql);
                if($query_rel){
                    $num_rows = mysql_num_rows($query_rel);
                    if($num_rows > 0){
                ?>
            
            <form name="print_relatorio" id="print_relatorio" method="post" action="printCurriculo.php">
                
                <div align='right' id="imprimir_relatorio">
                    <input type="submit" value="Imprimir" name="btn_print" id="btn_print" class="botao" />

                    <label class="filtro_label">Marcar Todos</label>
                    <input type="checkbox" name="paginasTodos" id="todos" value="" onclick="marcardesmarcar();">
                </div>
                
                <table width="100%">
                    <tr>
                        <td class="tabela_resultado nome">Nome</td>
                        <td class="tabela_resultado telefone">Telefone</td>
                        <td class="tabela_resultado telefone">Celular</td>
                        <td class="tabela_resultado email">E-mail</td>
                        <!--<td class="tabela_resultado genero">Gênero</td>
                        <td class="tabela_resultado telefone">Estado Civil</td> 
                        <td class="tabela_resultado genero">Idade</td>
                        <td class="tabela_resultado area_subarea">Área de Interesse</td>-->
                        <td class="tabela_resultado edita">Imprimir</td>
                    </tr>
                        <?php
                        while ($row_rel = mysql_fetch_object($query_rel)) {
                        ?>
                    <tr>
                        <td class="linha_relatorio"><?php echo $row_rel->nm_candidato; ?></td>
                        <td class="linha_relatorio"><?php echo $row_rel->nr_telefone; ?></td>
                        <td class="linha_relatorio"><?php echo $row_rel->nr_celular; ?></td>
                        <td class="linha_relatorio"><?php echo $row_rel->ds_email; ?></td>                        
                        <!--<td class="linha_relatorio"><?php //echo $row_rel->genero; ?></td>
                        <td class="linha_relatorio"><?php //echo $row_rel->estado_civil; ?></td>
                        <td class="linha_relatorio" align="center"><?php //echo $row_rel->idade; ?></td>-->
                        <td class="linha_relatorio" align="center">
                            <input type="checkbox" class="marcar" id="pag_perfil" name="ids[]" value="<?php echo $row_rel->id_candidato; ?>">
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </form>
                
                <?php
                    }else{
                        echo "<div align='center'>Sua busca não retornou nenhum registro!</div>";
                    }
                }else{
                    echo "<div align='center'>Não foi possível realizar a busca neste momento.<br>Tente novamente mais tarde!</div>";
                }
            }
            ?>
        </div>
    </div>
    <?php } ?>
    <?php  if(in_array(S_LOG_ACESSO , $_SESSION[SESSION_ACESSO])){?>
        <div id="parte-01">
            <fieldset>
                <legend class="legend">Dados de Acesso</legend>
                <form name="formLog" id="formLog" method="post" action="controleLog.php?op=buscar">
                    <table class="tabela_log">
                        <tr>
                            <td width="70px">
                                <label>Período:</label>
                            </td>
                            <td width="220px">
                                De:&nbsp;
                                <input type="text" readonly class="campo" name="dt_inicio" id="dt_inicio" value="<?php if(isset($_SESSION['post'])){ echo $_SESSION['post']['dt_inicio'];} ?>"/> 
                            </td>
                            <td>
                                Até:&nbsp;
                                <input type="text" readonly class="campo" name="dt_fim" id="dt_fim" value="<?php if(isset($_SESSION['post'])){ echo $_SESSION['post']['dt_fim'];} ?>"/> 
                            </td>
                            <?php
                            if( (isset($_SESSION['erros'])) && (in_array('dt_inicio', $_SESSION['erros']) || in_array('dt_fim', $_SESSION['erros']))){
                            ?>
                            <td class="style1">* Informe o período desejado!</td>
                            <?php  
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                <label>Origem:</label>
                            </td>
                            <td>
                                <input type="radio" name="ao_origem" id="ao_origem" value="E" checked />Empresa
                                <input type="radio" name="ao_origem" id="ao_origem" value="C" <?php if(isset($_SESSION['post']) && $_SESSION['post']['ao_origem'] == 'C'){ echo 'checked';} ?> />Candidato
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Tipo:</label>
                            </td>
                            <td>
                                <input type="radio" name="ao_tipo" id="ao_tipo" value="A" checked />Analítico
                                <input type="radio" name="ao_tipo" id="ao_tipo" value="S" <?php if (isset($_SESSION['post']) && $_SESSION['post']['ao_tipo'] == 'S') { echo 'checked';}  //indicar a linha da coluna do post?>/>Sintético 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br><input type="submit" class="campo" value="Buscar" />
                            </td>
                        </tr>
                    </table>
                </form>
                
                <?php
                if(isset($_SESSION['log'])){
                    $arrayLog = $_SESSION['log'];
                    include_once './funcoes.php';
                   if(count($arrayLog)>0){
                ?>
                <form name="imprimirLog" method="post" action="printLog.php">
                    <input type="hidden" name="tipo_print" value="<?php echo $_SESSION['post']['ao_tipo']; ?>" />
                    <input type="hidden" name="origem_print" value="<?php echo $_SESSION['post']['ao_origem']; ?>" />
                    <input type="hidden" name="inicio_print" value="<?php echo $_SESSION['post']['dt_inicio']; ?>" />
                    <input type="hidden" name="fim_print" value="<?php echo $_SESSION['post']['dt_fim']; ?>" />
                    <div align='right' id="imprimir_log">
                        <input type="submit" value="Imprimir" name="btn_print" id="btn_print" class="botao" />

                        <label class="filtro_label">Marcar Todos</label>
                        <input type="checkbox" name="paginasTodos" id="todos" value="" onclick="marcardesmarcar();">
                    </div>

                    <table width="100%">
                        <?php
                        if($_SESSION['post']['ao_tipo'] == 'A'){
                        ?>
                        <tr>
                            <td class="tabela_resultado" width="70%">Nome</td>
                            <td class="tabela_resultado" width="10%">Data</td>
                            <td class="tabela_resultado" width="10%">Hora</td>
                            <td class="tabela_resultado" width="10%">Imprimir</td>
                        </tr>
                        <?php
                            foreach ($arrayLog as $log) {
                        ?>
                        <tr>
                            <td class="linha_relatorio"><?php echo $log->nome; ?></td>
                            <td class="linha_relatorio" align="center"><?php echo $log->data; ?></td>
                            <td class="linha_relatorio" align="center"><?php echo $log->hora; ?></td>
                            <td class="linha_relatorio" align="center">
                                <input type="checkbox" class="marcar" id="pag_perfil" name="ids[]" value="<?php echo $log->id_log; ?>">
                            </td>
                        </tr>
                        <?php
                            }
                        
                        }else{
                        ?>
                        <tr>
                            <td class="tabela_resultado" width="75%">Nome</td>
                            <td class="tabela_resultado" width="15%">Quantidade de Acessos</td>
                            <td class="tabela_resultado" width="10%">Imprimir</td>
                        </tr>
                          <?php
                             foreach ($arrayLog as $log){
                          ?>
                        <tr>
                            <td class="linha_relatorio"><?php echo $log->nome;?></td>
                            <td class="linha_relatorio" align="center"><?php echo $log->qt_acessos;?></td>
                            <td class="linha_relatorio" align="center">
                                <input type="checkbox" class="marcar" id="pag_perfil" name="ids[]" value="<?php echo $log->id_acesso;?>">
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </form>
                <?php
                   }else{
                 ?>   
                    Não há logs de acesso neste período.
                <?php 
                   } 
                }
                ?>
            </fielset>
        </div>
    <?php } ?>
    
    <?php  if(in_array(S_RELATORIO_ADMISSAO , $_SESSION[SESSION_ACESSO])){
        
//        echo var_dump($_SESSION);
        ?>
        <div id="parte-02">            
            <fieldset>
                <legend class="legend">Dados de Admissões</legend>
                
                <form name="formAdmissao" id="formAdmissao" method="post" action="controleAdmissao.php?op=buscar">
                    <table class="tabela_log" style="margin-bottom: -15px;">
                        <tr>
                            <td width="3%">
                                <label>Período:</label>
                            </td>
                            <td width="1%">
                                De:
                            </td>
                            <td width="80px">
                                <input type="text" class="campo" name="dt_inicio_admissao" id="dt_inicio_admissao" value="<?php if(isset($_SESSION['post'])){ echo $_SESSION['post']['dt_inicio_admissao'];}else if(isset($_SESSION['datas'])){ echo $_SESSION['datas']['dt_inicio_admissao'];} ?>"/> 
                                Até:
                            
                                <input type="text" class="campo" name="dt_fim_admissao" id="dt_fim_admissao" value="<?php if(isset($_SESSION['post'])){ echo $_SESSION['post']['dt_fim_admissao'];}else if(isset($_SESSION['datas'])){ echo $_SESSION['datas']['dt_fim_admissao'];} ?>"/> 
                            
                            <?php
                            if( (isset($_SESSION['erros'])) && (in_array('dt_inicio_admissao', $_SESSION['erros']) || in_array('dt_fim_admissao', $_SESSION['erros']))){
                            ?>
                            <span class="style1">* Informe o período desejado!</span>
                            <?php  
                            }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label>
                                    Empresa:
                                </label>
                            </td>
                            <td>
                                <select name="empresa" id="empresa" class="campo">
                                    <option value="">Todos</option>
                                    <?php
                                        $sql = "SELECT nm_razaosocial,id_empresa
                                                FROM empresa 
                                                ORDER BY nm_razaosocial ASC";
                                        $query = mysql_query($sql);
                                        while($row = mysql_fetch_object($query)){
                                    ?>
                                            <option value="<?php echo $row->id_empresa; ?>" <?php if(($row->id_empresa == $_SESSION['post']['empresa']) || ($row->id_empresa == $_SESSION['datas']['empresa'])) echo 'selected'; ?>><?php echo $row->nm_razaosocial; ?></option>
                                    <?php
                                         }
                                     ?>
                                </select>
                            </td>
                        </tr>                       
                        <tr>
                            <td colspan="3">
                                <br><input type="submit" class="botao" value="Buscar" style="width: 90px;" />
                            </td>
                        </tr>
                    </table>
                </form>
                </fieldset>
                <?php
                //var_dump($_SESSION['admissoes']);
                if(isset($_SESSION['admissoes'])){
                                        
                    include_once 'funcoes.php';
                    //Recebe os arrays e joga na variável
                    $arrayAdmissao = $_SESSION['admissoes']['total'];
                    $arrayEncaminhado = $_SESSION['admissoes']['encaminhados'];
                    $arrayBaixaAutomatica = $_SESSION['admissoes']['baixaAutomatica'];
                    $arrayPreSelecionado = $_SESSION['admissoes']['preSelecionados'];
                    $arrayContratado = $_SESSION['admissoes']['contratados'];
                    $arrayDispensado = $_SESSION['admissoes']['dispensados'];
                    $arrayDeficientes = $_SESSION['admissoes']['deficientes'];
                    
                    //Faz um foreach dos encaminhados e joga num array
                    $idEmpresaEncaminhado = array();
                    foreach($arrayEncaminhado as $e){
                        $idEmpresaEncaminhado[$e->id_empresa] = $e->qtd;
                        $totalEncaminhados = $totalEncaminhados + $e->qtd;
                    }
                    
                    //Faz um foreach dos baixa automática e joga num array
                    $idEmpresaBaixaAutomatica = array();
                    foreach($arrayBaixaAutomatica as $b){
                        $idEmpresaBaixaAutomatica[$b->id_empresa] = $b->qtd;
                        $totalBaixaAutomatica = $totalBaixaAutomatica + $b->qtd;
                    }
                    
                    //Faz um foreach dos pré-selecionados e joga num array
                    $idEmpresaPreSelecionado = array();
                    foreach($arrayPreSelecionado as $p){
                        $idEmpresaPreSelecionado[$p->id_empresa] = $p->qtd;
                        $totalPreSelecionado = $totalPreSelecionado + $p->qtd;
                    }
                    
                    //Faz um foreach dos contratados e joga num array
                    $idEmpresaContratado = array();
                    foreach($arrayContratado as $c){
                        $idEmpresaContratado[$c->id_empresa] = $c->qtd;
                        $totalContratado = $totalContratado + $c->qtd;
                    }
                    
                    //Faz um foreach dos dispensados e joga num array
                    $idEmpresaDispensado = array();
                    foreach($arrayDispensado as $d){
                        $idEmpresaDispensado[$d->id_empresa] = $d->qtd;
                        $totalDispensado = $totalDispensado + $d->qtd;
                    }
                    
                    //Faz um foreach dos deficientes e joga num array
                    $idEmpresaDeficiente = array();
                    foreach($arrayDeficientes as $def){
                        $idEmpresaDeficiente[$def->id_empresa] = $def->qtd;
                        $totalDeficientes = $totalDeficientes + $def->qtd;                        
                    }
                    
                    if(count($arrayAdmissao)>0){
                        $contAdmissao = 0;
                ?>
                <br />
                <div class="tab_admissao">
                    <form name="imprimirAdmissao" method="post" action="printAdmissao.php">                        
                        <table width="100%" style="border-collapse: collapse">
                            <tr class="table_admissao_cab">
                                <td align="center" style="padding: 5px; width: 380px;">Empresa</td>
                                <td align="center" style="padding: 5px; width: 100px;">Encaminhados</td>
                                <td align="center" style="padding: 5px; width: 100px;">Baixas Automáticas</td>
                                <td align="center" style="padding: 5px; width: 100px;">Pré-Selecionados</td>
                                <td align="center" style="padding: 5px; width: 100px;">Contratados</td>
                                <td align="center" style="padding: 5px; width: 100px;">Dispensados</td>
                                <td align="center" style="padding: 5px; width: 100px;">Total de Deficientes</td>
                                <td align="center" style="padding: 5px; width: 100px;">Total</td>  
                            </tr>
                            <?php
                                foreach ($arrayAdmissao as $a) {
                                    $contAdmissao = $contAdmissao + $a->qtd;
                                    
                                }
                                //define a quantidade de resultados da lista
                                $qtd = 40;
                                //busca a page atual
                                $page = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                                //recebo um novo array com apenas os elemento necessarios para essa page atual
                                $auxAdmissao = listar($arrayAdmissao, $qtd, $page);
                                    
                                foreach ($auxAdmissao as $a) {
                                
                                    if(!is_null($a)){
                            ?>
                            <tr class="table_admissao_row">
                                <td style="padding: 5px; border: 1px solid #EE7228; width: 380px;"><?php echo  $a->nm_razaosocial?></td>
                                <td style="padding: 5px; border: 1px solid #EE7228; width: 100px; text-align: center;">
                                    <?php
                                        if(array_key_exists($a->id_empresa, $idEmpresaEncaminhado)){
                                            echo $idEmpresaEncaminhado[$a->id_empresa];
                                        }else{
                                            echo "-";
                                        }
                                    ?>
                                </td>
                                <td style="padding: 5px; border: 1px solid #EE7228; width: 100px; text-align: center;">
                                    <?php
                                        if(array_key_exists($a->id_empresa, $idEmpresaBaixaAutomatica)){
                                            echo $idEmpresaBaixaAutomatica[$a->id_empresa];
                                        }else{
                                            echo "-";
                                        }
                                    ?>
                                </td>
                                <td style="padding: 5px; border: 1px solid #EE7228; width: 100px; text-align: center;">
                                    <?php 
                                        if(array_key_exists($a->id_empresa, $idEmpresaPreSelecionado)){
                                            echo $idEmpresaPreSelecionado[$a->id_empresa];                                                
                                        }else{
                                            echo "-";
                                        }
                                    ?>
                                </td>
                                <td style="padding: 5px; border: 1px solid #EE7228; width: 100px; text-align: center;">
                                    <?php
                                        if(array_key_exists($a->id_empresa, $idEmpresaContratado)){
                                            echo $idEmpresaContratado[$a->id_empresa];                                                
                                        }else{
                                            echo "-";
                                        }
                                    ?>
                                </td>
                                <td style="padding: 5px; border: 1px solid #EE7228; width: 100px; text-align: center;">
                                    <?php
                                        if(array_key_exists($a->id_empresa, $idEmpresaDispensado)){
                                            echo $idEmpresaDispensado[$a->id_empresa];                                                
                                        }else{
                                            echo "-";
                                        }
                                    ?>
                                </td>
                                <td style="padding: 5px; border: 1px solid #EE7228; width: 100px; text-align: center;">
                                    <span style="vertical-align: middle;">
                                    <?php
                                        $mostrarDadosDeficientes = array_key_exists($a->id_empresa, $idEmpresaDeficiente);
                                        if($mostrarDadosDeficientes){
                                            echo $idEmpresaDeficiente[$a->id_empresa];
                                        }else{
                                            echo "-";
                                        }
                                    ?>
                                    </span>
                                    <?php
                                        if($mostrarDadosDeficientes){
                                    ?>
                                        <img onclick="" data-empresa="<?php echo $a->id_empresa; ?>" class="showModal" alt="Listar candidatos com deficiência encaminhados" title="Listar candidatos com deficiência encaminhados" src="../../Utilidades/Imagens/bancodeoportunidades/acessibilidade.png" style="vertical-align: middle; margin-left: 10px; cursor: pointer;" />
                                    <?php 
                                        }
                                    ?>
                                </td>
                                <td align="center" style="padding: 5px; border: 1px solid #EE7228; width: 100px; text-align: center;">
                                    <?php echo $a->qtd; ?>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                            <tr class="table_admissao_cab">
                                <td align="" style="padding: 5px;">Total Geral</td>
                                <td align="center" style="padding: 5px;"><?php echo $totalEncaminhados; ?></td>
                                <td align="center" style="padding: 5px;"><?php echo $totalBaixaAutomatica; ?></td>
                                <td align="center" style="padding: 5px;"><?php echo $totalPreSelecionado; ?></td>
                                <td align="center" style="padding: 5px;"><?php echo $totalContratado; ?></td>
                                <td align="center" style="padding: 5px;"><?php echo $totalDispensado; ?></td>
                                <td align="center" style="padding: 5px;"><?php echo $totalDeficientes; ?></td>
                                <td align="center" style="padding: 5px;"><?php echo $contAdmissao;?></td>
                            </tr>
                            <tr style="height: 20px;">
                                <td colspan="8" align="center" style="border: 1px solid #EE7228; padding: 3px;">
                                    <div id="paginacao_ad">                                        
                                        <?php
                                        //crio a paginacao propriamente dita
                                        $ancora = "#parte-02";
                                        
                                        echo criarPaginacao($arrayAdmissao, $qtd, $page, $ancora);                                        
                                        ?>
                                        
                                        <input type="submit" class="botao" value="Imprimir" style="height: 25px; width: 102px; float: right; " />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                    
                    <div id="modal-pcd" class="modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="close"><small>x</small></span>
                                <h2>Candidatos com deficiência encaminhados</h2>
                            </div>
                            <div class="modal-body">
                                <table id="modal-table" class="modal-table">
                                </table>
                            </div>
                            <div class="modal-footer">
                                <form name="imprimirRelatorioDeficientesPorEmpresa" method="post" action="printRelatorioDeficientesPorEmpresa.php">
                                    <input type="hidden" value="" name="id_empresa" id="empresaRelatorioDeficientesPorEmpresa" />
                                    <input type="submit" class="btn" value="Download"/>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <?php
                        }else{
                        ?>
                            Não há admissões neste período
                        <?php
                        }
                    }
                }
                ?>
            
            </div>
        
        <?php  if(in_array(S_RELATORIO_VAGA , $_SESSION[SESSION_ACESSO])){?>
        <div id="parte-03">
            <fieldset>
                <legend class="legend">Relatório de Vagas</legend>
                <form name="formLog" id="formLog" method="post" action="controleVaga.php?op=buscar">
                    <table class="tabela_log">
                        <tr>
                            <td>
                                <label>
                                    Empresa:
                                </label>
                            </td>
                            <td>
                                <select name="empresa" id="empresa" class="campo">
                                    <option value="">Todos</option>
                                    <?php
                                        $sql = "SELECT nm_razaosocial,id_empresa
                                                FROM empresa 
                                                ORDER BY nm_razaosocial ASC";
                                        $query = mysql_query($sql);
                                        while($row = mysql_fetch_object($query)){
                                    ?>
                                            <option value="<?php echo $row->id_empresa; ?>" <?php if($row->id_empresa == $_POST['empresa'] || $row->id_empresa == $_SESSION['dados']['empresa']) echo 'selected'; ?>><?php echo $row->nm_razaosocial; ?></option>
                                    <?php
                                         }
                                     ?>
                                </select>
                                <?php
                                if(isset($_SESSION['erros']) && in_array('empresa', $_SESSION['erros'])){
                                ?>
                                <span class="style1">Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php /* --- inicio comentario ---
                        <tr>
                            <td>
                                <label>Status:</label>
                            </td>
                            <td>
                                <input type="radio" name="ao_ativo" id="ao_origem" value="S" checked />Ativas
                                <input type="radio" name="ao_ativo" id="ao_origem" value="N" <?php if(isset($_SESSION['dados']) && $_SESSION['dados']['ao_ativo'] == 'N'){ echo 'checked';} ?> />Inativas
                                <input type="radio" name="ao_ativo" id="ao_origem" value="T" <?php if(isset($_SESSION['dados']) && $_SESSION['dados']['ao_ativo'] == 'T'){ echo 'checked';} ?> />Todas
                                <?php
                                if(isset($_SESSION['erros']) && in_array('ao_ativo', $_SESSION['erros'])){
                                ?>
                                <span class="style1">Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                         * 
                         --- fim comentario ---*/?>
                        <tr>
                            <td>Profissão:</td>
                            <td>
                                <select name="profissao" class="campo">
                                    <option value="">Todos</option>
                                <?php
                                $profissoes = array();
                                $sql = "select p.id_profissao, p.nm_profissao from profissao p where p.ao_ativo = 'S' order by p.nm_profissao asc";
                                $query = mysql_query($sql);
                                while($row = mysql_fetch_object($query)){
                                    $profissoes[] = $row;
                                }
                                foreach($profissoes as $p) {
                                ?>
                                    <option value="<?php echo $p->id_profissao; ?>" 
                                    <?php if (isset($_SESSION['dados']['profissao']) && ($p->id_profissao == $_SESSION['dados']['profissao'])) { echo 'selected'; }?>>
                                        <?php echo $p->nm_profissao; ?>
                                    </option>
                                <?php
                                }
                                ?>
                                </select>
                                <?php
                                if(isset($_SESSION['erros']) && in_array('profissao', $_SESSION['erros'])){
                                ?>
                                <span class="style1">Preencha corretamente este campo</span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br><input type="submit" class="campo" value="Buscar" />
                            </td>
                        </tr>
                    </table>
                </form>
                <?php
                if(isset($_SESSION['errosE'])){
                ?>
                <span class="style1">
                    * Escolha no mínimo um candidato
                </span>
                <?php
                }
                
                if(isset($_SESSION['msgE'])){
                ?>
                <span class="style1">
                    <?= $_SESSION['msgE']; ?>
                </span>
                <?php
                }
                
                if(isset($_SESSION['arrayVagas'])){
                    
                    if(count($_SESSION['arrayVagas'])>0){

                        include_once './funcoes.php';
                        //define a quantidade de resultados da lista
                        $qtdVaga = 5;
                        //busca a page atual
                        $pageVaga = (isset($_GET['pg'])) ? $_GET['pg'] : 0;
                        //recebo um novo array com apenas os elemento necessarios para essa page atual
                        $vagas = listar($_SESSION['arrayVagas'], $qtdVaga, $pageVaga);
                        
                ?>
                <div>
                    <table width="100%">
                        <?php
                        foreach ($vagas as $v) {
                            if(!is_null($v)){
                        ?>
                        <form name="formLog" id="formLog" method="post" action="controleVaga.php?op=encaminhar">
                            <input type="hidden" name="vaga" value="<?php echo $v->id_vaga; ?>" />
                        <tr>
                            <td>
                            <table class="vaga_tab" width="100%">
                                <tr>
                                    <td class="vaga_cab" width="15%">Empresa</td>
                                    <td class="vaga_row" colspan="2"><?php echo (!empty($v->nm_fantasia)) ? $v->nm_fantasia : $v->nm_razaosocial; ?></td>
                                </tr>
                                <tr>
                                    <td class="vaga_cab">Profissão</td>
                                    <td class="vaga_row" colspan="2"><?php echo $v->nm_profissao; ?></td>                                    
                                </tr>
                                <tr>
                                    <td class="vaga_cab">Vagas</td>
                                    <td class="vaga_row" colspan="2"><?php echo $v->qt_vaga; ?></td>
                                </tr>
                                <tr>
                                    <td class="vaga_cab" colspan="">Candidatos</td>
                                    <td class="vaga_cab" align="right" colspan="2">
                                        Marcar todos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" id="tCand<?= $v->id_vaga; ?>" onclick="marcarDinamico('tCand<?= $v->id_vaga; ?>','mCand<?= $v->id_vaga; ?>');" />
                                    </td>
                                </tr>
                                
                                <?php
                                foreach ($v->candidatos as $c) {
                                ?>
                                <tr class="vaga_cand">
                                    <td class="vaga_row" colspan="2"><?php echo $c->nm_candidato; ?></td>
                                    <td class="vaga_row" align="right">
                                        <input type="checkbox" class="mCand<?= $v->id_vaga; ?>" name="candidatos[]" value="<?php echo $c->id_candidato; ?>" 
                                        <?php if (isset($_SESSION['post']['candidatos']) && in_array($c->id_candidato, $_SESSION['post']['candidatos'])) { echo 'checked'; }?> />
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                                <tr>
                                    <td class="vaga_row" align="right" colspan="3">
                                        <input type="submit" value="Encaminhar para vaga" class="botao"/>
                                    </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <br/>
                            </td>
                        </tr>
                        </form>
                        <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="4" class="paginacao">
                                <?php
                                echo criarPaginacao($_SESSION['arrayVagas'], $qtdVaga, $pageVaga, $ancora='#parte-03');
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
                   }else{
                ?>   
                    Não há vagas.
                <?php
                    }
                ?>
                <?php
                }
                ?>
                    
            </fielset>
        </div>
        <?php } ?>
        <?php  if(in_array(S_RELATORIO_PERIODO , $_SESSION[SESSION_ACESSO])){ ?>
        <div id="parte-05">
            <fieldset>
                <legend class="legend">Relatório total do sistema por período</legend>
                <form name="formAdmissao" id="formAdmissao" method="post" action="controlePeriodo.php?op=buscar">
                    <table class="tabela_log">
                        <tr>                            
                            <td width="1%">
                                De:
                            </td>
                            <td width="80px">
                                <input type="text" class="campo" name="dt_inicio_periodo" id="dt_inicio_periodo" value="<?php if(isset($_SESSION['post'])){ echo $_SESSION['post']['dt_inicio_admissao'];}else if(isset($_SESSION['datas'])){ echo $_SESSION['datas']['dt_inicio_admissao'];} ?>"/> 
                                Até:
                            
                                <input type="text" class="campo" name="dt_fim_periodo" id="dt_fim_periodo" value="<?php if(isset($_SESSION['post'])){ echo $_SESSION['post']['dt_fim_admissao'];}else if(isset($_SESSION['datas'])){ echo $_SESSION['datas']['dt_fim_admissao'];} ?>"/> 
                            
                            <?php
                            if( (isset($_SESSION['erros'])) && (in_array('dt_inicio_periodo', $_SESSION['erros']) || in_array('dt_fim_periodo', $_SESSION['erros']))){
                            ?>
                            <span class="style1">* Informe o período desejado!</span>
                            <?php  
                            }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <br><input type="submit" class="botao" value="Buscar" />
                            </td>
                        </tr>
                    </table>
                </form>
            </fieldset>
                
            <br />
            <div style="height: 275px;">
            <?php if(isset($_SESSION['datas']['dt_inicio_periodo']) || isset($_SESSION['datas']['dt_fim_periodo'])){  ?>      
            
            <table class="tabela" style="width: 100%; border: solid 1px #EE7228;" >
                <tr>
                    <td colspan="2" style="background: #EE7228; color: white; padding: 5px;">
                        <?php
                            if(($_SESSION['datas']['dt_inicio_periodo'] == "") && ($_SESSION['datas']['dt_fim_periodo'] == "")){
                                $periododata = "Período total do sistema";
                            }else if(($_SESSION['datas']['dt_inicio_periodo'] != "") && ($_SESSION['datas']['dt_fim_periodo'] == "")){
                                $periododata = "Período a partir ".$_SESSION['datas']['dt_inicio_periodo'];
                            }else if(($_SESSION['datas']['dt_inicio_periodo'] == "") && ($_SESSION['datas']['dt_fim_periodo'] != "")){
                                $periododata = "Período até ".$_SESSION['datas']['dt_fim_periodo'];
                            }else{
                                $periododata = "Período de <b>".$_SESSION['datas']['dt_inicio_periodo']."</b> à <b>".$_SESSION['datas']['dt_fim_periodo']."</b>";
                            }
                                               
                            echo $periododata;
                            
                        ?>
                       
                    </td>             
                </tr>
                <tr>
                    <td style="padding: 5px; border-bottom: solid 1px #EE7228; width: 400px; border-right: solid 1px #EE7228;">
                        Número de <b style="color:black;">currículos</b> cadastrados no banco:
                    </td>
                    <td style="padding: 5px; border-bottom: solid 1px #EE7228; height: 45px;">
                        <b><?php echo $_SESSION['periodo']['totalCandidatos']; ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px; border-bottom: solid 1px #EE7228; width: 400px; border-right: solid 1px #EE7228;">
                        Número de <b style="color:black;">empresas</b> cadastradas no banco:
                    </td>
                    <td style="padding: 5px; border-bottom: solid 1px #EE7228;">
                        <div style="float: left; margin-top: 8px;">
                            <b><?php echo $_SESSION['periodo']['empresasCadastradas']; ?></b>
                        </div>
                        <?php
                            if($_SESSION['periodo']['empresasCadastradas'] != 0){
                        ?>
                                <div style="float: right; margin-left: 5px;">
                                    <form name="imprimirEmpresaDetalhada" method="post" action="printEmpresaDetalhada.php" style="margin-bottom: 2px;">
                                        <input type="submit" name="relatorioDetalhadoEmpresa" id="relatorioDetalhadoEmpresa" value="Relatório Detalhado" class="botao">
                                    </form>
                                </div>
                                <div style="float: right;">
                                    <form name="imprimirEmpresaListaPeriodo" method="post" action="printEmpresaListaPeriodo.php" style="margin-bottom: 2px;">
                                        <input type="submit" name="relatorioEmpresaListaPeriodo" id="relatorioDetalhadoEmpresa" value="Listar Empresas" class="botao">
                                    </form>
                                </div>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px; border-bottom: solid 1px #EE7228; width: 400px; border-right: solid 1px #EE7228;">
                        Número de <b style="color:black;">empregos efetivados</b> no banco:
                    </td>
                    <td style="padding: 5px; border-bottom: solid 1px #EE7228; height: 45px;">
                        <b><?php echo $_SESSION['periodo']['contratados']; ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px; border-bottom: solid 1px #EE7228; width: 400px; border-right: solid 1px #EE7228;">
                        Número de <b style="color:black;">vagas ofertadas</b> no banco:
                    </td>
                    <td style="padding: 5px; border-bottom: solid 1px #EE7228;">
                        <div style="float: left; margin-top: 8px;">
                            <b><?php echo $_SESSION['periodo']['totalVagas']; ?></b>
                        </div>
                        <?php
                            if($_SESSION['periodo']['totalVagas'] != 0){                            
                        ?>
                                <div style="float: right;">
                                    <form name="imprimirVagaDetalhada" method="post" action="printVagaDetalhada.php" style="margin-bottom: 2px;">
                                        <input type="submit" name="relatorioDetalhadoVaga" id="relatorioDetalhadoVaga" value="Relatório Detalhado" class="botao">
                                    </form>
                                </div>
                        <?php                        
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px; border-right: solid 1px #EE7228; width: 400px;">
                        Número de <b style="color:black;">encaminhamentos</b> para entrevista através do banco:
                    </td>
                    <td style="padding: 5px; height: 45px;">
                        <div style="float: left; margin-top: 8px;">
                            <b><?php echo $_SESSION['periodo']['numEncaminhamentos']; ?></b>
                        </div>
                        <?php
                            if($_SESSION['periodo']['numEncaminhamentosDeficientes'] != 0){
                        ?>                                
                                <div style="float: right;">
                                    <form name="imprimirRelatorioDeficienets" method="post" action="printRelatorioDeficientes.php" style="margin-bottom: 2px;">
                                        <input type="submit" name="relatorioDeficientes" id="relatorioDeficientes" value="<?php echo $_SESSION['periodo']['numEncaminhamentosDeficientes']; ?> Enc. para PCD(s)" class="botao">
                                    </form>
                                </div>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript" src="js/modal.js"></script>

<?php
}else{
    echo "SEM ACESSO";
}

require_once 'footer.php';

unset($_SESSION['erros']);
unset($_SESSION['post']);
unset($_SESSION['log']);
unset($_SESSION['errosE']);
unset($_SESSION['msgE']);
//include_once 'footer.php';
//unset($_SESSION['admissoes']);
?>