<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->helpers(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Model_membre');
	}


	public function index()
	{		
		unset($_SESSION['login']);
		$this->form_validation->set_rules('login','pseudo_connexion','trim|required|min_length[3]|max_length[35]',array('required'=>'Le champs login est vide.','min_length'=>'Le login doit faire au moins 3 caractères.','max_length'=>'le nom ne doit pas depasser 35 caracteres'));	
		$this->form_validation->set_rules('mdp','Mot de passe connexion','trim|required|min_length[4]|max_length[37]',array('required'=>'Le champs mot de passe doit faire au moins 4 caracteres.','max_length'=>'Le mot de passe ne doit pas depasser 37 caracteres '));

		$login=$this->input->post('login');
		$mdp=$this->input->post('mdp');

		if($this->form_validation->run()==FALSE){
				$this->load->view("templates/header");
				$this->load->view('Accueil');
				$this->load->view("templates/footer");	
				

		}
		else  {
			$hashPW=$this->Model_membre->hashPW($login,$mdp);
			$login =$this->Model_membre->connexion($login,$hashPW);
			if(($login!=-1)&&($login!=-2)){
				//session_start();
				$_SESSION['login']=$login;
				$data= $this->Model_membre->get_informations_utilisateur($_SESSION['login']);
				if(isset($_SESSION['login'])){
					$this->load->view("templates/headerS");
					$this->load->view('formulaire_sondage');
					$this->load->view("templates/footer");
				}
			}


			else if($login== -1){
				$data['erreur_connexion']="le compte n'existe pas";
				$this->load->view("templates/header");
				$this->load->view('Accueil',$data);
				$this->load->view("templates/footer");
				
			}
			else if($login== -2){
				$data['erreur_connexion']='le mot de passe est incorrect';
				$this->load->view("templates/header");
				$this->load->view('Accueil',$data);
				$this->load->view("templates/footer");

			}	
		}
	}


	public function deconnexion(){
		session_destroy();
		
		$this->load->view("templates/header");
		$this->load->view('Accueil');
		$this->load->view("templates/footer");
		
	}

	public function demande_mdp(){
		$this->form_validation->set_rules('login_mot_de_passe','pseudo_mot_de_passe','trim|required|min_length[3]|max_length[35]',array('required'=>'Le champ  login est vide.','min_length'=>'Le login doit faire au moins 3 caractères.','max_length'=>'le login ne doit pas dépasser 35 caractères.'));	
		$this->form_validation->set_rules('nouveau_mot_de_passe','nouveau_mot_de_passe','trim|required|min_length[4]|max_length[37]',array('required'=>'Le champ  mot de passe est vide.','min_length'=>'Le mot de passe doit faire au moins 4 caractères.','max_length'=>'le mot de passe ne doit pas dépasser 37 caractères.'));
		$this->form_validation->set_rules('email_mot_de_passe','Email_mot_de_passe','trim|required|valid_email',array('required'=>'Le champ email est vide.','valid_email'=>'L\'email n\'est pas valide'));
		
		$login_mot_de_passe=$this->input->post('login_mot_de_passe');
		$nouveau_mot_de_passe=$this->input->post('nouveau_mot_de_passe');
		$email_mot_de_passe=$this->input->post('email_mot_de_passe');

		if($this->form_validation->run()==FALSE){

				$this->load->view("templates/header");
				$this->load->view('formulaire_mdp'); 
				$this->load->view("templates/footer");

		}

		else{
			$req=$this->Model_membre->getPwOubli($login_mot_de_passe,$email_mot_de_passe);
			if($req==1){
				$hashPW=$this->Model_membre->hashPW($login_mot_de_passe,$nouveau_mot_de_passe);
				$this->Model_membre->setPWoubli($login_mot_de_passe,$hashPW);
				$this->load->view("templates/header");
				$this->load->view('Accueil');
				$this->load->view("templates/footer");
				
			}
			else if($req!=1){
				$data['erreur_mdp_oublie']="le login ou l'email n'est pas correct";
				$this->load->view("templates/header");
				$this->load->view('formulaire_mdp',$data);
				$this->load->view("templates/footer");
				
			}

		}	

	}


	public function inscription()
	{
		$this->form_validation->set_rules('login_inscription','Login_inscription','trim|required|min_length[3]|max_length[35]|is_unique[Utilisateur.login]',array('required'=>'Le champ  login est vide.','min_length'=>'Le login doit faire au moins 3 caractères.','max_length'=>'le login ne doit pas dépasser 35 caractères.','is_unique'=>'Login deja utilisé.'));	
		$this->form_validation->set_rules('mdp_inscription','Inscription_mot_de_passe','trim|required|min_length[4]|max_length[37]',array('required'=>'Le champ Le mot de passe est vide.','min_length'=>'Le mot de passe doit faire au moins 4 caractères.','max_length'=>'le mot de passe ne doit pas dépasser 37 caractères.'));
		$this->form_validation->set_rules('nom_inscription','Nom_inscription','trim|required|min_length[3]|max_length[40]',array('required'=>'Le champ nom est vide.','min_length'=>'Le nom doit faire au moins 3 caractères.','max_length'=>'le nom ne doit pas dépasser 40 caractères.'));
		$this->form_validation->set_rules('prenom_inscription','Prenomom_inscription','trim|required|min_length[3]|max_length[35]',array('required'=>'Le champ  prenom est vide.','min_length'=>'Le prenom doit faire au moins 3 caractères.','max_length'=>'le prenom ne doit pas dépasser 35 caractères.'));
		$this->form_validation->set_rules('email_inscription','Email_inscription','trim|required|valid_email',array('required'=>'Le champ email est vide.','valid_email'=>'L\'email n\'est pas valide'));
		
		$login_inscription=$this->input->post('login_inscription');
		$mdp_inscription=$this->input->post('mdp_inscription');
		$nom_inscription=$this->input->post('nom_inscription');
		$prenom_inscription=$this->input->post('prenom_inscription');
		$email_inscription=$this->input->post('email_inscription');



		if($this->form_validation->run()==FALSE){
				$this->load->view("templates/header");
				$this->load->view('formulaire_inscription'); 
				$this->load->view("templates/footer");
			

		}
		else{

			$hashPW=$this->Model_membre->hashPW($login_inscription,$mdp_inscription);
			$this->Model_membre->ajouter_utilisateur($login_inscription,$hashPW,$nom_inscription,$prenom_inscription,$email_inscription);

			$_SESSION['login_inscription'] = $_POST['login_inscription'];

			$data = $this->Model_membre->get_informations_utilisateur($_SESSION['login_inscription']);
				$this->load->view("templates/header");
				$this->load->view('Accueil',$data);
				$this->load->view("templates/footer");		
			
		}	

	}

	public function sondage(){

		$this->form_validation->set_rules('titre','Titre_sondage','trim|required|min_length[3]|max_length[50]',array('required'=>'Le champ titre est vide.','min_length'=>'Le titre doit faire au moins 3 caractères.','max_length'=>'le titre ne doit pas dépasser 50 caractères.'));
		$this->form_validation->set_rules('lieu','Lieu_sondage','trim|required|min_length[3]|max_length[50]',array('required'=>'Le champ lieu est vide.','min_length'=>'Le lieu doit faire au moins 3 caractères.','max_length'=>'le lieu ne doit pas dépasser 50caractères.'));
		$this->form_validation->set_rules('debut_date','Debut_date','trim|required',array('required'=>'Le champ date de debut est vide.','regex_match[/^((0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d)$/]'));
		$this->form_validation->set_rules('debut_heure','Debut_heure','trim|required',array('required'=>' Le champ heure de debut est vide.'));
		$this->form_validation->set_rules('fin_date','Fin_date','trim|required',array('required'=>'Le champ  date de fin est vide.'));
		$this->form_validation->set_rules('fin_heure','Fin_Heure','trim|required',array('required'=>'Le champ heure de fin est vide.'));
		$this->form_validation->set_rules('message','Description','trim|required|min_length[2]|max_length[255]',array('required'=>'Le champ message est vide.','min_length'=>'le message doit faire au moins 2 caracteres.','max_length'=>'le message ne doit pas depasser 255 caracteres.'));

		$dateDuJour=date("Y-m-j"); /* forme AAAA/AA/AA */
		$data['dateDuJour']=date("j/m/y"); /* forme AA-AA-AAAA*/

		if($this->form_validation->run()==FALSE){
			$this->load->view("templates/headerS");
			$this->load->view('formulaire_sondage',$data);
			$this->load->view("templates/footer");	 
		}
		else{
			$titre=$this->input->post('titre');
			$lieu=$this->input->post('lieu');
			$debut_date=$this->input->post('debut_date');
			$debut_heure=$this->input->post('debut_heure');
			$fin_date=$this->input->post('fin_date');
			$fin_heure=$this->input->post('fin_heure');
			$message=$this->input->post('message');

			$cle=$this->Model_membre->hashCle($_SESSION['login'],$titre);
			$hashPW=$this->Model_membre->hashPw($_SESSION['login'],$cle);
			$debut_date=$this->Model_membre->modifDateInverser($debut_date);
			$fin_date=$this->Model_membre->modifDateInverser($fin_date);

			echo $debut_date ." ".$dateDuJour ." ". $fin_date;

			if(($debut_date>=$dateDuJour)&&($fin_date>=$dateDuJour)) { 
				if($debut_date < $fin_date){
					if(($debut_date==$fin_date)&&($debut_heure>=$fin_heure)){
						$erreur_heure['erreur_sondage'] = " l'heure de fin doit etre superieur a l'heure de debut.";
						$this->load->view("templates/headerS");
						$this->load->view('formulaire_sondage',$erreur_heure);
						$this->load->view("templates/footer");	
					}
					else{
						$this->Model_membre->setSondage($titre,$lieu,$hashPW,$_SESSION['login'],$debut_date,$debut_heure,$fin_date,$fin_heure,$message);		
						$data['information_sondage']=$this->Model_membre->getMesSondages($_SESSION['login']);
						$this->load->view("templates/headerS");
						$this->load->view('liste_sondage',$data);
						$this->load->view("templates/footer");	
					}
				}
				else{
					$erreur_date['erreur_sondage'] = " la date de fin doit etre superieur a la date de debut.";
					$this->load->view("templates/headerS");
					$this->load->view('formulaire_sondage',$erreur_date);
					 $this->load->view("templates/footer");	
				}
			}
			else{
				$tmp=$this->Model_membre->modifDateNormal($dateDuJour);
				$erreur_date['erreur_sondage'] = " les dates doivent etre superieur au " .$tmp.".";
				$this->load->view("templates/headerS");
				$this->load->view('formulaire_sondage',$erreur_date); 
				$this->load->view("templates/footer");	
			}	
			
		}



	}
	
	public function cloturer_sondage($cle){
		$this->Model_membre->setModifEtat($cle);
		$data['information_sondage']=$this->Model_membre->getMesSondages($_SESSION['login']);
		$this->load->view("templates/headerS");
		$this->load->view('liste_sondage',$data); 
		$this->load->view("templates/footer");		

	}
	public function voirSondage(){
		$data['information_sondage']=$this->Model_membre->getMesSondages($_SESSION['login']);
		$this->load->view("templates/headerS");
		$this->load->view('liste_sondage',$data,NULL,TRUE);
		$this->load->view("templates/footer");	
	}
	public function delSondage($cle){
		$this->Model_membre->delVote($cle);
		$this->Model_membre->delSondage($cle);
		$this->load->view("templates/headerS");
		$data['information_sondage']=$this->Model_membre->getMesSondages($_SESSION['login']);
		$this->load->view('liste_sondage',$data);
		$this->load->view("templates/footer");	

	}
	public function descriptionSondage($cle){
		$data['sondage']=$this->Model_membre->getSondage($cle);	
		$this->load->view("templates/header");
		$this->load->view('description_sondage',$data);
		$this->load->view("templates/footer");	
	}
	
	public function profil(){

		$data['profil']=$this->Model_membre->get_informations_utilisateur($_SESSION['login']);
		$this->load->view("templates/header");	
		$this->load->view('profil',$data);
		$this->load->view("templates/footer");	

	}
	public function modifProfil(){

		$this->form_validation->set_rules('nom_profil','Nom_profil','trim|required|min_length[3]|max_length[40]',array('required'=>'Le champ nom  est vide.','min_length'=>'Le nom doit faire au moins 3 caractères.','max_length'=>'le nom ne doit pas dépasser 40 caractères.'));
		$this->form_validation->set_rules('prenom_profil','Prenom_profil','trim|required|min_length[3]|max_length[35]',array('required'=>'Le champ prenom est vide.','min_length'=>'Le prenom doit faire au moins 3 caractères.','max_length'=>'le prenom ne doit pas dépasser 35 caractères.'));
		$this->form_validation->set_rules('email_profil','Email_profil','trim|required|valid_email',array('required'=>'Le champ email est vide.','valid_email'=>'L\'email n\'est pas valide'));

		$nom_profil=$this->input->post('nom_profil');
		$prenom_profil=$this->input->post('prenom_profil');
		$email_profil=$this->input->post('email_profil');

		if($this->form_validation->run()==FALSE){

			$this->load->view("templates/header");
			$this->load->view('formulaire_profil'); 
			$this->load->view("templates/footer");	
			
		}
		
		else{		


			$this->Model_membre->setProfil($nom_profil,$prenom_profil,$email_profil,$_SESSION['login']);
			$this->Model_membre->setNomVote($nom_profil,$_SESSION['login']);
			$data['profil']=$this->Model_membre->get_informations_utilisateur($_SESSION['login']);
			$this->load->view("templates/header");
			$this->load->view('profil',$data);
			$this->load->view("templates/footer");	


		}
	}

	public function cleVote(){

		$this->form_validation->set_rules('cle','Cle_participation','trim|required',array('required'=>'le champ cle est vide.'));

		$cle=$this->input->post('cle');

		if($this->form_validation->run()==FALSE){

			$this->load->view("templates/header");
			$this->load->view('cle_sondage'); 
			$this->load->view("templates/footer");	
			
			
		}
		else{

			$verifcle=$this->Model_membre->verifCle($cle);
			$createur=$this->Model_membre->getCreateurSondage($cle);
			$etat=$this->Model_membre->getEtat($cle);
			if($verifcle==1){
				if($createur!=$_SESSION['login']){
					if($etat==1){
						$data['validation'] = "cle valide.";
						$data['cle'] =$cle;
						$this->load->view("templates/header");
						$this->load->view('cle_sondage',$data);	
						$this->load->view("templates/footer");	
					}else{
						$data['erreur_participation'] = "Le sondage est acutellement ferme.";
						$this->load->view("templates/header");
						$this->load->view('cle_sondage',$data);
						$this->load->view("templates/footer");	
					}
				}else{
					$data['erreur_participation'] = "Vous ne pouvez pas participer a votre propre sondage.";
					$this->load->view("templates/header");
					$this->load->view('cle_sondage',$data);
					$this->load->view("templates/footer");	
				}

			}
			else{
				$data['erreur_participation'] = "La cle n'existe pas.";
				$this->load->view("templates/header");
				$this->load->view('cle_sondage',$data);
				$this->load->view("templates/footer");	

			}

		}	
	}



	public function vote($cle){

		$this->form_validation->set_rules('nom','Nom_participatiob','trim|required|min_length[3]|max_length[40]',array('required'=>'Le champ nom est vide.','min_length'=>'Le nom doit faire au moins 3 caractères.','max_length'=>'le nom ne doit pas dépasser 40 caractères.'));
		$this->form_validation->set_rules('date','date_participation','trim|required',array('required'=>'le champ  date est vide.'));
		$this->form_validation->set_rules('heure','Heure_participation','trim|required',array('required'=>' le champ  heure est vide.'));
		
		$data['utilisateur']= $this->Model_membre->get_informations_utilisateur($_SESSION['login']);
		$data['sondage']=$this->Model_membre->getSondage($cle);	
		$data['cle']=$cle;

		if($this->form_validation->run()==FALSE){

			$this->load->view("templates/headerS");
			$this->load->view('participation_sondage',$data);
			$this->load->view("templates/footer");	 
			
			
		}
		else{	
			$nom=$this->input->post('nom');
			$date=$this->input->post('date');
			$heure=$this->input->post('heure');
			$data_sondage['information_sondage']=$this->Model_membre->getMesSondages($_SESSION['login']);
			
			if((isset($cle)) && (isset($date))){
				$date = $this->Model_membre->modifDateInverser($date);
				$infosdate = $this->Model_membre->getInfoDate($cle);
				$debut_heure = $infosdate['debut_heure'];
				$fin_heure = $infosdate['fin_heure'];
				$debut_date = $infosdate['debut_date'];
				$fin_date = $infosdate['fin_date'];
				
				if(($date >=$debut_date) && ($date <= $fin_date)){
					if(($date==$debut_date)&&($debut_heure>$heure)){
						$data['erreur_participation'] = "Veuillez rentrer une heure sup�rieur a ".$infosdate['debut_heure']." pour cette date.";
						$this->load->view("templates/headerS");
						$this->load->view('participation_sondage',$data);
						$this->load->view("templates/footer");	

					}
					if(($date==$fin_date)&&($fin_heure<$heure)){
						$data['erreur_participation'] = "Veuillez rentrer une heure inf�rieur a ".$infosdate['fin_heure']." pour cette date.";
						$this->load->view("templates/headerS");
						$this->load->view('participation_sondage',$data);
						$this->load->view("templates/footer");	
					}
					$this->Model_membre->addVote($nom,$date,$heure,$cle,$_SESSION['login']);
					$data['erreur_participation'] = "Vote valide.";
					$this->load->view("templates/headerS");
					$this->load->view('participation_sondage',$data);
					$this->load->view("templates/footer");	
				}else{
					$debut_date=$this->Model_membre-> modifDateNormal($infosdate['debut_date']);
					$fin_date=$this->Model_membre-> modifDateNormal($infosdate['fin_date']);

					$data['erreur_participation'] = "Veuillez rentrer une date entre le : ".$debut_date." et le ".$fin_date.".";

					$this->load->view("templates/headerS");
					$this->load->view('participation_sondage',$data);
					$this->load->view("templates/footer");	
				}


				$taille=0;
				
				$data_date=$this->Model_membre->getListDateVoteSondage($cle,$debut_date,$fin_date);
				if($data_date!=-1){
					foreach ($data_date as $Vdate) {
						$compt=$this->Model_membre->nbVotePourDate($cle,$Vdate['date_vote']);
						if($taille<$compt){
							$date=$Vdate['date_vote'];
							$taille=$compt;
						}
					}
					if($date==$debut_heure){
						$min=$debut_heure;
					}else{
						$min=0;
					}
					if($date==$fin_date){
						$max=$fin_heure;	
					}else{
						$max=23;
					}
					$taille=0;
					for($i=$min;$i<=$max;$i++){
						$compt=0;
						$compt=$this->Model_membre->nbVotePourDateHeure($cle,$date,$i);
						if($taille<$compt){
							$heure=$i;
							$taille=$compt;
						}
					}
					$this->Model_membre->setModifDateHeureChoix($cle,$date,$heure);
				}		

			}
			
		}
		

	}
}


?>
