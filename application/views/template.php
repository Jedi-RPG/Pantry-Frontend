<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>{pagetitle}</title>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="/assets/css/default.css"/>
</head>
<body>
<div id="header">
	<ul>
		<li><a href="/">RPG Crafter</a></li>
	</ul>
</div>
<div id="container">
	<div id="navigation">
		<ul>
			<li><a href="/" {dActive}>Dashboard</a></li>
			<li><a href="/admin" {aActive}>Administration</a></li>
			<li><a href="/receiving" {rActive}>Receiving</a></li>
			<li><a href="/production" {pActive}>Production</a></li>
			<li><a href="/sales" {sActive}>Sales</a></li>
		</ul>
	</div>
	{content}
</div>
<footer>
	<!-- <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.{ci_version}</p> -->
</footer>
<script type = 'text/javascript' src = "/assets/js/admin.js"></script>
</body>
</html>