<?php
//if($_SERVER["REMOTE_ADDR"] != "189.38.85.36"){
//    die("Acesso nao Autorizado");
//}

include_once './conecta.php';
include_once './Email.class.php';

            
$assunto = 'Banco de Oportunidade - Relatório Diário';
$nome = 'Usuário(a)';
$email = 'douglas.carlos@canoastec.rs.gov.br';



$mes = date('m');


$corpo = "
    <script type='text/javascript' src='http://canoastec.rs.gov.br/bancodeoportunidades/interno/js/jquery-1.6.2.js'></script>
    <script src='http://canoastec.rs.gov.br/Utilidades/js/highcharts.js'></script>
    <table id='container_geral' style='min-width:900px; height:400px; margin: 0 auto' align='center'>
    <!-- ESTATÍSTICAS GRÁFICAS -->
    <tr>
        <td>
            <script>
                //Cria um array de meses
                meses = new Array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
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
                            data: [100]//Mostra o valor no gráfico
                        }, {
                            //TOTAL DE VAGAS
                            name: 'Vagas', //Label
                            data: [150]//Mostra o valor no gráfico
                        }, {
                            //TOTAL DE CANDIDATOS
                            name: 'Currículos', //Label
                            data: [500]//Mostra o valor no gráfico
                        }, { 
                            //CANDIDATOS ENCAMINHADOS
                            name: 'Candidatos Encaminhados', //Label
                            data: [400]//Mostra o valor no gráfico
                        }, {
                            //CANDIDATOS DISPENSADOS
                            name: 'Candidatos Dispensados', //Label
                            data: [100]//Mostra o valor no gráfico
                        }, {
                            //EMPRESAS LIBERADAS
                            name: 'Empresas Liberadas', //Label
                            data: [5]//Mostra o valor no gráfico
                        }, {
                            //EMPRESAS NÃO LIBERADAS
                            name: 'Empresas Não Liberadas', //Label
                            data: [3]//Mostra o valor no gráfico 
                        }, {
                            //TOTAL DE CURRÍCULOS
                            name: 'Candidatos', //Label
                            data: [600]//Mostra o valor no gráfico 
                        }]
                    });
                });
            </script>
        </td>
    </tr>
</table>";


Email::enviarEmail($email, $assunto, $corpo, $nome);
?>
