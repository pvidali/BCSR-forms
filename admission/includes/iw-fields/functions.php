<?

function makeCommonTextfield($nameArray){
	$required = $nameArray["required"];
	$type = $nameArray["type"];
	$label = $nameArray["label"];
	$form_section = $nameArray["form_section"];
	$iw_field_name = $nameArray["iw_field_name"];
	$iw_field_id = $nameArray["iw_field_id"];
	$maxlength = $nameArray["maxlength"];
	$value = $nameArray["value"];
	$label_position = $nameArray["label_position"];

	$lnbrk = "\n";
	$reqSymbol = "";
	if($required){
		$label_class = "dynamic-form-required $label_position";
		$reqSymbol = "* ";
	}

	$str  = "";
	$str .= '<li class="clear-float"></li>';
	$str .= '	<li class="control-draggable control-child-wrapper">'.$lnbrk;
	$str .= '		<div id="IWDF-control-6" class="form-control field-control">'.$lnbrk;
	$str .= '			<label for="';
	$str .= $form_section;
	$str .= '.';	
	$str .= $iw_field_id;
	$str .= '" style="width:16em; margin-right: 5px;" class="';
	$str .= $label_class;
	$str .= '">'.$lnbrk;
	$str .= $reqSymbol;
	$str .= $label;
	$str .= '</label>';
	$str .= '<input name="';
	$str .= $form_section;
	$str .= '.';
	$str .= $iw_field_name;
	$str .= '" id="';
	$str .= $form_section;
	$str .= '.';
	$str .= $iw_field_id;
	$str .= '" value="';
	$str .= $value;
	$str .= '" type="';
	$str .= $type;
	$str .= '" />'.$lnbrk;	
	$str .= '<script type="text/javascript">'.$lnbrk;
	$str .= '// <![CDATA['.$lnbrk;
	$str .= '_IW.FormValidator.addTextFieldValidator("';
	$str .= $form_section;
	$str .= '.';
	$str .= $iw_field_id;
	$str .= '", "notEmpty", null, { trim: true, isReqFunc: true });'.$lnbrk;
	$str .= '// ]]>'.$lnbrk;
	$str .= '</script>'.$lnbrk;
	$str .= '	</div>'.$lnbrk;
	$str .= '</li>'.$lnbrk;
	return $str;
}

/*



												






												<script type="text/javascript">
// <![CDATA[
_IW.FormValidator.addTextFieldValidator("Contacts.685000000003015", "notEmpty", null, { trim: true, isReqFunc: true });
// ]]>
</script>
*/