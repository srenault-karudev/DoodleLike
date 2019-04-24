
<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="sondage">

	<h4> Participation Sondage</h4>
	<div class ="horizontal">


	</div>
	<?php echo form_open('Accueil/vote/'.$cle.'/',array()); ?>
	<div class ="form">
		<?php 
		foreach($utilisateur as $infos){
			$nom=$infos['nom'];
		}
		?>

		<label for="Nom">Nom</label>
		<input type="text" name="nom" value="<?php echo $nom;?>"/>


		<label for="date">date </label>
		<input type="text" name="date"required pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{2}" oninvalid="this.setCustomValidity('Format date : JJ/MM/AA')" oninput="setCustomValidity('')" />
		<span class="validity"></span>

		<label for="heure">heure</label>
		<input type="number" name="heure" value="<?php echo set_value('heure');?>" min="0" max="23"  />

	</div>


	<a href="<?php echo site_url('Accueil/sondage');?>"><img class="retour_description" alt="date" src="<?php echo img_url('retour');?>" width='40' height='40'></a>

	<div class="choixBouttonVote">
		<button class ="vote">Voter</button>
	</div>
</form>
<br>
<br>
<br>

<div class="titre">
	<h5>Titre :</h5>
	<h5>Lieu :</h5>
	<h5>Debut_date:</h5>
	<h5>Fin_date:</h5>
	<h5>Debut_heure :</h5>
	<h5>Fin_heure :</h5>
</div>	
<div class="infos">
	<?php
	foreach ($sondage as $donnee) {


		echo $donnee['titre']."<br>"."<br>";
		echo $donnee['lieu']."<br>"."<br>";
		echo $donnee['debut_date']."<br>"."<br>";
		echo $donnee['fin_date']."<br>"."<br>";
		echo $donnee['debut_heure']." h"."<br>"."<br>";
		echo $donnee['fin_heure']." h"."<br>"."<br>";	
	}
	?>
</div>
<a  class ="detail" href="<?php echo site_url('Accueil/descriptionSondage/'.$cle.'/');?>">Detail sondage</a><br>

<div class="erreur_sondage">

	<?php echo validation_errors(); ?>

	<?php  		

	if(isset($erreur_participation)){	
		echo $erreur_participation;
	} ?>
</div>	

</section>
