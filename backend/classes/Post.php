<?php
//Classe para os posts de administradores
class Post{

//Atributos do post
  private $id;
  private $autorId;
  public $data;
  private $titulo;
  private $texto;

//Construtor para a classe
  function __construct(array $array){
    $this->data = date("Y-m-d H:i:s");
    $this->titulo = $array["titulo"];
    $this->texto = $array["texto"];
  }
//Getters & Setters de...
//Id
  public function setId($id){
    $this->id = $id;
  }
  public function getId(){
    return $this->id;
  }
//Autor
  public function getAutorId(){
    return $this->autorId;
  }
  public function setAutorId($id){
    $this->autorId = $id;
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
}
?>
