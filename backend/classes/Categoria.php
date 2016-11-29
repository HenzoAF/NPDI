<?php
//Classe para os administradores do site
  class Categoria {

//Atributos do administrador
    private $id;
    private $administradores_id;
    private $privacidade;
    private $titulo;
    private $descricao;

//Construtor para a classe
    function __construct(array $data){
      $this->descricao = $data['descricao'];
      $this->titulo = $data['titulo'];
      $this->privacidade = $data['privacidade'];
    }

//Getters & Setters para o id
  public function getId(){
    return $this->id;
  }
  public function setId($id){
    $this->id = $id;
  }
//Getters & Setters para o id do administrador
  public function getAdministradores_id(){
    return $this->administradores_id;
  }
  public function setAdministradores_id($id){
    $this->administradores_id = $id;
  }
//Get para privacidade
  public function getPrivacidade(){
    return $this->privacidade;
  }
//Get para titulo
  public function getTitulo(){
    return $this->titulo;
  }
//Get para descrição
  public function getDescricao(){
    return $this->descricao;
  }

}
?>
