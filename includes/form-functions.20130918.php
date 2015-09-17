<?php

function error_check($test_value){
	if($test_value == "1"){
		return true;
	}
	else{
		return false;
	}
}


function get2digitMonth($month){
	switch ($month){
		case 'Jan':
			$dobm = '01';
			break;
		case 'Feb':
			$dobm = '02';
			break;
		case 'Mar':
			$dobm = '03';
			break;
		case 'Apr':
			$dobm = '04';
			break;
		case 'May':
			$dobm = '05';
			break;
		case 'Jun':
			$dobm = '06';
			break;
		case 'Jul':
			$dobm = '07';
			break;
		case 'Aug':
			$dobm = '08';
			break;
		case 'Sep':
			$dobm = '09';
			break;
		case 'Oct':
			$dobm = '10';
			break;
		case 'Nov':
			$dobm = '11';
			break;
		case 'Dec':
			$dobm = '12';
			break;
	}
	return $dobm;
}

function getDOB($dob_y,$dob_m,$dob_d){
	$dob  = $dob_y;
	$dob .= '-';
	$dob .= get2digitMonth($dob_m);
	$dob .= '-';
	$dob .= $dob_d;
	return $dob;
}

function dupCheck($db,$email,$fname,$lname,$zip){
	$dup_flag = "";
	$sql = "SELECT * FROM admission_banner_upload WHERE LOWER(`GOREMAL_EMAIL_ADDRESS`) = '".strtolower($email)."'";
	$db->do_query($sql);
	if($db->numRows()) {
		$dup_flag .= "email";
		$row = $db->fetchObject();
		$banner_id = $row->SPRIDEN_ID;
	}
	$sql = "SELECT * FROM `admission_banner_upload` WHERE LOWER(`PERS_LAST_NAME`) = '".strtolower($lname)."' AND 
					LOWER(`PERS_FIRST_NAME`) LIKE '%".strtolower($fname)."%' AND 
					`SPRADDR_ZIP` = '$zip'";
	$db->do_query($sql);
	if($db->numRows()) {
		if($dup_flag != ""){
			$dup_flag .= ",";
		}
		$dup_flag .= "lname,fname,zip";
		$row = $db->fetchObject();
		$banner_id = $row->SPRIDEN_ID;
	}
	if($dup_flag != ""){
		$dup_flag .= " (BANNER ID: $banner_id)";
	}
	return $dup_flag;
}

function makeIcontactFrame($email,$fname,$lname,$street_address,$city,$state,$zip,$dob,$anticipated_grad_year,$fields_recruiter){
	$icontactStr = "";
	$icontactStr .= "email=$email";
	$icontactStr .= "&";
	$icontactStr .= "fname=$fname";
	$icontactStr .= "&";
	$icontactStr .= "lname=$lname";
	$icontactStr .= "&";
	$icontactStr .= "street_address=$street_address";
	$icontactStr .= "&";
	$icontactStr .= "city=$city";
	$icontactStr .= "&";
	$icontactStr .= "state=$state";
	$icontactStr .= "&";
	$icontactStr .= "zip=$zip";
	$icontactStr .= "&";
	$icontactStr .= "dob=$dob";
	$icontactStr .= "&";
	$icontactStr .= "anticipated_grad_year=$anticipated_grad_year";
	$icontactStr .= "&";
	$icontactStr .= "fields_recruiter=$fields_recruiter";
	$icontactFrame = "<iframe src=\"http://forms.simons-rock.edu/admission/l/a/icontact.php?$icontactStr\" width=\"0\" height=\"0\"></iframe>";
	return $icontactFrame;
}

function concatDOB($m,$d,$y){
	$m = get2digitMonth($m);
	$dob = $m."/".$d."/".$y;
	return $dob;
}

function makeIWShortFrame($postArray){
	if($postArray['phonetype'] == 'Cell'){
		$phonekey = "685000000003031";
	}
	else {
		$phonekey = "685000000003027";
	}
	$formStr = "";
	$formStr .= "fname=".$postArray['fname']; // fname
	$formStr .= "&";
	$formStr .= "lname=".$postArray['lname']; // lname
	$formStr .= "&";
	$formStr .= "phonekey=$phonekey"; // phonetype
	$formStr .= "&";
	$formStr .= "phone=".$postArray['phone']; // phone
	$formStr .= "&";
	$formStr .= "email=".$postArray['email']; 
	$formStr .= "&";
	$formStr .= "hs_gradyear=".$postArray['hs_gradyear']; // hs grad year
	$formStr .= "&";
	$formStr .= "three_words=".$postArray['three_words']; // three words
	$formStr .= "&";
	$formFrame = "<iframe src=\"http://forms.simons-rock.edu/admission/l/iw/iw-short.php?$formStr\" width=\"0\" height=\"0\" style=\"border: 0\"></iframe>";
	return $formFrame;
}


// function makeIWFrame($email,$fname,$lname,$street_address,$city,$state,$zip,$dob,$anticipated_grad_year,$fields_recruiter){
function makeIWFrame($postArray){
	$DOB = concatDOB($postArray['dob_m'],$postArray['dob_d'],$postArray['dob_y']);
	$formStr = "";
	$formStr .= "Contacts_685000000003015=".$postArray['Contacts_685000000003015'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003017=".$postArray['Contacts_685000000003017'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000120167=".$postArray['Contacts_685000000120167'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003051=".$postArray['Contacts_685000000003051'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003063=".$postArray['Contacts_685000000003063'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003065=".$postArray['Contacts_685000000003065'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000123120=".$postArray['Contacts_685000000123120'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003069=".$postArray['Contacts_685000000003069'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003067=".$postArray['Contacts_685000000003067'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003071=".$postArray['Contacts_685000000003071'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003021=".$postArray['Contacts_685000000003021'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003027=".$postArray['Contacts_685000000003027'];
	$formStr .= "&";
	$formStr .= "Contacts_685000000003033=$DOB";
	$formStr .= "&";
	$formStr .= "Contacts_685000000110551=".$postArray['Contacts_685000000110551'];
	$formStr .= "&";
	$formStr .= "EducationHistory_High_School_records_IWDF-row-53_685000000002963=".$postArray['EducationHistory_High_School_records_IWDF-row-53_685000000002963'];
	$formStr .= "&";
	$formStr .= "EducationHistory_High_School_records_IWDF-row-53_685000000002993=".$postArray['EducationHistory_High_School_records_IWDF-row-53_685000000002993'];
	$formStr .= "&";
	$formStr .= "EducationHistory_High_School_records_IWDF-row-53_685000000003005=".$postArray['EducationHistory_High_School_records_IWDF-row-53_685000000003005'];
	$formStr .= "&";
	$formStr .= "EducationHistory_High_School_records_IWDF-row-53_685000000029103=".$postArray['EducationHistory_High_School_records_IWDF-row-53_685000000029103'];
	$formStr .= "&";
	$formStr .= "EducationHistory_High_School_records_IWDF-row-53_685000000002975=".$postArray['EducationHistory_High_School_records_IWDF-row-53_685000000002975'];
	$formStr .= "&";
	$formStr .= "EducationHistory_High_School_records_IWDF-row-53_685000000002997=".$postArray['EducationHistory_High_School_records_IWDF-row-53_685000000002997'];
	$formStr .= "&";
	$formStr .= "EducationHistory_High_School_myType=".$postArray['EducationHistory_High_School_myType'];
	$formFrame = "<iframe src=\"http://forms.simons-rock.edu/admission/l/iw/iw.php?$formStr\" width=\"0\" height=\"0\"></iframe>";
	return $formFrame;
}

function iw_fieldmapping($db,$type_passed,$value_passed){
	
	$sql = "SELECT * FROM admission_iw_fieldmapping WHERE $type_passed = '$value_passed'";
	$db->do_query($sql);
	$row = $db->fetchObject();
	return $row->conventional;
}
function iw_forminfo($db,$formid){
	$forminfo = array();
	$sql = "SELECT * FROM admission_iw_form WHERE id = $formid";
	$db->do_query($sql);
	$row = $db->fetchObject();
	$forminfo['formId'] = $row->iw_form_id;
	$forminfo['seed'] = $row->iw_form_seed;
	$forminfo['sbgi_source'] = $row->sbgi_source;
	$forminfo['lead_source'] = $row->lead_source;
	$forminfo['specify_source'] = $row->specify_source;
	$sql = "SELECT * FROM admission_iw_form_fields WHERE form_id = $formid";
	$db->do_query($sql);
	$field_ids = array();
	while($row = $db->fetchObject()){
		$field_ids[] = $row->field_id;
	}
	foreach($field_ids as $field_id){
		$sql = "SELECT * FROM admission_iw_fieldmapping WHERE id = $field_id";
		$db->do_query($sql);
		$row = $db->fetchObject();
		$section = $row->form_section;
		$conventional = $row->conventional;
		$forminfo['fields'][$section][$conventional] = $row->iw_formfield_name;
	}
	return $forminfo;
}

function iw_fieldmap_name($db,$fieldname){
	
	$sql = "SELECT * FROM admission_iw_fieldmapping WHERE conventional = '$fieldname'";
	$db->do_query($sql);
	$row = $db->fetchObject();
	return $row->iw_formfield_name;
	//	$iw_naming = array();
	//	$iw_naming['iw_formfield_name'] = $row->iw_formfield_name;
	//	$iw_naming['iw_post_varname'] = $row->iw_post_varname;
}

function getTerritoryInfoDB($state,$country,$db){
	// grab counselor info from DB
	$territory = $state;
	if ($territory == "") {
		$territory = $country;
	}
	$sql = "SELECT id FROM admission_territories WHERE territory = '$territory'";
	$db->do_query($sql);
	$result = $db->fetchObject();
	$terrId = $result->id;

	$sql = "SELECT admission_territories_zone FROM admission_territory_zones WHERE id = $terrId";
	$db->do_query($sql);
	$result = $db->fetchObject();
	$terrZoneId = $result->admission_territories_zone;

	$sql = "SELECT admission_recruiter FROM admission_recruiter_territory WHERE admission_territory_zone = $terrZoneId";
	$db->do_query($sql);
	$result = $db->fetchObject();
	$counsId = $result->admission_recruiter;

	$sql = "SELECT * FROM admission_recruiter  WHERE id = $counsId";
	$db->do_query($sql);
	$result = $db->fetchObject();
	$counsInfo['fname'] 			= $result->fname;
	$counsInfo['lname'] 			= $result->lname;
	$counsInfo['email'] 			= $result->email;
	$counsInfo['phone'] 			= $result->phone;
	$counsInfo['redir']	 			= $result->redir;
	$counsInfo['image'] 			= $result->image;
	$counsInfo['fields_recruiter'] 	= $result->fields_recruiter;

	$redirStr  = "http://www.simons-rock.edu/admission/";
	$redirStr .= $counsInfo['redir'];
	$redirStr .= "/";
		
	$counsInfo['redirStr'] = $redirStr;
	$counsInfo['doRedir'] = true;
	$counsInfo['recruiter_email_handle'] = $counsInfo['email']."@simons-rock.edu";

	return $counsInfo;
}

function setSource($source){
	$str  = date('Ymd');
	$str .= " ";
	$str .= $source;
	return $str;
}

function getTerritoryInfo($territory,$territories){
	$territories['south'] = array( 'KY', 'TN', 'NC', 'SC', 'MS', 'AL', 'GA', 'FL', 'IA', 'MO', 'AR', 'WI', 'MN','NS', 'IN', 'IL');
	
	// joe
	$territories['middle'] = array('NJ','DE','MD','DC','VA','WV','TX','LA','PAE');
	
	// joel
	$territories['north'] = array('MA', 'CT', 'RI', 'VT', 'NH', 'ME', 'OH', 'MI','PAW','OTH');
	
	// alexandra
	$territories['southwest'] = array('NYC', 'AZ', 'CA', 'CO', 'ID', 'KS', 'MT', 'ND', 'NE', 'NM', 'NV', 'OK', 'SD', 'UT', 'WY');
	
	// steve
	$territories['west'] = array('OR', 'WA', 'AK', 'HI', 'BC');
	
	$ethnicities = array('ethnicity_af','ethnicity_ai','ethnicity_ai_tribe','ethnicity_ai_enrolled','ethnicity_as','as_origin_country',
						'ethnicity_is','is_origin_country','ethnicity_hs','hs_origin_country','ethnicity_ma','ethnicity_nh',
						'ethnicity_pr','ethnicity_un','ethnicity_wh','ethnicity_ot','ot_specify');
	if(in_array($territory,$territories['south'])){
		$redir = "amanda-dubrowski";
		$fields_recruiter = "dubrowski";
		$recruiter_email_handle = "adubrowski@simons-rock.edu";
	}
	elseif(in_array($territory,$territories['middle'])){
		$redir = "verrelli";
		$fields_recruiter = "verrelli";
		$recruiter_email_handle = "mverrelli@simons-rock.edu";
	}
	elseif(in_array($territory,$territories['north'])){
		$redir = "joel-pitt";
		$fields_recruiter = "pitt";
		$recruiter_email_handle = "jpitt@simons-rock.edu";
	}
	elseif(in_array($territory,$territories['southwest'])){
		$redir = "taylor";
		$fields_recruiter = "taylor";
		$recruiter_email_handle = "ataylor@simons-rock.edu";
	}
	elseif(in_array($territory,$territories['west'])){
		$redir = "coleman";
		$fields_recruiter = "coleman";
		$recruiter_email_handle = "scoleman@simons-rock.edu";
	}
	else{
		$redir = "on-the-road/locations-outside-the-united-states/davidson";
		$fields_recruiter = "davidson";
		$recruiter_email_handle = "leslied@simons-rock.edu";
	}
	$redirStr  = "http://www.simons-rock.edu/admission/";
	$redirStr .= $redir;
	$redirStr .= "/";

	$tinfo = array();
	$tinfo['redir'] = $redir;
	$tinfo['fields_recruiter'] = $fields_recruiter;
	$tinfo['redirStr'] = $redirStr;
	$tinfo['doRedir'] = true;
	$tinfo['recruiter_email_handle'] = $recruiter_email_handle;

	return 	$tinfo;	
}
function makeHash($fname,$lname,$dob_y,$dob_m,$dob_d){
	$dob =  $dob_y.$dob_m.$dob_d;
	$str = strtolower($fname).strtolower($lname);
	return hash_hmac('md5',$str,$dob);
}

function makeEmail($postArray,$formNum,$dup_flag){
	//	return array of email elements
	foreach($postArray as $k => $v){
		$$k = $v;
	}
	$on_date = date('M j, Y ');
	$body = "";
	$subj = "";
	$emailArray = array();
	if($formNum == "0"){
		if($dup_flag != ""){
			$body .= "POSSIBLE DUPLICATE RECORD\n $dup_flag \n\n";
		}
		$body = "";
		$body .= "This request was submitted online at $on_date \n\n\n";
		$body .= "            Student First Name: $fname \n";
		$body .= "           Student Middle Name: $mname \n";
		$body .= "             Student Last Name: $lname \n";
		$body .= "                Usually Called: $nickname \n";
		$body .= "                        Gender: $gender \n";
		$body .= "                Street Address: $street_address \n";
		$body .= "                          City: $city \n";
		$body .= "                State/Province: $state \n";
		$body .= "                      Zip code: $zip \n";
		$body .= "                       Country: $country\n";
		$body .= "                 Email address: $email\n";
		$body .= "                         Phone: $phone\n";
		$body .= "                 Date of Birth: $dob_month/$dob_day/$dob_year \n";
		$body .= "                   High School: $high_school \n";
		$body .= "         High School City/Town: $high_school_city \n";
		$body .= "    High School State/Province: $high_school_state \n";
		if($high_school_state == "NY"){
			$body .= "     High School County/Region: $nycounty\n";
		}
		if($high_school_state == "PA"){
			$body .= "     High School County/Region: $paArea\n";
		}
		$body .= "           High School Country: $high_school_country\n";
		$body .= "Anticipated year of graduation: $anticipated_grad_year\n\n";
		$body .= "     How did you hear about SR? $how_did_you_hear";
		if($parent_url == "inquire" && $how_did_you_hear == "Other"){
			$body .= ": \t( $how_hear_other )";
		}
		$body .= "\n\n";
		$body .= "            Academic Interests: $academic_interests \n\n";
		$body .= "    Extracurricular Activities: $extra_interests\n\n";
		$body .= "Ethnic Background\n";
		$body .= "     AF: $ethnicity_af \n";
		$body .= "     AI: $ethnicity_ai \tTribal affiliation: $ethnicity_ai_tribe     Enrolled: $ethnicity_ai_enrolled\n";
		$body .= "     AS: $ethnicity_as \t\tCountry/ies of family's origin: $as_origin_country\n";
		$body .= "     IS: $ethnicity_is \t\tCountry/ies: $is_origin_country\n";
		$body .= "     HS: $ethnicity_hs \t\tCountry/ies: $hs_origin_country\n";
		$body .= "     MA: $ethnicity_ma \n";
		$body .= "     NH: $ethnicity_nh \n";
		$body .= "     PR: $ethnicity_pr \n";
		$body .= "     UN: $ethnicity_un \n";
		$body .= "     WH: $ethnicity_wh \n";
		$body .= "     OT: $ethnicity_ot \t\tSpecify: $ot_specify\n\n";
		$body .= "           Parent 1 first name: $parent1_fname\n";
		$body .= "            Parent 1 last name: $parent1_lname\n";
		$body .= "                 Parent 1 type: $parent1_type\n";
		$body .= "                Parent 1 email: $parent1_email\n";
		$body .= "                Parent 1 phone: $parent1_phone\n";
		$body .= "           Parent 1 phone type: $parent1_phonetype\n";
		$body .= "           Parent 2 first name: $parent2_fname\n";
		$body .= "            Parent 2 last name: $parent2_lname\n";
		$body .= "                 Parent 2 type: $parent2_type\n";
		$body .= "                Parent 2 email: $parent2_email\n";
		$body .= "                Parent 2 phone: $parent2_phone\n";
		$body .= "           Parent 2 phone type: $parent2_phonetype\n";
		if($parent_url != "inquire"){
			$body .= "                  Mailing list: $mailinglist\n";
		}
		else{
			$body .= "What three words capture your essence: $three_words \n";
		}
		$body .= "I have additional questions, please contact me: $additional_questions\n";
		$body .= "Questions/Comments: $questions_and_comments \n\n";

		if($parent_url != "inquire"){
			$body .= "Form used: http://www.simons-rock.edu/admission/forms/request_info\n\n";
		}
		else{
			$body .= "Form used: http://www.simons-rock.edu/inquire\n\n";
		}

		if($parent_url != "inquire"){
			$subj = "Information Request";
		}
		else {
			$subj = "Information Request -- Search Inquiry Mailing";
		}		
	}

	if($formNum == "1"){	
		if($dup_flag != ""){
			$body .= "POSSIBLE DUPLICATE RECORD\n $dup_flag \n\n";
		}
		$body .= "This request was submitted online at $on_date \n\n\n";
		$body .= "            Student First Name: $fname \n";

		$body .= "           Student Middle Name: $mname \n";
		$body .= "             Student Last Name: $lname \n";
		$body .= "                Usually Called: $nickname \n";
		$body .= "                        Gender: $gender \n";
		$body .= "                Street Address: $street_address \n";
		$body .= "                          City: $city \n";
		$body .= "                State/Province: $state \n";
		$body .= "                      Zip code: $zip \n";
		$body .= "                       Country: $country\n";
		$body .= "                 Email address: $email\n";
		$body .= "                         Phone: $phone\n";
		$body .= "                 Date of Birth: $dob_m/$dob_d/$dob_y\n";
		$body .= "                   High School: $high_school \n";
		$body .= "         High School City/Town: $high_school_city \n";
		$body .= "    High School State/Province: $high_school_state \n";
		if($high_school_state == "NY"){
			$body .= "     High School County/Region: $nycounty\n";
		}
		if($high_school_state == "PA"){
			$body .= "     High School County/Region: $paArea\n";
		}
		$body .= "           High School Country: $high_school_country\n";
		$body .= "Anticipated year of graduation: $anticipated_grad_year\n\n";
		if(isset($vr_email) && $vr_email != ""){
			$body .= "      Vertical Response E-mail: $vr_email \n";
			$body .= "    Vertical Response Campaign: $vr_campaign \n";
			$body .= "        Vertical Response Term: $vr_term \n";
		}
		$subj = "Info Request -- Search Inquiry Slideshow Part 1";
	}
	else if($formNum == "2"){
		$body = "";
		$body .= "This request was submitted online at $on_date \n\n\n";
		$body .= "           Part 2 (survey) for: $email\n";
		$body .= "                 Email address: $email\n";
		$body .= "     How did you hear about SR? $how_did_you_hear";
		$body .= "\n\n";
		$body .= "What three words capture your essence: $three_words\n";
		$body .= "            Academic Interests: $academic_interests\n\n";
		$body .= "    Extracurricular Activities: $extra_interests\n\n";
		$body .= "                      Question: $questions_and_comments\n\n";
		$body .= "Ethnic Background\n";
		$body .= "     AF: $ethnicity_af \n";
		$body .= "     AI: $ethnicity_ai \tTribal affiliation: $ethnicity_ai_tribe     Enrolled: $ethnicity_ai_enrolled\n";
		$body .= "     AS: $ethnicity_as \t\tCountry/ies of family's origin: $as_origin_country\n";
		$body .= "     IS: $ethnicity_is \t\tCountry/ies: $is_origin_country\n";
		$body .= "     HS: $ethnicity_hs \t\tCountry/ies: $hs_origin_country\n";
		$body .= "     MA: $ethnicity_ma \n";
		$body .= "     NH: $ethnicity_nh \n";
		$body .= "     PR: $ethnicity_pr \n";
		$body .= "     UN: $ethnicity_un \n";
		$body .= "     WH: $ethnicity_wh \n";
		$body .= "     OT: $ethnicity_ot \t\tSpecify: $ot_specify\n\n";
		$body .= "           Parent 1 first name: $parent1_fname\n";
		$body .= "            Parent 1 last name: $parent1_lname\n";
		$body .= "                 Parent 1 type: $parent1_type\n";
		$body .= "                Parent 1 email: $parent1_email\n";
		$body .= "                Parent 1 phone: $parent1_phone\n";
		$body .= "           Parent 1 phone type: $parent1_phonetype\n";
		$body .= "           Parent 2 first name: $parent2_fname\n";
		$body .= "            Parent 2 last name: $parent2_lname\n";
		$body .= "                 Parent 2 type: $parent2_type\n";
		$body .= "                Parent 2 email: $parent2_email\n";
		$body .= "                Parent 2 phone: $parent2_phone\n";
		$body .= "           Parent 2 phone type: $parent2_phonetype\n";
		$subj = "Info Request -- Search Inquiry Slideshow Part 2";
	}
	$emailArray['body'] = $body;
	$emailArray['subj'] = $subj;
	return $emailArray;
}
function getCounselorEmailHandle($counselor){
	if($counselor=="dubrowski"){
		$recruiter_email_handle = "adubrowski@simons-rock.edu";
	}
	elseif($counselor=="corso"){
		$recruiter_email_handle = "jcorso@simons-rock.edu";
	}
	elseif($counselor=="pitt"){
		$recruiter_email_handle = "jpitt@simons-rock.edu";
	}
	elseif($counselor=="taylor"){
		$recruiter_email_handle = "ataylor@simons-rock.edu";
	}
	elseif($counselor=="coleman"){
		$recruiter_email_handle = "scoleman@simons-rock.edu";
	}
	else{
		$recruiter_email_handle = "leslied@simons-rock.edu";
	}	
	return $recruiter_email_handle;
}
function fixFormatting(&$postArray){
	// fix some formatting 
	if(isset($postArray['fname']) && $postArray['fname'] != ""){
		$postArray['fname'] = formatFirstname($postArray['fname']);
	}

	if(isset($postArray['mname']) && $postArray['mname'] != ""){
		$postArray['mname'] = formatFirstname($postArray['mname']);
	}

	if(isset($postArray['lname']) && $postArray['lname'] != ""){
		$postArray['lname'] = formatLastname($postArray['lname']);
	}

	if(isset($postArray['nickname']) && $postArray['nickname'] != ""){
		$postArray['nickname'] = formatFirstname($postArray['nickname']);
	}

	if(isset($postArray['street_address']) && $postArray['street_address'] != ""){
		$postArray['street_address'] = formatAddress($postArray['street_address']);
	}

	if(isset($postArray['city']) && $postArray['city'] != ""){
		$postArray['city'] = formatCity($postArray['city']);
	}

	if(isset($postArray['zip']) && $postArray['zip'] != ""){
		$postArray['zip'] = formatZip($postArray['zip']);
	}			

	if(isset($postArray['parent1_fname']) && $postArray['parent1_fname'] != ""){
		$postArray['parent1_fname'] = formatFirstname($postArray['parent1_fname']);
	}			

	if(isset($postArray['parent1_lname']) && $postArray['parent1_lname'] != ""){
		$postArray['parent1_lname'] = formatLastname($postArray['parent1_lname']);
	}			

	if(isset($postArray['parent2_fname']) && $postArray['parent2_fname'] != ""){
		$postArray['parent2_fname'] = formatFirstname($postArray['parent2_fname']);
	}			

	if(isset($postArray['parent2_lname']) && $postArray['parent2_lname'] != ""){
		$postArray['parent2_lname'] = formatLastname($postArray['parent2_lname']);
	}			
}

function makeSQL($postArray,$formNum){
	foreach($postArray as $k => $v){
		$$k = $v;
	}
	if($formNum == "0"){
		$fname = safe($fname);
		$mname = safe($mname);
		$lname = safe($lname);
		$nickname = safe($nickname);
		$street_address = safe($street_address);
		$city = safe($city);
		$state = safe($state);
		$zip = safe($zip);
		$country = safe($country);
		$email = safe($email);
		$phone = safe($phone);
		$high_school = safe($high_school);
		$high_school_city = safe($high_school_city);
		$high_school_state = safe($high_school_state);
		$high_school_country = safe($high_school_country);
		$anticipated_grad_year = safe($anticipated_grad_year);
		if(isset($nycounty) && $nycounty != ""){
			$nycounty = safe($nycounty);
		}
		if(isset($paArea) && $paArea != ""){
			$paArea = safe($paArea);
		}
		$role = "student"; // ('student','parent','donor','alumni')
		if($gender == "male"){
			$gender = "m";
		}
		else if($gender == "female"){
			$gender = "f";
		}
		else {
			$gender = "";
		}
		$dob  = $dob_year;
		$dob .= '-';
		$dob .= $dob_month;
		$dob .= '-';
		$dob .= $dob_day;
		
		$hash_id = makeHash($fname,$lname,$dob_year,$dob_month,$dob_day);

		$this_ethnicity = "";
		foreach($postArray['ethnicities'] as $ethnicity){
			if($postArray[$ethnicity] != ""){
				$this_ethnicity .= $ethnicity.":".$postArray[$ethnicity];
				$this_ethnicity .= ",";
			}
		}
		if($this_ethnicity != ""){
			$this_ethnicity = substr($this_ethnicity,0,strlen($this_ethnicity)-1);
		}
		// clean up for db insert
		$academic_interests = safe($academic_interests);
		$extra_curricular = safe($extra_interests);
		$three_words = safe($three_words);
		$questions_and_comments = safe($questions_and_comments);
		$ethnicity = $this_ethnicity;
		$parent1_fname = safe($parent1_fname);
		$parent1_lname = safe($parent1_lname);
		$parent1_relationship = substr($parent1_type,0,1);
		$parent1_email = safe($parent1_email);
		$parent1_phone = safe($parent1_phone);
		$parent1_phonetype = $parent1_phonetype;
		$parent2_fname = safe($parent2_fname);
		$parent2_lname = safe($parent2_lname);
		$parent2_relationship = substr($parent2_type,0,1);
		$parent2_email = safe($parent2_email);
		$parent2_phone = safe($parent2_phone);
		$parent2_phonetype = $parent2_phonetype;
		
		if($mailinglist != ""){
			$mail_list = "1";
		}
		else{
			$mail_list = "0";
		}
		if($additional_questions != ""){
			$call = "1";
		}
		else{
			$call = "0";
		}
		$sql = "INSERT INTO forms.admission_form_submission 
			(form_id, firstname, middlename, lastname, nickname, email, role, gender, street_address, street_address_2, 
			 city, state, country, postal_code, phone, dob, high_school, high_school_city, high_school_state, 
			 high_school_country, anticipated_grad_year, academic_interests, extra_curricular, three_words, ethnicity, 
			 reference, mail_list, `call`, comment, date_submitted, vr_email, vr_campaign, vr_term, hash_id, 
			 parent1_fname, parent1_lname, parent1_relationship, parent1_email, parent1_phone, parent1_phonetype, 
			 parent2_fname, parent2_lname, parent2_relationship, parent2_email, parent2_phone, parent2_phonetype, 
			 dup_flag, typage_wedcall, typage_thcall, typage_question, counselor) 
			   VALUES (
			 $formNum, '$fname', '$mname', '$lname', '$nickname', '$email', '$role', '$gender', '$street_address', 
			 '$street_address_2', '$city', '$state', '$country', '$zip', '$phone', '$dob', '$high_school', '$high_school_city', 
			 '$high_school_state', '$high_school_country', '$anticipated_grad_year', '$academic_interests', '$extra_curricular', 
			 '$three_words', '$ethnicity', '$how_did_you_hear', '$mail_list', '$call', '$questions_and_comments', NOW(), 
			 '', '', '', '$hash_id', '$parent1_fname', '$parent1_lname', '$parent1_relationship', '$parent1_email', 
			 '$parent1_phone', '$parent1_phonetype', '$parent2_fname', '$parent2_lname', '$parent2_relationship', 
			 '$parent2_email', '$parent2_phone', '$parent2_phonetype', '$dup_flag', '', '', '', '$counselor')";
	}
	else if($formNum == "1"){
		$fname = safe($fname);
		$mname = safe($mname);
		$lname = safe($lname);
		$nickname = safe($nickname);
		$street_address = safe($street_address);
		$city = safe($city);
		$state = safe($state);
		$zip = safe($zip);
		$country = safe($country);
		$email = safe($email);
		$phone = safe($phone);
		$high_school = safe($high_school);
		$high_school_city = safe($high_school_city);
		$high_school_state = safe($high_school_state);
		$high_school_country = safe($high_school_country);
		$anticipated_grad_year = safe($anticipated_grad_year);
		if(isset($nycounty) && $nycounty != ""){
			$nycounty = safe($nycounty);
		}
		if(isset($paArea) && $paArea != ""){
			$paArea = safe($paArea);
		}
		$role = "student"; // ('student','parent','donor','alumni')
		if($gender == "male"){
			$gender = "m";
		}
		else if($gender == "female"){
			$gender = "f";
		}
		else {
			$gender = "";
		}
		$dob =  getDOB($dob_y,$dob_m,$dob_d);
		$hash_id = makeHash($fname,$lname,$dob_y,$dob_m,$dob_d);

		$tinfo = getTerritoryInfo($high_school_state,$territories);
		$counselor = $tinfo['fields_recruiter'];

		$sql = "INSERT INTO forms.admission_form_submission
(form_id, firstname, middlename, lastname, nickname, email, role, gender, street_address, street_address_2, city, state, country, postal_code, phone, dob, high_school, high_school_city, high_school_state, high_school_country, anticipated_grad_year, date_submitted, vr_email, vr_campaign, vr_term, hash_id, dup_flag,counselor) 
VALUES ($formNum, '$fname', '$mname', '$lname', '$nickname', '$email', '$role', '$gender', '$street_address', '$street_address_2', '$city', '$state', '$country', '$zip', '$phone', '$dob', '$high_school', '$high_school_city', '$high_school_state', '$high_school_country', '$anticipated_grad_year', NOW(), '$vr_email', '$vr_campaign', '$vr_term', '$hash_id','$dup_flag','$counselor');
";
	}
	else {
		$this_ethnicity = "";
		foreach($postArray['ethnicities'] as $ethnicity){
			if($postArray[$ethnicity] != ""){
				$this_ethnicity .= $ethnicity.":".$postArray[$ethnicity];
				$this_ethnicity .= ",";
			}
		}
		if($this_ethnicity != ""){
			$this_ethnicity = substr($this_ethnicity,0,strlen($this_ethnicity)-1);
		}
		// clean up for db insert
		$academic_interests = safe($academic_interests);
		$extra_curricular = safe($extra_interests);
		$three_words = safe($three_words);
		$additional_questions = safe($questions_and_comments);
		$ethnicity = $this_ethnicity;
		$parent1_fname = safe($parent1_fname);
		$parent1_lname = safe($parent1_lname);
		$parent1_relationship = substr($parent1_type,0,1);
		$parent1_email = safe($parent1_email);
		$parent1_phone = safe($parent1_phone);
		$parent1_phonetype = $parent1_phonetype;
		$parent2_fname = safe($parent2_fname);
		$parent2_lname = safe($parent2_lname);
		$parent2_relationship = substr($parent2_type,0,1);
		$parent2_email = safe($parent2_email);
		$parent2_phone = safe($parent2_phone);
		$parent2_phonetype = $parent2_phonetype;
		
		$db_id = $db_id;
		$counselor = $counselor;
		
		$sql = "UPDATE forms.admission_form_submission SET 
			academic_interests = '$academic_interests',
			extra_curricular = '$extra_curricular',
			three_words = '$three_words',
			comment = '$additional_questions',
			ethnicity = '$ethnicity',
			parent1_fname = '$parent1_fname',
			parent1_lname = '$parent1_lname',
			parent1_relationship = '$parent1_relationship',
			parent1_email = '$parent1_email',
			parent1_phone = '$parent1_phone',
			parent1_phonetype = '$parent1_phonetype',
			parent2_fname = '$parent2_fname',
			parent2_lname = '$parent2_lname',
			parent2_relationship = '$parent2_relationship',
			parent2_email = '$parent2_email',
			parent2_phone = '$parent2_phone',
			parent2_phonetype = '$parent2_phonetype',
			counselor = '$counselor' 
				WHERE id = $db_id";
	}
	return $sql;
}
if (!function_exists('json_encode')) {
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}

if(!function_exists('json_decode'))
{
    function json_decode($json)
    {
        $comment = false;
        $out = '$x=';
        for ($i=0; $i<strlen($json); $i++)
        {
            if (!$comment)
            {
                if (($json[$i] == '{') || ($json[$i] == '['))
                    $out .= ' array(';
                else if (($json[$i] == '}') || ($json[$i] == ']'))
                    $out .= ')';
                else if ($json[$i] == ':')
                    $out .= '=>';
                else
                    $out .= $json[$i];
            }
            else
                $out .= $json[$i];
            if ($json[$i] == '"' && $json[($i-1)]!="\\")
                $comment = !$comment;
        }
        eval($out . ';');
        return $x;
    }
}
?>