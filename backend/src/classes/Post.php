<?php
//Classe para os posts de administradores
class Post{

//Atributos do post
  private $id;
  private $autor;
  private $data;
  private $titulo;
  private $texto;
  private static $idToPost;

//Construtor para a classe
  function __construct(array $data){
    $this->id = $this->getIdToPost();
    $this->incrementId();
    $this->autor = $data["autor"];
    $this->$data = date('l jS \of F Y h:i:s A');
    $this->titulo = $data["titulo"];
    $this->texto = $data["texto"];
  }
//Getters & Setters de...
//Id
  public function getId(){
    return $this->id;
  }
//Autor
  public function getAutor(){
    return $this->autor;
  }
//Data
  public function getData(){
    return $this->data;
  }
//Titulo
  public function getTitulo(){
    return $this->titulo;
  }
//Texto
  public function getTexto(){
    return $this->texto;
  }
//Incrementa e retorna o id correto
  public function getIdToPost(){
    return self::$idToPost;
  }
  public function incrementId(){
    return self::$idToPost++;
  }
}
?>
