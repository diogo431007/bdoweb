<?php
//if($_SERVER["REMOTE_ADDR"] != "189.38.85.36"){
//    die("Acesso nao Autorizado");
//}

include_once './conecta.php';
include_once './Email.class.php';

            
$assunto = 'Banco de Oportunidade - Relat�rio Di�rio';
$nome = 'Usu�rio(a)';
$email = 'douglas.carlos@canoastec.rs.gov.br';



$mes = date('m');


$corpo = "
    <script type='text/javascript' src='http://canoastec.rs.gov.br/bancodeoportunidades/interno/js/jquery-1.6.2.js'></script>
    <script src='http://canoastec.rs.gov.br/Utilidades/js/highcharts.js'></script>
    <table id='container_geral' style='min-width:900px; height:400px; margin: 0 auto' align='center'>
    <!-- ESTAT�STICAS GR�FICAS -->
    <tr>
        <td>
            <script>
                //Cria um array de meses
                meses = new Array('Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
                //Pega o m�s e ano atual para montar o gr�fico
                hoje = new Date();
                mes = hoje.getMonth();
                ano = hoje.getFullYear();

                $(function () {
                    //Seta a cor dos gr�ficos
                    Highcharts.setOptions({
                        colors: ['#A0BF5F', '#C45653', '#5587C1', '#866AA7', '#EE7228', '#015754', '#B00067', '#F96E74'] //Cor dos gr�ficos, definido pela ordem dos dados
                    });
                    $('#container_geral').highcharts({
                        chart: {
                            type: 'column' //Tipo do Gr�fico: bar, line, column, spline, area, areaspline, pie, scatter
                            //marginLeft: 300 //Margin do gr�fico para a esquerda
                        },
                        title: {
                            text: 'Dados Gerais', //T�tulo do Gr�fico
                            //x: 140 //Posi��o X do titulo
                            style: {
                                color: '#EE7228'
                                //fontWeight: 'bold'
                            }
                        },
                        subtitle: {
                            text: 'Situa��o Atual' //Subt�tulo do Gr�fico
                            //x: 140 //Posi��o X do subtitulo
                        },
                        legend: {
                            align: 'left', //Onde a legenda vai ser alinhada
                            verticalAlign: 'top', //Onde a legenda vai ser alinhada na vertical
                            x: 0, //Posi��o X da legenda
                            y: 100, //Posi��o Y da legenda
                            //borderWidth: 2, //Largura da borda da legenda
                            layout: 'vertical', //Estilo da legenda: Vertical | Horizontal
                            //itemWidth: 400 //Espa�amento dos itens dentro da legenda
                            itemStyle: {
                                fontFamily: 'nexa_boldregular',
                                fontSize: '14px'
                            }
                        },
                        xAxis: {
                            categories: [meses[mes] + '/' + ano] //Categoria do gr�fico - m�s/ano
                        },
                        yAxis: {
                            title: {
                                text: '' //Texto abaixo do gr�fico
                            },
                            labels: {
                                formatter: function() {
                                    return this.value.toFixed(0); //Formata o label para n�mero inteiro (0) = 0 | (1) = 0.0 e assim adiante
                                }
                            }
                        },
                        series: [{
                            //TOTAL DE CONTRATA��ES
                            name: 'Contrata��es', //Label
                            data: [100]//Mostra o valor no gr�fico
                        }, {
                            //TOTAL DE VAGAS
                            name: 'Vagas', //Label
                            data: [150]//Mostra o valor no gr�fico
                        }, {
                            //TOTAL DE CANDIDATOS
                            name: 'Curr�culos', //Label
                            data: [500]//Mostra o valor no gr�fico
                        }, { 
                            //CANDIDATOS ENCAMINHADOS
                            name: 'Candidatos Encaminhados', //Label
                            data: [400]//Mostra o valor no gr�fico
                        }, {
                            //CANDIDATOS DISPENSADOS
                            name: 'Candidatos Dispensados', //Label
                            data: [100]//Mostra o valor no gr�fico
                        }, {
                            //EMPRESAS LIBERADAS
                            name: 'Empresas Liberadas', //Label
                            data: [5]//Mostra o valor no gr�fico
                        }, {
                            //EMPRESAS N�O LIBERADAS
                            name: 'Empresas N�o Liberadas', //Label
                            data: [3]//Mostra o valor no gr�fico 
                        }, {
                            //TOTAL DE CURR�CULOS
                            name: 'Candidatos', //Label
                            data: [600]//Mostra o valor no gr�fico 
                        }]
                    });
                });
            </script>
        </td>
    </tr>
</table>";


Email::enviarEmail($email, $assunto, $corpo, $nome);
?>
