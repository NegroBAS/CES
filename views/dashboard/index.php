<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h4>Dashboard</h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="jumbotron">
                <h1 class="display-5">Bievenido <span class="text-primary"><?php echo $this->user['name']; ?></span></h1>
                <p class="lead">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi eaque esse eligendi vero eius quo pariatur! In, nisi quasi. Provident cumque maxime nobis earum voluptate quas soluta labore molestiae ab..</p>
                <hr class="my-4">
                <a class="btn btn-primary btn-lg" href="#" role="button">Empezar</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('views/layouts/footer.php') ?>