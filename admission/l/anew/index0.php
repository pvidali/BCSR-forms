<?php

foreach($_REQUEST as $k => $v){
	echo "K: $k => V: $v<br />";	
}

?>


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
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17909295-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>
<div id="container">
	<div id="content">
		<div id="header"></div>
		<div id="main">
			<div id="left">
				<div class="pluit-carousel2 photo-tag-skin fancy-nav-skin2" id="carousel">
				<div class="left_top">You can start college now. <br>
					Without finishing high school.</div>
				<div id="slidenav"></div>
				<div class="viewport" style="width: 566px;">
					<ul class="ul_slideshow">
						<li><img alt="7" src="images/slide_7.jpg" /></li>
						<li><img alt="4" src="images/slide_4.jpg" /></li>
						<li><img alt="1" src="images/slide_1.jpg" /></li>
						<li><img alt="3" src="images/slide_3.jpg" /></li>
						<li><img alt="6" src="images/slide_6.jpg" /></li>
						<li><img alt="2" src="images/slide_2.jpg" /></li>
<!--						<li><img alt="5" src="images/slide_5.jpg" /></li> -->
					</ul>
					</div>
					<div class="left_footer">
						Work with inspiring professors, join other engaged students in<br />spirited debate, and have fun learning. <br /><br />
						It's life-changing, and yes it can be affordable. You owe it to yourself to check it out. <br /><br />
						It's life changing, and yes, it can be affordable. You owe it to yourself to check it out.
					</div>
				</div>			
			</div>
			<div id="right">
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