Site feito com o objetivo de responder ao teste técnico da Gerencia Net
Por João Gabriel Alves Junior

# INSTALAÇÃO DO SITE
- Criação do Banco de dados que foi feito em MYSQL que se encontra no final desse README.md(O Código foi criado com um bando de dados local, mas caso deseje mudar entre na pasta "../banco de dados/conexão.php" )
- Instalçao do projeto que se encontra pelo git hub e em um link do google drive, LINKS:
 git hub : https://github.com/Gabrieljr42/GN-VendasJG 
 Google Drive : https://drive.google.com/drive/folders/1tjEzzURV_NkabGKHPSN44SIrotFGezzn?usp=sharing;

 Uma das possiveis formas de instação do projeto é atraves de um local server, sera utlizado WAMP((https://sourceforge.net/projects/wampserver/)) para demonstração, TUTORIAL :

 (Vídeo com explicação detalhada : https://www.youtube.com/watch?v=BPhp3hddSt8 (no lugar de cursophp seria colocado GNVendas.com))

    1-> Localize no computador o diretório onde o Wamp Server foi instalado. Abra a pasta "www".
    2-> Dentro da pasta "www", faça o download do projeto e o coloque lá, colocando no final do nome da pasta um ".com". Ficando no final com : ../www/GNVendas.com
    3-> Abra o bloco de notas do Windows como Administrador (clique com o botão direito do mouse sobre o ícone do Bloco de Notas)
    4-> Localize a pasta onde está instalado o seu Wamp Server
    5-> Localize a pasta "bin --> apache --> apache2.4.23 --> conf --> extra" . No nosso exemplo o caminho ficaria assim: C:/wamp/bin/apache/apache2.4.23/conf/extra
    6-> Altere de "Documentos de texto" para Todos Arquivos (*.*). Abra o arquivo httpd-vhosts.config.
    7-> Dentro do arquivo cole o sequinte script :
<VirtualHost *:80>
  ServerName GNVendas.com
  ServerAlias GNVendas.com
  DocumentRoot "${INSTALL_DIR}/www/GNVendas.com"
  <Directory "${INSTALL_DIR}/www/GNVendas.com">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
  </Directory>
</VirtualHost>
8-> Reinicie o DNS. Clique com o botão direito do mouse sobre o ícone do Wamp e em [Ferramentas] selecione [Reiniciar DNS].
9-> No navegador que desejar digite : GNVendas.com  







PS: 1 -> Para o upload de imagens maior do que 2M é necessario modificar o arquivo php.ini do seu código php.(linha "upload_max_filesize")
    2 -> Erros na instação do WAMP : https://loiane.com/2012/03/instalando-apache-php-mysql-no-windows-com-wamp/
    


SCRIPT PARA O BANDO DE DADOS :


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gnvendas`
--
CREATE DATABASE IF NOT EXISTS `gnvendas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `gnvendas`;

-- --------------------------------------------------------
--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `preço` double DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



--
-- Estrutura da tabela `compras`
--

DROP TABLE IF EXISTS `compras`;
CREATE TABLE IF NOT EXISTS `compras` (
  `id_produto` int NOT NULL,
  `idBoleto` varchar(7) COLLATE utf8_bin DEFAULT NULL,
  `pdfLink` varchar(90) COLLATE utf8_bin DEFAULT NULL,
  FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`),
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
