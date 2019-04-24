
<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="choix">
	
	<h4>Se Connecter</h4>
	<?php echo form_open('Accueil/index',array()); ?>
	
	<label>Login<input type="text" name="login" value="<?php echo set_value('login');?>"/> </label>
	<label >Password  <input type="password" name="mdp" value="<?php echo set_value('mdp');?>" /></label>
	

	<ul>
		<li> <a href="<?php echo site_url('Accueil/inscription');?>">s'inscrire</a> </li>
		<li class="mdpf"> <a href="<?php echo site_url('Accueil/demande_mdp');?>">mot de passe oublie ?</a></li>
	</ul>
	<div >
		<button class ="connetion">Connexion</button>
	</div>	
</form>

<p> 
	<?php 
	if(isset($erreur_connexion)){
		echo $erreur_connexion;
	}
	?>
</p>

<p> <?php echo validation_errors(); ?> </p>



</section>



