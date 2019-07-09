/*##############################################################################
 *         VALIDAÇÃO DE CPF
 *##############################################################################*/

function validarCPF(campo) {

    cpf = campo.replace(/\./g, '').replace(/\-/g, '').replace(/\_/g, '');

    erro = new String;
    if (cpf.length != 0) { //se o campo cpf for diferente de 0 passa para o próximo if.
        if (cpf.length < 11) { //se quantidade de números for menor que 11 da o erro.
            erro += "Sao necessarios 11 digitos para verificacao do CPF! \n\n";
        }
    }

    var nonNumbers = /\D/;
    if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999") {
        erro += "Numero de CPF invalido!";
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
        erro += "CPF Inválido!";

    }
    if (erro.length > 0) {
        alert(erro);
        document.getElementById("nr_cpf").value = '';
        document.getElementById("nr_cpf").focus();
        return true;
    }
    return false;
}

//mascara cpf
$(function ($) {
    $(document).ready(function () {
        $("#nr_cpf").mask("999.999.999-99");
    });
});

//mascara telefone
$(function ($) {
    $(document).ready(function () {
        $("#nr_telefone").mask("(99) 9999-9999");
    });

    //mascara celular
    $(document).ready(function () {
        $("#nr_celular").mask("(99) 99999-9999");
    });
});

/*permite somente valores numericos*/
function valCPF(e, campo) {

    var tecla = (window.event) ? event.keyCode : e.which;
    if ((tecla > 47 && tecla < 58)) {
        mascara(campo, '###.###.###-##');
        return true;
    } else {
        if (tecla != 8)
            return false;
        else
            return true;
    }
}


/*##############################################################################
 *         VERIFICA SE A DATA DIGITADA É VÁLIDA
 *##############################################################################*/
/**
 * Valida data (dd/mm/aaaa)
 *
 * @return boolean
 */
function valida_data(val) {
    if (val == "")
        return false;
    var data = val.split("/");
    if (data.length != 3)
        return false;
    var dia = data[0];
    var mes = data[1];
    var ano = data[2];
    if ((ano <= 0) || (mes > 12 || mes == 0) || (dia > 31 || dia == 0))
        return false;
    else if (((ano % 4) == 0) && (mes == 2) && (dia > 29))
        return false;
    else if (((ano % 4) > 0) && (mes == 2) && (dia > 28))
        return false;
    else if (((mes == 4) || (mes == 6) || (mes == 9) || (mes == 11)) && (dia == 31))
        return false;
    return true;
}

/*##############################################################################
 *         VALIDAÇÃO PARA PERMITIR APENAS NÚMERO NO CAMPO
 *##############################################################################*/

/**
 * Permite números + ponto + virgula
 *
 * Códigos ASCII
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

//Bloquea a digitação de números no campo
function bloqueia_numeros(evento)
{
    var tecla;

    if (window.event) { // Internet Explorer
        tecla = event.keyCode;
    } else { // Firefox
        tecla = evento.which;
    }

    if (tecla >= 48 && tecla <= 57)
        return false;
    return true;
}

/*##############################################################################
 *         MÁSCARA PARA O CAMPO DATA
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
    vr = vr.replace(".", "");
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

/*##############################################################################
 *         BUSCAR CIDADE PELA CHANGE DO ESTADO
 *##############################################################################*/
$(function ($) {
    $('#id_estado').change(function () {

        var uf = $('#id_estado').val();
        var op = 1;

        var options = '<option value="">Selecione</option>';

        $.post("../util/Utilidades.php", {op: op, id_estado: uf}, function (retorno) {
            if (retorno != false) {
                options += retorno;
                $('#id_cidade').html(options).show();
            } else {
                $('#id_cidade').html(options).show();
            }
        });

    });
});

/*##############################################################################
 *         BUSCAR CID PELA CHANGE DA DEFICIÊNCIA
 *##############################################################################*/
$(function ($) {
    $('#id_deficiencia').change(function () {

        var id_deficiencia = $('#id_deficiencia').val();
        var op = 1;

        var options = '<option value="">Selecione</option>';

        $.post("../util/Utilidades.php", {op: op, id_deficiencia: id_deficiencia}, function (retorno) {
            if (retorno != false) {
                options += retorno;
                $('#id_deficienciacid').html(options).show();
            } else {
                $('#id_deficienciacid').html(options).show();
            }
        });

    });
});

//máscara de cnpj
function FormataCnpj(campo, teclapres)
{
    var tecla = teclapres.keyCode;
    var vr = new String(campo.value);
    vr = vr.replace(".", "");
    vr = vr.replace("/", "");
    vr = vr.replace("-", "");
    tam = vr.length + 1;
    if (tecla != 14)
    {
        if (tam == 3)
            campo.value = vr.substr(0, 2) + '.';
        if (tam == 6)
            campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 5) + '.';
        if (tam == 10)
            campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(6, 3) + '/';
        if (tam == 15)
            campo.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(6, 3) + '/' + vr.substr(9, 4) + '-' + vr.substr(13, 2);
    }
}

//bloqueia as letras no cnpj
function BloqueiaLetras(evento)
{
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

    if (cnpj.length != 0) { //se campo cnpj for diferente de 0 entra no próximo if
        if (((dig1 * 10) + dig2) != digito) {
            alert('CNPJ Invalido!');
            document.getElementById("nr_cnpj").focus();
            document.getElementById("nr_cnpj").select();
        }
    }

}



/*##############################################################################
 *        VALIDAR CPF/CNPJ SE JA SAO CADASTRADOS
 *##############################################################################*/

$(function ($) {

    $('#nr_cnpj').blur(function () {
        //alert();
        var cnpj = $('#nr_cnpj').val();

        $.post("validarCpfCnpj.php", {cnpj: cnpj}, function (retorno) {
            if (retorno != false) {
                alert(retorno);
                $('#nr_cnpj').focus();
            }
        });
    });

    $('#nr_cpf').blur(function () {
        //alert();
        var cpf = $('#nr_cpf').val();

        $.post("validarCpfCnpj.php", {cpf: cpf}, function (retorno) {
            if (retorno != false) {
                alert(retorno);
                $('#nr_cpf').focus();
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
        var op = 2;
        $.post("../util/Utilidades.php", {query: "" + inputString + "", op: op}, function (data) {
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



/*##############################################################################
 *         MARCAR/DESMARCAR CHECKBOX
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

    if ($("#tdQua").attr("checked")) {
        $('.mQua').each(
                function () {
                    $(this).attr("checked", true);
                }
        );
    } else {
        $('.mQua').each(
                function () {
                    $(this).attr("checked", false);
                }
        );
    }

    if ($("#tdExp").attr("checked")) {
        $('.mExp').each(
                function () {
                    $(this).attr("checked", true);
                }
        );
    } else {
        $('.mExp').each(
                function () {
                    $(this).attr("checked", false);
                }
        );
    }

    if ($("#tdEmpDet").attr("checked")) {
        $('.mEmpDet').each(
                function () {
                    $(this).attr("checked", true);
                }
        );
    } else {
        $('.mEmpDet').each(
                function () {
                    $(this).attr("checked", false);
                }
        );
    }
}

///////////////////MARCAR E DESMARCAR - GuiCurriculos\\\\\\\\\\\\\\\\\\\\\\\\\\\
function marcardesmarcar_cimabaixo() {
    if ($("#todos_cima").attr("checked") || $("#todos_baixo").attr("checked")) {
        $('.marcar_cimabaixo').each(
                function () {
                    $(this).attr("checked", true);
                }
        );

    } else {
        $('.marcar_cimabaixo').each(
                function () {
                    $(this).attr("checked", false);
                }
        );
    }
}
////////////////////////////////////////////////////////////////////////////////

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

function desmarcar() {

    if ($(".oProf").attr("checked")) {
        mostrarOutro();
    } else if ($("#id_profissao").val() == 'OUTRO') {
        mostrarOutro();
    } else {
        ocultarOutro();
    }

}

function ocultarOutro() {
    $('#ds_outro').hide();
    $('#ds_outro').val('');
}

function mostrarOutro() {
    $('#ds_outro').show();
    $('#ds_outro').focus();
}

/*##############################################################################
 *         CONFIRMAR DELETE
 *##############################################################################*/
function confirmarDeleteFormacao() {

    var ids = $('.marcar').is(":checked");
    if (ids) {
        var flag;
        flag = window.confirm("Você deseja apagar esta formação?");
        if (flag) {
            document.deletarFormacao.submit();
        }
    } else {
        alert("Selecione no mínimo uma formação!");
    }
}

function confirmarDeleteQualificacao() {

    var ids = $('.mQua').is(":checked");
    if (ids) {
        var flag;
        flag = window.confirm("Você deseja apagar esta qualificação?");
        if (flag) {
            document.deletarQualificacao.submit();
        }
    } else {
        alert("Selecione no mínimo uma qualificação!");
    }
}

function confirmarDeleteExperiencia() {

    var ids = $('.mExp').is(":checked");
    if (ids) {
        var flag;
        flag = window.confirm("Você deseja apagar esta experiência?");
        if (flag) {
            document.deletarExperiencia.submit();
        }
    } else {
        alert("Selecione no mínimo uma experiência!");
    }
}

//mascara telefone da empresa
$(function ($) {
    $(document).ready(function () {
        $("#nr_telefoneempresa").mask("(99) 9999-9999");
    });
});
//máscara cnpj
$(function ($) {
    $(document).ready(function () {
        $("#nr_cnpj").mask("99.999.999/9999-99");
    });
});
// máscara cep
$(function ($) {
    $(document).ready(function () {
        $("#nr_cep").mask("99999-999");
    });
});
//máscara dt_fundacao
$(function ($) {
    $(document).ready(function () {
        $("#dt_fundacao").mask("99/99/9999");
    });
});
//máscara nascimento
$(function ($) {
    $(document).ready(function () {
        $("#nascimento").mask("99/99/9999");
    });
});

//máscara das inscrições estaduais de todos os estados
$(function ($) {
    $('#id_estado').change(function () {
        var uf = $('#id_estado').val();

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

function validaDataEmpresa(val, campo) {
    if (val === "")
        return false;
    var data = val.split("/");
    if (data.length !== 3)
        return false;
    var dia = data[0];
    var mes = data[1];
    var ano = data[2];
    if ((ano <= 0) || (mes > 12 || mes == 0) || (dia > 31 || dia == 0)) {
        alert('Data Inválida');
    } else if (((ano % 4) == 0) && (mes == 2) && (dia > 29)) {
        alert('Data Inválida');
    } else if (((ano % 4) > 0) && (mes == 2) && (dia > 28)) {
        alert('Data Inválida');
    } else if (((mes == 4) || (mes == 6) || (mes == 9) || (mes == 11)) && (dia == 31)) {
        alert('Data Inválida');
    } else {
        return true;
    }
    document.getElementById(campo).focus();
    document.getElementById(campo).select();
}

//function mostraCurso() {
//    if(document.getElementById("curso_cand").style.display == "none") {
//       document.getElementById("curso_cand").style.display = "block";
//            }
//        }
//function escondeCurso(){
//    if(document.getElementById("curso_cand").style.display == "block"){
//       document.getElementById("curso_cand").style.display = "none";
//        }
//        else {
//            document.getElementById("curso_cand").style.display = "none";
//            }
//        }
//
//function mostraSemestre() {
//    if(document.getElementById("semestre_cand").style.display == "none") {
//       document.getElementById("semestre_cand").style.display = "block";
//            }
//        }
//function escondeSemestre(){
//    if(document.getElementById("semestre_cand").style.display == "block"){
//       document.getElementById("semestre_cand").style.display = "none";
//        }
//        else {
//            document.getElementById("semestre_cand").style.display = "none";
//            }
//        }

//function mostrar(){
//    $(function($) {
//        $(document).ready(function(){
//            $('#curso_cand').show();
//        });
//    });
//}

//function ocultar(curso_cand){
//    $(function($) {
//        $(document).ready(function(){
//            $(curso_cand).hide();
//        });
//    });
//}

$(function ($) {
    $(document).ready(function () {

        $('#id_formacao').change(function () {
            id = $('#id_formacao').val();

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
 * ######################### FORMATAR VALOR DA MOEDA ############################
 * #############################################################################*/

function BlockKeybord() {
    if (window.event) { // IE
        if ((event.keyCode < 48) || (event.keyCode > 57)) {
            event.returnValue = false;
        }
    } else if (e.which) { // Netscape/Firefox/Opera
        if ((event.which < 48) || (event.which > 57)) {
            event.returnValue = false;
        }
    }
}

function troca(str, strsai, strentra) {
    while (str.indexOf(strsai) > -1) {
        str = str.replace(strsai, strentra);
    }
    return str;
}

function FormataMoeda(campo, tammax, teclapres, caracter) {
    if (teclapres == null || teclapres == "undefined") {
        var tecla = -1;
    } else {
        var tecla = teclapres.keyCode;
    }

    if (caracter == null || caracter == "undefined") {
        caracter = ".";
    }

    vr = campo.value;
    if (caracter != "") {
        vr = troca(vr, caracter, "");
    }

    vr = troca(vr, "/", "");
    vr = troca(vr, ",", "");
    vr = troca(vr, ".", "");

    tam = vr.length;
    if (tecla > 0) {
        if (tam < tammax && tecla != 8) {
            tam = vr.length + 1;
        }

        if (tecla == 8) {
            tam = tam - 1;
        }
    }
    if (tecla == -1 || tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
        if (tam <= 2) {
            campo.value = vr;
        }
        if ((tam > 2) && (tam <= 5)) {
            campo.value = vr.substr(0, tam - 2) + ',' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 6) && (tam <= 8)) {
            campo.value = vr.substr(0, tam - 5) + caracter + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 9) && (tam <= 11)) {
            campo.value = vr.substr(0, tam - 8) + caracter + vr.substr(tam - 8, 3) + caracter + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 12) && (tam <= 14)) {
            campo.value = vr.substr(0, tam - 11) + caracter + vr.substr(tam - 11, 3) + caracter + vr.substr(tam - 8, 3) + caracter + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
        }
        if ((tam >= 15) && (tam <= 17)) {
            campo.value = vr.substr(0, tam - 14) + caracter + vr.substr(tam - 14, 3) + caracter + vr.substr(tam - 11, 3) + caracter + vr.substr(tam - 8, 3) + caracter + vr.substr(tam - 5, 3) + ',' + vr.substr(tam - 2, tam);
        }
    }
}

function maskKeyPress(objEvent) {
    var iKeyCode;

    if (window.event) { // IE
        iKeyCode = objEvent.keyCode;
        if (iKeyCode >= 48 && iKeyCode <= 57)
            return true;
        return false;
    } else if (e.which) { // Netscape/Firefox/Opera
        iKeyCode = objEvent.which;
        if (iKeyCode >= 48 && iKeyCode <= 57)
            return true;
        return false;
    }
}

function cadastrarVaga() {
    var op = 4;
    var vaga = true;
    $.post("../util/Utilidades.php", {op: op, vaga: vaga}, function (retorno) {
        if (retorno !== false) {
            link = 'GuiCadVaga.php';
            window.location = link;
        }
    });
}

function cancelarVaga() {
    var op = 5;
    var cancelar = 1;
    $.post("../util/Utilidades.php", {op: op, cancelar: cancelar}, function (retorno) {
        if (retorno !== false) {
            link = 'GuiVagas.php';
            window.location = link;
        }
    });
}

function mostrarDescProfissao(id) {
    document.getElementById('ds_profissao_' + id).setAttribute('style', '');
    document.getElementById('bt_profissao_' + id).setAttribute('onclick', 'ocultarDescProfissao(' + id + ')');
}

function ocultarDescProfissao(id) {
    document.getElementById('ds_profissao_' + id).setAttribute('style', 'display:none;');
    document.getElementById('bt_profissao_' + id).setAttribute('onclick', 'mostrarDescProfissao(' + id + ')');
}

function mostrarCampoNIS() {
    document.getElementById('nr_nis').value = '';
    if (document.getElementById('ao_bolsafamilia_n').checked === true) {
        $('#numeroNis').hide();
    } else {
        $('#numeroNis').show();
    }
}

// ########## PARA ABA COM TODOS OS CANDIDATOS ##########
function mostrarSelectMotivos(id, vem_do) {
    document.getElementById('candidato_' + id).style.display = 'block';
    document.getElementById('candidato_' + id).style.padding = '10px';
    document.getElementById('inputEnviar_' + id).style.display = 'block';
    document.getElementById('inputEnviar_' + id).style.margin = '-35px 0 0 270px';

    //Se o dispensar vier direto do E, recebe E para decrementar nos encaminhados e mostra o enviarMotivo_E_,
    //se vier do P, recebe P e decrementa do P e mostra o enviarMotivo_P_.
    if (vem_do === 'E') {
        document.getElementById('enviarMotivo_E_' + id).style.display = 'block';
        document.getElementById('enviarMotivo_P_' + id).style.display = 'none';
    } else if (vem_do === 'P') {
        document.getElementById('enviarMotivo_P_' + id).style.display = 'block';
        document.getElementById('enviarMotivo_E_' + id).style.display = 'none';
    }

}

function ocultarSelectMotivos(id) {
    document.getElementById('ds_motivo_' + id).value = '';
    document.getElementById('id_motivo_' + id).value = 'Selecione';
    document.getElementById('candidato_' + id).style.display = 'none';
    document.getElementById('mostrarMotivo_' + id).style.display = 'none';
    document.getElementById('inputEnviar_' + id).style.display = 'none';
}

function mostrarCampoMotivoDispensa(id) {
    if (document.getElementById('id_motivo_' + id).value === 'Outros') {
        $('#mostrarMotivo_' + id).show();
        document.getElementById('inputEnviar_' + id).style.margin = '-35px 0 0 750px';
    } else {
        $('#mostrarMotivo_' + id).hide();
        document.getElementById('ds_motivo_' + id).value = '';
        document.getElementById('inputEnviar_' + id).style.margin = '-35px 0 0 270px';
    }
}

// ########## PARA ABA COM COM CANDIDATOS ENCAMINHADOS ##########
function mostrarSelectMotivosEnc(id, vem_do) {
    document.getElementById('candidatoEnc_' + id).style.display = 'block';
    document.getElementById('candidatoEnc_' + id).style.padding = '10px';
    document.getElementById('inputEnviarEnc_' + id).style.display = 'block';
    document.getElementById('inputEnviarEnc_' + id).style.margin = '-35px 0 0 270px';

    //Se o dispensar vier direto do E, recebe E para decrementar nos encaminhados e mostra o enviarMotivo_E_,
    //se vier do P, recebe P e decrementa do P e mostra o enviarMotivo_P_.
    if (vem_do === 'E') {
        document.getElementById('enviarMotivo_Enc_' + id).style.display = 'block';
        document.getElementById('enviarMotivo_Pre_' + id).style.display = 'none';
    } else if (vem_do === 'P') {
        document.getElementById('enviarMotivo_Pre_' + id).style.display = 'block';
        document.getElementById('enviarMotivo_Enc_' + id).style.display = 'none';
    }
}

function ocultarSelectMotivosEnc(id) {
    document.getElementById('ds_motivoEnc_' + id).value = '';
    document.getElementById('id_motivoEnc_' + id).value = 'Selecione';
    document.getElementById('candidatoEnc_' + id).style.display = 'none';
    document.getElementById('mostrarMotivoEnc_' + id).style.display = 'none';
    document.getElementById('inputEnviarEnc_' + id).style.display = 'none';
}

function mostrarCampoMotivoDispensaEnc(id) {
    if (document.getElementById('id_motivoEnc_' + id).value === 'Outros') {
        $('#mostrarMotivoEnc_' + id).show();
        document.getElementById('inputEnviarEnc_' + id).style.margin = '-35px 0 0 750px';
    } else {
        $('#mostrarMotivoEnc_' + id).hide();
        document.getElementById('ds_motivoEnc_' + id).value = '';
        document.getElementById('inputEnviarEnc_' + id).style.margin = '-35px 0 0 270px';
    }
}

function verificarSelectEnc(vem_do, id, vc, status, id_vaga, id_interno) {
    if (document.getElementById('id_motivoEnc_' + id).value === 'Selecione') {
        alert("Selecione um motivo de dispensa!");
        return false;
    } else if (document.getElementById('id_motivoEnc_' + id).value === 'Outros') {
        if (document.getElementById('ds_motivoEnc_' + id).value === '') {
            alert("Informe uma descrição de motivo!");
            return false;
        }
    }
    alterarStatus(vem_do, vc, status, id_vaga, id_interno);
    ocultarSelectMotivosEnc(id);

}

// ########## PARA ABA COM COM CANDIDATOS PRÉ-SELECIONADOS ##########
function mostrarSelectMotivosPre(id) {
    document.getElementById('candidatoPre_' + id).style.display = 'block';
    document.getElementById('candidatoPre_' + id).style.padding = '10px';
    document.getElementById('inputEnviarPre_' + id).style.display = 'block';
    document.getElementById('inputEnviarPre_' + id).style.margin = '-35px 0 0 270px';
    document.getElementById('id_motivo_' + id).value = 'Selecione';
}

function ocultarSelectMotivosPre(id) {
    document.getElementById('ds_motivoPre_' + id).value = '';
    document.getElementById('id_motivoPre_' + id).value = 'Selecione';
    document.getElementById('candidatoPre_' + id).style.display = 'none';
    document.getElementById('mostrarMotivoPre_' + id).style.display = 'none';
    document.getElementById('inputEnviarPre_' + id).style.display = 'none';
}

function mostrarCampoMotivoDispensaPre(id) {
    if (document.getElementById('id_motivoPre_' + id).value === 'Outros') {
        $('#mostrarMotivoPre_' + id).show();
        document.getElementById('inputEnviarPre_' + id).style.margin = '-35px 0 0 750px';
    } else {
        $('#mostrarMotivoPre_' + id).hide();
        document.getElementById('ds_motivoPre_' + id).value = '';
        document.getElementById('inputEnviarPre_' + id).style.margin = '-35px 0 0 270px';
    }
}

function verificarSelectPre(vem_do, id, vc, status, id_vaga, id_interno) {
    if (document.getElementById('id_motivoPre_' + id).value === 'Selecione') {
        alert("Selecione um motivo de dispensa!");
        return false;
    } else if (document.getElementById('id_motivoPre_' + id).value === 'Outros') {
        if (document.getElementById('ds_motivoPre_' + id).value === '') {
            alert("Informe uma descrição de motivo!");
            return false;
        }
    }
    alterarStatus(vem_do, vc, status, id_vaga, id_interno);
    ocultarSelectMotivosPre(id);

}

//Função que mantem atualizado a quantidade dos candidatos na sessão para mostrar nos contadores
function atualizarSessaoCandidatos(encaminhados, baixasAutomaticas, preSelecionados, contratados, dispensados, vem_do, status) {
    $.post("../controle/ControleVaga.php?op=atualizarSessaoQtdCandidatos", {
        vem_do: vem_do,
        ao_status: status,
        resultadoEncaminhados: encaminhados,
        baixasAutomaticas: baixasAutomaticas,
        preSelecionados: preSelecionados,
        contratados: contratados,
        dispensados: dispensados

    }, function (retorno) {});

}

function chamarEdicaoVaga(idvaga) {
    $("#linha_vaga_" + idvaga).html('<td colspan="8"><center>Carregando vaga...<br /><img src="../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif" /></center></td>');

    $.post("../controle/ControleVaga.php?op=pegar", {id_vaga: idvaga}, function (retorno) {
        if (retorno !== false) {
            link = '../visao/GuiManutencaoVaga.php#parte-02';
            window.location = link;
        }
    });
}

function alterarStatus(vem_do, vc, status, id_vaga, id_interno) {

    $.post("../controle/ControleVaga.php?op=verificarVaga", {id_vaga: id_vaga}, function (retorno) {
        if (retorno > 0) {
            $.post("../controle/ControleVaga.php?op=registrar", {id_vagacandidato: vc, ao_status: status, vem_do: vem_do, id_interno: id_interno}, function (retorno) {
                $.post("../controle/ControleVaga.php?op=atualizarSessaoQtdCandidatos", {vem_do: vem_do, ao_status: status}, function (retorno) {});

                //pego o valor do campo hidden que verifica quantos encaminhados tem na página e diminuio 1 até chegar em 0 e liberar a paginação.
                var numEncaminhadosTodosPag = document.getElementById('conta_encaminhados_todos').value;
                var numEncaminhadosTodosPag_enc = document.getElementById('conta_encaminhados_todos_enc').value;

                if (vem_do === 'E') {

                    /*
                     //pego a url
                     var url = document.URL;
                     //pego o id da linha da aba encaminhados para verificar com o id da linha da aba total
                     var ultimoCaracterDaUrl = vc.split("#parte-0").pop();
                     //pego o último caracter da url
                     var ultimoCaracterDaUrl = url.split("#parte-0").pop();
                     //aba de todos os status
                     if(ultimoCaracterDaUrl === '2'){
                     }
                     //aba só de encaminhados
                     if(ultimoCaracterDaUrl === '3'){
                     }*/

                    //decremento do contador da aba todos
                    numEncaminhadosTodosPag--;
                    document.getElementById('conta_encaminhados_todos').value = numEncaminhadosTodosPag;

                    //decremento do contador da aba encaminhados
                    if (numEncaminhadosTodosPag === 0) {
                        document.getElementById('paginacaoFalsaTodos').style.display = "none";
                        document.getElementById('paginacaoCertaTodos').style.display = "block";
                    }


                    numEncaminhadosTodosPag_enc--;
                    document.getElementById('conta_encaminhados_todos_enc').value = numEncaminhadosTodosPag_enc;
                    if (numEncaminhadosTodosPag_enc === 0) {
                        document.getElementById('paginacaoFalsaTodos_enc').style.display = "none";
                        document.getElementById('paginacaoCertaTodos_enc').style.display = "block";
                    }
                }

                if (status === 'P') {
                    //alert("Email enviado com sucesso!");
                    atualizaQtdCandidatos(vem_do, status);
                    atualizaQtdCandidatosEnc(vem_do, status);
                    atualizaQtdCandidatosBaixas(vem_do, status);
                    atualizaQtdCandidatosPre(vem_do, status);
                    atualizaQtdCandidatosCon(vem_do, status);
                    atualizaQtdCandidatosDis(vem_do, status);
                    $('#pre_t_' + vc).html("Candidato pré-selecionado");
                    $('#pre_e_' + vc).html("Candidato pré-selecionado");
                    $('#linha_pre_t_' + vc).css('background', '#D1EEEE');
                    $('#linha_pre_e_' + vc).css('background', '#D1EEEE');
                    setTimeout(function () {
                        $('#pre_t_' + vc).hide();
                        $('#pre_e_' + vc).hide();
                        $('#div_p_' + vc).show(1000);
                        $('#div_p_e_' + vc).show(1000);
                    }, 3000);
                } else if (status === 'C') {
                    alert("Email enviado ao candidato contratado!");
                    atualizaQtdCandidatos(vem_do, status);
                    atualizaQtdCandidatosEnc(vem_do, status);
                    atualizaQtdCandidatosBaixas(vem_do, status);
                    atualizaQtdCandidatosPre(vem_do, status);
                    atualizaQtdCandidatosCon(vem_do, status);
                    atualizaQtdCandidatosDis(vem_do, status);
                    //dimunio o valor campo de quantidade de vagas
                    var qt_vaga = $('#qt_vaga').val();
                    qt_vaga--;
                    $('#qt_vaga').val(qt_vaga);
                    $('#div_p_' + vc).hide();
                    $('#div_p_e_' + vc).hide();
                    $('#div_p2_' + vc).html("Candidato contratado");
                    $('#div_p2_e_' + vc).html("Candidato contratado");
                    $('#div_p2_p_' + vc).html("Candidato contratado");
                    $('#pre_t_' + vc).html("Candidato contratado");
                    $('#pre_e_' + vc).html("Candidato contratado");
                    $('#linha_pre_t_' + vc).css('background', '#B4EEB4');
                    $('#linha_pre_e_' + vc).css('background', '#B4EEB4');
                    $('#linha_pre_p_' + vc).css('background', '#B4EEB4');
                    $('#pre_t_' + vc).show();
                    $('#pre_e_' + vc).show();
                } else if (status === 'D') {
                    atualizaQtdCandidatos(vem_do, status);
                    atualizaQtdCandidatosEnc(vem_do, status);
                    atualizaQtdCandidatosBaixas(vem_do, status);
                    atualizaQtdCandidatosPre(vem_do, status);
                    atualizaQtdCandidatosCon(vem_do, status);
                    atualizaQtdCandidatosDis(vem_do, status);
                    $('#div_p2_' + vc).html("Candidato dispensado");
                    $('#div_p2_e_' + vc).html("Candidato dispensado");
                    $('#div_p2_p_' + vc).html("Candidato dispensado");
                    $('#pre_t_' + vc).html("Candidato dispensado");
                    $('#pre_e_' + vc).html("Candidato dispensado");
                    $('#linha_pre_e_' + vc).css('background', '#FFDAB9');
                    $('#linha_pre_t_' + vc).css('background', '#FFDAB9');
                    $('#linha_pre_p_' + vc).css('background', '#FFDAB9');
                    $('#div_p_' + vc).hide();
                    $('#div_p_e_' + vc).hide();
                    $('#pre_t_' + vc).show();
                    $('#pre_e_' + vc).show();
                }
            });
        } else {
            alert('Não é possível fazer novas contratações. Favor alterar a quantidade de vagas!');
        }

        //$('input[name=buscar]').click();
    });
}

function verificarSelect(vem_do, id, vc, status, id_vaga, id_interno) {
    if (document.getElementById('id_motivo_' + id).value === 'Selecione') {
        alert("Selecione um motivo de dispensa!");
        return false;
    } else if (document.getElementById('id_motivo_' + id).value === 'Outros') {
        if (document.getElementById('ds_motivo_' + id).value === '') {
            alert("Informe uma descrição de motivo!");
            return false;
        }
    }


    alterarStatus(vem_do, vc, status, id_vaga, id_interno);
    ocultarSelectMotivos(id);

    //document.getElementById('formSinalizar_'+id).submit();
}

//##################ATUALIZA QUANTIDADE DE CANDIDATOS NO TOPO DA PÁGINA######################
function atualizaQtdCandidatos(vem_do, status) {
    var encaminhados = document.getElementById("totalEncaminhados").innerHTML;
    var baixasAutomaticas = document.getElementById("totalBaixasAutomaticas").innerHTML;
    var preSelecionados = document.getElementById("totalPreSelecionados").innerHTML;
    var contratados = document.getElementById("totalContratados").innerHTML;
    var dispensados = document.getElementById("totalDispensados").innerHTML;

    if (status === 'P') {
        preSelecionados++;
        $('#totalPreSelecionados').html(preSelecionados);
        //atualiza os campos hiddens para passar por post
        document.getElementById('preSelecionadosT').value = preSelecionados;
        document.getElementById('preSelecionadosE').value = preSelecionados;
        document.getElementById('preSelecionadosB').value = preSelecionados;
        document.getElementById('preSelecionadosP').value = preSelecionados;
        document.getElementById('preSelecionadosC').value = preSelecionados;
        document.getElementById('preSelecionadosD').value = preSelecionados;
    } else if (status === 'C') {
        contratados++;
        $('#totalContratados').html(contratados);
        //atualiza os campos hiddens para passar por post
        document.getElementById('contratadosT').value = contratados;
        document.getElementById('contratadosE').value = contratados;
        document.getElementById('contratadosB').value = contratados;
        document.getElementById('contratadosP').value = contratados;
        document.getElementById('contratadosC').value = contratados;
        document.getElementById('contratadosD').value = contratados;
    } else if (status === 'D') {
        dispensados++;
        $('#totalDispensados').html(dispensados);
        //atualiza os campos hiddens para passar por post
        document.getElementById('dispensadosT').value = dispensados;
        document.getElementById('dispensadosE').value = dispensados;
        document.getElementById('dispensadosB').value = dispensados;
        document.getElementById('dispensadosP').value = dispensados;
        document.getElementById('dispensadosC').value = dispensados;
        document.getElementById('dispensadosD').value = dispensados;
    }

    if (vem_do === 'E') {
        encaminhados--;
        $('#totalEncaminhados').html(encaminhados);
        //atualiza os campos hiddens para passar por post
        document.getElementById('encaminhadosT').value = encaminhados;
        document.getElementById('encaminhadosE').value = encaminhados;
        document.getElementById('encaminhadosB').value = encaminhados;
        document.getElementById('encaminhadosP').value = encaminhados;
        document.getElementById('encaminhadosC').value = encaminhados;
        document.getElementById('encaminhadosD').value = encaminhados;
    } else if (vem_do === 'P') {
        preSelecionados--;
        $('#totalPreSelecionados').html(preSelecionados);
        //atualiza os campos hiddens para passar por post
        document.getElementById('preSelecionadosT').value = preSelecionados;
        document.getElementById('preSelecionadosE').value = preSelecionados;
        document.getElementById('preSelecionadosB').value = preSelecionados;
        document.getElementById('preSelecionadosP').value = preSelecionados;
        document.getElementById('preSelecionadosC').value = preSelecionados;
        document.getElementById('preSelecionadosD').value = preSelecionados;
    }
}

//###########ATUALIZA QUANTIDADE DE CANDIDATOS ENCAMINHADOS NO TOPO DA PÁGINA###############
function atualizaQtdCandidatosEnc(vem_do, status) {
    var encaminhadosE = document.getElementById("totalEncaminhadosE").innerHTML;
    var baixasAutomaticasE = document.getElementById("totalBaixasAutomaticasE").innerHTML;
    var preSelecionadosE = document.getElementById("totalPreSelecionadosE").innerHTML;
    var contratadosE = document.getElementById("totalContratadosE").innerHTML;
    var dispensadosE = document.getElementById("totalDispensadosE").innerHTML;

    if (status === 'P') {
        preSelecionadosE++;
        $('#totalPreSelecionadosE').html(preSelecionadosE);
    } else if (status === 'C') {
        contratadosE++;
        $('#totalContratadosE').html(contratadosE);
    } else if (status === 'D') {
        dispensadosE++;
        $('#totalDispensadosE').html(dispensadosE);
    }

    if (vem_do === 'E') {
        encaminhadosE--;
        $('#totalEncaminhadosE').html(encaminhadosE);
    } else if (vem_do === 'P') {
        preSelecionadosE--;
        $('#totalPreSelecionadosE').html(preSelecionadosE);
    }
}

//###########ATUALIZA QUANTIDADE DE CANDIDATOS COM BAIXAS AUTOMÁTICAS NO TOPO DA PÁGINA###############
function atualizaQtdCandidatosBaixas(vem_do, status) {
    var encaminhadosB = document.getElementById("totalEncaminhadosB").innerHTML;
    var baixasAutomaticasB = document.getElementById("totalBaixasAutomaticasB").innerHTML;
    var preSelecionadosB = document.getElementById("totalPreSelecionadosB").innerHTML;
    var contratadosB = document.getElementById("totalContratadosB").innerHTML;
    var dispensadosB = document.getElementById("totalDispensadosB").innerHTML;

    if (status === 'P') {
        preSelecionadosB++;
        $('#totalPreSelecionadosB').html(preSelecionadosB);
    } else if (status === 'C') {
        contratadosB++;
        $('#totalContratadosB').html(contratadosB);
    } else if (status === 'D') {
        dispensadosB++;
        $('#totalDispensadosB').html(dispensadosB);
    }

    if (vem_do === 'E') {
        encaminhadosB--;
        $('#totalEncaminhadosB').html(encaminhadosB);
    } else if (vem_do === 'P') {
        preSelecionadosB--;
        $('#totalPreSelecionadosB').html(preSelecionadosB);
    }
}

//###########ATUALIZA QUANTIDADE DE CANDIDATOS PRÉ-SELECIONADOS NO TOPO DA PÁGINA###############
function atualizaQtdCandidatosPre(vem_do, status) {
    var encaminhadosP = document.getElementById("totalEncaminhadosP").innerHTML;
    var baixasAutomaticasP = document.getElementById("totalBaixasAutomaticasP").innerHTML;
    var preSelecionadosP = document.getElementById("totalPreSelecionadosP").innerHTML;
    var contratadosP = document.getElementById("totalContratadosP").innerHTML;
    var dispensadosP = document.getElementById("totalDispensadosP").innerHTML;

    if (status === 'P') {
        preSelecionadosP++;
        $('#totalPreSelecionadosP').html(preSelecionadosP);
    } else if (status === 'C') {
        contratadosP++;
        $('#totalContratadosP').html(contratadosP);
    } else if (status === 'D') {
        dispensadosP++;
        $('#totalDispensadosP').html(dispensadosP);
    }

    if (vem_do === 'E') {
        encaminhadosP--;
        $('#totalEncaminhadosP').html(encaminhadosP);
    } else if (vem_do === 'P') {
        preSelecionadosP--;
        $('#totalPreSelecionadosP').html(preSelecionadosP);
    }
}

//###########ATUALIZA QUANTIDADE DE CANDIDATOS CONTRATADOS NO TOPO DA PÁGINA###############
function atualizaQtdCandidatosCon(vem_do, status) {
    var encaminhadosC = document.getElementById("totalEncaminhadosC").innerHTML;
    var baixasAutomaticasC = document.getElementById("totalBaixasAutomaticasC").innerHTML;
    var preSelecionadosC = document.getElementById("totalPreSelecionadosC").innerHTML;
    var contratadosC = document.getElementById("totalContratadosC").innerHTML;
    var dispensadosC = document.getElementById("totalDispensadosC").innerHTML;

    if (status === 'P') {
        preSelecionadosC++;
        $('#totalPreSelecionadosC').html(preSelecionadosC);
    } else if (status === 'C') {
        contratadosC++;
        $('#totalContratadosC').html(contratadosC);
    } else if (status === 'D') {
        dispensadosC++;
        $('#totalDispensadosC').html(dispensadosC);
    }

    if (vem_do === 'E') {
        encaminhadosC--;
        $('#totalEncaminhadosC').html(encaminhadosC);
    } else if (vem_do === 'P') {
        preSelecionadosC--;
        $('#totalPreSelecionadosC').html(preSelecionadosC);
    }
}

//###########ATUALIZA QUANTIDADE DE CANDIDATOS DISPENSADOS NO TOPO DA PÁGINA###############
function atualizaQtdCandidatosDis(vem_do, status) {
    var encaminhadosD = document.getElementById("totalEncaminhadosD").innerHTML;
    var baixasAutomaticasD = document.getElementById("totalBaixasAutomaticasD").innerHTML;
    var preSelecionadosD = document.getElementById("totalPreSelecionadosD").innerHTML;
    var contratadosD = document.getElementById("totalContratadosD").innerHTML;
    var dispensadosD = document.getElementById("totalDispensadosD").innerHTML;

    if (status === 'P') {
        preSelecionadosD++;
        $('#totalPreSelecionadosD').html(preSelecionadosD);
    } else if (status === 'C') {
        contratadosD++;
        $('#totalContratadosD').html(contratadosD);
    } else if (status === 'D') {
        dispensadosD++;
        $('#totalDispensadosD').html(dispensadosD);
    }

    if (vem_do === 'E') {
        encaminhadosD--;
        $('#totalEncaminhadosD').html(encaminhadosD);
    } else if (vem_do === 'P') {
        preSelecionadosD--;
        $('#totalPreSelecionadosD').html(preSelecionadosD);
    }
}

function abrirHistoricoCandidato(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay').style.display = 'block';
}

function fecharHistoricoCandidato(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay').style.display = 'none';
}

function abrirDadosCandidato(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay').style.display = 'block';
}

function fecharDadosCandidato(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay').style.display = 'none';
}

//############### PARA ABA DE TODOS OS CANDIDATOS ######################
function abrirHistoricoCandidatoTodos(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_todos').style.display = 'block';
}

function fecharHistoricoCandidatoTodos(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_todos').style.display = 'none';
}

function abrirDadosCandidatoTodos(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_todos').style.display = 'block';
}

function fecharDadosCandidatoTodos(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_todos').style.display = 'none';
}
//#######################################################################


//########### PARA ABA DE CANDIDATOS COM BAIXAS AUTOMÁTICAS #############
function abrirHistoricoCandidatoBaixa(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_baixa').style.display = 'block';
}

function fecharHistoricoCandidatoBaixa(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_baixa').style.display = 'none';
}

function abrirDadosCandidatoBaixa(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_baixa').style.display = 'block';
}

function fecharDadosCandidatoBaixa(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_baixa').style.display = 'none';
}
//#######################################################################

//########### PARA ABA DE CANDIDATOS PRÉ-SELECIONADOS ###################
function abrirHistoricoCandidatoPre(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_pre').style.display = 'block';
}

function fecharHistoricoCandidatoPre(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_pre').style.display = 'none';
}

function abrirDadosCandidatoPre(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_pre').style.display = 'block';
}

function fecharDadosCandidatoPre(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_pre').style.display = 'none';
}
//#######################################################################

//########### PARA ABA DE CANDIDATOS CONTRATADOS ###################
function abrirHistoricoCandidatoCon(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_con').style.display = 'block';
}

function fecharHistoricoCandidatoCon(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_con').style.display = 'none';
}

function abrirDadosCandidatoCon(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_con').style.display = 'block';
}

function fecharDadosCandidatoCon(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_con').style.display = 'none';
}
//#######################################################################

//########### PARA ABA DE CANDIDATOS DISPENSADOS ########################
function abrirHistoricoCandidatoDis(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_dis').style.display = 'block';
}

function fecharHistoricoCandidatoDis(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_dis').style.display = 'none';
}

function abrirDadosCandidatoDis(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('black_overlay_dis').style.display = 'block';
}

function fecharDadosCandidatoDis(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('black_overlay_dis').style.display = 'none';
}
//#######################################################################

function mostrarCamposQualificacoes() {
    document.getElementById('ds_qualificacao').value = '';
    document.getElementById('nm_instituicao').value = '';
    document.getElementById('dt_termino').value = '';
    document.getElementById('qtd_horas').value = '';
    if (document.getElementById('ao_qualificacao_s').checked === true) {
        $('#tabela_qualificacoes').show();
    } else {
        $('#tabela_qualificacoes').hide();
    }
}

function mostrarCamposExperiencias() {
    document.getElementById('nm_empresa').value = '';
    document.getElementById('dt_inicio').value = '';
    document.getElementById('dt_termino').value = '';
    document.getElementById('ds_atividade').value = '';
    if (document.getElementById('ao_experiencia_s').checked === true) {
        $('#tabela_experiencias').show();
    } else {
        $('#tabela_experiencias').hide();

    }
}

function marcaAdicional(id) {
    if (document.getElementById('ao_adicional_' + id).checked === true) {
        $('#ladicional_' + id).css('color', '#EE7228');
    } else {
        $('#ladicional_' + id).css('color', '#666666');
    }
}

function marcaBeneficio(id) {
    if (document.getElementById('ao_beneficio_' + id).checked === true) {
        $('#lbeneficio_' + id).css('color', '#EE7228');
    } else {
        $('#lbeneficio_' + id).css('color', '#666666');
    }
}

function marcaFormacao(id) {
    if (document.getElementById('ao_formacao_' + id).checked === true) {
        $('#lformacao_' + id).css('color', '#EE7228');
    } else {
        $('#lformacao_' + id).css('color', '#666666');
    }
}

function marcaDivulgar() {
    //NOME DA EMPRESA
    if (document.getElementById('ao_exibenome').checked === true) {
        //o value vem com N, quando marcado recebe S caso contrário N
        document.getElementById('ao_exibenome').value = "S";
        $('#lnm_empresa').css('color', '#00CD00');
    } else {
        if (document.getElementById('ao_exibenome').checked === false) {
            document.getElementById('ao_exibenome').value = "N";
        }

        $('#lnm_empresa').css('color', '#666666');
    }
    //TELEFONE DA EMPRESA
    if (document.getElementById('ao_exibetelefone').checked === true) {
        //o value vem com N, quando marcado recebe S caso contrário N
        document.getElementById('ao_exibetelefone').value = "S";
        $('#lnm_empresatelefone').css('color', '#00CD00');
    } else {
        if (document.getElementById('ao_exibetelefone').checked === false) {
            document.getElementById('ao_exibetelefone').value = "N";
        }
        $('#lnm_empresatelefone').css('color', '#666666');
    }
    //EMAIL DA EMPRESA
    if (document.getElementById('ao_exibeemail').checked === true) {
        //o value vem com N, quando marcado recebe S caso contrário N
        document.getElementById('ao_exibeemail').value = "S";
        $('#lnm_empresaemail').css('color', '#00CD00');
    } else {
        if (document.getElementById('ao_exibeemail').checked === false) {
            document.getElementById('ao_exibeemail').value = "N";
        }
        $('#lnm_empresaemail').css('color', '#666666');
    }
}

function mostrarProfissao() {
    //chamar essa função no onchange do select.

    //Pega o valor selecionado no select e toca numa variável
    var profissao = $("#id_profissao option:selected").text();
    $("#ds_msg_vaga").fadeOut(1000);


    if ((profissao === "Selecione") || (profissao === 'OUTRO')) {
        profissao = "";
    }

    document.getElementById('ds_profissao').style.display = "block";
    $('#ds_profissao').html(profissao);
}

function inativarVaga() {

    var pergunta = "VOCÊ TEM CERTEZA QUE DESEJA INATIVAR A VAGA?";
    pergunta += "\n\n";
    pergunta += "*Inativando a vaga ela não receberá mais encaminhamentos e você não poderá alterá-la novamente, ";
    pergunta += "apenas cadastrando uma nova vaga.";

    if (confirm(pergunta)) {
        //altero o hidden que está S para N
        document.getElementById('ao_ativo').value = 'N';

        //submeto o formulário para inativar a vaga
        document.formCadVaga.submit();
    }
}

function atualizaListaTodos(id_vaga) {
    var filtro_codigo = "";
    var filtro_nome = "";
    var filtro_status = "";
    //oculto a tabela dos candidatos
    $("#tabela_todos").hide();
    $("#tabela_todos_pesq").hide();

    $("#tabela_todos_div").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");
    $("#tabela_todos_div_pesq").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");

    $.post("../controle/ControleVaga.php?op=pesquisarTodos", {id_vaga: id_vaga, filtro_codigo: filtro_codigo, filtro_nome: filtro_nome, filtro_status: filtro_status}, function (retorno) {
        window.location.reload();
    });
}

function atualizaListaEncaminhados(id_vaga) {
    var filtro_codigo = "";
    var filtro_nome = "";
    var filtro_status = "E";

    //oculto a tabela dos candidatos
    $("#tabela_encaminhados").hide();
    $("#tabela_encaminhados_pesq").hide();

    $("#tabela_encaminhados_div").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos encaminhados...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");
    $("#tabela_encaminhados_div_pesq").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos encaminhados...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");

    $.post("../controle/ControleVaga.php?op=pesquisarEncaminhados", {id_vaga: id_vaga, filtro_codigo: filtro_codigo, filtro_nome: filtro_nome, filtro_status: filtro_status}, function (retorno) {
        window.location.reload();
    });
}

function atualizaListaBaixasAutomaticas(id_vaga) {
    var filtro_codigo = "";
    var filtro_nome = "";
    var filtro_status = "B";
    //oculto a tabela dos candidatos
    $("#tabela_baixas_automaticas").hide();
    $("#tabela_baixas_automaticas_pesq").hide();

    $("#tabela_baixas_automaticas_div").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando baixas automáticas...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");
    $("#tabela_baixas_automaticas_div_pesq").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando baixas automáticas...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");

    $.post("../controle/ControleVaga.php?op=pesquisarBaixasAutomaticas", {id_vaga: id_vaga, filtro_codigo: filtro_codigo, filtro_nome: filtro_nome, filtro_status: filtro_status}, function (retorno) {
        window.location.reload();
    });
}

function atualizaListaPreSelecionados(id_vaga) {
    var filtro_codigo = "";
    var filtro_nome = "";
    var filtro_status = "P";

    //oculto a tabela dos candidatos
    $("#tabela_pre_selecionados").hide();
    $("#tabela_pre_selecionados_pesq").hide();

    $("#tabela_pre_selecionados_div").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos pré-selecionados...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");
    $("#tabela_pre_selecionados_div_pesq").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos pré-selecionados...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");

    $.post("../controle/ControleVaga.php?op=pesquisarPreSelecionados", {id_vaga: id_vaga, filtro_codigo: filtro_codigo, filtro_nome: filtro_nome, filtro_status: filtro_status}, function (retorno) {
        window.location.reload();
    });
}

function atualizaListaContratados(id_vaga) {
    var filtro_codigo = "";
    var filtro_nome = "";
    var filtro_status = "C";
    //oculto a tabela dos candidatos
    $("#tabela_contratados").hide();
    $("#tabela_contratados_pesq").hide();

    $("#tabela_contratados_div").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos contratados...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");
    $("#tabela_contratados_div_pesq").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos contratados...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");

    $.post("../controle/ControleVaga.php?op=pesquisarContratados", {id_vaga: id_vaga, filtro_codigo: filtro_codigo, filtro_nome: filtro_nome, filtro_status: filtro_status}, function (retorno) {
        window.location.reload();
    });
}

function atualizaListaDispensados(id_vaga) {
    var filtro_codigo = "";
    var filtro_nome = "";
    var filtro_status = "D";
    //oculto a tabela dos candidatos
    $("#tabela_dispensados").hide();
    $("#tabela_dispensados_pesq").hide();

    $("#tabela_dispensados_div").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos dispensados...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");
    $("#tabela_dispensados_div_pesq").html("<table width='100%' class='tabela_encaminhados'><tr class='table_formacao_cab'><td>&nbsp;</td></tr><tr class='table_formacao_row'><td style='height: 300px;'><center>Atualizando candidatos dispensados...<br /><img src='../../../Utilidades/Imagens/bancodeoportunidades/carregando_vaga.gif' /></center></td></tr></table>");

    $.post("../controle/ControleVaga.php?op=pesquisarDispensados", {id_vaga: id_vaga, filtro_codigo: filtro_codigo, filtro_nome: filtro_nome, filtro_status: filtro_status}, function (retorno) {
        window.location.reload();
    });
}

function atualizaContratado(id_vagacandidato, nm_candidato, ds_email) {

    $("#img_contratar_" + id_vagacandidato).hide(1000);
    $("#img_contratado_" + id_vagacandidato).show(1000);
    $.post("../controle/ControleVaga.php?op=contrataCandidato", {id_vagacandidato: id_vagacandidato, nm_candidato: nm_candidato, ds_email: ds_email}, function (retorno) {

    });
}

function mostraCpfContato() {
    if (document.getElementById('formacaoContato').value === 'Esqueci Minha Senha') {
        document.getElementById('cpf_contato').style.display = 'block';
    } else {
        document.getElementById('cpf_contato').style.display = 'none';
    }
}

function escondeCNH() {
    //esconde o cnh a idade na vaga seja escolhida a opção até 16 ou até 18, caso contrário mostra.

    if (document.getElementById('ds_idade').value === "16") {
        document.getElementById('lb_cnh').style.display = "none";
        document.getElementById('ds_cnh').style.display = "none";
        //Seleciona o index 0, onde está marcado no select como vazio.
        document.getElementById('ds_cnh').selectedIndex = 0;
    } else if (document.getElementById('ds_idade').value === "18") {
        document.getElementById('lb_cnh').style.display = "none";
        document.getElementById('ds_cnh').style.display = "none";
        //Seleciona o index 0, onde está marcado no select como vazio.
        document.getElementById('ds_cnh').selectedIndex = 0;
    } else {
        document.getElementById('lb_cnh').style.display = "block";
        document.getElementById('ds_cnh').style.display = "block";
    }
}

/*##############################################################################
 *         BUSCAR BAIRRO PELA CHANGE DO CIDADE
 *##############################################################################*/
$(function ($) {
    $('#id_cidade').change(function () {

        var uf = $('#id_cidade').val();
        var op = 6;
        var options = '<option value="">Selecione</option>';


        $.post("../util/Utilidades.php", {op: op, id_cidade: uf}, function (retorno) {
            if (retorno != false) {
                options += retorno;
                document.getElementById('id_bairro').style.display = "block";
                document.getElementById('ds_bairro').value = "";
                document.getElementById('ds_bairro').style.display = "none";
                $('#id_bairro').html(options).show();
            } else {
                $('#id_bairro').html(options).show();
                document.getElementById('ds_bairro').value = "";
                document.getElementById('ds_bairro').style.display = "block";
                document.getElementById('id_bairro').style.display = "none";
            }
        });
    });
});

function bairroChange() {
    //var uf = $('#id_cidade').val();
    var uf = document.getElementById('id_cidade').value;
    var op = 6;
    var options = '<option value="">Selecione</option>';


    $.post("../util/Utilidades.php", {op: op, id_cidade: uf}, function (retorno) {
        if (retorno != false) {
            options += retorno;
            document.getElementById('id_bairro').style.display = "block";
            document.getElementById('ds_bairro').value = "";
            document.getElementById('ds_bairro').style.display = "none";
            $('#id_bairro').html(options).show();
        } else {
            $('#id_bairro').html(options).show();
            document.getElementById('ds_bairro').value = "";
            document.getElementById('ds_bairro').style.display = "block";
            document.getElementById('id_bairro').style.display = "none";
        }
    });
}

function esconder_profissao_lista(id_candidato, id_profissao, nm_profissao) {
    //Escondo a profissão
    $("#profissao_lista" + id_profissao).fadeOut(500);

    $.post("../controle/ControleCandidato.php?op=manutencao&form=9", {id_candidato: id_candidato, id_profissao: id_profissao}, function (retorno) {
        window.location.reload();
    });
}

function profissao_outra() {
    $('#label_nova_profissao').hide();
    $('#profissao_outra').fadeIn(1000);
}

function verifica_vazio_profissoes() {
    if (document.getElementById('profissoes').value === "") {
        alert("Campo em branco, escolha uma ou mais profissões para concorrer as vagas do banco de oportunidades");
        return false;
    }
}

function trocaImagemVerMais(imagem) {
    $("#imagem_ver_mais").attr("src", "../Utilidades/Imagens/bancodeoportunidades/" + imagem);
}
