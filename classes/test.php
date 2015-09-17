<?php
ini_set("display_errors","On");
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

require_once $_SERVER['DOCUMENT_ROOT']."/includes/formatting-functions.php";

class Contact {
	private $firstname;
	private $middlename;
	private $lastname;
	private $nickname;
	private $email;
	private $role;
	private $gender;
	private $street_address;
	private $street_address_2;
	private $city;
	private $state;
	private $country;
	private $postal_code;
	private $phone;
	private $dob;
	private $high_school;
	private $high_school_city;
	private $high_school_state;
	private $high_school_country;
	private $anticipated_grad_year;
	private $academic_interests;
	private $extra_curricular;
	private $ethnicity;
	private $reference;
	private $mail_list;
	private $call;
	private $comment;
	private $date_submitted;
	private $vr_email;
	private $vr_campaign;
	private $vr_term;
	private $banner_id;

	function __construct($firstname,$middlename,$lastname,$nickname,$email,$role,$gender,$street_address,$street_address_2,$city,$state,$country,$postal_code,$phone,$dob,$high_school,$high_school_city,$high_school_state,$high_school_country,$anticipated_grad_year){
		//,$academic_interests,$academic_interests,$ethnicity,$reference,$mail_list,$call,$comment,$date_submitted,$vr_email,$vr_campaign,$vr_term
		$this->firstname = caseFix($firstname);
		$this->middlename =  caseFix($middlename);
		$this->lastname =  caseFix($lastname);
		$this->nickname =  caseFix($nickname);
		$this->email =  $email;
		$this->role =  $role;
		$this->gender =  $gender;
		$this->street_address =  caseFix($street_address);
		$this->street_address_2 =  caseFix($street_address_2);
		$this->city =  caseFix($city);
		$this->state =  $state;
		$this->country =  $country;
		$this->postal_code =  formatZip($postal_code);
		$this->phone =  $phone;
		$this->dob =  $dob;
		$this->high_school =  $high_school;
		$this->high_school_city =  $high_school_city;
		$this->high_school_state =  $high_school_state;
		$this->high_school_country =  $high_school_country;
		$this->anticipated_grad_year =  $anticipated_grad_year;
/*		$this->academic_interests =  $academic_interests;
		$this->extra_curricular =  $extra_curricular;
		$this->ethnicity =  $ethnicity;
		$this->reference =  $reference;
		$this->mail_list =  $mail_list;
		$this->call =  $call;
		$this->comment =  $comment;
		$this->date_submitted =  $date_submitted;
		$this->vr_email =  $vr_email;
		$this->vr_campaign =  $vr_campaign;
		$this->vr_term =  $vr_term;
*/	}
	
	private function outputName(){
		echo $this->firstname;
		echo " ";
		echo $this->middlename;
		echo " ";
		echo $this->lastname;
	}
	public function output(){
		$this->outputName();
	}

	function caseFix() {
		$whole = array();
		if(strstr($input,"-")){
			$parts = explode("-",$input);
			foreach($parts as $part){
				$whole[] = ucwords(strtolower($part));
			}
			return implode("-",$whole);
		}
		else{
			return 	ucwords(strtolower($input));
		}
	}

}
?>