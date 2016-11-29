<?php
class CategoriaDAO{

  private function __construct(){
  }

  function __destruct(){
  }

//--------------------Função que instancia a classe DAO-----------------------//
  public static function getInstance() {
    static $instance = null;
    if (null === $instance) {
        $instance = new static();
    }
    return $instance;
  }

//-------------------Função para cadastrar novo uma nova categoria-----------------------//
//Registra a categoria no banco de dados
  public function insert($array){

    session_start();

    $novaCategoria = new Categoria($array);
    $novaCategoria->setAdministradores_id($_SESSION['administrador']);

    //Conectando ao db
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);
    $resultado = mysqli_query($connection, "SELECT * FROM categorias");
    $linhas_ant = mysqli_num_rows($resultado);

    $sql = "INSERT INTO categorias (administradores_id, privacidade, titulo, descricao)
            VALUES (".$novaCategoria->getAdministradores_id().", '".$novaCategoria->getPrivacidade()."', '".$novaCategoria->getTitulo()."', '".$novaCategoria->getDescricao()."')";

    $action = mysqli_query($connection, $sql);
    $resultado = mysqli_query($connection, "SELECT * FROM posts");
    $linhas_pos = mysqli_num_rows($resultado);
    mysqli_close($connection);
    unlink($nomeFinal);
    if($linhas_pos = $linhas_ant + 1){
      return $novaImagem;
    }
    else throw new InsertionException();

  }

//---------------------Função para excluir uma categoria----------------------------//
  public function delete($id){

    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM categorias
            WHERE id = ".$id;
    $resultado = mysqli_query($connection, $sql);
    $categoria = mysqli_fetch_assoc($resultado);
    if ($categoria['administradores_id'] != $_SESSION['administrador'] && $categoria['privacidade'] < 3) {
      throw new DeleteException();
    }

    $sql = "DELETE
            FROM imagens
            WHERE categorias_id = ".$id;
    $action = mysqli_query($connection, $sql);

    $resultado = mysqli_query($connection, "SELECT * FROM categorias");
    $linhas_ant = mysqli_num_rows($resultado);

    $sql = "DELETE
            FROM categorias
            WHERE id = ".$id;

    $action = mysqli_query($connection, $sql);
    $resultado = mysqli_query($connection, "SELECT * FROM categorias");
    $linhas_pos = mysqli_num_rows($resultado);
    mysqli_close($connection);

    if($linhas_pos == $linhas_ant - 1){
      return true;
    }
    else return false;
  }
//-------------------Funções para recuperar categorias-----------------------------//
//Recuperar categoria pelo id
  public function getById($id){
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM categorias
            WHERE id = ".$id;

    $result = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($result);

    if ($linhas == 0) {
      mysqli_close($connection);
      throw new GetCategoryException();
    }
    else {
      $assoc = mysqli_fetch_assoc($result);
      $categoria = new Categoria($assoc);
      $categoria->setId($assoc['id']);
      $categoria->setAdministradores_id($assoc['administradores_id']);
      mysqli_close($connection);
      return $categoria;
    }
  }
//-------------------------------Auxiliares-----------------------------------//
  function get_mysql_credentials(){
    $file = fopen("../private/credentials.json", "r");
    $jsonStr = '';

    while(!feof($file)){
        $jsonStr .= fgets($file);
    }

    $credentials = json_decode($jsonStr, true);
    return $credentials[0];
  }
}
function cleanDirectory($directory){
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) {
            cleanDirectory($file);
            rmdir($file);
        }
        else {
            unlink($file);
        }
    }
}
?>
