<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link rel='stylesheet' type='text/css' href='<?php echo css_url('Accueil');?>'>
	<title>Doodle Like</title>
</head>

<body>
	<header>
		<nav class ="menu">
			<ul>
				<li>	
					<a href="<?php echo site_url('Accueil/index');?>">Accueil</a>
					
				</li>
			
				<li class ="login">
					<?php 
					if(isset($_SESSION['login'])){
						echo '<a href="'.site_url("Accueil/profil/").'">'.$_SESSION['login'].'</a>';
					
					}
?>
				</li>
				
			</ul>
		</nav>
	</header>