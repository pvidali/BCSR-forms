<!DOCTYPE HTML>
<html><head>
<meta charset="utf-8">
<title>Start College Now | Bard College at Simon's Rock</title>
<script type="text/javascript" src="js/pluit-prototype.js"></script>
<script type="text/javascript" src="js/pluit-effects.js"></script>
<script type="text/javascript" src="js/pluit-carousel.js"></script>
<script type="text/javascript" src="/js/form-funcs.js"></script>
<link href="css/pluit-carousel.css" rel="stylesheet" type="text/css" media="screen" /> 
<link href="css/pluit-carousel-skins.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="css/main.css" />
<link rel="stylesheet" href="/css/forms.css" />
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/google-analytics.php";
?>
</head>
<body>
<div id="container">
	<div id="content">
		<div id="header"></div>
		<div id="main">
		<?php
			if(!(isset($_POST['submit']))){
				$rightFloat = 'right';
		?>
			<iframe src="http://forms.simons-rock.edu/admission/assetsnew/index.php" width="567" height="760" scrolling="no" style="border: 0; margin: 0; padding: 0; width: 564px;float: left"></iframe>
		<?php
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
<script type="text/javascript">

new Pluit.Carousel('#carousel', {
  circular: true
});
</script>
</body>
</html>