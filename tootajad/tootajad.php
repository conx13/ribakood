<!DOCTYPE html>
<html lang="et">
	<head>
		<meta charset="utf-8">
		<title>Tootajad</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
		<link href="../pais/navibar.css" rel="stylesheet">
		<link href="tootajad.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    	<script src="../scriptid/bootstrap-paginator.min.js"></script>
    	<script src="tootajad.js"></script>

	</head>
	<body>
		<?php
			$path = $_SERVER['DOCUMENT_ROOT'];
      		//require_once($path .'/login/kont.php'); //kas on lubatud kasutaja
      		include_once ($path .'/pais/navibar.php'); //võtame päise külge
      	?>
      	<div class="container">
      		<div class="row"> <!-- nupud -->
      			<div class="panel panel-info col-lg-8 col-lg-offset-2" id="Nupud">
      				<div class="panel-body">
	      				<form class="form-inline" id="otsiForm" role="form"> 				
	      					<div class="col-lg-8"><!-- vaska nupp -->
		      					<div class="input-group input-group-sm col-lg-4">
		      						<button type="button" class="btn btn-info btn-sm btn-block" id="lisa">Lisa uus</button>
		      					</div>
	      					</div>
	      					<div class="col-lg-4"><!-- parem nupp -->
								<div class="input-group pull-right input-group-sm">
									<input type="text" class="form-control" id="otsiText" placeholder="Nimi..." autofocus>
									<span class="input-group-btn">
							        	<button type="submit" class="btn btn-info" id="otsiNupp" type="button">Filter</button>
							      	</span>
								</div><!-- /input-group -->
	      					</div><!-- /parem nupp -->	
	      				</form>
      				</div><!-- /panel-body -->
      			</div><!-- /panel -->
      		</div><!-- /nupud -->
      		<div class="row"> <!-- tabel -->
      			<div class="panel panel-info col-lg-8 col-lg-offset-2" id="tootPanel">
                    <div class="alert alert-danger alert-dismissible text-center teateAken" role="alert" id="tootajaAlertError">
                        <button type="button" class="close alert-close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="teade"></div>
                    </div>
      				<div class="panel-body">
      					<table class="table table-bordered table-striped table-condensed table-hover" id='tootTabel'>
      						<thead>
	      						<tr class="info">
	      							<th width="50%" class="text-center">Nimi</th>
	      							<th class="text-center">Ajareziim</th>
	      							<th width="10%" class="text-center">Aktiivne</th>
	      						</tr>		
      						</thead>
      						<tbody>
      						</tbody>
      					</table>
      				</div><!-- panel-body -->
      			</div><!-- panel -->
      		</div><!-- row -->
            <div class="alert alert-success text-center teateAken" role="alert" id="tootajaAlertOk">
            </div>
            
			<!-- Muuda nime form -->
			<div class="modal fade" id="muudaModal" tabindex="-1" role="dialog" aria-labelledby="muudaModal" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header text-center">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 class="modal-title"></h3>
						</div>
				        <form  class="form" role="form" id="mTootajaForm" autocomplete="off" method="POST">
				            <div class="modal-body">
	                           <input type="hidden" name="muudatKood" id="muudatKood" >
                                <div class="form-group">
	                                <label for="muudaEnimi" class="control-label">Eesnimi</label>
	                                <input type="text" class="form-control kont" autocomplete="off" id="muudaEnimi" name="muudaEnimi" placeholder="Eesnimi">
	                           </div>
	                            <div class="form-group">
	                                <label for="muudaPnimi" class="control-label">Perenimi</label>
	                                <input type="text" class="form-control kont" autocomplete="off" id="muudaPnimi" name="muudaPnimi" placeholder="Perenimi">
	                            </div>

	                            <div class="form-group">
	                                <label for="muudaIkood" class="control-label">Isiku kood</label>
	                                <input type="text" class="form-control kont" autocomplete="off" id="muudaIkood" name="muudaIkood" maxlength="11" placeholder="Isikukood">
	                            </div>

	                            <div class="form-group">
	                            	<label for="muudaAeg" class="control-label" >Aja grupp</label>
	                            	<select class="form-control kont" name="muudaAeg" id="muudaAeg">
	                            	</select>
	                            </div>
		                            <div class="form-group">
		                            <label for="muudaAkt">Aktiivne
		                            <input type="checkbox" class="kont" name="muudaAkt" id="muudaAkt" checked>
		                            </label> 	
	                            </div>
                            </div>
                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-default btn-sm col-lg-4 col-lg-offset-2" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm col-lg-4" disabled="disabled" id="muudaModalSave">Salvesta</button>
                            </div>
				        </form>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

      	</div><!-- container -->
	</body>