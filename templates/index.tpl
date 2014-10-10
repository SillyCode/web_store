<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<script src='../javascript/jquery-1.11.1.min.js'></script>
		<script src="../javascript/jquery-ui-1.11.1/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="../javascript/jquery-ui-1.11.1/jquery-ui.min.css">
		<link rel="stylesheet" href="../css/general.css">
	</head>
	</body>
		<p>Welcome to the website!!</p>
		<div class="tabs">
			<ul>
				{loop tabs}
					<li><a href="{url}">{text}</a></li>
				{/loop tabs}
			</ul>
		</div>
		{content}
	</body>
</html>