<?php

$interaction_data = file_get_contents('interaction_data.json');
$interaction_data = json_decode($interaction_data, true);
function truncate($str, $len) {
  $tail = max(0, $len-10);
  $trunk = substr($str, 0, $tail);
  $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', '...', strrev(substr($str, $tail, $len-$tail))));
  return $trunk;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Experimental mutations with free energy</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
html, body {
overflow-x: hidden;
}
.table-div .mutation_hide {
display: none;
}
.modal-body {
	max-height: 600px;
	overflow-y: scroll;
}
</style>
  </head>

  <body>



    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
		<? foreach($interaction_data as $pdb => $interaction) : ?>
			<div class="col-md-4" style="height: 750px;">
			  <h4><?= $pdb ?></h4>
				<img data-toggle="tooltip" data-placement="left" title="<?= $interaction['title'] ?>" src="pngs/<?= $pdb ?>.png" width="100%" /><br />
<p style="text-transform: uppercase; height: 40px;" data-toggle="tooltip" data-placement="top" title="<?= $interaction['title'] ?>"><?= truncate($interaction['title'], 85) ?></p>


				<table class="table table-condensed">
				  <thead>
					<tr>
					  <th>Chain</th>
					  <th>Description</th>
					</tr>
				  </thead>
				  <tbody>
					<? foreach($interaction['antibody_chains'] as $chain => $antibody_chain) : ?>
							<tr>
							  <td><?= $chain ?></td>
							  <td><?= truncate($antibody_chain, 35) ?></td>
							</tr>
					<? endforeach; ?>		
<? if(count($interaction['antibody_chains']) == 1) : ?>
							<tr>
							  <td>-</td>
							  <td>-</td>
							</tr>
<? endif; ?>			
					<? foreach($interaction['antigen_chain'] as $chain => $antibody_chain) : ?>
							<tr class="info">
							  <td><?= $chain ?></td>
							  <td><?= truncate($antibody_chain, 35) ?></td>
							</tr>
					<? endforeach; ?>
				  </tbody>
				</table>
<div class="table_<?= $pdb ?> table-div">
				<table class="table table-condensed table-striped table-bordered" style="margin-bottom: 0">
				  <thead>
					<tr>
					  <th>Mutations</th>
					  <th>Exp. &#916;&#916;G</th>
					  <th class="mutation_hide">Kd</th>
					  <th class="mutation_hide">EC50</th>
					  <th>FoldX</th>
					  <th>Rosetta</th>
					  <th class="mutation_hide">ASA</th>
					  <th class="mutation_hide">AnalyseComplex</th>
					</tr>
				  </thead>
				  <tbody>
					<? foreach($interaction['mutations'] as $i => $mutation) : ?>
							<tr class="<?= ($i <= 4)?'mutation_show':'mutation_hide' ?>">
							  <td><?= $mutation['mutations'] ?></td>
							  <td><?= $mutation['ddg'] ?></td>
							  <td class="mutation_hide"><?= $mutation['kd'] ?></td>
							  <td class="mutation_hide"><?= $mutation['ec50'] ?></td>
							  <td><?= $mutation['foldx_predicted'] ?></td>
							  <td><?= $mutation['rosetta_predicted'] ?></td>
							  <td class="mutation_hide"><?= $mutation['asa'] ?></td>
							  <td class="mutation_hide"><?= $mutation['analyse_complex_predicted'] ?></td>
							</tr>
					<? endforeach; ?>
				  </tbody>
				</table>
</div>
				<a href="#" class="pull-right view_all" data-pdb="<?= $pdb ?>" style="font-size: 12px; ">view all <?= count($interaction['mutations']) ?> mutations</a>
				<br />

				
			</div>
		<? endforeach; ?>

      </div>

      <hr>

      <footer>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="jquery.tablesorter.js"></script>

	<div class="modal fade" id="myModal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">title</h4>
		  </div>
		  <div class="modal-body">
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script>

$(function () {
    $("[data-toggle='tooltip']").tooltip();
	$(".view_all").click(function(){
		$('.modal-body').html('');
		$('.modal-title').html($(this).data('pdb'));
		var html = $('.table_' + $(this).data('pdb')).html();
		$('.modal-body').html(html);
		$(".modal-body table").tablesorter();
		$('#myModal').modal('show');
		return false;
	});
});
	</script>

  </body>
</html>

