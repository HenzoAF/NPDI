<?php
class CandidatoDAO implements DefaultDAO{

  private function __construct(){
  }

//Função que instancia a classe DAO
  public static function getInstance() {
    static $instance = null;
    if (null === $instance) {
        $instance = new static();
    }
    return $instance;
  }
//Funções de login
  public function validate($login, $senha){
    $file = fopen("../private/logindata/login.json",'r');
    $jsonStr = '';

    while(!feof($file)) $jsonStr .= fgets($file);

    $arrayLogins = json_decode($jsonStr, true);
    if($arrayCandidato[0]['login']==crypt($login, 'DcCnPd1')&&$arrayCandidato[0]['senha']==crypt($senha, 'DcCnPd1')){
      
    }
  }
}
?>
