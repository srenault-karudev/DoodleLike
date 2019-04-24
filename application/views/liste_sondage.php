
<section class ="title">
	<h2>DOODLE LIKE</h2>
	<h3>Une participation en un rien de temps </h3>
</section>
<section class ="sondage">
	<h4>Liste de sondage</h4>
	
	<table class="table" >
		<thead> 
			<tr>
				<th>Titre</th>
				<th>Lieu</th>
				<th>Description</th>
				<th>Etat</th>
				<th>Participant</th>
				<th>Date choisie</th>
				<th>Heure choisie</th>

			</tr>
		</thead>
		<tbody>
			<?php
			
			foreach($information_sondage as $sondage){

				echo "<tr>";
				echo '<td><a href="'.site_url("Accueil/descriptionSondage/".$sondage['cle']).'">'.$sondage['titre'].'</a></td>';

				echo "<td>" . $sondage["lieu"]. "</td>";
				echo "<td>" . $sondage["description"] . "</td>";


				if($sondage["etat"]==0){
					echo "<td bgcolor='#FF6347'>" .'Fermer'. "</td>";
				}
				else{
					echo "<td bgcolor='#a5f154'>" .'Ouvert'. "</td>";
				}

				echo "<td>" . $sondage["Nb_Participant"] . "</td>";


				if($sondage["etat"]==1){

					echo '<td> </td>';
					echo '<td> </td>';

				}
				else{
					if($sondage['date_choisie']==NULL){
						echo '<td> Pas de date  </td>';
					}else{
						echo "<td>" . $sondage["date_choisie"]   ."</td>";
					}


					if($sondage['heure_choisie']==NULL){
						echo '<td> pas d heure</td>';
					}
					else{
						echo "<td>" . $sondage["heure_choisie"]   ."</td>";
					}

				}
				

				
				if($sondage["etat"]==1){
					echo '<td><a href="'.site_url("Accueil/cloturer_sondage/".$sondage['cle']).'">Cloturer Sondage</a></td>';
				}
				else {
					echo '<td></td>';	
				}


				echo '<td><a href="'.site_url("Accueil/delSondage/".$sondage['cle']).'">Supprimer Sondage</a></td>';
				echo "</tr>";

			}
			
			?>

			
		</tbody>
	</table>

	<div class="erreur">
		<?php echo validation_errors(); ?>
	</div>	
	<a href="<?php echo site_url('Accueil/sondage');?>"><img class="retour_liste" alt="date" src="<?php echo img_url('retour');?>" width='40' height='40'></a>

</section>

