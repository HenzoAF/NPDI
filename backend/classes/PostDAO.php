<?php
class PostDAO{

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

//-------------------Função para cadastrar novo um post-----------------------//
//Registra o post no banco de dados
  public function insert($array){

    session_start();
    $novoPost = new Post($array);
    $novoPost->setAutorId($_SESSION['administrador']);
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);
    $resultado = mysqli_query($connection, "SELECT * FROM posts");
    $linhas_ant = mysqli_num_rows($resultado);

    $sql = "INSERT INTO posts (administradores_id, data_criacao, titulo, texto)
            VALUES (".$novoPost->getAutorId().", '".$novoPost->getData()."', '".$array['titulo']."', '".$array['texto']."')";

    $action = mysqli_query($connection, $sql);
    $resultado = mysqli_query($connection, "SELECT * FROM posts");
    $linhas_pos = mysqli_num_rows($resultado);
    mysqli_close($connection);
    if($linhas_pos = $linhas_ant + 1){
      return $novoPost;
    }
    else throw new InsertionException();

  }

//---------------------Função para excluir um post----------------------------//
  public function delete($id){
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);
    $resultado = mysqli_query($connection, "SELECT * FROM posts");
    $linhas_ant = mysqli_num_rows($resultado);

    $sql = "DELETE
            FROM posts
            WHERE id = ".$id;

    $action = mysqli_query($connection, $sql);
    $resultado = mysqli_query($connection, "SELECT * FROM posts");
    $linhas_pos = mysqli_num_rows($resultado);
    mysqli_close($connection);

    if($linhas_pos == $linhas_ant - 1){
      return true;
    }
    else return false;
  }
//-------------------Funções para recuperar posts-----------------------------//
//Recuperar post pelo id
  public function getById($id){
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM posts
            WHERE id = ".$id;

    $result = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($result);

    if ($linhas == 0) {
      mysqli_close($connection);
      throw new GetPostException();
    }
    else {
      $assoc = mysqli_fetch_assoc($result);
      $array = array( 'data' => $assoc['data_criacao'],
                      'titulo' => $assoc['titulo'],
                      'texto' => $assoc['texto']);
      $post = new Post($array);
      $post->setId($assoc['id']);
      $post->setAutorId($assoc['administradores_id']);
      mysqli_close($connection);
      return $post;
    }
  }

//Recuperar post pelo id do autor
  public function getByAuthor($id){
    $posts = [];
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM posts
            WHERE administradores_id = ".$id;

    $result = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($result);

    if ($linhas == 0) {
      mysqli_close($connection);
      throw new GetPostException();
    }
    else {
      for ($i=0; $i < $linhas; $i++) {
        $post = mysqli_fetch_assoc($result);
        $array = array( 'data' => $post['data_criacao'],
                        'titulo' => $post['titulo'],
                        'texto' => $post['texto']);
        $posts[$i] = new Post($array);
        $posts[$i]->setId($post['id']);
        $posts[$i]->setAutorId($post['administradores_id']);
      }
      mysqli_close($connection);
      return $posts;
    }
  }
//Recuperar posts para paginação
  public function getByPage($pag, $quant){
    $initialIndex = $quant * $pag;
    $finalIndex = $initialIndex + $quant;
    $posts = [];
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM posts
            WHERE administradores_id = ".$id;

    $result = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($result);

    if ($linhas == 0) {
      mysqli_close($connection);
      throw new GetPostException();
    }
    else {
      for ($i=$initialIndex; $i < $linhas && $i < $finalIndex; $i++) {
        $post = mysqli_fetch_assoc($result);
        $array = array( 'data' => $post['data_criacao'],
                        'titulo' => $post['titulo'],
                        'texto' => $post['texto']);
        $posts[$initialIndex - $i] = new Post($array);
        $posts[$initialIndex - $i]->setId($post['id']);
        $posts[$initialIndex - $i]->setAutorId($post['administradores_id']);
      }
    }
    mysqli_close($connection);
    return $posts;
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
?>
