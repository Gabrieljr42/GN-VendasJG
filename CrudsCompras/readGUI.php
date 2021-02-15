<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Produtos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"> </script>
    <link rel="stylesheet" type="text/css" href="../CSS/NavBar.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../CSS/readGUI.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../CSS/footer.css" media="screen" />
    <script type="text/javascript" src="../JS/readGUI.js"></script>
    
    <script>
      //Pegando produtos pelo server-side(php) e convertando para js
      var arrayProdutos, arrayProdutosComprados;  

      <?php  
         require_once $_SERVER['DOCUMENT_ROOT'] . '/CrudsCompras/readSQL.php';
         echo 'arrayProdutos = '.json_encode($arrayProdutos) . '; arrayProdutosComprados = '.json_encode($arrayProdutosComprados);
        
       ?>
    </script>
    
</head>
<body>
    <!-- NavBar -->
    <div>
        <ul class="ul">
          <li class="li"><a href="../Index.html"><img src="../Imagens/logo1.png" alt="PAGINA INICIAL" width="125" height="55"></a></li>
          <li class="li"><a href="CreateGUI.html"><h1>ADICIONAR PRODUTOS</h1></a></li>
          <li class="li"><a class="active" href="readGUI.php"><h1>COMPRAR PRODUTOS</h1></a></li>
        </ul>
      </div>

      <!-- Home Page-->
      <div class = "lista" id="Produtos"><H1><b> PRODUTOS DISPONIVEIS </H1><div><ul class="ulProduto"></ul><!--listaProdutos() Prenche esse ul com os produtos --> </div></div></div>
      <div class = "lista" id="ProdutosComprados"><H1><b> PRODUTOS AGUARDANDO PAGAMENTO OU JÁ PAGOS </H1><div><ul class="ulProduto"></ul><!--listaProdutos() Prenche esse ul com os produtos --> </div></div></div>
      
      <div class="footer"><H1>GNVENDAS</H1></div>

        
</body>
    <!-- Modal para pegar Nome, Telefone e CPF -->
<div class="modal fade" id="ModalForm" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalCentralizado">Insira sua informações para finalizar a compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- Form para pegar nome, telefone, cpf-->
        <form action="BoletoMaker.php" method="POST" name="clienteForm" onsubmit= "return validar()">

          <!-- Input para conseguir o nome-->
         <div class="form-group">
            <label for="formNome">Nome :</label>
            <input name = "nomeCliente" type="text" class="form-control" id="nomeInput" placeholder="Insira seu nome" required>
            <small id="NomeLegenda" >Insira nome e SobreNome</small>
         </div>
         <!-- Input para conseguir o telefone -->
         <div class="form-group">
            <label for="formTelefone">Telefone :</label>
            <input type="text" class="form-control" name="telefoneCliente" id="telefoneInput" placeholder="Insira seu telefone" min="11" max="11" required>
         </div>
         <!-- Input para conseguir o CPF-->
         <div class="form-group">
            <label for="formCPF">CPF :</label>
            <input type="text" class="form-control" id="cpfInput" name="cpfCliente" placeholder="Insira seu CPF" required>
         </div>
         <!-- input para passar o ID do produto juntamente com nome,telefone e CPF-->
         <input name="idProduto" id="idProduto" type="hidden"  />

         <button type="submit" class="btn btn-primary">Finalizar Compra</button>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
      
        
       
      </div>
    </div>
  </div>
</div>
  
<!-- Modal que aparece após uma compra, contendo as informações do pdf e id do boleto-->
<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalCentralizado">PARABÉNS PELA COMPRA!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div>
            <h3 id="pdfLink" style="width: max-content; height: max-content;">PDF BOLETO: <br></h1>
            <h4 id="idBoleto">ID DO SEU BOLETO: </h4>
          </div>
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
  </div>
</div>

<!-- Modal que aparece caso ocorra algum erro em "BoletoMaker"-->
<div class="modal fade" id="modalErro" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalCentralizado">ERRO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="erroModal">
        
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
  </div>
</div>
<script>
//Executa procedimentos quando página estiver totalmente carregada
window.onload = listaProdutos(arrayProdutos,arrayProdutosComprados);
window.onload = urlTest();
</script>

</html>