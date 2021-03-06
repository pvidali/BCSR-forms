<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Parent Supplement | Application | Bard College at Simon's Rock</title>
<style>
body{
	background: #ccc;
	margin-top: 0px !important;
	margin: 0px !important;
	padding: 0px !important;
	font-family: Arial, Helvetica, Verdana, sans-serif;
}
#topDiv{
	margin: auto;
	width: 900px;
	background: #fff;
	border-left: 1px solid;
	border-right: 1px solid;
	padding: 0 11px;
}
</style>
</head>
<?php 
$qStr  = "";
$qStr .= "stdt_lname=";
$qStr .= $_REQUEST['stdt_lname'];
$qStr .= "&stdt_eml=";
$qStr .= $_REQUEST['stdt_eml'];

?>

<body>
<input type="hidden" id="hiddentick" name="hiddentick" value="0">
<input type="hidden" id="stdt_lname" name="stdt_lname" value="<?php echo($_REQUEST['stdt_lname']);?>">
<input type="hidden" id="stdt_eml" name="stdt_eml" value="<?php echo($_REQUEST['stdt_eml']);?>">
<div id="topDiv">
	<img src="/admission/images/secondary_wide_no_tagline.jpg" style="width: 904px; margin-top: 10px;" />
    <div id="IWDF-control-4" class="form-control richtext-control page-child first">
        <span style="font-size:10.0pt;">
            Simon's Rock would like to collect information about both parents, even if one or more is deceased or no longer has legal responsibilities toward the applicant.<br /><br />
<!--             <input type="checkbox" name="both_parents" id="both_parents"  onClick="toggleSubmitValue(this.checked)" />  -->
            <input type="checkbox" name="both_parents" id="both_parents"   /> 
            <label for="both_parents">I am completing the form for BOTH parents</label>.</span>
    </div>
</div>

<!-- <div id="tyiframeDiv">
	<iframe id="tyiframe" src="typage.php" style="height: 150px; width: 100%" frameborder="0"></iframe>
</div>
-->
<div id="p1iframeDiv">
	<iframe id="p1iframe" src="p1-iframe.php?<?php echo($qStr); ?>" style="height: 2500px; width: 100%" frameborder="0"></iframe>
</div>

<!--
<div id="p2iframeDiv" style="display:none">
	<iframe id="p2iframe" src="p2-iframe.php?<?php echo($qStr); ?>" frameborder="0"></iframe>
</div>
-->
</body>
</html>
