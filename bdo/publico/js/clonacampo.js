function duplicarFormacao(){  
    var clone = document.getElementById('origem_formacao').cloneNode(true);  
    var destino = document.getElementById('destino_formacao');  
    destino.appendChild (clone);  
      
    var camposClonados = clone.getElementsByTagName('input');
    var selectClonado = clone.getElementsByTagName('select');
   
      
    for(i=0; i<camposClonados.length;i++){ 
        camposClonados[i].value = '';  
    }  
    for(j=0; j<selectClonado.length;j++){ 
        selectClonado[j].value = '';  
    } 
}  

function duplicarExperiencia(){  
    var clone = document.getElementById('origem_experiencia').cloneNode(true);  
    var destino = document.getElementById('destino_experiencia');  
    destino.appendChild (clone);  
      
    var camposClonados = clone.getElementsByTagName('input');  
      
    for(i=0; i<camposClonados.length;i++){  
        camposClonados[i].value = '';  
    }
}  

function duplicarQualificacao(){  
    var clone = document.getElementById('origem_qualificacao').cloneNode(true);  
    var destino = document.getElementById('destino_qualificacao');  
    destino.appendChild (clone);  
      
    var camposClonados = clone.getElementsByTagName('input');  
      
    for(i=0; i<camposClonados.length;i++){  
        camposClonados[i].value = '';  
    }  
}  




function removerFormacao(id){  
    var node1 = document.getElementById('destino_formacao');
    node1.removeChild(node1.childNodes[0]);
}

function removerExperiencia(id){  
    var node1 = document.getElementById('destino_experiencia');  
    node1.removeChild(node1.childNodes[0]);  
}  

function removerQualificacao(id){  
    var node1 = document.getElementById('destino_qualificacao');  
    node1.removeChild(node1.childNodes[0]);  
}  




/************* teste ******************/

function duplicarFormacao2(id){
    var div = 'origem_formacao'+id;
    
    var clone = document.getElementById(div).cloneNode(true);  
    var destino = document.getElementById('destino_formacao');  
    destino.appendChild (clone);  
      
    var camposClonados = clone.getElementsByTagName('input');
    var selectClonado = clone.getElementsByTagName('select');
   
      
    for(i=0; i<camposClonados.length;i++){ 
        camposClonados[i].value = '';  
    }  
    for(j=0; j<selectClonado.length;j++){ 
        selectClonado[j].value = '';  
    } 
      
      
}

function duplicarFormacao3(){
    
    var clone = document.getElementById('destino_formacao').cloneNode(true);  
    var destino = document.getElementById('destino_formacao');  
    destino.appendChild (clone);  
      
    var camposClonados = clone.getElementsByTagName('input');
    var selectClonado = clone.getElementsByTagName('select');
   
      
    for(i=0; i<camposClonados.length;i++){ 
        camposClonados[i].value = '';  
    }  
    for(j=0; j<selectClonado.length;j++){ 
        selectClonado[j].value = '';  
    } 
      
      
}

function removerFormacao2(id){
//    var elemento = document.getElementById('formacao_candidato');
//    elemento.remove(elemento.getElementsByTagName(id_div));
    
    
    var node1 = document.getElementById('destino_formacao');
    node1.removeChild(node1.childNodes[0]);
    
    /*
    var div = 'origem_formacao';
    var divOrigem = div+""+id;
    var node1 = document.getElementById(divOrigem);
    node1.removeChild(node1.childNodes[0]);
    
    removerFormacao(id);
    */
}

function duplicarQualificacao2(id){
    var div = 'origem_qualificacao'+id;
    
    var clone = document.getElementById(div).cloneNode(true);  
    var destino = document.getElementById('destino_qualificacao');  
    destino.appendChild (clone);  
      
    var camposClonados = clone.getElementsByTagName('input');  
      
    for(i=0; i<camposClonados.length;i++){  
        camposClonados[i].value = '';  
    }
   
}

function duplicarExperiencia2(id){  
    var div = 'origem_experiencia'+id;

    var clone = document.getElementById(div).cloneNode(true);
    var destino = document.getElementById('destino_experiencia');
    destino.appendChild (clone);

    var camposClonados = clone.getElementsByTagName('input');
    var textAreaClonado = clone.getElementsByTagName('textarea');
    
    for(i=0; i<camposClonados.length;i++){
        camposClonados[i].value = "";
    }
    for(j=0; j<textAreaClonado.length;j++){
        textAreaClonado[j].value = "";
    }
} 