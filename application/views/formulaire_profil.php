	<section class ="title">
		<h2>DOODLE LIKE</h2>
		<h3>Une participation en un rien de temps </h3>
	</section>
	<section class ="choix">

		<h4>Modifier Profil</h4>
		<?php echo form_open('Accueil/modifProfil',array()); ?>

		<label>Nom<input type="text" name="nom_profil" value="<?php echo set_value('nom_profil');?>" /></label>

		<label>Prenom<input type="text" name="prenom_profil" value="<?php echo set_value('prenom_profil');?>" /></label>

		<label>Email<input type="email" name="email_profil" value="<?php echo set_value('email_profil');?>" /></label>

		<button class ="connetion">Confirmer</button>
	</form>
	<br>
	<a href="<?php echo site_url('Accueil/profil');?>"><img class="retour_profil" alt="date"  src="<?php echo img_url('retour');?>" width='40' height='40'></a>

	<?php echo validation_errors(); ?> 

</section>

