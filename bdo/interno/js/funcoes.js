
$(function () {
    $('#dt_inicio').datepicker({changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy'});
    $('#dt_fim').datepicker({changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy'});
});

$(function () {
    $('#dt_inicio_admissao').datepicker({changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy'});
    $('#dt_fim_admissao').datepicker({changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy'});
});


$(function () {
    $('#dt_inicio_periodo').datepicker({changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy'});
    $('#dt_fim_periodo').datepicker({changeMonth: true, changeYear: true, dateFormat: 'dd/mm/yy'});
});


/*##############################################################################
 *         LOGIN DO SISTEMA
 *##############################################################################*/
$(function ($) {

    // Quando o formul·rio for enviado, essa funÁ„o È chamada

    $("#sisLog").submit(function () {

        // Colocamos os valores de cada campo em uma v·riavel para facilitar a manipulaÁ„o
        var user = $("#user_log").val();
        var pass = $("#pass_log").val();

        // Exibe mensagem de carregamento
        // Fazemos a requis„o ajax com o arquivo envia.php e enviamos os valores de cada campo atravÈs do mÈtodo POST
        $.post('enviaLogin.php', {user: user, pass: pass}, function (resposta) {
            // Quando terminada a requisiÁ„o
            // Exibe a div status
            // Se a resposta È um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#log_error").html(resposta);
                $("#log_error").slideDown();
            }
        });
    });

});

/*##############################################################################
 *         CADASTRO DE USU¡RIOS
 *##############################################################################*/

$(function ($) {
    // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada
    $("#cadastroUsuario").submit(function () {
        // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o
        var nome = $("#nome_user").val();
        var email = $("#email_user").val();
        var login = $("#login_user").val();
        var senha = $("#senha_user").val();
        var secretaria = $("#secretaria_user").val();
        var perfil = $("#perfil_user").val();
        // Exibe mensagem de carregamento
        $("#user_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
        $.post('enviaUsuario.php', {nome: nome, email: email, login: login, senha: senha, perfil: perfil, secretaria: secretaria}, function (resposta) {
            // Quando terminada a requisi√ß√£o
            // Exibe a div status
            $("#user_load").slideDown();
            // Se a resposta √© um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#user_load").hide('tohide');
                $("#user_ok").hide('tohide');
                $("#user_error").html(resposta);
                $("#user_error").slideDown();

            }
            // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
            else {

                // Exibe mensagem de sucesso
                $("#user_load").hide('tohide');
                $("#user_error").hide('tohide');
                $("#user_ok").html("Cadastro efetuado com sucesso!");
                $("#user_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos
                $("#nome_user").val("");
                $("#email_user").val("");
                $("#login_user").val("");
                $("#senha_user").val("");
                $("#secretaria_user").val("");
                $("#perfil_user").val("");
                $("#dta_user").val("");
            }
        });
    });
});

/*##############################################################################
 *         ALTERA«√O DE USU¡RIOS
 *##############################################################################*/

$(function ($) {
    // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada
    $("#editaUsuario").submit(function () {
        // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o
        var id = $("#id_user").val();
        var nome = $("#nome_user").val();
        var email = $("#email_user").val();
        var perfil = $("#perfil_user").val();
        var secretaria = $("#secretaria_user").val();
        var controle_flag = $("#controle_user").is(":checked");

        if (controle_flag) {
            var controle = 'S';
        } else {
            var controle = 'N';
        }

        // Exibe mensagem de carregamento
        $("#user_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
        $.post('enviaEditaUsuario.php', {id: id, nome: nome, email: email, perfil: perfil, controle: controle, secretaria: secretaria}, function (resposta) {
            // Quando terminada a requisi√ß√£o
            // Exibe a div status
            $("#user_load").slideDown();
            // Se a resposta √© um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#user_load").hide('tohide');
                $("#user_ok").hide('tohide');
                $("#user_error").html(resposta);
                $("#user_error").slideDown();

            }
            // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
            else {

                // Exibe mensagem de sucesso
                $("#user_load").hide('tohide');
                $("#user_error").hide('tohide');
                $("#user_ok").html("Usu·rio alterado com sucesso!");
                $("#user_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos

            }
        });
    });
});

/*##############################################################################
 *         ALTERA«√O DE PROFISS’ES
 *##############################################################################*/

$(function ($) {
    // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada

    $("#editaProfissao").submit(function () {
        // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o
        var id = $("#id_profissao").val();
        var profissao = $("#profissao").val();
        var status_s = $("#ao_ativo_s").is(":checked");
        var status_n = $("#ao_ativo_n").is(":checked");
        var status_v = $("#ao_ativo_v").is(":checked");
        var status = '';
        var descricao = $("#ds_profissao").val();

        if (status_s)
            status = 'S';
        else if (status_n)
            status = 'N';
        else if (status_v)
            status = 'V';

        var flag_s = $("#flag_s").is(":checked");
        var flag_n = $("#flag_n").is(":checked");
        var ajuste = 'N';
        if (flag_s)
            ajuste = $("#prof_encaminha").val();

        // Exibe mensagem de carregamento
        $("#user_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
        $.post('enviaEditaProfissao.php', {id: id, profissao: profissao, status: status, descricao: descricao, ajuste: ajuste}, function (resposta) {
            // Quando terminada a requisi√ß√£o
            // Exibe a div status
            $("#user_load").slideDown();
            // Se a resposta √© um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#user_load").hide('tohide');
                $("#user_ok").hide('tohide');
                $("#user_error").html(resposta);
                $("#user_error").slideDown();

            }
            // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
            else {

                // Exibe mensagem de sucesso
                $("#user_load").hide('tohide');
                $("#user_error").hide('tohide');
                $("#user_ok").html("Profiss„o alterada com sucesso!");
                $("#user_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos

            }
        });
    });
});

/*##############################################################################
 *         ALTERA«√O DE Secretaria
 *##############################################################################*/

$(function ($) {
    // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada

    $("#editaSecretaria").submit(function () {
        // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o
        var id = $("#id_secretaria").val();
        var Secretaria = $("#secretaria").val();

        // Exibe mensagem de carregamento
        $("#sec_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
        $.post('enviaEditaSecretaria.php', {id: id, secretaria: Secretaria}, function (resposta) {
            // Quando terminada a requisi√ß√£o
            // Exibe a div status
            $("#sec_load").slideDown();
            // Se a resposta √© um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#sec_load").hide('tohide');
                $("#sec_ok").hide('tohide');
                $("#sec_error").html(resposta);
                $("#sec_error").slideDown();

            }
            // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
            else {

                // Exibe mensagem de sucesso
                $("#sec_load").hide('tohide');
                $("#sec_error").hide('tohide');
                $("#sec_ok").html("Secretaria alterada com sucesso!");
                $("#sec_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos

            }
        });
    });
});

/*##############################################################################
 *         CADASTRO DE SECRETARIA
 *##############################################################################*/

$(function ($) {
    // Quando o formul·rio for enviado, essa funÁ„o È chamada
    $("#cadastroSecretaria").submit(function () {
        // Colocamos os valores de cada campo em uma v·riavel para facilitar a manipulaÁ„o
        var secretaria = $("#secretaria").val();

        // Exibe mensagem de carregamento
        $("#sec_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis„o ajax com o arquivo envia.php e enviamos os valores de cada campo atravÈs do mÈtodo POST
        $.post('enviaSecretaria.php', {secretaria: secretaria}, function (resposta) {
            // Quando terminada a requisiÁ„o
            // Exibe a div status
            $("#sec_load").slideDown();
            // Se a resposta È um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#sec_load").hide('tohide');
                $("#sec_ok").hide('tohide');
                $("#sec_error").html(resposta);
                $("#sec_error").slideDown();
            }
            // Se resposta for false, ou seja, n„o ocorreu nenhum erro
            else {
                // Exibe mensagem de sucesso
                $("#sec_load").hide('tohide');
                $("#sec_error").hide('tohide');
                $("#sec_ok").html("Secretaria salva com sucesso!");
                $("#sec_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos
                $("#secrataria").val("");

            }
        });
    });
});

/*##############################################################################
 *         CADASTRO DE DEFICI NCIA
 *##############################################################################*/

$(function ($) {
    // Quando o formul·rio for enviado, essa funÁ„o È chamada
    $("#cadastroDeficiencia").submit(function () {
        // Colocamos os valores de cada campo em uma v·riavel para facilitar a manipulaÁ„o
        var deficiencia = $("#deficiencia").val();

        // Exibe mensagem de carregamento
        $("#def_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis„o ajax com o arquivo envia.php e enviamos os valores de cada campo atravÈs do mÈtodo POST
        $.post('enviaDeficiencia.php', {deficiencia: deficiencia}, function (resposta) {
            // Quando terminada a requisiÁ„o
            // Exibe a div status
            $("#def_load").slideDown();
            // Se a resposta È um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#def_load").hide('tohide');
                $("#def_ok").hide('tohide');
                $("#def_error").html(resposta);
                $("#def_error").slideDown();
            }
            // Se resposta for false, ou seja, n„o ocorreu nenhum erro
            else {
                // Exibe mensagem de sucesso
                $("#def_load").hide('tohide');
                $("#def_error").hide('tohide');
                $("#def_ok").html("DeficiÍncia salva com sucesso!");
                $("#def_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos
                $("#deficiencia").val("");

            }
        });
    });
});


/*##############################################################################
 *         ALTERA«√O DE DEFICI NCIAS
 *##############################################################################*/

$(function ($) {
    // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada

    $("#editaDeficiencia").submit(function () {
        // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o
        var id = $("#id_deficiencia").val();
        var deficiencia = $("#deficiencia").val();

        // Exibe mensagem de carregamento
        $("#user_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
        $.post('enviaEditaDeficiencia.php', {id: id, deficiencia: deficiencia}, function (resposta) {
            // Quando terminada a requisi√ß√£o
            // Exibe a div status
            $("#user_load").slideDown();
            // Se a resposta √© um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#user_load").hide('tohide');
                $("#user_ok").hide('tohide');
                $("#user_error").html(resposta);
                $("#user_error").slideDown();

            }
            // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
            else {

                // Exibe mensagem de sucesso
                $("#user_load").hide('tohide');
                $("#user_error").hide('tohide');
                $("#user_ok").html("DeficiÍncia alterada com sucesso!");
                $("#user_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos

            }
        });
    });
});

/*##############################################################################
 *         CADASTRO DE PERFIL
 *##############################################################################*/
$(function ($) {

    // Quando o formul·rio for enviado, essa funÁ„o È chamada

    $("#cadastroPerfil").submit(function () {

        // Colocamos os valores de cada campo em uma v·riavel para facilitar a manipulaÁ„o
        var perfil = $("#perfil").val();
        var pagSelecionados = new Array();

        // Exibe mensagem de carregamento
        // Fazemos a requis„o ajax com o arquivo envia.php e enviamos os valores de cada campo atravÈs do mÈtodo POST
        $.post('enviaPerfil.php', {perfil: perfil, 'data[]': pagSelecionados}, function (resposta) {

            // Quando terminada a requisiÁ„o
            // Exibe a div status
            $("#perf_load").slideDown();
            // Se a resposta È um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#perf_load").hide('tohide');
                $("#perf_ok").hide('tohide');
                $("#perf_error").html(resposta);
                $("#perf_error").slideDown();
            }
            // Se resposta for false, ou seja, n„o ocorreu nenhum erro
            else {
                // Exibe mensagem de sucesso
                $("#perf_load").hide('tohide');
                $("#perf_error").hide('tohide');
                $("#perf_ok").html("Perfil salvo com sucesso!");
                $("#perf_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos
                $("#perfil").val("");

            }

        });
    });
});

/*##############################################################################
 *         ALTERA«√O DE PERFIL
 *##############################################################################*/

$(function ($) {
    // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada

    $("#editaPerfil").submit(function () {
        // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o
        var id = $("#id_perfil").val();
        var descricao = $("#descricao").val();
        var controle = $("#controle").val();

        // Exibe mensagem de carregamento
        $("#perf_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
        $.post('enviaEditaPerfil.php', {id: id, descricao: descricao}, function (resposta) {
            // Quando terminada a requisi√ß√£o
            // Exibe a div status
            $("#perf_load").slideDown();
            // Se a resposta √© um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#perf_load").hide('tohide');
                $("#perf_ok").hide('tohide');
                $("#perf_error").html(resposta);
                $("#perf_error").slideDown();

            }
            // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
            else {

                // Exibe mensagem de sucesso
                $("#perf_load").hide('tohide');
                $("#perf_error").hide('tohide');
                $("#perf_ok").html("Profiss„o alterada com sucesso!");
                $("#perf_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos

            }
        });
    });
});



/*##############################################################################
 *         CADASTRO DE PROFISS√O
 *##############################################################################*/

$(function ($) {
    // Quando o formul·rio for enviado, essa funÁ„o È chamada
    $("#cadastroProfissao").submit(function () {
        // Colocamos os valores de cada campo em uma v·riavel para facilitar a manipulaÁ„o
        var profissao = $("#profissao").val();
        var descricao = $("#ds_profissao").val();

        // Exibe mensagem de carregamento
        $("#prof_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis„o ajax com o arquivo envia.php e enviamos os valores de cada campo atravÈs do mÈtodo POST
        $.post('enviaProfissao.php', {profissao: profissao, descricao: descricao}, function (resposta) {
            // Quando terminada a requisiÁ„o
            // Exibe a div status
            $("#prof_load").slideDown();
            // Se a resposta È um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#prof_load").hide('tohide');
                $("#prof_ok").hide('tohide');
                $("#prof_error").html(resposta);
                $("#prof_error").slideDown();
            }
            // Se resposta for false, ou seja, n„o ocorreu nenhum erro
            else {
                // Exibe mensagem de sucesso
                $("#prof_load").hide('tohide');
                $("#prof_error").hide('tohide');
                $("#prof_ok").html("Profiss„o salva com sucesso!");
                $("#prof_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos
                $("#profissao").val("");
                $("#ds_profissao").val("");

            }
        });
    });
});


/*##############################################################################
 *         MARCARDOR CADASTRO - MARCA TODOS
 *##############################################################################*/

function marcardesmarcar() {
    if ($("#todos").attr("checked")) {
        $('.marcar').each(
                function () {
                    $(this).attr("checked", true);
                }
        );
    } else {
        $('.marcar').each(
                function () {
                    $(this).attr("checked", false);
                }
        );
    }
}

function marcarDinamico(idTodos, classFilho) {

    if ($("#" + idTodos).attr("checked")) {
        $('.' + classFilho).each(
                function () {
                    $(this).attr("checked", true);
                }
        );
    } else {
        $('.' + classFilho).each(
                function () {
                    $(this).attr("checked", false);
                }
        );
    }
}

function marcarTodosProfissao() {
    if ($("#tdProf").attr("checked")) {
        $('.mProf').each(
                function () {
                    $(this).attr("checked", true);
                }
        );
        $('.oProf').each(
                function () {
                    $(this).attr("checked", true);
                }
        );
        mostrarOutro();
    } else {
        $('.mProf').each(
                function () {
                    $(this).attr("checked", false);
                }
        );
        $('.oProf').each(
                function () {
                    $(this).attr("checked", false);
                }
        );
        ocultarOutro();
    }
}

/*******************************************************/
function desmarcar() {
    if ($(".oProf").attr("checked")) {
        mostrarOutro();
    } else {
        ocultarOutro();
    }
}

function ocultarOutro() {
    $('#ds_outro').hide();
    $('#ds_outro').val('');
}

function ocultarSelectProfissao() {
    $('#span_prof').hide();
    $('#prof_encaminha').val('');
    $('#tr_descricao').show();
    $('#tr_status').show();
}

function mostrarOutro() {
    $('#ds_outro').show();
    $('#ds_outro').focus();
}

function mostrarSelectProfissao() {
    $('#tr_descricao').hide();
    $('#tr_status').hide();
    $('#span_prof').show();
    $('#prof_encaminha').focus();
}

/*##############################################################################
 *         MARCARDOR PESQUISA - MARCA TODOS
 *##############################################################################*/

function marcardesmarcar2() {
    if ($("#todos2").attr("checked")) {
        $('.marcar2').each(
                function () {
                    $(this).attr("checked", true);
                }
        );
    } else {
        $('.marcar2').each(
                function () {
                    $(this).attr("checked", false);
                }
        );
    }
}

/*##############################################################################
 *         VALIDA«√O DE CPF
 *##############################################################################*/
function validarCPF(campo) {

    cpf = campo.replace(/\./g, '').replace(/\-/g, '').replace(/\_/g, '');

    erro = new String;
    if (cpf.length != 0) { //se o campo cpf for diferente de 0 passa para o prÛximo if.
        if (cpf.length < 11) { //se quantidade de n˙meros for menor que 11 da o erro.
            erro += "Sao necessarios 11 digitos para verificacao do CPF! \n\n";
            document.getElementById("cpf_cand").focus();
            document.getElementById("cpf_cand").select();
//
//                document.getElementById("nr_cpf").focus();
//                document.getElementById("nr_cpf").select();
        }
    }

    var nonNumbers = /\D/;
    if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999") {
        erro += "Numero de CPF inv·lido!"
        document.getElementById("cpf_cand").focus();
        document.getElementById("cpf_cand").select();

//            document.getElementById("nr_cpf").focus();
//            document.getElementById("nr_cpf").select();
    }
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i++) {
        a[i] = cpf.charAt(i);
        if (i < 9)
            b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) {
        a[9] = 0
    } else {
        a[9] = 11 - x
    }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y++)
        b += (a[y] * c--);
    if ((x = b % 11) < 2) {
        a[10] = 0;
    } else {
        a[10] = 11 - x;
    }
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])) {
        erro += "CPF Inv·lido!";
        document.getElementById("cpf_cand").focus();
        document.getElementById("cpf_cand").select();

//          document.getElementById("nr_cpf").focus();
//          document.getElementById("nr_cpf").select();

    }
    if (erro.length > 0) {
        alert(erro);
        return true;
    }
    return false;
}



function verificarCPF(c) {
    var i;
    s = c;
    var c = s.substr(0, 9);
    var dv = s.substr(9, 2);
    var d1 = 0;
    var v = false;

    for (i = 0; i < 9; i++) {
        d1 += c.charAt(i) * (10 - i);
    }
    if (d1 == 0) {
        alert("CPF Inv·lido")
        v = true;
        return false;
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(0) != d1) {
        alert("CPF Inv·lido")
        v = true;
        return false;
    }

    d1 *= 2;
    for (i = 0; i < 9; i++) {
        d1 += c.charAt(i) * (11 - i);
    }
    d1 = 11 - (d1 % 11);
    if (d1 > 9)
        d1 = 0;
    if (dv.charAt(1) != d1) {
        alert("CPF Inv·lido")
        v = true;
        return false;
    }
}

//mascara cpf
//$(function($) {
//    $(document).ready(function(){
//            $("#nr_cpf").mask("999.999.999-99");
//    });
//});
$(function ($) {
    $(document).ready(function () {
        $("#cpf_cand").mask("999.999.999-99");
    });
});
//mascara telefone da empresa
$(function ($) {
    $(document).ready(function () {
        $("#nr_telefoneempresa").mask("(99) 9999-9999");
    });
});
//m·scara cnpj
$(function ($) {
    $(document).ready(function () {
        $("#nr_cnpj").mask("99.999.999/9999-99");
    });
});

//mascara telefone
$(function ($) {
    $(document).ready(function () {
        $("#tel_cand").mask("(99) 9999-9999");
    });
});
// m·scara cep
$(function ($) {
    $(document).ready(function () {
        $("#nr_cep").mask("99999-999");
    });
});

$(function ($) {
    $(document).ready(function () {
        $("#nr_cepcand").mask("99999-999");
    });
});
//mascara celular
$(function ($) {
    $(document).ready(function () {
        $("#cel_cand").mask("(99) 99999-9999");

    });
});
//m·scara dt_fundacao
$(function ($) {
    $(document).ready(function () {
        $("#dt_fundacao").mask("99/99/9999");
    });
});

$(function ($) {
    $(document).ready(function () {
        $("#dt_admissao").mask("99/99/9999");
    });
});
//m·scara dt_nascimento
//$(function($) {
//    $(document).ready(function(){
//            $("#dt_nascimento").mask("99/99/9999");
//    });
//});
//mascara telefone celular
/*
 $(function($) {
 $(document).ready(function(){
 $("#nr_celular").mask("(99) 99999-9999");
 });
 });
 */
//m·scara das inscriÁıes estaduais de todos os estados
$(function ($) {
    $('#estadoEmp').change(function () {
        var uf = $('#estadoEmp').val();

        if (uf === '1') {
            $("#nr_inscricaoestadual").mask("99.999.999/999-99");
        } else if (uf === '2') {
            $("#nr_inscricaoestadual").mask("999999999");
        } else if (uf === '3') {
            $("#nr_inscricaoestadual").mask("99.999.999-9");
        } else if (uf === '4') {
            $("#nr_inscricaoestadual").mask("999999999");
        } else if (uf === '5') {
            $("#nr_inscricaoestadual").mask("999.999.99-9");
        } else if (uf === '6') {
            $("#nr_inscricaoestadual").mask("99999999-9");
        } else if (uf === '7') {
            $("#nr_inscricaoestadual").mask("99999999999-99");
        } else if (uf === '8') {
            $("#nr_inscricaoestadual").mask("999.999.99-9");
        } else if (uf === '9') {
            $("#nr_inscricaoestadual").mask("99.999.999-9");
        } else if (uf === '10') {
            $("#nr_inscricaoestadual").mask("999999999");
        } else if (uf === '11') {
            $("#nr_inscricaoestadual").mask("999.999.999/9999");
        } else if (uf === '12') {
            $("#nr_inscricaoestadual").mask("999999999");
        } else if (uf === '13') {
            $("#nr_inscricaoestadual").mask("999999999");
        } else if (uf === '14') {
            $("#nr_inscricaoestadual").mask("99-999999-9");
        } else if (uf === '15') {
            $("#nr_inscricaoestadual").mask("99999999-9");
        } else if (uf === '16') {
            $("#nr_inscricaoestadual").mask("99.9.999.9999999-9");
        } else if (uf === '17') {
            $("#nr_inscricaoestadual").mask("999999999");
        } else if (uf === '18') {
            $("#nr_inscricaoestadual").mask("99999999-99");
        } else if (uf === '19') {
            $("#nr_inscricaoestadual").mask("99.999.99-9");
        } else if (uf === '20') {
            $("#nr_inscricaoestadual").mask("99.999.999-9");
        } else if (uf === '21') {
            $("#nr_inscricaoestadual").mask("999.99999-9");
        } else if (uf === '22') {
            $("#nr_inscricaoestadual").mask("99999999-9");
        } else if (uf === '23') {
            $("#nr_inscricaoestadual").mask("999-9999999");
        } else if (uf === '24') {
            $("#nr_inscricaoestadual").mask("999.999.999");
        } else if (uf === '25') {
            $("#nr_inscricaoestadual").mask("999999999-9");
        } else if (uf === '26') {
            $("#nr_inscricaoestadual").mask("999.999.999.999");
        } else {
            $("#nr_inscricaoestadual").mask("99999999999");
        }

    });
});


function valida_data(val) {
    if (val == "")
        return false;
    var data = val.split("/");
    if (data.length != 3)
        return false;
    var dia = data[0];
    var mes = data[1];
    var ano = data[2];
    if ((ano <= 0) || (mes > 12 || mes == 0) || (dia > 31 || dia == 0)) {
        alert('Data Inv·lida');
    } else if (((ano % 4) == 0) && (mes == 2) && (dia > 29)) {
        alert('Data Inv·lida');
    } else if (((ano % 4) > 0) && (mes == 2) && (dia > 28)) {
        alert('Data Inv·lida');
    } else if (((mes == 4) || (mes == 6) || (mes == 9) || (mes == 11)) && (dia == 31)) {
        alert('Data Inv·lida');
    } else {
        return true;
    }
}

/*##############################################################################
 *         VALIDA«√O PARA PERMITIR APENAS N⁄MERO NO CAMPO
 *##############################################################################*/

/**
 * Permite n˙meros + ponto + virgula
 *
 * CÛdigos ASCII
 * 48 a 57 - numeros de 0 a 9
 * 44 - virgula
 * 46 - delete e ponto
 * 8 - backspace
 * 9 - tab
 *
 * Exemplo:
 * onkeypress="return valida_numero(event);"
 *
 * @return boolean
 */
function valida_numero(e) {
    if (!e)
        e = window.event;
    var tecla;
    if (e.keyCode)
        tecla = e.keyCode;
    else if (e.which)
        tecla = e.which; //Netscape 4.?
    if ((tecla > 47 && tecla < 58) || tecla == 8 || tecla == 9)
        return true;
    else
        return false;
}


//valida telefone
//function ValidaTel(tel){
//	exp = /\(\d{2}\)\ \d{4}\-\d{4}/
//	if(!exp.test(tel.value))
//		alert('Numero de Telefone Inv·lido!');
//}
//
//function MascaraTel(tel){
//	if(mascaraInteiro(tel)==false){
//		event.returnValue = false;
//	}
//	return formataTel(tel, '(00) 0000-0000', event);
//}

/*##############################################################################
 *         M¡SCARA PARA O CAMPO DATA
 *##############################################################################*/
/**
 * Formata campo data (dd/mm/yyyy)
 *
 * Exemplo:
 * onkeydown="formata_data(this,event)"
 *
 * @return void
 */
function formata_data(campo, e) {

    if (!e)
        e = window.event;
    if (e.keyCode)
        tecla = e.keyCode;
    else if (e.which)
        tecla = e.which; //Netscape 4.?
    if (e.target)
        objEv = e.target; //Firefox
    else if (e.srcElement)
        objEv = e.srcElement; //IE
    vr = objEv.value;
//    vr = vr.replace(".","");
    vr = vr.replace("/", "");
    vr = vr.replace("/", "");
    tam = vr.length + 1;
    if (tecla != 9 && tecla != 8) {
        if (tam > 2 && tam < 5)
            objEv.value = vr.substr(0, tam - 2) + '/' + vr.substr(tam - 2, tam);
        if (tam >= 5 && tam <= 10)
            objEv.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 3);
    }
}

function formata_telefone(campo, e) {

    if (!e)
        e = window.event;
    if (e.keyCode)
        tecla = e.keyCode;
    else if (e.which)
        tecla = e.which; //Netscape 4.?
    if (e.target)
        objEv = e.target; //Firefox
    else if (e.srcElement)
        objEv = e.srcElement; //IE
    vr = objEv.value;
    vr = vr.replace(/D/g, ""); //Remove tudo o que n„o È dÌgito
    vr = vr.replace(/^(d{2})(d)/g, "($1) $2"); //Coloca parÍnteses em volta dos dois primeiros dÌgitos
    vr = vr.replace(/(d)(d{5})$/, "$1-$2"); //Coloca hÌfen entre o quarto e o quinto dÌgitos
    tam = vr.length + 1;
    if (objEv.value.length == 0)
        objEv.value = '(' + objEv.value;

    if (objEv.value.length == 3)
        objEv.value = objEv.value + ')';

    if (objEv.value.length == 10)
        objEv.value = objEv.value + '-';
}

function formata_cpf(Campo, teclapres) {
    var tecla = teclapres.keyCode;

    var vr = new String(Campo.value);
    vr = vr.replace(".", "");
    vr = vr.replace(".", "");
    vr = vr.replace("-", "");

    tam = vr.length + 1;

    if (tecla != 9 && tecla != 8) {
        if (tam > 3 && tam < 7)
            Campo.value = vr.substr(0, 3) + '.' + vr.substr(3, tam);
        if (tam >= 7 && tam < 10)
            Campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(6, tam - 6);
        if (tam >= 10 && tam < 12)
            Campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(6, 3) + '-' + vr.substr(9, tam - 9);
    }
}

function Mascara(objeto) {
    if (objeto.value.length == 0)
        objeto.value = '(' + objeto.value;

    if (objeto.value.length == 3)
        objeto.value = objeto.value + ')';

    if (objeto.value.length == 8)
        objeto.value = objeto.value + '-';
}


function MascaraCpf(objeto) {

    if (objeto.value.length == 3)
        objeto.value = objeto.value + '.';
    if (objeto.value.length == 7)
        objeto.value = objeto.value + '.';
    if (objeto.value.length == 11)
        objeto.value = objeto.value + '-';

}

/*##############################################################################
 *         BUSCAR CIDADE PELA CHANGE DO ESTADO
 *##############################################################################*/
$(function ($) {
    $('#estado_cand').change(function () {
        var uf = $('#estado_cand').val();
        $.post("trazerCidades.php", {id_estado: uf}, function (retorno) {

            var options = '<option value="">Selecione</option>';

            if (retorno != false) {
                options += retorno;
                $('#cidade_cand').html(options).show();
            }

        });

    });
});


$(function ($) {
    $('#estadoEmp').change(function () {

        var uf = $('#estadoEmp').val();

        $.post("trazerCidades.php", {id_estado: uf}, function (retorno) {
            //alert(retorno);
            var options = '<option value="">Selecione</option>';
            if (retorno != false) {
                options += retorno;
                $('#cidadeEmp').html(options).show();
            } else {
                //alert('caiu aqui');
            }
        });
    });
});

/*##############################################################################
 *         BUSCAR MICROREGI√O PELA CHANGE DO QUADRANTE
 *##############################################################################*/
$(function ($) {
    $('#quadranteEmp').change(function () {

        var quadrante = $('#quadranteEmp').val();

        $.post("trazerMicroregioes.php", {id_quadrante: quadrante}, function (retorno) {
            //alert(retorno);
            var options = '<option value="">Selecione</option>';
            if (retorno != false) {
                options += retorno;
                $('#microregiaoEmp').html(options).show();
            } else {
                //alert('caiu aqui');
            }
        });
    });
});


//bloqueia as letras no cnpj
function BloqueiaLetras(evento) {
    var tecla;

    if (window.event) { // Internet Explorer
        tecla = event.keyCode;
    } else { // Firefox
        tecla = evento.which;
    }

    if (tecla >= 48 && tecla <= 57 || tecla == 8)
        return true;
    return false;
}


//valida o CNPJ digitado
function ValidarCNPJ(Cnpj) {
    var cnpj = Cnpj;
    var valida = new Array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
    var dig1 = new Number;
    var dig2 = new Number;

    exp = /\.|\-|\//g
    cnpj = cnpj.toString().replace(exp, "");
    var digito = new Number(eval(cnpj.charAt(12) + cnpj.charAt(13)));

    for (i = 0; i < valida.length; i++) {
        dig1 += (i > 0 ? (cnpj.charAt(i - 1) * valida[i]) : 0);
        dig2 += cnpj.charAt(i) * valida[i];
    }
    dig1 = (((dig1 % 11) < 2) ? 0 : (11 - (dig1 % 11)));
    dig2 = (((dig2 % 11) < 2) ? 0 : (11 - (dig2 % 11)));

    if (cnpj.length != 0) { //se campo cnpj for diferente de 0 entra no prÛximo if
        if (((dig1 * 10) + dig2) != digito) {
            alert('CNPJ Inv·lido!');
            document.getElementById("nr_cnpj").focus();
            document.getElementById("nr_cnpj").select();
        }
    }

}

$(function ($) {

    $('#nr_cnpj').blur(function () {

        var cnpj = $('#nr_cnpj').val();

        ValidarCNPJ(cnpj);

        $.post("validarCnpj.php", {cnpj: cnpj}, function (retorno) {
            if (retorno != false) {
                alert(retorno);
                $('#nr_cnpj').focus();
            }
        });
    });
});

/*##############################################################################
 *         CADASTRO DE EMPRESA
 *##############################################################################*/

$(function ($) {

    $("#cadastroEmpresa").submit(function () {

        // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o
        var nm_razaosocial = $("#nm_razaosocial").val();
        var nm_fantasia = $("#nm_fantasia").val();
        var nr_cnpj = $("#nr_cnpj").val();
        var nm_ramoatividade = $("#nm_ramoatividade").val();
        var nm_empresatipo = $("#nm_empresatipo").val();
        var nm_quantidadefuncionario = $("#nm_quantidadefuncionario").val();
        var nm_contato = $("#nm_contato").val();
        var nr_telefoneempresa = $("#nr_telefoneempresa").val();
        var nr_cep = $("#nr_cep").val();
        var ds_logradouro = $("#ds_logradouro").val();
        var nr_logradouro = $("#nr_logradouro").val();
        var ds_bairro = $("#ds_bairro").val();
        var ds_complemento = $("#ds_complemento").val();
        var estadoEmp = $("#estadoEmp").val();
        var cidadeEmp = $("#cidadeEmp").val();
        var ds_email = $("#ds_email").val();
        var ds_site = $("#ds_site").val();
        var nr_inscricaoestadual = $("#nr_inscricaoestadual").val();
        var nr_inscricaomunicipal = $("#nr_inscricaomunicipal").val();
        var dt_fundacao = $("#dt_fundacao").val();

        var aux_ao_liberacao = $("#ao_liberacao").is(":checked");
        var ao_liberacao = '';
        if (aux_ao_liberacao) {
            ao_liberacao = 'S';
        } else if (!aux_ao_liberacao) {
            ao_liberacao = 'N';
        }

        var nm_proprietario = $("#nm_proprietario").val();

        var nr_cpf = $("#nr_cpf").val();
        var dt_nascimento = $("#dt_nascimento").val();
        var nr_celular = $("#nr_celular").val();
        var ds_emailproprietario = $("#ds_emailproprietario").val();
        var ds_cargo = $("#ds_cargo").val();

        var quadranteEmp = $("#quadranteEmp").val();
        var microregiaoEmp = $("#microregiaoEmp").val();
        var poligonoEmp = $("#microregiaoEmp").val();

        var aux_ao_selo = $("#ao_selo").is(":checked");
        var ao_selo = '';
        if (aux_ao_selo) {
            ao_selo = 'S';
        } else if (!aux_ao_selo) {
            ao_selo = 'N';
        }

        $("#emp_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");

        $.post('enviaEmpresa.php', {nm_razaosocial: nm_razaosocial,
            nm_fantasia: nm_fantasia,
            nr_cnpj: nr_cnpj,
            nm_ramoatividade: nm_ramoatividade,
            nm_empresatipo: nm_empresatipo,
            nm_quantidadefuncionario: nm_quantidadefuncionario,
            nm_contato: nm_contato,
            nr_telefoneempresa: nr_telefoneempresa,
            nr_cep: nr_cep,
            ds_logradouro: ds_logradouro,
            nr_logradouro: nr_logradouro,
            ds_bairro: ds_bairro,
            ds_complemento: ds_complemento,
            estadoEmp: estadoEmp,
            cidadeEmp: cidadeEmp,
            ds_email: ds_email,
            ds_site: ds_site,
            nr_inscricaoestadual: nr_inscricaoestadual,
            nr_inscricaomunicipal: nr_inscricaomunicipal,
            dt_fundacao: dt_fundacao,
            nm_proprietario: nm_proprietario,
            nr_cpf: nr_cpf,
            dt_nascimento: dt_nascimento,
            nr_celular: nr_celular,
            ds_emailproprietario: ds_emailproprietario,
            ao_liberacao: ao_liberacao,
            ds_cargo: ds_cargo,
            quadranteEmp: quadranteEmp,
            microregiaoEmp: microregiaoEmp,
            poligonoEmp: poligonoEmp,
            ao_selo: ao_selo},
                function (resposta) {

                    $("#emp_load").slideDown();

                    if (resposta != false) {

                        $("#emp_load").hide('tohide');
                        $("#emp_ok").hide('tohide');
                        $("#emp_error").html(resposta);
                        $("#emp_error").slideDown();


                    } else {

                        // Exibe mensagem de sucesso
                        $("#emp_load").hide('tohide');
                        $("#emp_error").hide('tohide');
                        $("#emp_ok").html("Cadastro efetuado com sucesso!");
                        $("#emp_ok").slideDown();
                        // Coloca a mensagem no div de mensagens
                        // Limpando todos os campos
                        $("#nm_razaosocial").val("");
                        $("#nm_fantasia").val("");
                        $("#nr_cnpj").val("");
                        $("#nm_ramoatividade").val("");
                        $("#nm_empresatipo").val("");
                        $("#nm_quantidadefuncionario").val("");
                        $("#nm_contato").val("");
                        $("#nr_telefoneempresa").val("");
                        $("#nr_cep").val("");
                        $("#ds_logradouro").val("");
                        $("#secretaria_user").val("");
                        $("#nr_logradouro").val("");
                        $("#ds_bairro").val("");
                        $("#ds_complemento").val("");
                        $("#estadoEmp").val("");
                        $("#cidadeEmp").val("");
                        $("#ds_email").val("");
                        $("#ds_site").val("");
                        $("#nr_inscricaoestadual").val("");
                        $("#nr_inscricaomunicipal").val("");
                        $("#dt_fundacao").val("");
                        $("#nm_proprietario").val("");
                        $("#nr_cpf").val("");
                        $("#dt_nascimento").val("");
                        $("#nr_celular").val("");
                        $("#ds_emailproprietario").val("");
                        $("#ao_liberacao").val("");
                        $("#ds_cargo").val("");
                        $("#quadranteEmp").val("");
                        $("#microregiaoEmp").val("");
                        $("#poligonoEmp").val("");
                        $("#ao_selo").val("");

                    }


                });

    });
});

/*##############################################################################
 *         ALTERA«¬O DE EMPRESA
 *##############################################################################*/

$(function ($) {
    // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada
    $("#editaEmpresa").submit(function () {
        // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o
        var id = $("#id_empresa").val();
        var nm_razaosocial = $("#nm_razaosocial").val();
        var nm_fantasia = $("#nm_fantasia").val();
        var id_ramoatividade = $("#id_ramoatividade").val();
        var id_empresatipo = $("#id_empresatipo").val();
        var id_quantidadefuncionario = $("#id_quantidadefuncionario").val();
        var nm_contato = $("#nm_contato").val();
        var nr_telefoneempresa = $("#nr_telefoneempresa").val();
        var nr_cep = $("#nr_cep").val();
        var ds_logradouro = $("#ds_logradouro").val();
        var nr_logradouro = $("#nr_logradouro").val();
        var ds_bairro = $("#ds_bairro").val();
        var ds_complemento = $("#ds_complemento").val();
        var estadoEmp = $("#estadoEmp").val();
        var cidadeEmp = $("#cidadeEmp").val();
        var ds_email = $("#ds_email").val();
        var ds_site = $("#ds_site").val();
        var nr_inscricaoestadual = $("#nr_inscricaoestadual").val();
        var nr_inscricaomunicipal = $("#nr_inscricaomunicipal").val();
        var dt_fundacao = $("#dt_fundacao").val();
        var nm_proprietario = $("#nm_proprietario").val();
        var nr_cpf = $("#nr_cpf").val();
        var dt_nascimento = $("#dt_nascimento").val();
        var nr_celular = $("#nr_celular").val();
        var ds_emailproprietario = $("#ds_emailproprietario").val();

        var aux_ao_status = $("#ao_status").is(":checked");
        var ao_status = '';
        if (aux_ao_status) {
            ao_status = 'S';
        } else if (!aux_ao_status) {
            ao_status = 'N';
        }

        var aux_ao_liberacao = $("#ao_liberacao").is(":checked");
        var ao_liberacao = '';
        if (aux_ao_liberacao) {
            ao_liberacao = 'N';
        } else if (!aux_ao_liberacao) {
            ao_liberacao = 'S';
        }

        var ds_cargo = $("#ds_cargo").val();
        var ds_observacao = $("#ds_observacao").val();
        var quadranteEmp = $("#quadranteEmp").val();
        var microregiaoEmp = $("#microregiaoEmp").val();
        var poligonoEmp = $("#poligonoEmp").val();

        var aux_ao_selo = $("#ao_selo").is(":checked");
        var ao_selo = '';
        if (aux_ao_selo) {
            ao_selo = 'N';
        } else if (!aux_ao_selo) {
            ao_selo = 'S';
        }

        //alert(ds_observacao);

        // Exibe mensagem de carregamento
        $("#emp_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
        $.post('enviaEditaEmpresa.php', {id_empresa: id,
            nm_razaosocial: nm_razaosocial,
            nm_fantasia: nm_fantasia,
            id_ramoatividade: id_ramoatividade,
            id_empresatipo: id_empresatipo,
            id_quantidadefuncionario: id_quantidadefuncionario,
            nm_contato: nm_contato,
            nr_telefoneempresa: nr_telefoneempresa,
            nr_cep: nr_cep,
            ds_logradouro: ds_logradouro,
            nr_logradouro: nr_logradouro,
            ds_bairro: ds_bairro,
            ds_complemento: ds_complemento,
            estadoEmp: estadoEmp,
            cidadeEmp: cidadeEmp,
            ds_email: ds_email,
            ds_site: ds_site,
            nr_inscricaoestadual: nr_inscricaoestadual,
            nr_inscricaomunicipal: nr_inscricaomunicipal,
            dt_fundacao: dt_fundacao,
            nm_proprietario: nm_proprietario,
            nr_cpf: nr_cpf,
            dt_nascimento: dt_nascimento,
            nr_celular: nr_celular,
            ds_emailproprietario: ds_emailproprietario,
            ao_status: ao_status,
            ao_liberacao: ao_liberacao,
            ds_cargo: ds_cargo,
            ds_observacao: ds_observacao,
            quadranteEmp: quadranteEmp,
            microregiaoEmp: microregiaoEmp,
            poligonoEmp: poligonoEmp,
            ao_selo: ao_selo},
                function (resposta) {
                    // Quando terminada a requisi√ß√£o
                    // Exibe a div status
                    $("#emp_load").slideDown();
                    // Se a resposta √© um erro
                    if (resposta != false) {
                        alert(resposta);
                        // Exibe o erro na div
                        $("#emp_load").hide('tohide');
                        $("#emp_ok").hide('tohide');
                        $("#emp_error").html(resposta);
                        $("#emp_error").slideDown();

                    }
                    // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
                    else {
                        // Exibe mensagem de sucesso
                        $("#emp_load").hide('tohide');
                        $("#emp_error").hide('tohide');
                        $("#emp_ok").html("Empresa alterada com sucesso!");
                        $("#emp_ok").slideDown();
                        // Coloca a mensagem no div de mensagens
                        // Limpando todos os campos


                    }


                });
    });

});

/*##############################################################################
 *         BUSCAR CBO
 *##############################################################################*/

function lookup(inputString) {
    if (inputString.length == 0) {
        // Hide the suggestion box.
        $('#suggestions').hide();
        document.getElementById('inputId').setAttribute('value', '');
    } else {

        $.post("buscaCbo.php", {query: inputString}, function (data) {
            if (data.length > 0 || data !== null) {
                $('#suggestions').show();
                $('#autoSuggestionsList').html(data);
            }
        });
    }
} // lookup

function fill(id, nm) {
    $('#inputString').val(nm);
    setTimeout("$('#suggestions').hide();", 200);
    $('#inputId').val(id);
}

//$(function($) {
//    $("#ao_liberacao").click(function() {

function teste(flag) {
    if (flag === 'S') {
        //alert('123');
        // Hide the suggestion box.
        $('#ds_observacao').hide();
    } else {
        $('#ds_observacao').show();
//            alert ('aquiii');
    }
}
//    });

//});
function testeEdita(flag) {
    if (flag === 'S') {
        //alert('123');
        // Hide the suggestion box.
        $('#observacao').hide();
    } else {
        $('#observacao').show();
//            alert ('aquiii');
    }
}

$(function ($) {
    $(document).ready(function () {

        $('#form_cand').change(function () {
            id = $('#form_cand').val();

            if (id == 6 || id == 7) {
                $('#auxCurso').show();
                $('#auxSemestre').show();
            } else {
                $('#auxCurso').hide();
                $('#auxSemestre').hide();
            }

            if (id == 8) {
                $('#auxCurso').show();
            }
        });
    });
});

/*##############################################################################
 *         VALIDAR CHECKS
 *##############################################################################*/
function validarChecks() {
    if (document.getElementById('candidatos').checked === false &&
            document.getElementById('empresas').checked === false &&
            document.getElementById('todos').checked === false) {
        alert('Ao menos um filtro deve ser marcado!');
        return false;
    } else {
        return true;
    }
}
/* Function que verifica se o checkbox do filtro candidato foi marcado.
 * Se true, exibe na tela as profissıes.
 * Se false, oculta as profissıes.
 */
function mostrarProfissoes() {
    if (document.getElementById('candidatos').checked === true) {
        $('#span_prof').show();
    } else {
        $('#span_prof').hide();
    }
}

/* Function que verifica se todos os chackbox foram marcados.
 * Se true, marca todos e exibe na tela as profissıes.
 * Se false, desmarca todos e oculta as profissıes.
 */
function marcarTodos() {
    if ($("#todos").attr("checked")) {
        $('.marcar').each(
                function () {
                    $(this).attr("checked", true);
                    $('#span_prof').show();
                }
        );
    } else {
        $('.marcar').each(
                function () {
                    $(this).attr("checked", false);
                    $('#span_prof').hide();
                }
        );
    }
}

/*##############################################################################
 *         CADASTRO DE PERGUNTA
 *##############################################################################*/

$(function ($) {
    // Quando o formul·rio for enviado, essa funÁ„o È chamada
    $("#cadastroFaq").submit(function () {
        // Colocamos os valores de cada campo em uma v·riavel para facilitar a manipulaÁ„o
        var pergunta = $("#ds_pergunta").val();
        var resposta = $("#ds_resposta").val();


        // Exibe mensagem de carregamento
        $("#def_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis„o ajax com o arquivo envia.php e enviamos os valores de cada campo atravÈs do mÈtodo POST
        $.post('enviaFaq.php', {ds_pergunta: pergunta, ds_resposta: resposta}, function (resposta) {
            // Quando terminada a requisiÁ„o
            // Exibe a div status
            $("#def_load").slideDown();

            // Se a resposta È um erro
            if (resposta != false) {
                // Exibe o erro na div
                $("#def_load").hide('tohide');
                $("#def_ok").hide('tohide');
                $("#def_error").html(resposta);
                $("#def_error").slideDown();
            }
            // Se resposta for false, ou seja, n„o ocorreu nenhum erro
            else {
                // Exibe mensagem de sucesso
                $("#def_load").hide('tohide');
                $("#def_error").hide('tohide');
                $("#def_ok").html("Pergunta salva com sucesso!");
                $("#def_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos
                $("#ds_pergunta").val("");
                $("#ds_resposta").val("");
                // ApÛs 3 segundos atualiza a p·gina
                setTimeout(function () {
                    location.reload(1);
                }, 3000);
            }
        });
    });
});

function editarPergunta(id_pergunta) {
    document.getElementById('esconder' + id_pergunta).style.display = 'block';
    document.getElementById('pergunta' + id_pergunta).style.display = 'none';
    document.getElementById('btEditar' + id_pergunta).style.display = 'none';
    document.getElementById('btExcluir' + id_pergunta).style.display = 'none';
    //document.getElementById('btAtualizar'+id_pergunta).style.display='block';
    $("#per_load" + id_pergunta).hide();
    $("#per_error" + id_pergunta).hide();
}

function cancelarEditaPergunta(id_pergunta) {
    document.getElementById('esconder' + id_pergunta).style.display = 'none';
    document.getElementById('pergunta' + id_pergunta).style.display = 'block';
    document.getElementById('btEditar' + id_pergunta).style.display = 'block';
    document.getElementById('btExcluir' + id_pergunta).style.display = 'block';
    //Oculta a imagem de carragemento, para quando o usu·rio clicar em cancelar, ele ficar hide.
    $("#per_load" + id_pergunta).hide();
    $("#per_error" + id_pergunta).hide();
    //Quando o usu·rio apagar um texto e clicar em cancelar, logo depois voltar a clicar em editar,
    //os campos ser„o carregados com os valores originais.
    document.getElementById("ds_pergunta" + id_pergunta).value = document.getElementById("ds_perguntaTexto" + id_pergunta).innerHTML;
    document.getElementById("ds_resposta" + id_pergunta).value = document.getElementById("ds_respostaTexto" + id_pergunta).innerHTML;


}

/*##############################################################################
 *         ALTERA«√O DE PERGUNTA
 *##############################################################################*/

function alterarPergunta(id) {

    $(function ($) {
        // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada

        $("#editaFaq" + id).submit(function () {
            // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o

            var pergunta = $("#ds_pergunta" + id).val();
            var resposta = $("#ds_resposta" + id).val();

            // Exibe mensagem de carregamento
            $("#per_load" + id).html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
            // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
            $.post('enviaEditaFaq.php', {id_pergunta: id, ds_pergunta: pergunta, ds_resposta: resposta}, function (resposta) {
                // Quando terminada a requisi√ß√£o
                // Exibe a div status
                $("#per_load" + id).slideDown();
                // Se a resposta √© um erro
                if (resposta != false) {
                    // Exibe o erro na div
                    $("#per_load" + id).hide('tohide');
                    $("#per_ok" + id).hide('tohide');
                    $("#per_error" + id).html(resposta);
                    $("#per_error" + id).slideDown();

                    $("#esconder" + id).slideDown();
                    $("#pergunta" + id).hide();
                    $("#btEditar" + id).hide();
                    $("#btExcluir" + id).hide();
                }
                // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
                else {

                    // Exibe mensagem de sucesso
                    $("#per_load" + id).hide('tohide');
                    $("#per_error" + id).hide('tohide');
                    $("#per_ok" + id).html("Pergunta alterada com sucesso!");
                    $("#per_ok" + id).slideDown();

                    // Coloca a mensagem no div de mensagens
                    $("#esconder" + id).hide();
                    $("#pergunta" + id).slideDown();
                    $("#btEditar" + id).slideDown();
                    $("#btExcluir" + id).slideDown();

                    //apÛs clicar em atualizar joga os valores dos campos no texto em html
                    document.getElementById("ds_perguntaTexto" + id).innerHTML = $('#ds_pergunta' + id).val();
                    document.getElementById("ds_respostaTexto" + id).innerHTML = $('#ds_resposta' + id).val();

                    //ApÛs 3 segundos esconde a div da mensagem
                    setTimeout(function () {
                        $("#per_error" + id).hide('tohide');
                    }, 3000);
                    setTimeout(function () {
                        $("#per_ok" + id).hide('tohide');
                    }, 3000);

                }

                //Esconde a img de carragemento
                $("#per_load" + id).hide();
            });
        });
    });
}

/*##############################################################################
 *         EXCLUIR/INATIVAR PERGUNTA
 *##############################################################################*/

function excluirPergunta(id) {

    $(function ($) {
        // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada

        $("#editaFaq" + id).submit(function () {
            // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o

            var pergunta = $("#ds_pergunta" + id).val();
            var resposta = $("#ds_resposta" + id).val();
            var ao_ativo = "N";

            // Exibe mensagem de carregamento
            $("#per_load" + id).html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
            // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
            $.post('enviaEditaFaq.php', {id_pergunta: id, ds_pergunta: pergunta, ds_resposta: resposta, ao_ativo: ao_ativo}, function (resposta) {
                // Quando terminada a requisi√ß√£o
                // Exibe a div status
                $("#per_load" + id).slideDown();
                // Se a resposta √© um erro
                if (resposta != false) {
                    // Exibe o erro na div
                    $("#per_load" + id).hide('tohide');
                    $("#per_ok" + id).hide('tohide');
                    $("#per_error" + id).html(resposta);
                    $("#per_error" + id).slideDown();

                    $("#esconder" + id).slideDown();
                    $("#pergunta" + id).hide();
                    $("#btEditar" + id).hide();
                    $("#btExcluir" + id).hide();
                }
                // Se resposta for false, ou seja, n√£o ocorreu nenhum erro
                else {

                    // Exibe mensagem de sucesso
                    $("#per_load" + id).hide('tohide');
                    $("#per_error" + id).hide('tohide');
                    $("#per_ok" + id).html("Pergunta excluÌda com sucesso!");
                    $("#per_ok" + id).slideDown();

                    // Coloca a mensagem no div de mensagens

                    $("#esconder" + id).hide(); //oculta a div esconder.
                    $("#pergunta" + id).slideDown(); //mostra a div pergunta para exiber a mensagem.
                    $("#btEditar" + id).hide(); //oculta o bot„o editar.
                    $("#btExcluir" + id).hide(); //oculta o bot„o excluir.
                    $("#hr" + id).hide(); //oculta a linha abaixo da pergunta.
                    $("#p" + id).hide(); //oculta a div do par·grafo

                    //apÛs clicar em atualizar joga os valores dos campos no texto em html
                    document.getElementById("ds_perguntaTexto" + id).innerHTML = "";
                    document.getElementById("ds_respostaTexto" + id).innerHTML = "";

                    //ApÛs 3 segundos esconde a div da mensagem
                    setTimeout(function () {
                        $("#per_error" + id).hide('tohide');
                    }, 3000);
                    setTimeout(function () {
                        $("#per_ok" + id).hide('tohide');
                    }, 3000);
                    setTimeout(function () {
                        $("#tr" + id).hide();
                    }, 3600);

                }

                //Esconde a img de carragemento
                $("#per_load" + id).hide();
            });
        });
    });
}
/*##############################################################################
 *         CADASTRO DE TEXTO
 *##############################################################################*/

$(function ($) {
    // Quando o formul·rio for enviado, essa funÁ„o È chamada
    $("#cadastroTexto").submit(function () {
        // Colocamos os valores de cada campo em uma v·riavel para facilitar a manipulaÁ„o
        var titulo = $("#ds_titulo").val();
        var texto = $("#ds_texto").val();


        // Exibe mensagem de carregamento
        $("#def_load").html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
        // Fazemos a requis„o ajax com o arquivo envia.php e enviamos os valores de cada campo atravÈs do mÈtodo POST
        $.post('enviaTexto.php', {ds_titulo: titulo, ds_texto: texto}, function (texto) {
            // Quando terminada a requisiÁ„o
            // Exibe a div status
            $("#def_load").slideDown();

            console.log(texto);
            // Se o texto È um erro
            if (texto != false) {
                // Exibe o erro na div
                $("#def_load").hide('tohide');
                $("#def_ok").hide('tohide');
                $("#def_error").html(texto);
                $("#def_error").slideDown();
            }
            // Se o texto for false, ou seja, n„o ocorreu nenhum erro
            else {
                // Exibe mensagem de sucesso
                $("#def_load").hide('tohide');
                $("#def_error").hide('tohide');
                $("#def_ok").html("Texto salvo com sucesso!");
                $("#def_ok").slideDown();
                // Coloca a mensagem no div de mensagens
                // Limpando todos os campos
                $("#ds_titulo").val("");
                $("#ds_texto").val("");
                // ApÛs 3 segundos atualiza a p·gina
                setTimeout(function () {
                    location.reload(1);
                }, 3000);
            }
        });
    });
});

function editarTexto(id_texto) {
    document.getElementById('esconder' + id_texto).style.display = 'block';
    document.getElementById('texto' + id_texto).style.display = 'none';
    document.getElementById('btEditar' + id_texto).style.display = 'none';
    document.getElementById('btExcluir' + id_texto).style.display = 'none';
    //document.getElementById('btAtualizar'+id_texto).style.display='block';
    $("#per_load" + id_texto).hide();
    $("#per_error" + id_texto).hide();
}

function cancelarEditaTexto(id_texto) {
    document.getElementById('esconder' + id_texto).style.display = 'none';
    document.getElementById('texto' + id_texto).style.display = 'block';
    document.getElementById('btEditar' + id_texto).style.display = 'block';
    document.getElementById('btExcluir' + id_texto).style.display = 'block';
    //Oculta a imagem de carragemento, para quando o usu·rio clicar em cancelar, ele ficar hide.
    $("#per_load" + id_texto).hide();
    $("#per_error" + id_texto).hide();
    //Quando o usu·rio apagar um texto e clicar em cancelar, logo depois voltar a clicar em editar,
    //os campos ser„o carregados com os valores originais.
    document.getElementById("ds_titulo" + id_texto).value = document.getElementById("ds_tituloTexto" + id_texto).innerHTML;
    document.getElementById("ds_texto" + id_texto).value = document.getElementById("ds_textoTexto" + id_texto).innerHTML;


}

/*##############################################################################
 *         ALTERA«√O DE TEXTO
 *##############################################################################*/

function alterarTexto(id) {

    $(function ($) {
        // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada

        $("#editaTexto" + id).submit(function () {
            // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o

            var titulo = $("#ds_titulo" + id).val();
            var texto = $("#ds_texto" + id).val();

            // Exibe mensagem de carregamento
            $("#per_load" + id).html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
            // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
            $.post('enviaEditaTexto.php', {id_texto: id, ds_titulo: titulo, ds_texto: texto}, function (texto) {
                // Quando terminada a requisi√ß√£o
                // Exibe a div status
                $("#per_load" + id).slideDown();
                // Se o texto √© um erro
                if (texto != false) {
                    // Exibe o erro na div
                    $("#per_load" + id).hide('tohide');
                    $("#per_ok" + id).hide('tohide');
                    $("#per_error" + id).html(texto);
                    $("#per_error" + id).slideDown();

                    $("#esconder" + id).slideDown();
                    $("#texto" + id).hide();
                    $("#btEditar" + id).hide();
                    $("#btExcluir" + id).hide();
                }
                // Se o texto for false, ou seja, n√£o ocorreu nenhum erro
                else {

                    // Exibe mensagem de sucesso
                    $("#per_load" + id).hide('tohide');
                    $("#per_error" + id).hide('tohide');
                    $("#per_ok" + id).html("Texto alterado com sucesso!");
                    $("#per_ok" + id).slideDown();

                    // Coloca a mensagem no div de mensagens
                    $("#esconder" + id).hide();
                    $("#texto" + id).slideDown();
                    $("#btEditar" + id).slideDown();
                    $("#btExcluir" + id).slideDown();

                    //apÛs clicar em atualizar joga os valores dos campos no texto em html
                    document.getElementById("ds_tituloTexto" + id).innerHTML = $('#ds_titulo' + id).val();
                    document.getElementById("ds_textoTexto" + id).innerHTML = $('#ds_texto' + id).val();

                    //ApÛs 3 segundos esconde a div da mensagem
                    setTimeout(function () {
                        $("#per_error" + id).hide('tohide');
                    }, 3000);
                    setTimeout(function () {
                        $("#per_ok" + id).hide('tohide');
                    }, 3000);
                }

                //Esconde a img de carragemento
                $("#per_load" + id).hide();
            });
        });
    });
}

/*##############################################################################
 *         EXCLUIR/INATIVAR TEXTO
 *##############################################################################*/

function excluirTexto(id) {

    $(function ($) {
        // Quando o formul√°rio for enviado, essa fun√ß√£o √© chamada

        $("#editaTexto" + id).submit(function () {
            // Colocamos os valores de cada campo em uma v√°riavel para facilitar a manipula√ß√£o

            var titulo = $("#ds_titulo" + id).val();
            var texto = $("#ds_texto" + id).val();
            var ao_ativo = "N";

            // Exibe mensagem de carregamento
            $("#per_load" + id).html("<img src='../../../Utilidades/Imagens/bancodeoportunidades/loader.gif' alt='Enviando' />");
            // Fazemos a requis√£o ajax com o arquivo envia.php e enviamos os valores de cada campo atrav√©s do m√©todo POST
            $.post('enviaEditaTexto.php', {id_texto: id, ds_titulo: titulo, ds_texto: texto, ao_ativo: ao_ativo}, function (texto) {
                // Quando terminada a requisi√ß√£o
                // Exibe a div status
                $("#per_load" + id).slideDown();
                // Se o texto √© um erro
                if (texto != false) {
                    // Exibe o erro na div
                    $("#per_load" + id).hide('tohide');
                    $("#per_ok" + id).hide('tohide');
                    $("#per_error" + id).html(texto);
                    $("#per_error" + id).slideDown();

                    $("#esconder" + id).slideDown();
                    $("#texto" + id).hide();
                    $("#btEditar" + id).hide();
                    $("#btExcluir" + id).hide();
                }
                // Se o texto for false, ou seja, n√£o ocorreu nenhum erro
                else {

                    // Exibe mensagem de sucesso
                    $("#per_load" + id).hide('tohide');
                    $("#per_error" + id).hide('tohide');
                    $("#per_ok" + id).html("Texto excluÌdo com sucesso!");
                    $("#per_ok" + id).slideDown();

                    // Coloca a mensagem no div de mensagens

                    $("#esconder" + id).hide(); //oculta a div esconder.
                    $("#texto" + id).slideDown(); //mostra a div texto para exiber a mensagem.
                    $("#btEditar" + id).hide(); //oculta o bot„o editar.
                    $("#btExcluir" + id).hide(); //oculta o bot„o excluir.
                    $("#hr" + id).hide(); //oculta a linha abaixo do texto.
                    $("#p" + id).hide(); //oculta a div do par·grafo

                    //apÛs clicar em atualizar joga os valores dos campos no texto em html
                    document.getElementById("ds_tituloTexto" + id).innerHTML = "";
                    document.getElementById("ds_textoTexto" + id).innerHTML = "";

                    //ApÛs 3 segundos esconde a div da mensagem
                    setTimeout(function () {
                        $("#per_error" + id).hide('tohide');
                    }, 3000);
                    setTimeout(function () {
                        $("#per_ok" + id).hide('tohide');
                    }, 3000);
                    setTimeout(function () {
                        $("#tr" + id).hide();
                    }, 3600);

                }

                //Esconde a img de carragemento
                $("#per_load" + id).hide();
            });
        });
    });
}

/*##############################################################################
 *         IMPRIMIR CURRÕCULO CANDIDATO
 *##############################################################################*/

function imprimir_curriculo_individual(id_form, nome_candidato) {

    if (confirm("Deseja fazer o donwload do currÌculo de " + nome_candidato + "?") === true) {
        $('#print_relatorio_' + id_form).submit();
    } else {
        return false;
    }

}

/*##############################################################################
 *         RESETAR SENHA
 *##############################################################################*/

function resetar_senha_candidato(id_candidato, nm_candidato, ds_email, ds_loginportal) {
    if (confirm("Deseja resetar a senha de " + nm_candidato + "?") === true) {
        $.post('controleCandidato.php?op=resetarSenha', {id_candidato: id_candidato, nm_candidato: nm_candidato, ds_email: ds_email, ds_loginportal: ds_loginportal}, function (resposta) {
            alert("Foi enviada uma nova senha para o email do candidato " + nm_candidato);
        });
    } else {
        return false;
    }
}

/*##############################################################################
 *         ENVIA EMAIL
 *##############################################################################*/

function envia_email(nm_candidato) {

    if ((document.getElementById('ds_assunto').value === "") || (document.getElementById('ds_emailindividual').value === "")) {
        if (document.getElementById('ds_assunto').value === "") {
            alert("Informe o assunto do email para o candidato");
            document.getElementById('ds_assunto').focus();
            document.getElementById('ds_assunto').style.background = "#EEE8AA";
        } else {
            alert("Informe a descriÁ„o do email para o candidato");
            document.getElementById('ds_emailindividual').focus();
            document.getElementById('ds_emailindividual').style.background = "#EEE8AA";
        }
    } else {
        if (confirm("Deseja realmente enviar o email a " + nm_candidato + "?") === true) {
            $('#formEnviaEmail').fadeOut(1000);
            $('#tabelaPosEmail').show(1000);
            $('#imagem_envio_email').show(1000);
            //ApÛs 5 segundos esconde a mensagem de enviando email
            setTimeout(function () {
                $('#imagem_envio_email').fadeOut();
                $('#pos_envio_email').fadeIn(2500);
                $('#formEnviaEmail').submit();
            }, 4000);
        }
    }
}

function novo_email_individual() {
    $('#formEnviaEmail').fadeIn(1000);
}

function destruirSessaoBuscaCandidato() {
    destruirSessaoBuscaCandidato = "sim";
    $.post('controleCandidato.php?op=destruirSessaoBuscaCandidato', {destruirSessaoBuscaCandidato: destruirSessaoBuscaCandidato}, function (resposta) { });
}
