<?php
/*
*     A persistência dos dados é primeiramente implementada
*     em arquivos. Após a conclusão das classes e rotas, será
*     feita a optimização com implementação do banco de dados.
*/
class PostDAO implements DefaultDAO{

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

//-------------------Função para cadastrar novo um post-----------------------//
    public function newPost($id, $autor, $data, $titulo, $texto) {
      $jsonToPrint = array( "id" => $id,
                            "autor" => $autor,
                            "data" => $data,
                            "titulo" => $titulo,
                            "texto" => $texto);
      $file = fopen("posts.txt", "a+") or die ("Unable to open file!");
      fwrite($file, json_encode($jsonToPrint));
    }
?>
