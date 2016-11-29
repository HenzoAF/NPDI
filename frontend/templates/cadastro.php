<?php include 'head.inc';?>
<div class="canvas clearfix">
  <center>
    <div class="login painel col5">
      <form class="col s12" action="../../backend/public/index.php/cadastro" method="post" name="loginForm" ng-submit="submitLoginForm(loginForm.$valid)" novalidate>
        <div class="row">
          <div class="input-field col s4">
            <input placeholder="Usuário" id="usuario" type="text" class="validate" name="login" ng-model="login" required>
          </div>
          <div class="input-field col s4">
            <input placeholder="Senha" id="senha" type="password" class="validate" name="senha" ng-model="senha" required>
          </div>
          <div class="input-field col s4">
            <input placeholder="Email" id="email" type="text" class="validate" name="email" ng-model="email" required>
          </div>
          <div class="input-field col s6">
            <input placeholder="Nome" id="primeiroNome" type="text" class="validate" name="primeiroNome" ng-model="primeiroNome" required>
          </div>
          <div class="input-field col s6">
            <input placeholder="Sobrenome" id="sobreNome" type="text" class="validate" name="sobreNome" ng-model="sobreNome" required>
          </div>
        </div>
        <center>
          <!--Frontend, implementar redirecionamento angular-->
          <input class="waves-effect waves-light btn-large bg-blue" type="submit" value="Cadatrar">
        </center>
      </form>
    </div>
  </center>
</div>
<?php include 'footer.inc';?>
