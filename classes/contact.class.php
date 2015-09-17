<?php

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
	
	const countries = array('AF' => 'AFGHANISTAN','AL' => 'ALBANIA','DZ' => 'ALGERIA','AS' => 'AMERICAN SAMOA','AD' => 'ANDORRA','AO' => 'ANGOLA','AI' => 'ANGUILLA','AQ' => 'ANTARCTICA','AG' => 'ANTIGUA AND BARBUDA','AR' => 'ARGENTINA','AM' => 'ARMENIA','AW' => 'ARUBA','AU' => 'AUSTRALIA','AT' => 'AUSTRIA','AZ' => 'AZERBAIJAN','AP' => 'AZORES','BS' => 'BAHAMAS','BH' => 'BAHRAIN','BD' => 'BANGLADESH','BB' => 'BARBADOS','BY' => 'BELARUS','BE' => 'BELGIUM','BZ' => 'BELIZE','BJ' => 'BENIN','BM' => 'BERMUDA','BT' => 'BHUTAN','BO' => 'BOLIVIA','BA' => 'BOSNIA AND HERZEGOWINA','XB' => 'BOSNIA-HERZEGOVINA','BW' => 'BOTSWANA','BV' => 'BOUVET ISLAND','BR' => 'BRAZIL','IO' => 'BRITISH INDIAN OCEAN TERRITORY','VG' => 'BRITISH VIRGIN ISLANDS','BN' => 'BRUNEI DARUSSALAM','BG' => 'BULGARIA','BF' => 'BURKINA FASO','BI' => 'BURUNDI','KH' => 'CAMBODIA','CM' => 'CAMEROON','CA' => 'CANADA','CV' => 'CAPE VERDE','KY' => 'CAYMAN ISLANDS','CF' => 'CENTRAL AFRICAN REPUBLIC','TD' => 'CHAD','CL' => 'CHILE','CN' => 'CHINA','CX' => 'CHRISTMAS ISLAND','CC' => 'COCOS (KEELING) ISLANDS','CO' => 'COLOMBIA','KM' => 'COMOROS','CG' => 'CONGO','CD' => 'CONGO, THE DEMOCRATIC REPUBLIC O','CK' => 'COOK ISLANDS','XE' => 'CORSICA','CR' => 'COSTA RICA','CI' => 'COTE D` IVOIRE (IVORY COAST)','HR' => 'CROATIA','CU' => 'CUBA','CY' => 'CYPRUS','CZ' => 'CZECH REPUBLIC','DK' => 'DENMARK','DJ' => 'DJIBOUTI','DM' => 'DOMINICA','DO' => 'DOMINICAN REPUBLIC','TP' => 'EAST TIMOR','EC' => 'ECUADOR','EG' => 'EGYPT','SV' => 'EL SALVADOR','GQ' => 'EQUATORIAL GUINEA','ER' => 'ERITREA','EE' => 'ESTONIA','ET' => 'ETHIOPIA','FK' => 'FALKLAND ISLANDS (MALVINAS)','FO' => 'FAROE ISLANDS','FJ' => 'FIJI','FI' => 'FINLAND','FR' => 'FRANCE (INCLUDES MONACO)','FX' => 'FRANCE, METROPOLITAN','GF' => 'FRENCH GUIANA','PF' => 'FRENCH POLYNESIA','TA' => 'FRENCH POLYNESIA (TAHITI)','TF' => 'FRENCH SOUTHERN TERRITORIES','GA' => 'GABON','GM' => 'GAMBIA','GE' => 'GEORGIA','DE' => 'GERMANY','GH' => 'GHANA','GI' => 'GIBRALTAR','GR' => 'GREECE','GL' => 'GREENLAND','GD' => 'GRENADA','GP' => 'GUADELOUPE','GU' => 'GUAM','GT' => 'GUATEMALA','GN' => 'GUINEA','GW' => 'GUINEA-BISSAU','GY' => 'GUYANA','HT' => 'HAITI','HM' => 'HEARD AND MC DONALD ISLANDS','VA' => 'HOLY SEE (VATICAN CITY STATE)','HN' => 'HONDURAS','HK' => 'HONG KONG','HU' => 'HUNGARY','IS' => 'ICELAND','IN' => 'INDIA','ID' => 'INDONESIA','IR' => 'IRAN','IQ' => 'IRAQ','IE' => 'IRELAND','EI' => 'IRELAND (EIRE)','IL' => 'ISRAEL','IT' => 'ITALY','JM' => 'JAMAICA','JP' => 'JAPAN','JO' => 'JORDAN','KZ' => 'KAZAKHSTAN','KE' => 'KENYA','KI' => 'KIRIBATI','KP' => 'KOREA, DEMOCRATIC PEOPLE\'S REPUB','KW' => 'KUWAIT','KG' => 'KYRGYZSTAN','LA' => 'LAOS','LV' => 'LATVIA','LB' => 'LEBANON','LS' => 'LESOTHO','LR' => 'LIBERIA','LY' => 'LIBYA','LI' => 'LIECHTENSTEIN','LT' => 'LITHUANIA','LU' => 'LUXEMBOURG','MO' => 'MACAO','MK' => 'MACEDONIA','MG' => 'MADAGASCAR','ME' => 'MADEIRA ISLANDS','MW' => 'MALAWI','MY' => 'MALAYSIA','MV' => 'MALDIVES','ML' => 'MALI','MT' => 'MALTA','MH' => 'MARSHALL ISLANDS','MQ' => 'MARTINIQUE','MR' => 'MAURITANIA','MU' => 'MAURITIUS','YT' => 'MAYOTTE','MX' => 'MEXICO','FM' => 'MICRONESIA, FEDERATED STATES OF','MD' => 'MOLDOVA, REPUBLIC OF','MC' => 'MONACO','MN' => 'MONGOLIA','MS' => 'MONTSERRAT','MA' => 'MOROCCO','MZ' => 'MOZAMBIQUE','MM' => 'MYANMAR (BURMA)','NA' => 'NAMIBIA','NR' => 'NAURU','NP' => 'NEPAL','NL' => 'NETHERLANDS','AN' => 'NETHERLANDS ANTILLES','NC' => 'NEW CALEDONIA','NZ' => 'NEW ZEALAND','NI' => 'NICARAGUA','NE' => 'NIGER','NG' => 'NIGERIA','NU' => 'NIUE','NF' => 'NORFOLK ISLAND','MP' => 'NORTHERN MARIANA ISLANDS','NO' => 'NORWAY','OM' => 'OMAN','PK' => 'PAKISTAN','PW' => 'PALAU','PS' => 'PALESTINIAN TERRITORY, OCCUPIED','PA' => 'PANAMA','PG' => 'PAPUA NEW GUINEA','PY' => 'PARAGUAY','PE' => 'PERU','PH' => 'PHILIPPINES','PN' => 'PITCAIRN','PL' => 'POLAND','PT' => 'PORTUGAL','PR' => 'PUERTO RICO','QA' => 'QATAR','RE' => 'REUNION','RO' => 'ROMANIA','RU' => 'RUSSIAN FEDERATION','RW' => 'RWANDA','KN' => 'SAINT KITTS AND NEVIS','SM' => 'SAN MARINO','ST' => 'SAO TOME AND PRINCIPE','SA' => 'SAUDI ARABIA','SN' => 'SENEGAL','XS' => 'SERBIA-MONTENEGRO','SC' => 'SEYCHELLES','SL' => 'SIERRA LEONE','SG' => 'SINGAPORE','SK' => 'SLOVAK REPUBLIC','SI' => 'SLOVENIA','SB' => 'SOLOMON ISLANDS','SO' => 'SOMALIA','ZA' => 'SOUTH AFRICA','GS' => 'SOUTH GEORGIA AND THE SOUTH SAND','KR' => 'SOUTH KOREA','ES' => 'SPAIN','LK' => 'SRI LANKA','NV' => 'ST. CHRISTOPHER AND NEVIS','SH' => 'ST. HELENA','LC' => 'ST. LUCIA','PM' => 'ST. PIERRE AND MIQUELON','VC' => 'ST. VINCENT AND THE GRENADINES','SD' => 'SUDAN','SR' => 'SURINAME','SJ' => 'SVALBARD AND JAN MAYEN ISLANDS','SZ' => 'SWAZILAND','SE' => 'SWEDEN','CH' => 'SWITZERLAND','SY' => 'SYRIAN ARAB REPUBLIC','TW' => 'TAIWAN','TJ' => 'TAJIKISTAN','TZ' => 'TANZANIA','TH' => 'THAILAND','TG' => 'TOGO','TK' => 'TOKELAU','TO' => 'TONGA','TT' => 'TRINIDAD AND TOBAGO','XU' => 'TRISTAN DA CUNHA','TN' => 'TUNISIA','TR' => 'TURKEY','TM' => 'TURKMENISTAN','TC' => 'TURKS AND CAICOS ISLANDS','TV' => 'TUVALU','UG' => 'UGANDA','UA' => 'UKRAINE','AE' => 'UNITED ARAB EMIRATES','UK' => 'UNITED KINGDOM','GB' => 'GREAT BRITAIN','USA' => 'UNITED STATES','UM' => 'UNITED STATES MINOR OUTLYING ISL','UY' => 'URUGUAY','UZ' => 'UZBEKISTAN','VU' => 'VANUATU','XV' => 'VATICAN CITY','VE' => 'VENEZUELA','VN' => 'VIETNAM','VI' => 'VIRGIN ISLANDS (U.S.)','WF' => 'WALLIS AND FURUNA ISLANDS','EH' => 'WESTERN SAHARA','WS' => 'WESTERN SAMOA','YE' => 'YEMEN','YU' => 'YUGOSLAVIA','ZR' => 'ZAIRE','ZM' => 'ZAMBIA','ZW' => 'ZIMBABWE');

	const states = array('alaska' => 'AK', 'alabama' => 'AL', 'arkansas' => 'AR', 'american samoa' => 'AS', 'arizona' => 'AZ','california' => 'CA','colorado' => 'CO','connecticut' => 'CT','d.c.' => 'DC','washington dc' => 'DC','washington d.c.' => 'DC','florida' => 'FL','micronesia' => 'FM','georgia' => 'GA','guam' => 'GU','hawaii' => 'HI','iowa' => 'IA','idaho' => 'ID','illinois' => 'IL','indiana' => 'IN','kansas' => 'KS','kentucky' => 'KY','louisiana' => 'LA','massachusetts' => 'MA','maryland' => 'MD','maine' => 'ME','marshall islands' => 'MH','michigan' => 'MI','minnesota' => 'MN','missouri' => 'MO','marianas' => 'MP','mississippi' => 'MS','montana' => 'MT','north carolina' => 'NC','north dakota' => 'ND','nebraska' => 'NE','new hampshire' => 'NH','new jersey' => 'NJ','new mexico' => 'NM','nevada' => 'NV','new york' => 'NY','ohio' => 'OH','oklahoma' => 'OK','oregon' => 'OR','pennsylvania' => 'PA','puerto rico' => 'PR','palau' => 'PW','rhode island' => 'RI','south carolina' => 'SC','south dakota' => 'SD',
'tennessee' => 'TN','texas' => 'TX','utah' => 'UT','virginia' => 'VA','virgin islands' => 'VI','vermont' => 'VT','washington' => 'WA','wisconsin' => 'WI','west virginia' => 'WV','wyoming' => 'WY','military americas' => 'AA','military pacific' => 'AP');


	function __construct($firstname,$middlename,$lastname,$nickname,$email,$role,$gender,$street_address,$street_address_2,$city,$state,$country,$postal_code,$phone,$dob,$high_school,$high_school_city,$high_school_state,$high_school_country,$anticipated_grad_year,$academic_interests,$academic_interests,$ethnicity,$reference,$mail_list,$call,$comment,$date_submitted,$vr_email,$vr_campaign,$vr_term){
		$this->firstname = $firstname;
		$this->middlename =  $middlename;
		$this->lastname =  $lastname;
		$this->nickname =  $nickname;
		$this->email =  $email;
		$this->role =  $role;
		$this->gender =  $gender;
		$this->street_address =  $street_address;
		$this->street_address_2 =  $street_address_2;
		$this->city =  $city;
		$this->state =  $state;
		$this->country =  $country;
		$this->postal_code =  $postal_code;
		$this->phone =  $phone;
		$this->dob =  $dob;
		$this->high_school =  $high_school;
		$this->high_school_city =  $high_school_city;
		$this->high_school_state =  $high_school_state;
		$this->high_school_country =  $high_school_country;
		$this->anticipated_grad_year =  $anticipated_grad_year;
		$this->academic_interests =  $academic_interests;
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
		
			
	}


	public function formatFields(){
		$this->firstname->formatFirstName();
		$this->middlename->caseFix();
		$this->firstname->caseFix();
		$this->middlename = formatFirstname($this->middlename);
		$this->lastname = formatLastname($this->lastname);
			
			//	$contact = new Contact();
			//	$contact->formatFields();
			
			if(isset($_POST['mname']) && $_POST['mname'] != ""){
				$mname = formatFirstname($_POST['mname']);
			}
			else {
				$mname = "";
			}
			if(isset($_POST['lname']) && $_POST['lname'] != ""){
				$lname = formatLastname($_POST['lname']);
			}
			else {
				$lname = "";
			}
			if(isset($_POST['nickname']) && $_POST['nickname'] != ""){
				$nickname = formatFirstname($_POST['nickname']);
			}
			else {
				$nickname = "";
			}
			if(isset($_POST['street_address']) && $_POST['street_address'] != ""){
				$street_address = formatAddress($_POST['street_address']);
			}
			else {
				$street_address = "";
			}
			if(isset($_POST['city']) && $_POST['city'] != ""){
				$city = formatCity($_POST['city']);
			}
			else {
				$city = "";
			}
			if(isset($_POST['zip']) && $_POST['zip'] != ""){
				$zip = formatZip($_POST['zip']);
			}			
			else {
				$zip = "";
			}
	}

	private function caseFix($input) {
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
	
	// Foreign postal codes sometimes have alpha values, make sure they are uppercase
	private function formatZip($zipcode) {
		return strtoupper($zipcode);
	}
	
	// Other than for the United States, grab the countries' proper intials from the $countries array above
	private function formatCountry($country,$countryArray) {
		if((strtolower($country) == 'united states') || (strtolower($country) == 'us')) {
			$country = "USA";
		}
		else {
			$c = $country;
			$country = $countryArray[$c];
		}
		if($country == ""){
			$country = $country;
		}
		return strtoupper($country);
	}
	
	
	private function formatState() {
		switch(strtolower($this->state)){
			case "alaska":
				$this->state = "AK";
				break;
			case "alabama":
				$this->state = "AL";
				break;
			case "arkansas":
				$this->state = "AR";
				break;
			case "american samoa":
				$this->state = "AS";
				break;
			case "arizona":
				$this->state = "AZ";
				break;
			case "california":
				$this->state = "CA";
				break;
			case "colorado":
				$this->state = "CO";
				break;
			case "connecticut":
				$this->state = "CT";
				break;
			case "d.c.":
				$this->state = "DC";
				break;
			case "washington dc":
				$this->state = "DC";
				break;
			case "washington d.c.":
				$this->state = "DC";
				break;
			case "florida":
				$this->state = "FL";
				break;
			case "micronesia":
				$this->state = "FM";
				break;
			case "georgia":
				$this->state = "GA";
				break;
			case "guam":
				$this->state = "GU";
				break;
			case "hawaii":
				$this->state = "HI";
				break;
			case "iowa":
				$this->state = "IA";
				break;
			case "idaho":
				$this->state = "ID";
				break;
			case "illinois":
				$this->state = "IL";
				break;
			case "indiana":
				$this->state = "IN";
				break;
			case "kansas":
				$this->state = "KS";
				break;
			case "kentucky":
				$this->state = "KY";
				break;
			case "louisiana":
				$this->state = "LA";
				break;
			case "massachusetts":
				$this->state = "MA";
				break;
			case "maryland":
				$this->state = "MD";
				break;
			case "maine":
				$this->state = "ME";
				break;
			case "marshall islands":
				$this->state = "MH";
				break;
			case "michigan":
				$this->state = "MI";
				break;
			case "minnesota":
				$this->state = "MN";
				break;
			case "missouri":
				$this->state = "MO";
				break;
			case "marianas":
				$this->state = "MP";
				break;
			case "mississippi":
				$this->state = "MS";
				break;
			case "montana":
				$this->state = "MT";
				break;
			case "north carolina":
				$this->state = "NA";
				break;
			case "north dakota":
				$this->state = "ND";
				break;
			case "nebraska":
				$this->state = "NE";
				break;
			case "new hampshire":
				$this->state = "NH";
				break;
			case "new jersey":
				$this->state = "NJ";
				break;
			case "new mexico":
				$this->state = "NM";
				break;
			case "nevada":
				$this->state = "NV";
				break;
			case "new york":
				$this->state = "NY";
				break;
			case "ohio":
				$this->state = "OH";
				break;
			case "oklahoma":
				$this->state = "OK";
				break;
			case "oregon":
				$this->state = "OR";
				break;
			case "pennsylvania":
				$this->state = "PA";
				break;
			case "puerto rico":
				$this->state = "PR";
				break;
			case "palau":
				$this->state = "PW";
				break;
			case "rhode island":
				$this->state = "RI";
				break;
			case "south carolina":
				$this->state = "SC";
				break;
			case "south dakota":
				$this->state = "SD";
				break;
			case "tennessee":
				$this->state = "TN";
				break;
			case "texas":
				$this->state = "TX";
				break;
			case "utah":
				$this->state = "UT";
				break;
			case "virginia":
				$this->state = "VA";
				break;
			case "virgin islands":
				$this->state = "VI";
				break;
			case "vermont":
				$this->state = "VT";
				break;
			case "washington":
				$this->state = "WA";
				break;
			case "wisconsin":
				$this->state = "WI";
				break;
			case "west virginia":
				$this->state = "WV";
				break;
			case "wyoming":
				$this->state = "WY";
				break;
			case "military americas":
				$this->state = "AA";
				break;
			case "military pacific":
				$this->state = "AP";
				break;
		}
	}
	
	private function getState() {
		if($this->country == "USA"){
			$this->state->formatState();
		}
		else{
			$this->state->caseFix();
		}
	}
	private function formatContact() {
		$this->firstname->formatFirstname() . " " . $this->lastname->formatLastname();
	}
	private function formatCompany() {
		$this->formatContact();
	}
	private function formatFirstname() {
		$this->firstname->caseFix();
	}
	private function formatMiddlename() {
		$this->middlename->caseFix();
	}
	private function formatLastname() {
		$this->lastname->caseFix();
	}
	private function formatAddress() {
		$this->address->caseFix();
	}
	private function formatCity() {
		$this->city->caseFix();
	}
}