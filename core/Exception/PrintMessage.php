<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title> TEED EXCEPTION! </title>
	<link rel="stylesheet" type="text/css" href="www/css/pages/default.css">
	<link rel="stylesheet" type="text/css" href="www/css/libs/font-awesome.min.css">
	<link rel="shortcut icon" href="www/images/favicon.png">
	<style>
	body{ padding-top:15px; background:#eee; }
	*{ color:#333 !important; }
	a, a * { color:#d54 !important;  }
	.small-text { font-size:14px;  }
	</style>
</head>
<body>

	<div class="content">

		<div class="container">

			<div class="small-text" style="border-bottom:1px solid #555;margin-bottom:15px">

				<a href="<?php echo App::getBase(); ?>">

					<i class="fa fa-home"></i> &nbsp;

					go to home

				</a>

				<p style="font-weight:bold;">

					<i class="fa fa-warning"></i> &nbsp;

					TEED EXCEPTION &nbsp;

					<i class="fa fa-warning"></i>

				</p>

			</div>

			<div>

				<div style="font-weight:bold;"> <?php echo str_replace( '%s', $debug[0]['args'][1], $message[0] ); ?> </div>

				<?php

					for( $x=1; $x<count($message); $x++ )
					{

						$arg = isset($debug[0]['args'][$x+1])? $debug[0]['args'][$x+1]: null;

						$message[$x] = str_replace( "%s", $arg, $message[$x] );

						echo "<div> {$message[$x]} </div>";

					}

				?>

			</div>

		</div>

	</div>

</body>
</html>