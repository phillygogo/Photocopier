<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Photocopier</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <?php $__env->startSection('banner'); ?>
            <div class="photo-header" role="banner">
                <div class="row photo-content">
                    <div class="logo col-md-2">
                    <a href="/"><img id="photo-logo" src="<?php echo e(asset('images/logo.png')); ?>" /></a>
                    </div>
                    <div xlass="col-md-8"></div>
                    <div class="col-md-2 offset-md-8 text-right photo-banner"><a href="/">About us</a></div>
                </div>
            </div>
        <?php echo $__env->yieldSection(); ?>
        <?php $__env->startSection('navbar'); ?>
            <div class="photo-nav position-ref border-top border-bottom">
                <div class="row photo-content">
                    <div class="links">
                        <a href="/facebook/getAlbums">Facebook</a>
                        <a href="/" style="color:#636b6f36;">Instagram</a>
                        <a href="/" style="color:#636b6f36;">Dropbox</a>
                        <a href="/" style="color:#636b6f36;">Google Drive</a>
                        <a href="/" style=color:#636b6f36;">One Drive</a>
                    </div>
                </div>
            </div>
        <?php echo $__env->yieldSection(); ?>

        <div class="photo-body">
            <div class="container">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>

        <?php $__env->startSection('footer'); ?>
            <div class="photo-footer border-top">
        <?php echo $__env->yieldSection(); ?>
    </body>
</html>

<?php /* /var/www/resources/views/layouts/app.blade.php */ ?>