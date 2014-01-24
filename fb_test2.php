<?php
// incluir o sdk do facebook
require_once('libs/facebook/src/facebook.php');
  
// Configure abaixo o appId e secret do seu aplicativo
$facebook = new Facebook(array(
  'appId'  => '390907424378928',
  'secret' => 'cb62dc04dd6104b49ef5049bed89183f',
));
  
// verifica se o usuário já esta logado no aplicativo
$user = $facebook->getUser();
if ($user) { 
        try {
        // Obtem dados do profile do usuario logado
        // o app terá acesso somente os dados públicos
            $user_profile = $facebook->api('/me');
  
            // exibe foto do usuario 
            echo "<img src='https://graph.facebook.com/$user/picture' />";
  
            // printa os dados públicos do profile do usuario 
        echo "<pre>";
        print_r($user_profile);
        echo "</pre>";
  
        } catch (FacebookApiException $e) {
        // tratamento de erro
                print_r($e);
        }
} else {
        // usuario não logado, solicitar autenticação
        $loginUrl = $facebook->getLoginUrl();
        echo "<a href='$loginUrl'>Conectar no aplicativo</a><br />";
        echo "<strong><em>Voc&ecirc; n&atilde;o esta conectado..</em></strong>";
}
?>