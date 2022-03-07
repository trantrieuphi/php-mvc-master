<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->yield('title') ;?></title>
</head>
<body>
    <?php $this->yield('header') ?>
    <h1>This is body</h1>
    <?php $this->yield('footer') ?>
</body>
</html>