var modal = document.getElementById('modal-pcd');
var span = document.getElementsByClassName("close")[0];
var table = document.getElementById('modal-table');
var inputEmpresa = document.getElementById('empresaRelatorioDeficientesPorEmpresa');

$(document).ready(function(){
    $(".showModal").click(function() {
                
        $.ajax({
            url: 'trazerEncaminhadosPcd.php',
            type: 'POST',
            data: {
                empresa : $(this).data('empresa')
            },
            success: function(empresa){
                console.log(empresa);
                table.innerHTML = "";
                
                var rowEmpresa = table.insertRow(0);
                rowEmpresa.className = "table_admissao_cab modal-table-head";
                var cellEmpresa = rowEmpresa.insertCell(0);
                cellEmpresa.colSpan = 4;
                cellEmpresa.innerHTML = empresa.nm_empresa;
                
                var rowCabecalho = table.insertRow(1);
                rowCabecalho.className = "table_admissao_cab";
                var cabNome = rowCabecalho.insertCell(0);
                var cabDeficiencia = rowCabecalho.insertCell(1);
                var cabStatus = rowCabecalho.insertCell(2);
                var cabVaga = rowCabecalho.insertCell(3);
                
                cabNome.innerHTML = "Candidato";
                cabDeficiencia.innerHTML = "Deficiência";
                cabStatus.innerHTML = "Status";
                cabVaga.innerHTML = "Vaga";
                
                $.each(empresa.deficientes, function(i, deficiente){
                    var row = table.insertRow(i+2);
                    row.className = "table_admissao_row";
                    var cellNome = row.insertCell(0);
                    var cellDeficiencia = row.insertCell(1);
                    var cellStatus = row.insertCell(2);
                    var cellVaga = row.insertCell(3);

                    cellNome.innerHTML = deficiente.nm_candidato;
                    cellDeficiencia.innerHTML = deficiente.tp_deficiencia;
                    cellStatus.innerHTML = deficiente.ds_status;
                    cellVaga.innerHTML = deficiente.nm_profissao; 
                });
                
                inputEmpresa.value = empresa.id_empresa;
                modal.style.display = "block";
            },
            error : function(data){
                console.log('erro:');
                console.log(data);
            }
        });
        
    });
});

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}