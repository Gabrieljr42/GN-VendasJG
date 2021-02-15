<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   //Validação das informações recebidas pelo Cliente

   
    /*
    Error 0 = Nome do produto Inexistente 
    Error 1 = Preço inexistente

    Error 2 =  Nome do produto não condiz com o esperado
    Error 3 = Preço não condiz com o esperado
    
    */

   //Existência dos campos ou não
    if(!isset($_POST['nomeProduto'])){
        header("Location: createGUI.html?error=0");
        return;
    }

    if(!isset($_POST['preçoProduto'])){
        header("Location: createGUI.html?error=1");
        return;
    }

    //Campos Vazios ou não
    if(empty($_POST['nomeProduto'])){
        header("Location: createGUI.html?error=2");
        return;
    }
    if(empty($_POST['preçoProduto']) ){
        header("Location: createGUI.html?error=3");
        return;
        
    }

    // -- Coletando Dados do form -- //
   $nomeProduto = $_POST['nomeProduto'];
   $preçoProduto = $_POST['preçoProduto'];

   //Cliente passou dados corretos ou não
   if(strlen($nomeProduto) < 2 || strlen($nomeProduto) > 100){
        header("Location: createGUI.html?error=2");
        return;
    }

    if(!is_numeric($preçoProduto) || $preçoProduto < 5){
        header("Location: createGUI.html?error=3");
        return;
    }


   
    //Verificando se o Cliente colocou imagem do produto ou não.
    $imgProduto;
    if(isset($_FILES['imgProduto'])){
        if(!empty($_FILES['imgProduto']['name'])){
            //Salvando nome da imagem juntamente com um timeStamp 
            $imgProduto = time(). '_' . $_FILES['imgProduto']['name'];
            
            //Pegando o local onde a img foi salva temporariamente
            $tmp = $_FILES['imgProduto']['tmp_name'];

        }else{
           //Saindo do IF caso não exista imagem
        }
    }else{
        //Saindo do IF caso não exista imagem
    }

   //Conexão com o banco
   require_once $_SERVER['DOCUMENT_ROOT'] . '/BancoDeDados/Conexao.php';
   global $conexao;
   //Verificando se imagem existe ou não 
   if(empty($imgProduto)){
   $sql = "INSERT into produtos(nome, preço) VALUES('$nomeProduto', '$preçoProduto' );";
   }else{
    $Salvando = '../Imagens/Produtos/'.$imgProduto;
    move_uploaded_file($tmp,$Salvando);
    echo '<pre>' .print_r($_FILES['imgProduto']).'</pre>';
    $sql = $sql = "INSERT into produtos(nome, preço, imagem) VALUES('$nomeProduto', '$preçoProduto', '$imgProduto' );";
   }
   mysqli_query($conexao, $sql);
   $conexao->close();

   //Chamando a lista com todos os produtos
   header("Location: readGUI.php");
  }
?>