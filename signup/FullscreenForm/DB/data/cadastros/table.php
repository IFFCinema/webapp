<!-- Projeto experimental de código aberto do 4º Módulo do Curso Técnico Concomitante em Informática, 2015.2 -->

<!--
	* Bons programadores são curiosos mesmo, relaxa.
	* Bem-vind@ ao nosso código-fonte.
	* Use o que precisar, é de código aberto!
	* acesse: https://github.com/IFFCinema/webapp
	* Nós <3 open source. E se você está aqui, você também ama tanto quanto nós. Sinta-se em casa.
 -->
<?php
include("../security.php");
protegePagina();


/* REGISTRO DE ACESSO DE USUÁRIO -- início */
$arquivo = "./acessos.log";

$ip = ($_SERVER['REMOTE_ADDR']);
$browser = ($_SERVER['HTTP_USER_AGENT']);
$data = date('d/m/Y H:i:s');
/* REGISTRO DE ACESSO DE USUÁRIO -- fim */

$host = '127.0.0.1';
$user = 'root';
$password = 'fvs38795';
$database = 'cadastro';

$link = mysql_connect($host, $user, $password);
if (!$link) {
  die('Desculpe, não foi possível conectar-se ao servidor.<br><b>ERRO: </b> ' . mysql_error());
}
mysql_select_db ($database, $link);

echo "<!DOCTYPE HTML>";
echo "<html lang='pt-BR'>";
echo "<head>";
echo "<meta charset='utf-8'>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='5;URL=table.php' >";
echo "<title>ACESSO RESTRITO | Exibindo os dados da tabela - Cinema no IFF</title>";
echo "</head'>";
echo "<body bgcolor='#000'>";
echo "<header align='middle'>";
echo "<font color='#fff'>";
echo "<p align='left'>Olá, " . $_SESSION['usuarioNome']." - <a href='./logout.php'><font color='#fff'>encerrar sessão</font></a>";
echo "</p></font>";
echo "<div><!-- begin only for Mozilla Firefox --><center><!-- end only for Mozilla Firefox --><a target='_blank' href='http://www.iff.edu.br/' title='IFFluminense'><span><img src='logo_iff.png'></span></a></div><p align='middle'><br><font color='#fff' size='3.2px'><b>Mostra de Cinema Alternativo do Instituto Federal Fluminense</b><br><span><i>campus</i> Campos-Centro</span></font></p><br><!-- begin only for Mozilla Firefox --></center><!-- end only for Mozilla Firefox --></div>";
echo "</header>";
$consulta = "select * from reserva";
$resultado = mysql_query ($consulta, $link);
$quant = mysql_num_rows($resultado);
echo "<font color='#fff'>";
for($i=0;$i<$quant;$i++){
    $matricula = mysql_result($resultado,$i,"matricula");
    $nome = mysql_result($resultado,$i,"nome");
    $email = mysql_result($resultado,$i,"email");
    $dataNasc = mysql_result($resultado,$i,"dataNasc");
    $sessao = mysql_result($resultado,$i,"sessao");

    echo "<center>
          <table border='1' width='30%' align='middle'>
          <font color='#fff'>
            <th colspan='2' align='middle'>DADOS DA RESERVA</th>
            <tr>
              <td align='middle'>Matrícula:</td>
              <td align='middle'>".$matricula."</td>
            </tr>
            <tr>
              <td align='middle'>Nome:</td>
              <td align='middle'>".$nome."</td>
            </tr>
            <tr>
              <td align='middle'>E-mail:</td>
              <td align='middle'>".$email."</td>
            </tr>
            <tr>
              <td align='middle'>Data de nascimento:</td>
              <td align='middle'>".$dataNasc."</td>
            </tr>
            <tr>
              <td align='middle'>Sessão:</td>
              <td align='middle'>".$sessao."</td>
            </tr>
          </font>
          </table>
          </center>
    ";
}

//ARQUIVO LOG

	if (strchr($browser, 'Firefox'))
	  {
	    $nav = '<img src="images/firefox.png" /> Firefox ';
	  }
	  elseif (strchr($browser, 'Chromium'))
	  {
	    $nav = '<img src="images/chromium.png" /> Chromium ';
	  }
	  elseif (strchr($browser, 'Chrome'))
	  {
	    $nav = '<img src="images/chrome.png" /> Chrome ';
	  }
	  elseif (strchr($browser, 'Opera'))
	  {
	    $nav = '<img src="images/opera.png" /> Opera ';
	  }
	  elseif (strchr($browser, 'MSIE'))
	  {
	    $nav = '<img src="images/msie.png" /> Internet Explorer ';
	  }elseif (strchr($browser, 'Epiphany')){

	    $nav = '<img src="images/outro.png" /> Epiphany ';
	  }elseif (strchr($browser, 'Safari')){

	    $nav = '<img src="images/safari.png" /> Safari ';
          }else{
            $nav = '<img src="images/outro.png" /> Outro Navegador';
          }


        if (strchr($browser, 'Linux'))
           {
             $os = '<img src="images/linux.png" /> Linux ';
           }
           elseif (strchr($browser, 'Windows'))
           {
             $os = '<img src="images/windows.png" /> Windows ';
           }elseif(strchr($browser, 'MAC')){
             $os = '<img src="images/apple.png" /> MAC OSX';
           }else{
             $os = '<img src="images/os.png" /> Outro Sistema';
           }


	//PREPARA O CONTEÚDO A SER GRAVADO
	$conteudo	=	"IP: $ip - OS: ".strip_tags($os)." - Navegador: ".strip_tags($nav)." - Data/Hora: $data - User Agent (UA): $browser - Usuário: ". $_SESSION['usuarioNome']." -------\r\n\n";

	//TENTA ABRIR O ARQUIVO TXT
	if (!$abrir = fopen($arquivo, "a")) {
         echo  "Erro abrindo arquivo ($arquivo)";
         exit;
    }
	if($browser == 'Mozilla/5.0 (X11; Linux i686; rv:5.0) Gecko/20100101 Firefox/5.0')
        {
           fclose($abrir);
        }else{
	//ESCREVE NO ARQUIVO TXT
	if (!fwrite($abrir, $conteudo)) {
        print "Erro escrevendo no arquivo ($arquivo)";
        exit;
	//FECHA O ARQUIVO
	fclose($abrir);
        }
    }

echo "<p align='middle'><font color='#fff'>Número de registros até o momento: ".$quant."</font></p><br><p align='middle'><font color='#fff'>Gerar a <b><a target='_blank' href='static.php'><font color='#fff'>tabela do ODB</font></a></b>. A tabela ODB é uma tabela de acesso ao banco de dados MySQL gerada pelo LibreOffice Base. Para acessar os dados da tabela, tenha certeza de que você está conectado ao banco de dados 'cadastro' no servidor MySQL da máquina 'maracuja' ou 'passionFruit' (Ubuntu Server).</font></p>";
echo "
<!-- copyright -->
<footer>
  <p align='middle'>
    <br><br>
    <font size='2px'>feito com &#10084; no <i>campus</i> Campos-Centro<br>Projeto experimental interdisciplinar do 4º Módulo do Técnico Concomitante em Informática do Instituto Federal Fluminense, <i>campus</i> Campos-Centro</font><br><br>
    </span>
</p>
</footer>";
echo "</font></p>
      </font>";
echo "</body>";
echo "</html>";
mysql_close ($link);
?>
