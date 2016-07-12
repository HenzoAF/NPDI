<?php
//Classe para os administradores do site
  class Administrador {

//Atributos do administrador
    private $id;
    private $login;
    private $senha;
    private $primeiroNome;
    private $sobreNome;
    private $email;

//Construtor para a classe
    function __construct(array $data){
      $this->id = $data["id"];
      $this->login = $data["login"];
      $this->senha = $data["senha"];
      $this->primeiroNome = $data["primeiroNome"];
      $this->sobreNome = $data["sobreNome"];
      $this->email = $data["email"];
    }

//Getters & Setters para o login
  public function getId(){
      return $this->id;
  }
  public function setId($idSet){
    $this->id = $idSet;
  }
  public function getLogin(){
      return $this->login;
  }
  public function setLogin($Login){
      $this->login = $Login;
  }
  public function getSenha(){
      return $this->senha;
  }
  public function setSenha($Senha){
      $this->senha = $Senha;
  }

//Getters & Setters de $primeiroNome
  public function getPrimeiroNome(){
      return $this->primeiroNome;
  }
  public function setPrimeiroNome($Pname){
      $this->primeiroNome = $Pname;
  }

//Getters & Setters de $sobreNome
  public function getSobreNome(){
      return $this->sobreNome;
  }
  public function setSobreNome($Sname){
      $this->sobreNome = $Sname;
  }
//Getters $ Setters para email
  public function setEmail($newEmail){
    $this->email = $newEmail;
  }
  public function getEmail(){
    return $this->email;
  }
}
?>
