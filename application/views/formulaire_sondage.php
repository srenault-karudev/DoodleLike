

<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="sondage">



	<h4> Menu Sondage</h4>
	<div class ="horizontal">

	</div>
	<?php echo form_open('Accueil/sondage',array()); ?>
	<div class ="form">
		<label>Titre <input type="text" name="titre" value="<?php echo set_value('titre');?>" /></label>

		<label >Lieu <input type="text" name="lieu" value="<?php echo set_value('lieu');?>" /></label>

		<label >Debut date<input type="text" name="debut_date" value="<?php echo set_value('debut_date');?>" required pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{2}" placeholder="<?php if(isset($dateDuJour)) echo $dateDuJour;?>"
			oninvalid="this.setCustomValidity('Format date : JJ/MM/AA')" oninput="setCustomValidity('')"
			/></label>

			<label >Debut heure<input type="number" name="debut_heure" value="<?php echo set_value('debut_heure');?>" min="0" max="23" /></label>

			<label>Fin date<input type="text" name="fin_date"  value="<?php echo set_value('fin_date');?>" required pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{2}" placeholder="<?php if(isset($dateDuJour)) echo $dateDuJour;?>" 
				oninvalid="this.setCustomValidity('Format date : JJ/MM/AA')" oninput="setCustomValidity('')"
				/> </label>	

				<label>Fin heure <input type="number" name="fin_heure" value="<?php echo set_value('fin_heure');?>" min="0" max="23" /> </label>

				<label>Description<br>
					<textarea rows="4" col="150" name="message" ><?php echo set_value('message');?></textarea></label>
				</div>


				<a href="<?php echo site_url('Accueil/index');?>"><img class="retour" alt="date" src="<?php echo img_url('retour');?>" width='40' height='40'></a>

				<button class ="connetion_sondage">Creer Sondage</button>
			</form>
			<div class="choixBoutton">
				<p></p>
				<a class ="sondage" href="<?php echo site_url('Accueil/voirSondage');?>">Voir Mes Sondages</a>
				<p></p>
				<a class ="sondage" href="<?php echo site_url('Accueil/cleVote');?>">Participer Sondage</a>
			</div>

			<div class="erreur">
				<?php echo validation_errors(); ?>

				<?php  		

				if(isset($erreur_sondage)){	
					echo $erreur_sondage;
				} ?>

			</div>	
		</section>

