  <?php
  include 'head.inc';
  ?>
  <div class="canvas clearfix">
    <center>
      <div class="login painel col3">
        <form class="col s12" action="teste.php" method="get">
          <div class="row">
            <div class="input-field col s6">
              <input placeholder="Usuário" id="user" type="text" class="validate">
            </div>
            <div class="input-field col s6">
              <input placeholder="Senha" id="password" type="password" class="validate">
            </div>
          </div>
          <center>
            <a class="waves-effect waves-light btn-large bg-blue" type="submit">Login</a>
          </center>
        </form>
      </div>
    </center>
  </div>
  <?php include 'footer.inc';?>
