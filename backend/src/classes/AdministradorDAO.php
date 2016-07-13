<?php
/*
*     A persistência dos dados é primeiramente implementada
*     em arquivos. Após a conclusão das classes e rotas, será
*     feita a optimização com implementação do banco de dados.
*/
class AdministradorDAO implements DefaultDAO{

    private function __construct(){
    }

//--------------------Função que instancia a classe DAO-----------------------//
    public static function getInstance() {
      static $instance = null;
      if (null === $instance) {
          $instance = new static();
      }
      return $instance;
    }
//-----------------------------Funções de login-------------------------------//
    public function validate($login, $senha){
      $file = fopen("../private/logindata/login.json",'r');
      $jsonStr = '';

      while(!feof($file)){
          $jsonStr .= fgets($file);
      }

      $arrayLogins = json_decode($jsonStr, true);
      for($i = 0; $i <= $this->getIdToUser()-1; $i++){
        if($arrayLogins[$i]['login'] == crypt($login, 'DcCnPd1') && $arrayLogins[$i]['senha'] == crypt($senha, 'DcCnPd1')){
          return $arrayLogins[$i]['id'];
        }
      }
      throw new ValidateException();
    }
//----------------------------Funções de cadastro-----------------------------//
//Cadastra no arquivo de login dos usuários
    private function cadastra($id, $login, $senha){
        $jsonToPrint = array( 'id' => $id,
                              'login' => crypt($login, 'DcCnPd1'),
                              'senha' => crypt($senha, 'DcCnPd1'));

        $oldFile = fopen('../private/logindata/login.json', "r") or die("Unable to open file!");
        $jsonStr = "";

        while(!feof($oldFile)){
            $jsonStr .= fgets($oldFile);
        }

        fclose($oldFile);

        json_encode($jsonToPrint);
        $newJson = json_decode($jsonStr, true);
        $newJson[] = $jsonToPrint;

        $newFile = fopen('../private/logindata/login.json', "w") or die("Unable to open file!");
        fwrite($newFile, json_encode($newJson));
        fclose($newFile);
    }
//Cadastra os dados no arquivo do usuário.
    private function insertData($login, $senha, $pNome, $sNome, $email){
      $jsonToPrint = array( 'id' => $id,
                            'login' => crypt($login, 'DcCnPd1'),
                            'senha' => crypt($senha, 'DcCnPd1'),
                            'primeiroNome' => $pNome,
                            'sobreNome' => $sNome,
                            'email' => $email
                            );

      json_encode($jsonToPrint);
      $newJson[] = $jsonToPrint;

      $newFile = fopen('../private/userdata/userdata-'.$id.'.json', "w") or die("Unable to open file!");
      fwrite($newFile, json_encode($newJson));
      fclose($newFile);
    }
//Chama as funções para o cadastro do usuário
    public function insert($array){
        $novoCandidato = new Candidato($array);
        $novoCandidato->setId();
        $this->cadastra($novoCandidato->getId(),
                        $novoCandidato->getLogin(),
                        $novoCandidato->getSenha());
        $this->insertData($novoCandidato->getLogin(),
                          $novoCandidato->getSenha(),
                          $novoCandidato->getPrimeiroNome(),
                          $novoCandidato->getSobreNome(),
                          $novoCandidato->getId(),
                          $novoCandidato->getEmail()
                          );
        return $novoCandidato;
    }
}
//------------------Funções para exclusão de administradores------------------//
//Função para excluir um administrador
  public function delete($object){
    $file = fopen("../private/userdata/userdata-".$object->id.".json", "r") or die("Candidato inexistente");
    $jsonStr = fgets($file);
    $candidato = json_decode($jsonStr);
    unlink($file);
    fclose($file);
  }
//Função para exluir todos os administradores
  public function deleteAll() {
    $file = fopen("../private/logindata/login.json", "w");
    fclose($file);
    for($i=0; $i<=getIdToUser()-1; $i++){
      $file = fopen("../private/userdata/userdata-".$i.".json", "w");
      unlink($file);
      fclose($file);
    }
  }
//---------------------------------Auxiliares---------------------------------//
//Retorna um administrador específico
  public function getById($id){
    try {
      $file = fopen("../private/userdata/userdata-".$id.'.json','r');
    }catch(Exception $e){
      return 0;
    }

    $jsonStr = '';
    while(!feof($file)){
      $jsonStr .= fgets($file);
    }
    fclose($file);
    $arrayCandidato = json_decode($jsonStr, true);

    $novoCandidato = new Candidato($arrayCandidato[0]);
    $novoCandidato->setId($arrayCandidato[0]['id']);
    return $novoCandidato;
  }
//Retorna todos os administradores
  public function getAll(){
    $file = fopen('../private/logindata/login.json', "r") or die("Unable to proceed!");
    while(!feof($file)){
      $candidatos .= fgets($file);
    }
    return $candidatos;
  }
//Função para validação de emails
  private function validateEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
?>
