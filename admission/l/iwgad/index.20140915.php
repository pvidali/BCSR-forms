<!DOCTYPE HTML>
<html><head>
<meta charset="utf-8">
<title>Start College Now | Bard College at Simon's Rock</title>
		<script src="https://crm.orionondemand.com/crm/javascript/jquery/js/jquery-min.js" type="text/javascript"></script>
		<script src="https://crm.orionondemand.com/crm/javascript/jquery/js/jquery-ui-min.js" type="text/javascript"></script>
		<script type="text/javascript">
// <![CDATA[
jQuery.noConflict();
// ]]>
</script>
<script src="https://crm.orionondemand.com/crm/javascript/jquery/plugins/jquery.json.min.js" type="text/javascript"></script>
<script src="https://crm.orionondemand.com/crm/javascript/iw.js" type="text/javascript"></script>
<script src="https://crm.orionondemand.com/crm/javascript/IWFormValidator.js" type="text/javascript"></script>
<script src="https://crm.orionondemand.com/crm/javascript/uitypes.js" type="text/javascript"></script>
<script src="https://crm.orionondemand.com/crm/javascript/html.js" type="text/javascript"></script>
<script src="https://crm.orionondemand.com/crm/javascript/countrystate.js" type="text/javascript"></script>
<script src="https://crm.orionondemand.com/crm/javascript/fielddep.js" type="text/javascript"></script>
<script src="https://crm.orionondemand.com/crm/javascript/inlinelookup.js" type="text/javascript"></script>
<script src="https://crm.orionondemand.com/crm/javascript/formsruntime.js" type="text/javascript"></script>
<link rel="Stylesheet" type="text/css" href="https://crm.orionondemand.com/crm/javascript/jquery/css/smoothness/jquery-ui.css" />
<link rel="Stylesheet" type="text/css" href="https://crm.orionondemand.com/crm/css/common.css" />
<link rel="Stylesheet" type="text/css" href="https://crm.orionondemand.com/crm/css/formscommon.css" />
<link rel="Stylesheet" type="text/css" href="https://crm.orionondemand.com/crm/css/formsruntime.css" />
<script src="https://crm.orionondemand.com/crm/javascript/jquery/plugins/jquery.bjax.js" type="text/javascript"></script>
<script type="text/javascript">
// <![CDATA[
var serverURL = "https://crm.orionondemand.com";
// ]]>
</script>
<script src="https://crm.orionondemand.com/crm/javascript/inquiryformruntime.js" type="text/javascript"></script>

<script type="text/javascript" src="/js/form-funcs.js"></script>

<link rel="stylesheet" href="css/main.css" />
<link rel="stylesheet" href="/css/forms.css" />
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/google-analytics.php";
?>
<style>
.field-control label.left, .legend, label.left{
	font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #AB033A;
}
.legend{
	margin-bottom: 5px;
	border-bottom: solid 1px #B7DDF2;
	width: 414px;
	margin-left: 15px;
}

</style>
</head>
<body>
<div id="container">
	<div id="content">
		<div id="header" style="display:none"></div>
		<div id="main" style="padding-top:10px;">
		<?php
			if(!(isset($_POST['submit']))){
				$rightFloat = 'right';
				include $_SERVER['DOCUMENT_ROOT']."/admission/assetsnew/index.php";
			}
			else{
				$rightFloat = 'none';
				
			}
		?>
			<div id="right" style="float:<?php echo ($rightFloat);?>">
				<?php 
					include "request-info.php";
				?>
			</div>
		</div>
	</div>
</div>
</body>
</html>