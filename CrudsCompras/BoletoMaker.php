<?php




    require __DIR__ . '/../Bibliotecas/vendor/autoload.php'; // caminho relacionado a SDK

   use Gerencianet\Exception\GerencianetException;
   use Gerencianet\Gerencianet;

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Validação dos dados recebidos

    //Verificando existência do campo "nomeCliente", "cpfCliente", "telefoneCliente"
    if(!isset($_POST['nomeCliente']) || !isset($_POST['cpfCliente']) || !isset($_POST['telefoneCliente'])){
        header("Location: readGUI.php?error=1");
        return;
    }
    //Pegando as informações passadas pelo form
    $nomeCliente = $_POST["nomeCliente"];
    $telefoneCliente = $_POST["telefoneCliente"];
    $cpfCliente = $_POST["cpfCliente"];

   //Verificando se os parâmentros estão corretos(NomeCliente != 0, cpf != 11, telefone != 11, cpf apenas números, telefone apenas números)
    if(strlen($nomeCliente) == 0 || strlen($cpfCliente) != 11 || strlen($telefoneCliente) != 11|| !is_numeric($telefoneCliente) || !is_numeric($cpfCliente)){
        header("Location: readGUI.php?error=0");
        return;
    }


    //Pegando,  atraves do ID, as informações do produto escolhido pelo cliente

    //Conexão 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/BancoDeDados/Conexao.php';
    global $conexao;

    $idProduto = $_POST['idProduto'];
    //Chamando as informações do Banco do Dados
    $sql = "SELECT nome, preço from Produtos where id = '$idProduto';";
    $resultado= mysqli_query($conexao, $sql);

    

    //Salvar as informações em um Array chamado arrayProdutos
    $arrayProdutos = [];
    if (mysqli_num_rows($resultado) != 0) {
      while ($row = mysqli_fetch_array($resultado)) {
         array_push($arrayProdutos, $row);
        }
    }
    //Dentro do Array Multi-Dimensional -> [0][0] = nome do Produto
    $nomeProduto = $arrayProdutos[0][0];
    //Dentro do Array Multi-Dimensional -> [0][1] = preço do Produto
    $preçoProduto = $arrayProdutos[0][1];
    //Conversão de preçoProduto de double para INT
    $preçoProduto = $preçoProduto * 100;
    echo $preçoProduto , $nomeProduto;

    //Pegando a data de hoje para gerar a data de válidade logo em seguida
    $dia = (date("d")+2);
    $Mes = date("m");
    $Ano = date("Y");
    $dataDeVencimento = ($Ano.'-'.$Mes.'-'.$dia);

   }

    //Gerando o boleto  
   $clientId = 'Client_Id_4e4327e045ceb277ed5f62db8c46c399c309e0bf';// insira seu Client_Id, conforme o ambiente (Des ou Prod)
   $clientSecret = 'Client_Secret_bb1ad596c70e1c17089cd27ec860816670412681'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

    $options = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
    ];
   
    $item_1 = [
        'name' => $nomeProduto, // nome do item, produto ou serviço
        'amount' => 1, // quantidade
        'value' => $preçoProduto // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
    ];
    $items = [
        $item_1
    ];
    $metadata = array('notification_url'=>'http://gnvendas.com/CrudsCompras/BoletoMaker.php'); //Url de notificações
    $customer = [
        'name' => $nomeCliente, // nome do cliente
        'cpf' => $cpfCliente, // cpf válido do cliente
        'phone_number' => $telefoneCliente, // telefone do cliente
    ];
    $discount = [ // configuração de descontos
        'type' => 'currency', // tipo de desconto a ser aplicado
        'value' => 599 // valor de desconto 
    ];
    $configurations = [ // configurações de juros e mora
        'fine' => 200, // porcentagem de multa
        'interest' => 33 // porcentagem de juros
    ];
    $conditional_discount = [ // configurações de desconto condicional
        'type' => 'percentage', // seleção do tipo de desconto 
        'value' => 500, // porcentagem de desconto
        'until_date' => '2019-08-30' // data máxima para aplicação do desconto
    ];
    $bankingBillet = [
        'expire_at' => $dataDeVencimento, // data de vencimento do titulo
        'message' => 'teste\nteste\nteste\nteste', // mensagem a ser exibida no boleto
        'customer' => $customer,
        //'discount' =>$discount,
        //'conditional_discount' => $conditional_discount
    ];
    $payment = [
        'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
    ];
    $body = [
        'items' => $items,
        'metadata' =>$metadata,
        'payment' => $payment
    ];
    try {
        
      $api = new Gerencianet($options);    
      $pay_charge = $api->oneStep([],$body);
      
      echo '<pre>';
      print_r($pay_charge);
      echo '<pre>';
      
      //Definindo DATA em variaveis
      $idBoleto = $pay_charge['data']['charge_id'];
      $pdfLink = $pay_charge['data']['pdf']['charge'];

      //Salvando informações dentro do banco de dados
      global $conexao;
      $sql = "Insert into compras(id_produto,idBoleto,pdfLink) values ('$idProduto','$idBoleto','$pdfLink');";
      mysqli_query($conexao, $sql);

      header("Location: readGUI.php?pdfLink=$pdfLink&idBoleto=$idBoleto");
    //Fecha conexão
    $conexao-> close();

     } catch (GerencianetException $e) {
        //print_r($e->code);
        //print_r($e->error);
        //print_r($e->errorDescription);
        header("Location: readGUI.php?erro=$e->error&code=$e->code&descriçao=".$e->errorDescription['message']);;
        

    } catch (Exception $e) {
        //print_r($e->getMessage());
        header("Location: readGUI.php?erro=".$e->getMessage());
    }
