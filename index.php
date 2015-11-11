<html>
	<head>
		<meta charset="UTF-8">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

		<title>Pan Tadeusz</title>
	</head>	
	<body>
		<header class="page-header">
			<div class="container text-center">
				<h1>Pan Tadeusz, czyli ostatni zajazd na Litwie</h1>
				<h2>Historia szlachecka z roku 1811 i 1812 we dwunastu księgach wierszem</h2>
			</div>
		</header>
		<div class="container" id="menu">
			<div class="row">
				<ul class="nav nav-tabs">
					<?php
						for ($i=1;$i<=12;$i++){
							$book='k'.$i;
								if ($book==$_GET[co]){
									echo ("<li role='presentation' class='active'><a href='index.php?co=".$book."'>Księga ".rome($i)."</a></li>");
								} else {
									echo ("<li role='presentation' ><a href='index.php?co=".$book."'>Księga ".rome($i)."</a></li>");
								}
						}
					?>
				</ul>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div id="refleksje" class="col-sm-12 col-lg-4">
					<h1>Refleksje</h1>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<p>Prześlij refleksję</p>
						</div>
					  	<div class="panel-body">
					    	<form method="POST" action="insert.php">
							  	<div class="form-group">
							    	<label for="title">Tytuł</label>
							    	<input type="text" class="form-control" name="title" id="title" placeholder="Tytuł refleksji">
							  	</div>
							  	<div class="form-group">
							    	<label for="content">Treść</label>
							    	<textarea id="content" name="content" class="form-control" rows="3"></textarea>
							  	</div>
							  	<button type="submit" class="btn btn-primary pull-right">Prześlij</button>
							</form>
					  	</div>
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<p>Przesłane refleksje</p>
						</div>
					  	<div class="panel-body">
					    	<?php
								include_once('parameters.php');

								$connection=pg_connect("host=$hostname port=5432 user=$username dbname=$database password=$password1")
									or die ("Couldn't connect to database: ".pg_last_error($connection));

								$query = "SELECT * FROM reflections;";
								$result = pg_query($connection, $query);
								if (!$result) {
				  					echo "An error occured.\n";
				  					exit;
								} else {
									echo "<table class='table table-hover'>
											<thead>
												<tr>
													<th>Id</th>
													<th>Tytuł</th>
													<th>Treść</th>
												<tr>
											</thead>
											<tbody>";
									while($row = pg_fetch_array($result)){
										echo "<tr>";
										echo "<td>".$row[0]."</td>";
										echo "<td>".$row[1]."</td>";
										echo "<td>".$row[2]."</td>";
										echo "</tr>";
									}
									echo "</tbody></table>";
								}

							?>
					  	</div>
					</div>
				</div>
				<div id="ksiegi" class="col-sm-12 col-lg-8">
					<?php
						for ($i=1;$i<=12;$i++){
								$book='k'.$i;
								if ($book==$_GET[co]){
									$book='./ksiegi/'.$_GET[co].'.html';
									require_once($book);
								}
							}
					?>
				</div>
			</div>
		</div>
		<footer>
			<div class="container">
				<p>(c) Katarzyna Wójcik Uniwersytet Ekonomiczny w Krakowie</p>
			</div>
		</footer>
	</body>	
</html>

<?php

function rome($N){
    $c='IVXLCDM';
    for($a=5,$b=$s='';$N;$b++,$a^=7)
        for($o=$N%$a,$N=$N/$a^0;$o--;$s=$c[$o>2?$b+$N-($N&=-2)+$o=1:$b].$s);
    return $s;
}

?>