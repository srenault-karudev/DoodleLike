		<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		class Model_membre extends CI_Model
		{
			public function __construct(){
		/**
		* on recharge la base a chaque fois qu'on appel ce model
		*/
		$this->load->database();
	}

	
	/**
	 *	Ajouter un nouveau utilisateur
	 */

	public function ajouter_utilisateur($login,$password,$nom,$prenom,$email)
	{
		$sql="INSERT INTO Utilisateur(login,password,nom,prenom,email) VALUES ( ?, ?, ?, ?, ?)";
		$req=$this->db->query($sql,array($login,$password,$nom,$prenom,$email));
	}

/**
	*Modifie le profil de l'utilisateur.
	*/
	public function setProfil($nom,$prenom,$email,$login){
		$sql="UPDATE Utilisateur set nom=?, prenom=?, email=? WHERE login=?";
		return $this->db->query($sql,array($nom,$prenom,$email,$login));
	}

	/**
	*Modifie le nom associe a un login dans la table vote.
	*/
	public function setNomVote($nom,$login){
		$sql="UPDATE Vote set nomU=? WHERE login=?";
		return $this->db->query($sql,array($nom,$login));
	}


	/**
	* retourne les informations de l'utilisateur 
	*/
	public function get_informations_utilisateur($login){

		$sql = "SELECT * FROM Utilisateur WHERE login = ?";
		$req = $this->db->query($sql, array($login));


/**
*calcul le nombre de ligne retourne
*/
$res = $req->num_rows();

if($res == 1){
	$res=$req->result_array();

	return $res;
}
else{

	return -1;

}
}

	/**
	*renvoie 1 si il trouve un tuple qui corresponde à c'est valeur sinon renvoie 0
	*/
	public function getPwOubli($login,$email){
		
		$sql= "SELECT password FROM Utilisateur WHERE login = ? AND email = ?";
		$req = $this->db->query($sql,array($login,$email));
		$res =$req->num_rows();
		return $res;
		
	}


/**
*connexion d'un utilisateur, renvoie le login , -2 si le compte n'existe pas  et -1 si le mdp est incorrect
*/
public function connexion($login, $password){


	$sql = "SELECT * FROM Utilisateur WHERE login = ?";
	$req = $this->db->query($sql, array($login));

	$res = $req->num_rows();

	if($res == 1){

		$sql = "SELECT * FROM Utilisateur WHERE login = ? AND password = ?";
		$req = $this->db->query($sql, array($login, $password));

		$res = $req->num_rows();

		if($res == 1){

			$row = $req->row();

			$login = $row->login;

			return $login;
		}
		else{

			return -2;
		}
	}
	else
	{
		return -1;
	}

}

	/**
	*Hashage du password pour sécuriser le compte de l'utilisateur.
	*/
	public function hashPW($log,$pw){
		$c=10+26+26;
		$lp=strlen($pw);
		$compt=0;
		$hash="";
		for($i=0;$i<$lp;$i++){
			$tmp=ord(substr($pw, $i,1))+ord(substr($log, ($compt%strlen($log)),1));
			$tmp=$tmp%$c;
			if(($tmp>9)&&($tmp<36)){
				$tmp=$tmp+55;
			}else{
				$tmp=$tmp+61;
			}
			$hash=$hash.chr($tmp);
			$compt++;
		}
		$id="".substr($log, 0,1).substr($log,strlen($log)-1,1);
		$hash=$id.$hash;
		return $hash;
	}
	/**
	*Hashage de la cle du sondage pour permettre de l'identifier.
	*/
	public function hashCle($log,$t){
		$date=time();
		$l=strlen($date);
		$r=$l%2;
		$l=$l/2;
		$cle=substr($date, 0,$l).$t.substr($date,$l,$l+$r);
		return $cle;
	}
	
	/**
	*Permet d'avoir la periode où les participants peuvent votes.
	*/
	public function getInfoDate($cle){
		$sql = "SELECT debut_date,debut_heure,fin_date,fin_heure FROM Sondage WHERE cle = ?";
		$req = $this->db->query($sql, array($cle));
		$res = $req->num_rows();
		
		if($res==1){
			$row=$req->row();
			$data['debut_date'] = $row->debut_date;
			$data['debut_heure'] = $row->debut_heure;
			$data['fin_date'] = $row->fin_date;
			$data['fin_heure'] = $row->fin_heure;

			return $data;
		}
		else{
			return -1;
		}
	}  	

	/**
	*Affectation d'un nouveau mot de passe.
	*/
	public function setPwOubli($login,$password){
		$sql="UPDATE Utilisateur set password=? where login=?";
		return $this->db->query($sql, array($password,$login));
	}
	/**
	*Compte le nombre de vote pour une date precise
	*/
	public function nbVotePourDate($cle,$date){
		$sql="SELECT COUNT(idVote) FROM Vote WHERE cle=? AND date_vote=?";
		$req=$this->db->query($sql,array($cle,$date));
		$res =$req->result_array();
		foreach($res as $nb){
		$count=$nb['COUNT(idVote)'];		
		return $count;
}		
	}
	/**
	*Compte le nombre de vote pour une date et une heure precise
	*/
	public function nbVotePourDateHeure($cle,$date,$heure){
		$sql="SELECT COUNT(idVote) FROM Vote WHERE cle=? AND date_vote=? AND heure_vote=?";
		$this->db->query($sql,array($cle,$date,$heure));
		$req=$this->db->query($sql,array($cle,$date,$heure));
		$res =$req->result_array();
		foreach($res as $nb){
		$count=$nb['COUNT(idVote)'];		
		return $count;
	}
}

	
	/**
	*Creation d'un sondage.
	*/
	public function setSondage($titre,$lieu,$cle,$createur,$debut_date,$debut_heure,$fin_date,$fin_heure,$description){
		$sql="INSERT INTO Sondage VALUES(?,?,?,?,?,?,?,?,null,null,true,0,?)";
		return $this->db->query($sql,array($titre,$lieu,$cle,$createur,$debut_date,$debut_heure,$fin_date,$fin_heure,$description));
	}
	/**
	*Modifier l'etat pour cloturer le sondage.
	*/
	public function setModifEtat($cle){
		$sql="UPDATE Sondage  set etat=false WHERE cle=?";
		return $this->db->query($sql,array($cle));
	}
	/**
	*Retourne l'etat du sondage.
	*/
	public function getEtat($cle){
		$sql="SELECT  etat from Sondage WHERE cle=?";
		$req=$this->db->query($sql,array($cle));
		$res =$req->num_rows();
		if($res==1){
			$row=$req->row();
			$etat=$row->etat;
			return $etat;
		}
		else{
			return -1;
		}


	}
/**
* renvoie 1 si la cle existe   ou 0 si elle n' existe pas .
*/
public function verifCle($cle){

	$sql= "SELECT * FROM Sondage WHERE cle = ? ";
	$req = $this->db->query($sql,array($cle));
	$res =$req->num_rows();	
	if($res==1){
		return $res;
	}
	else{
		return -1;
	}
}

	/**
	*Retourne les donnees du sondage.
	*/
	public function getSondage($cle){
		$sql="SELECT * FROM Sondage WHERE cle=?";
		$req=$this->db->query($sql,array($cle));
		$res =$req->result_array();
		return $res;
	}
	
	/**
	*Modifie la date et l'heure chosie pour le sondage.
	*/
	public function setModifDateHeureChoix($cle,$date,$heure){
		$sql="UPDATE Sondage set date_choisie=?, heure_choisie=? WHERE cle=?";
		return $this->db->query($sql,array($date,$heure,$cle));
	}

	/**
	*Retourne la liste des sondages crees par l'utilisateur.
	*/
	public function getMesSondages($login){
		$sql="SELECT * FROM Sondage WHERE createur=?";
		$req= $this->db->query($sql,array($login));
		$res =$req->result_array();
		return $res;
	}

	/**
	*Supprime un sondage.
	*/
	public function delSondage($cle){
		$sql="DELETE FROM Sondage WHERE cle=?";
		return $this->db->query($sql,array($cle));
	}

	/**
	*Supprime vote du sondage .
	*/
	public function delVote($cle){
		$sql="DELETE FROM Vote WHERE cle=?";
		return $this->db->query($sql,array($cle));
	}

	/**
	*Ajout un nouveau vote.
	*/
	public function addVote($nom,$date_vote,$heure_vote,$cle,$login){
		$sql="INSERT INTO Vote VALUES (' ',?,?,?,?,?)";
		return $this->db->query($sql,array($nom,$date_vote,$heure_vote,$cle,$login));
	}
	/**
	*Renvoie le login du createur de ce sondage.
	*/
	public function getCreateurSondage($cle){
		$sql="SELECT createur FROM Sondage WHERE cle=?";
		$req=$this->db->query($sql,array($cle));
		$res=$req->num_rows();
		if($res==1){
			$row=$req->row();
			$createur=$row->createur;
			return $createur;
		}
		else{
			return -1;
		}

	}
	/**
	*Transformation de  AAAA-MM-JJ --> JJ/MM/AA.
	*/
	public function modifDateNormal($date){
		$taille=strlen($date);
		return "".substr($date, $taille-2,2)."/".substr($date, $taille-5,2)."/".substr($date, $taille-8,2);
	}
	/**
	*Transformation de  JJ/MM/AA --> AAAA-MM-JJ , sachant que nous sommes dans les annees 2000 donc pas d'autre valeur que 20 pour les deux premiers A.
	*/
	public function modifDateInverser($date){
		$taille=strlen($date);
		return "20".substr($date, $taille-2,2)."-".substr($date, $taille-5,2)."-".substr($date, $taille-8,2);
	}

	/**
	*Renvoie la liste des dates de vote pour un sondage sachant que leur valeur est entre la date de debut et la date de fin.
	*/
	public function getListDateVoteSondage($cle,$ddate,$fdate){
		$sql="SELECT DISTINCT date_vote FROM Vote WHERE cle=?  AND  date_vote BETWEEN ? and ?";
		$req=$this->db->query($sql,array($cle,$ddate,$fdate));
		$res=$req->num_rows();
		if($res!=0){
		return $req->result_array();	
		}
		else{
			return -1;
		}
		
	}
}
