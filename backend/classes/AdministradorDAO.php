<?php
class AdministradorDAO{

    private function __construct(){
    }

//--------------------Função que instancia a classe DAO-----------------------//
    static function getInstance() {
      static $instance = null;
      if (null === $instance) {
          $instance = new static();
      }
      return $instance;
    }
//------------------------Funções de login e logout---------------------------//
// Login
    function validate($login, $senha){
      session_start();
      $_SESSION['administrador'] = null;
      session_destroy();
      $credentials = $this->get_mysql_credentials();
      $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

      $sql = "SELECT *
              FROM administradores
              WHERE login = '".$login."' && senha = '".crypt($senha, 'DcCnPd1')."'";

      $resultado = mysqli_query($connection, $sql);
      $linhas = mysqli_num_rows($resultado);
      if ($linhas != 1) {
        throw new ValidateException();
      }
      else{
        $data = mysqli_fetch_assoc($resultado);
        mysqli_close($connection);
        $administrador = new Administrador($data);
        $administrador->setId($data['id']);
        session_start();
        $_SESSION['administrador'] = $administrador->getId();
      }

      if(!isset($_SESSION['administrador'])){
        throw new ValidateException();
      }
      else return true;

    }
// Logout
    function logout(){
      session_start();
      if(isset($_SESSION['administrador'])){
        $_SESSION['administrador'] = null;
        session_destroy();
        echo "you are loged out.";
      }
      else throw new LogoutException();
    }
//----------------------------Funções de cadastro-----------------------------//
//Verifica a disponibilidade das credenciais
    function verify($login){
      $credentials = $this->get_mysql_credentials();
      $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

      $sql = "SELECT *
              FROM administradores
              WHERE login = '".$login."'";

      $resultado = mysqli_query($connection, $sql);
      $linhas = mysqli_num_rows($resultado);
      mysqli_close($connection);
      if($linhas == 0){
        return true;
      }
      else return false;
    }
//Chama as funções para o cadastro do usuário
    function insert($array){
      session_start();
      if(isset($_SESSION['administrador'])){
        $novoAdministrador = new Administrador($array);
      }
      else throw new InsertionException();

      if ($this->verify($array['login']) && $this->validateEmail($array['email'])) {
        $credentials = $this->get_mysql_credentials();
        $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);
        $resultado = mysqli_query($connection, "SELECT * FROM administradores");
        $linhas_ant = mysqli_num_rows($resultado);

        $sql = "INSERT INTO administradores (login, senha, primeiro_nome, sobre_nome, email)
                VALUES ('".$array['login']."', '".crypt($array['senha'], 'DcCnPd1')."', '".$array['primeiro_nome']."', '".$array['sobre_nome']."', '".$array['email']."')";
        $action = mysqli_query($connection, $sql);

        $resultado = mysqli_query($connection, "SELECT * FROM administradores");
        $linhas_pos = mysqli_num_rows($resultado);
        mysqli_close($connection);

        if($linhas_pos == $linhas_ant + 1){
          return $novoAdministrador;
        }
        else throw new InsertionException();
      }

      else throw new InsertionException();
    }
//------------------Funções para exclusão de administradores------------------//
//Função para excluir um administrador
    function delete(){
      session_start();
      if(!isset($_SESSION['administrador'])){
        throw new DeleteException();
      }

      $credentials = $this->get_mysql_credentials();
      $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

      $sql = "DELETE
              FROM administradores
              WHERE id = ".$_SESSION['administrador'];

      $result = mysqli_query($connection, "SELECT * FROM administradores");
      $linhas_ant = mysqli_num_rows($result);

      $action = mysqli_query($connection, $sql);
      $result = mysqli_query($connection, "SELECT * FROM administradores");
      $linhas_pos = mysqli_num_rows($result);
      mysqli_close($connection);

      if ($linhas_pos == $linhas_ant - 1) {
        return true;
      }
      else {
        return false;
      }
    }
//Função para exluir todos os administradores
  function deleteAll() {
    session_start();
    if(!isset($_SESSION['administrador'])){
      throw new DeleteException();
    }

    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);
    $sql = "DROP TABLE administradores";
    $action = mysqli_query($connection, $sql);
    $sql = "CREATE TABLE administradores (id INT NOT NULL AUTO_INCREMENT,
								                          login VARCHAR(50) NOT NULL,
								                          senha VARCHAR(50) NOT NULL,
                                          primeiro_nome VARCHAR(50) NOT NULL,
                                          sobrenome VARCHAR(50),
                                          email VARCHAR(100) NOT NULL,
                                          PRIMARY KEY(id))";
    $action = mysqli_query($connection, $sql);
    $result = mysqli_query($connection, "SELECT * FROM administradores");
    $linhas = mysqli_num_rows($result);
    mysqli_close($connection);
    if($linhas == 0){
      return true;
    }
    else return false;
  }

//---------------------------------Auxiliares---------------------------------//
//Busca as credênciais para o banco de dados
  function get_mysql_credentials(){
    $file = fopen("../private/credentials.json", "r");
    $jsonStr = '';

    while(!feof($file)){
        $jsonStr .= fgets($file);
    }

    $credentials = json_decode($jsonStr, true);
    return $credentials[0];
  }
//Exclui todas as pastas e arquivos de um diretório
  function cleanDirectory($directory){
      foreach(glob("{$directory}/*") as $file)
      {
          if(is_dir($file)) {
              cleanDirectory($file);
              rmdir($file);
          } else {
              unlink($file);
          }
      }
  }
//Retorna um administrador específico
  function getById(){
    session_start();
    $id = $_SESSION['administrador'];
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = 'SELECT *
            FROM administradores
            WHERE id = '.$id;

    $resultado = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($resultado);

    if($linhas == 0){
      mysqli_close($connection);
      throw new GetUserException();
    }
    else{
      $data = mysqli_fetch_assoc($resultado);
      mysqli_close($connection);
      $administrador = new Administrador($data);
      return $administrador;
    }
  }
//Retorna todos os administradores
  function getAll(){
    $administradores = [];
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);
    $sql = 'SELECT * FROM administradores';
    $resultado = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($resultado);
    for ($i=0; $i < $linhas; $i++) {
      $administrador = mysqli_fetch_assoc($resultado);
      $administradores[$i] = new Administrador($administrador);
    }
    mysqli_close($connection);
    return $administradores;
  }
//Função para validação de emails
  function validateEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
//Retorna a quantidade usuários cadastrados
  function getNumDeUsuarios(){
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);
    $sql = 'SELECT * FROM administradores';
    $resultado = mysqli_query($conexao, $sql);
    $numUsuarios = mysqli_num_rows($resultado);
    mysqli_close($connection);
    return $numUsuarios;
  }
}
?>
