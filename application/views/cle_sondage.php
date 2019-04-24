
<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="choix">

	<h4>Verification cle sondage</h4>
	<?php echo form_open('Accueil/cleVote',array()); ?>

	<label>Cle<input type="text" name="cle" /></label>
	<button class ="connetion">Valider</button>
</form>

<a href="<?php echo site_url('Accueil/sondage');?>"><img class="retour_liste" alt="date" src="<?php echo img_url('retour');?>" width='40' height='40'></a>

<?php 
if(isset($erreur_connexion)){
	echo $erreur_connexion;
}

echo validation_errors(); 

if(isset($validation)){
	echo $validation;
	echo  '<br><br><a  class ="participation" href="'.site_url("Accueil/vote/".$cle).'">Participer au Sondage</a>';
}
if(isset($erreur_participation)){	
	echo $erreur_participation;
} ?>


</section>

