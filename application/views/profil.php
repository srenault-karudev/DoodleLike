

<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="choix">
	<h4> Profil</h4>
	<div class="titre">
		<h5>Login :</h5>
		<h5>Nom :</h5>
		<h5>Prenom:</h5>
		<h5>Email :</h5>
	</div>	

	<div class="infos">
		<?php
		foreach ($profil as $donnee) {


			echo  $donnee['login']."<br>"."<br>";
			echo  $donnee['nom']."<br>"."<br>";
			echo 	$donnee['prenom']."<br>"."<br>";
			echo 	$donnee['email']."<br>"."<br>";

		}
		?>

	</div>

	<a href="<?php echo site_url('Accueil/sondage');?>"><img class="retour" alt="date" src="<?php echo img_url('retour');?>" width='40' height='40'></a>

	<a  class ="modif" href="<?php echo site_url('Accueil/modifProfil');?>">Modifier son profil</a> 
	
</section>
