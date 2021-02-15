//Pegando variaveis que são passadas pela URL

 /*
    Error 0 = Nome do produto Inexistente 
    Error 1 = Preço inexistente

    Error 2 =  Nome do produto não condiz com o esperado
    Error 3 = Preço não condiz com o esperado
    
    
    */
function urlTest(){

    //Pegando variaveis que são passadas pela URL

    const queryString = window.location.search;
    const urlPara = new URLSearchParams(queryString);
    if(!urlPara.has('error')){
        return;
    }else{
        var error = urlPara.get('error');
        switch(error){
        case '0' :
                document.getElementById("nomeInput").className = "form-control is-invalid";
                alert("Erro com campo nome")
                break;
        case '1' :
                 document.getElementById("preçoInput").className = "form-control is-invalid";
                 alert("Erro com campo preço")
                 break;
            
        case '2' :
                document.getElementById("nomeInput").className = "form-control is-invalid";
                break;

        case '3' :
                document.getElementById("preçoInput").className = "form-control is-invalid";
                break;       
        }
    }

}

function validar(){
    //Validação do form com informações sobre o produto
    var nomeProduto = document.forms['produtoForm']['nomeProduto'].value;
    var preçoProduto = document.forms['produtoForm']['preçoProduto'].value;
    
    //Campo "nomeProduto" é maior que 2 e menor que 150
    if(nomeProduto.length < 2 || nomeProduto.length >= 150){
        document.getElementById("nomeInput").className = "form-control is-invalid";
        return false;
    }else{
        document.getElementById("nomeInput").className = "form-control is-valid";
    }

    //Campo "preçoProduto" é númerico e maior do que 5.0
    if(isNaN(preçoProduto) || preçoProduto < 5.0){
         document.getElementById("preçoInput").className = "form-control is-invalid";
        return false;
    }else{
        document.getElementById("preçoInput").className = "form-control is-valid";
    }

}


