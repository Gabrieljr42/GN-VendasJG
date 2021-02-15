function listaProdutos(arrayProdutos, arrayProdutosComprados){
    //Definição de variaveis
    var id;
    var nome;
    var preço;
    var Comprado = false;
    //For com o tamanho de arrayProdutos
    for(var i = 0; i != arrayProdutos.length; i++){
        //Dentro do Array Multi-dimensional -> [i][0] = ID do produto
        id = arrayProdutos[i][0];
        //Dentro do Array Multi-dimensional -> [i][1] = nome do produto
        nome = arrayProdutos[i][1];
         //Dentro do Array Multi-dimensional -> [i][2] = preço do produto
        preço = arrayProdutos[i][2];
        //Dentro do Array Multi-dimensional -> [i][3] = nome da imagem do produto
       if(arrayProdutos[i][3] != null){
        imagem = arrayProdutos[i][3];
       }
       else{
           imagem = null;
       }
       //fazendo a verificação se o produto já foi comprado
      
       for(j = 0; j != arrayProdutosComprados.length; j ++){
                if(arrayProdutosComprados[j][0] == id){
                    //Colocando o produto na lista de produtos esperando pagamento ou comprados
                    document.getElementById("ProdutosComprados").innerHTML += "<li class=\"liProduto\"><div class=\"cartao\"> <img class = \"Imagem\" src=\"../Imagens/Produtos/"+imagem+"\" alt=\"\" > <h1>"+nome+"</h1>  <p class=\"preço\">$"+preço+"</p> </li>";
                    comprado = true;
                    break;
                }
       }

        //Implementação dos produtos na div com id = "produtos"
        if(!comprado){
        document.getElementById("Produtos").innerHTML += "<li class=\"liProduto\"><div class=\"cartao\"> <img class = \"Imagem\" src=\"../Imagens/Produtos/"+imagem+"\" alt=\"\" > <h1>"+nome+"</h1>  <p class=\"preço\">$"+preço+"</p>  <button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#ModalForm\" onclick= \"pegandoID("+id+")\"> COMPRAR </button></li>";
        }
        comprado = false;
    }
}

function pegandoID(id){
//Procedimento com o objetivo de passar o id do produto escolhido para o Form com as informações do Cliente
document.getElementById("idProduto").value = id;
}

function validar(){
    //Função com o objetivo de validar o formulário que contem as informações do Cliente
    
    var nomeCliente = document.forms['clienteForm']['nomeCliente'].value;
    var cpfCliente = document.forms['clienteForm']['cpfCliente'].value; 
    var telefoneCliente = document.forms['clienteForm']['telefoneCliente'].value; 
    
    //Campo "nomeCliente" vazio
    if(nomeCliente == ''){
        document.getElementById("nomeInput").className = "form-control is-invalid";
        return false;
    }else{
        document.getElementById("nomeInput").className = "form-control is-valid";
    }

    //Campo "telefoneCliente" com valores fora do esperado
    //isNaN verifica se existe apenas números dentro da variavel

    if(telefoneCliente.length != 11 || isNaN(telefoneCliente)){
        document.getElementById("telefoneInput").className = "form-control is-invalid";
        return false;
    }else{
        document.getElementById("telefoneInput").className = "form-control is-valid";
    }

    //Campo "cpfCliente" com valores fora do esperado
     //isNaN verifica se existe apenas números dentro da variavel
    if(cpfCliente.length != 11 || isNaN(cpfCliente)){
        document.getElementById("cpfInput").className = "form-control is-invalid";
        return false;
    }else{
        document.getElementById("cpfInput").className = "form-control is-valid";
    }
}
function urlTest(){
     //Pegando variaveis que são passadas pela URL após a compra

     const queryString = window.location.search;
     const urlPara = new URLSearchParams(queryString);
     if(!urlPara.has('idBoleto')){
         
     }else{
        var idBoleto = urlPara.get('idBoleto');
        var pdfLink = urlPara.get('pdfLink');
        document.getElementById("pdfLink").innerHTML += "<a href=\""+pdfLink+"\">Link para download</a><br><br>"
        document.getElementById("idBoleto").innerHTML += idBoleto;
        $('#modalInfo').modal({backdrop: 'static', keyboard: false})    
     }
     if(!urlPara.has('erro')){

     }else{
        var erro = urlPara.get('erro');
        var codigo = urlPara.get('code');
        var descricao = urlPara.get('descriçao');

        document.getElementById("erroModal").innerHTML +="<div><n>Código<n> : "+codigo+"<br><n>Erro:<n> "+erro+"<br>Descrição : "+descricao+"<br></div>";
        $('#modalErro').modal({backdrop: 'static', keyboard: false}) 
     }
    
}

