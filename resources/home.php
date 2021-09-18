<?php
if ( !isset($_SESSION['user']) ) {
    redirect('\login');
}
?>

<div class="container my-5 d-flex justify-content-center">
    <div class="card" style="width: 25rem;">
    <img src="<?php echo url('/resources/assets/images/user-satisfaction.png') ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title text-capitalize"><?php echo $user['firstname'].' '.$user['lastname']; ?></h5>
        <p class="card-text">You are successfuly loggedIn!</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><?php echo $user['email']; ?></li>
        <li class="list-group-item">Registered at : <?php echo $user['created_at']; ?></li>
        <li class="list-group-item">Last login at : <?php echo $user['updated_at']; ?></li>
    </ul>
    <div class="card-body">
        <a href="<?php url('\logout'); ?>" class="card-link">Logout</a>
    </div>
    </div>
</div>