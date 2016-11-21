<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$msg?></title>
</head>
<body>

<h1>Welcome</h1>

<?php echo $msg ?>

<form method="post" action="<?= URL::to('contact')?>">
	<input type="text" name="name">
	<input type="password" name="password">
	<input type="submit" value="GO">
</form>

</body>
</html>