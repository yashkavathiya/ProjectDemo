<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <title><?php if(isset($title)) { echo $title; } ?></title>
    <?php 
    if(isset($style)){
        echo $style;
    }
    ?>
</head>

<body>
    