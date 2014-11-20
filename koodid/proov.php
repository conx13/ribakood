<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="utf-8">
    <title>Ribakoodid</title>
    <link href="../bootstrap3/css/bootstrap.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="../bootstrap3/js/bootstrap.min.js"></script>

</head>
<body>
  																												   
  <button id="nupp">Modal</button>
  																												       
  <div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelly="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text-center">Seotud tööd</h4>
        </div>
        <div class="modal-body">
          <form role="form" class="form-inline">
            <div class="form-group">
              <labelfor="Lep">leping</label>
              <input id="Lepo"  type="text" name="Lep" placeholder="Lep nr"/>
            </div>
            <input class="UusRidaNupp" tabindex="4" id="Salvesta" disabled="disabled" type="submit" name="uSubmit" value="Lisa">    
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm laius2" data-dismiss="modal">Sulge</button>
        </div>
      </div>
    </div>
  </div> 
	 
</body>
</html>
																								  
<script>
	$("#nupp").click(function(){
			 $("#linkModal").modal("show");
			 })																							  
</script>																								  