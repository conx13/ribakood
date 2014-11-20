    <!-- <span id="pealkiri">Pealkiri</span> -->
<nav class="navbar" role="navigation">
  <div class="collapse navbar-inverse navbar-fixed-top navbar-collapse">
    <div class="container">
    <div style="position:absolute; left:50%">
      <div style="position:relative; left:-50%">        
          <a href="#" class="navbar-text" id="navText">15:24</a>
      </div>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="../koodid/rKood.php"><i class="fa fa-barcode"></i> Koodid</a></li>
      <li><a href="../tool/rTool.php"><i class="fa fa-clock-o"></i> Hetkel tööl</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Aruanded
          <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="../chart/chart_grupp.html"><i class="fa fa-bar-chart-o"> </i> m2 ja tunnid kuus</a></li>
          <li><a href="../Aruanded/rMarkused.html"><i class="fa fa-comment-o"> </i> Projekti märkused</a></li>
        </ul>
      </li>
    </ul>

    <ul class="nav navbar-nav navbar-right pais">
      <li class="dropdown">
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class="fa fa-user"></i>
          <?php
            if (isset($_SESSION['kasutaja']))
              {
              echo $_SESSION['kasutaja'];
              echo "<script>sessionStorage.setItem('Kasutaja','" . $_SESSION['kasutaja']. "');</script>";
              }
            ?>
          <b class="caret"></b>
        </a>
      <ul class="dropdown-menu">
        <li>
          <a id="logout" href="#"><i class="fa fa-sign-out"></i> Logi välja</a>
        </li>
      </ul>
      </li>
    </ul>
    </div>  
  </div>
</nav>


<div class="">
  
</div>

<script type="text/javascript">

$(function(){
  $("#logout").click(function(){
    console.log('vajutas välja');
    sessionStorage.setItem('Kasutaja','');
    $.get('/login/logout.php',function(){
      location.reload();
    })
  })
})
</script>