<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title> TEED EXCEPTION! </title>
	<link rel="stylesheet" type="text/css" href="www/css/pages/default.css">
	<link rel="stylesheet" type="text/css" href="www/css/libs/font-awesome.min.css">
	<link rel="shortcut icon" href="www/images/favicon.png">
	<style>
	body{padding-top:40px;background:#EB3D3D;color:#FFF;}
	*{color:#FFF !important;}
	h1,h2,h3,h4{margin:0;text-transform:uppercase;}
	a{color:rgb(255,255,255) !important;}
	</style>
</head>
<body>

	<div class="content">

		<div class="container">

			<header>

				<a href="<?php echo App::getBase(); ?>">

					PÁGINA INICIAL

				</a>

			</header>

			<div class="panel panel-big">

				<h1 style="text-align:center;">

					Um erro foi encontrado

				</h1>

				<h2 style="text-align:center;border:0;">

					<i class="fa fa-warning"></i> &nbsp;

					TEED EXCEPTION &nbsp;

					<i class="fa fa-warning"></i>

				</h2>

				<div class="panel">

					<h3> <?php echo str_replace( '%s', $debug[0]['args'][1], $message[0] ); ?> </h3>

					<?php

						for( $x=1; $x<count($message); $x++ ):

							$arg = isset($debug[0]['args'][$x+1])? $debug[0]['args'][$x+1]: null;

							$message[$x] = str_replace( "%s", $arg, $message[$x] );

							echo "<p> {$message[$x]} </p>";

						endfor;

					?>

				</div>

				<?php

					if(count($debug)>6):

						echo "<table>";

							for( $x=1; $x<count($debug)-6; $x++ ):

								echo "<tr>",

										"<td>",

											isset($debug[$x]['class'])?"{$debug[$x]['class']}::{$debug[$x]['function']}": $debug[$x]['function'],

										"</td>",

										"<td>",

											isset($debug[$x]['file'])? $debug[$x]['file']: $debug[$x-1]['file'],

										"</td>",

										"<td>",

											isset($debug[$x]['line'])? $debug[$x]['line']: null,

										"</td>",

									"</tr>";

							endfor;

						echo "</table>";

					endif;

				?>

			</div>

		</div>

	</div>

</body>
</html>