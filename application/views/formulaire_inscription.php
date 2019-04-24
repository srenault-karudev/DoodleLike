
<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="choix">

	<h4>S'inscrire</h4>
	
	<?php echo form_open('Accueil/inscription',array()); ?>
	<div class ="form">
		<label>Login<input type="text" name="login_inscription" value="<?php echo set_value('login_inscription');?>"/> </label>

		<label>Password <input type="password" name="mdp_inscription" value="<?php echo set_value('mdp_inscription');?>" /></label>
		
		<label> Nom <input type="text" name="nom_inscription" value="<?php echo set_value('nom_inscription');?>" /></label>
		
		<label>Prenom <input type="text" name="prenom_inscription" value="<?php echo set_value('prenom_inscription');?>" /> </label>
		
		<label>Email <input type="email" name="email_inscription" value="<?php echo set_value('email_inscription');?>" /></label>	
	</div>
	<button class ="connetion">Valider</button>
</form>
<div class="erreur">
	<?php echo validation_errors(); ?>
</div>		
<a href="<?php echo site_url('Accueil/index');?>"><img class="retour" alt="date" src="<?php echo img_url('retour');?>" width='40' height='40'></a>

</section>

