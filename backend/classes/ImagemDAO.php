<?php
class ImagemDAO{

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

//-------------------Função para cadastrar novo uma nova imagem-----------------------//
//Registra a imagem no banco de dados
  public function insert($array, $file){

    session_start();

    //Verificando requisitos da imagem
    $upload = true;
    $extensao = pathinfo($file["name"],PATHINFO_EXTENSION);
    $nomeFinal = "tempFile.".$extensao;
    if ($file["size"] > 5120000) {
       $upload = false;
    }
    if($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "bmp" && $extensao != "svg") {
        $upload = false;
    }
    if (!$upload) {
      throw new InsertionException();

    }

    //Organizando imagem no servidor
    move_uploaded_file($file['tmp_name'], $nomeFinal);
    $fileSize = $file['size'];
    $img = fopen($nomeFinal, "r");
    $mysqlImg = addslashes(fread($img, $fileSize));

    //Instanciando objeto
    $novaImagem = new Imagem($array, $mysqlImg, $extensao);
    $novaImagem->setAdministradores_id($_SESSION['administrador']);

    //Conectando ao db
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);
    $resultado = mysqli_query($connection, "SELECT * FROM imagens");
    $linhas_ant = mysqli_num_rows($resultado);

    $sql = "INSERT INTO imagens (administradores_id, categorias_id, titulo, imagem, extensao)
            VALUES (".$novaImagem->getAdministradores_id().", '".$novaImagem->getCategorias_id()."', '".$novaImagem->getTitulo()."', '".$novaImagem->getImagem()."', '".$novaImagem->getExtensao()."')";

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

//---------------------Função para excluir uma imagem----------------------------//
  public function delete($id){
    session_start();
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM imagens
            WHERE id = ".$id;
    $resultado = mysqli_query($connection, $sql);
    $imagem = mysqli_fetch_assoc($resultado);
    if($imagem['administradores_id'] != $_SESSION['administrador']){
      throw new DeleteException();
    }

    $resultado = mysqli_query($connection, "SELECT * FROM imagens");
    $linhas_ant = mysqli_num_rows($resultado);

    $sql = "DELETE
            FROM imagens
            WHERE id = ".$id;

    $action = mysqli_query($connection, $sql);
    $resultado = mysqli_query($connection, "SELECT * FROM imagens");
    $linhas_pos = mysqli_num_rows($resultado);
    mysqli_close($connection);

    if($linhas_pos == $linhas_ant - 1){
      return true;
    }
    else return false;
  }
//-------------------Funções para recuperar imagens-----------------------------//
//Recuperar imagem pelo id
  public function getById($id){
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM imagens
            WHERE id = ".$id;

    $result = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($result);

    if ($linhas == 0) {
      mysqli_close($connection);
      throw new GetImageException();
    }
    else {
      $assoc = mysqli_fetch_assoc($result);
      $array = array( 'categorias_id' => $assoc['categorias_id'],
                      'titulo' => $assoc['titulo'],
                      'administradores_id' => $assoc['titulo']);
      $imagem = new Imagem($array, $assoc['imagem'], $assoc['extensao']);
      $imagem->setId($assoc['id']);
      mysqli_close($connection);
      $imagemPath = "../../frontend/img/ById/imagem.".$imagem->getExtensao();
      $file = fopen($imagemPath, "w");
      fwrite($file, $assoc['imagem']);
      fclose($file);
      return $imagem;
    }
  }

//Recuperar imagem pelo id do autor
  public function getByAdmin($id){
    $folderPath = "../../frontend/img/ByAdmin/";
    $this->cleanDirectory($folderPath);
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM imagens
            WHERE administradores_id = ".$id;

    $result = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($result);

    if ($linhas == 0) {
      mysqli_close($connection);
      throw new GetImageException();
    }
    else {
      for ($i=0; $i < $linhas; $i++) {
        $assoc = mysqli_fetch_assoc($result);
        $array = array( 'categorias_id' => $assoc['categorias_id'],
                        'titulo' => $assoc['titulo'],
                        'administradores_id' => $assoc['administradores_id']);
        $imagem = new Imagem($array, $assoc['imagem'], $assoc['extensao']);
        $imagem->setId($assoc['id']);
        $imagemPath = $folderPath.$i.".".$imagem->getExtensao();
        $file = fopen($imagemPath, "w");
        fwrite($file, $imagem->getImagem);
        fclose($file);
      }
      mysqli_close($connection);
      return $folderPath;
    }
  }
//Recuperar imagem por categoria
  public function getByCategory($id){
    $folderPath = "../../frontend/img/ByCategory/";
    $this->cleanDirectory($folderPath);
    $credentials = $this->get_mysql_credentials();
    $connection = mysqli_connect($credentials['host'], $credentials['login'], $credentials['senha'], $credentials['database']);

    $sql = "SELECT *
            FROM imagens
            WHERE categorias_id = ".$id;

    $result = mysqli_query($connection, $sql);
    $linhas = mysqli_num_rows($result);

    if ($linhas == 0) {
      mysqli_close($connection);
      throw new GetImageException();
    }
    else {
      for ($i=0; $i < $linhas; $i++) {
        $assoc = mysqli_fetch_assoc($result);
        $imagemPath = $folderPath.$i.".".$assoc['extensao'];
        $file = fopen($imagemPath, "w");
        fwrite($file, $assoc['imagem']);
        fclose($file);
      }
      mysqli_close($connection);
      return $folderPath;
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
}
?>
