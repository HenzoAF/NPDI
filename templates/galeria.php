  <?php include 'head.inc';?>
  <div class="canvas clearfix">
    <div class="col3 right">
      <div class="col6 card left" style="background-image: url(http://lorempixel.com/601/201);">
        <a href="#">
          <div class="card-selected-blue">
            <center>
              <h3 class="card-text">Documentos Históricos Com Tinta Reversa</h3>
            </center>
          </div>
        </a>
      </div>
      <div class="col6 card left" style="background-image: url(http://lorempixel.com/601/200);">
        <a href="#">
          <div class="card-cover-blue">
            <center>
              <h3 class="card-text">Imagens Clássicas do PDI</h3>
            </center>
          </div>
        </a>
      </div>
      <div class="col6 card left" style="background-image: url(http://lorempixel.com/600/201);">
        <a href="#">
          <div class="card-cover-blue">
            <center>
              <h3 class="card-text">Arte das Ruas</h3>
            </center>
          </div>
        </a>
      </div>
      <div class="col6 card left" style="background-image: url(http://lorempixel.com/600/200);">
        <a href="#">
          <div class="card-cover-blue">
            <center>
              <h3 class="card-text">Giocondas</h3>
            </center>
          </div>
        </a>
      </div>
    </div>
    <div class="col3 painel left">
      <center><h3>Documentos Históricos Com Tinta Reversa</h3></center>
      <div class="slider">
        <ul class="slides galeria-slider">
          <li>
            <img src="http://lorempixel.com/580/251">
            <div class="caption center-align">
              <h3></h3>
              <h5 class="light grey-text text-lighten-3"></h5>
            </div>
          </li>
          <li>
            <img src="http://lorempixel.com/581/250">
            <div class="caption left-align">
              <h3></h3>
              <h5 class="light grey-text text-lighten-3"></h5>
            </div>
          </li>
          <li>
            <img src="http://lorempixel.com/581/251">
            <div class="caption right-align">
              <h3></h3>
              <h5 class="light grey-text text-lighten-3"></h5>
            </div>
          </li>
          <li>
            <img src="http://lorempixel.com/580/249">
            <div class="caption center-align">
              <h3></h3>
              <h5 class="light grey-text text-lighten-3"></h5>
            </div>
          </li>
        </ul>
      </div>
        <a class="btn bg-blue left col2 slide-button" onclick="previousSlide()">Anterior</a>
        <a class="btn bg-blue right col2 slide-button" onclick="nextSlide()">Próximo</a>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.slider').slider({full_width: true});
      $('.slider').slider('pause');
    });
  </script>
  <?php include 'footer.inc';?>
