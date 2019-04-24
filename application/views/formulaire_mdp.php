
<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="choix">
	
	<h4>Mot de passe oublie</h4>
	<?php echo form_open('Accueil/demande_mdp',array()); ?>
	
	<label>Login<input type="text" name="login_mot_de_passe" value="<?php echo set_value('pseudo');?>" /></label>
	
	<label>Nouveau password <input type="password" name="nouveau_mot_de_passe" value="<?php echo set_value('ancien_mot_de_passe');?>" /></label>
	
	<label>Email <input type="email" name="email_mot_de_passe" value="<?php echo set_value('email_mot_de_passe');?>" /></label>
	
	<button class ="connetion">Confirmer</button>
	
</form>
<p> <?php echo validation_errors(); ?> </p>
<a href="<?php echo site_url('Accueil/index');?>"><img class="retour" alt="date"  src="<?php echo img_url('retour');?>" width='40' height='40'></a>
<?php  
if(isset($erreur_mdp_oublie)){
	echo $erreur_mdp_oublie;
}
?>
</section>


