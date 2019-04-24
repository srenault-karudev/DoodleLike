
<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="choix">

	<h4> Description Sondage</h4>
	<div class="titre">
		<h5>Titre :</h5>
		<h5>Lieu :</h5>
		<h5>Debut_date:</h5>
		<h5>fin_date:</h5>
		<h5>Debut_heure :</h5>
		<h5>fin_heure :</h5>
		<h5>Description :</h5>
		<h5>Nb_Participant:</h5>	

	</div>	
	<div class="infos_description">
		<?php
		foreach ($sondage as $donnee) {
			
			
			
			echo  $donnee['titre']."<br>"."<br>";
			echo  $donnee['lieu']."<br>"."<br>";
			echo  $donnee['debut_date']."<br>"."<br>";
			echo  $donnee['fin_date']."<br>"."<br>";
			echo  $donnee['debut_heure']." h"."<br>"."<br>";
			echo  $donnee['fin_heure']." h"."<br>"."<br>";
			echo  $donnee['description']."<br>"."<br>";
			echo  $donnee['Nb_Participant']."<br>"."<br>";
		}
		?>
	</div>
	<a href="<?php echo site_url('Accueil/voirSondage');?>"><img class="retour2" alt="date" src="<?php echo img_url('retour');?>" width='40' height='40'></a>

	
	
</section>
