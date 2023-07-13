<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TC - Twitter Clone</title>
    <?= link_tag('css/bootstrap.min.css') ?>
    <link rel="stylesheet" href="<?= base_url('vendor/fortawesome/font-awesome/css/all.min.css') ?>">
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-ligt mt-2" 
            style="background-color: #e3f2fd;">  
            <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <?=img(['src'=>'images/Bootstrap_logo.svg', 'width'=>30, 'height'=>24])?>                
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">                
                <strong><a class="nav-link" href="<?=base_url('/')?>">(TC) Twitter Clone</a></strong>
                <a class="nav-link" href="<?=base_url('/auth')?>">Login</a>
                <a class="nav-link" href="<?=base_url('/register')?>">Register</a>
            </div>
            </div>
        </nav>