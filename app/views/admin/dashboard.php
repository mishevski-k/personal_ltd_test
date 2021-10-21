<?php require APPROOT . "/views/includes/head.php" ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php" ?>
    <?php printNav("Home") ?>
    <div class="main-container">
    <a href="<?php echo URLROOT ?>/admin/newCall"><i class="gg-add-r"></i>New Call</a>
        <div class="calls-container">

        </div>

        <div class="users-container">
            <?php foreach($data['users'] as $user): ?>
                <div class="user">
                    <h1>User: <span><?php echo $user->user ?></span></h1>
                    <form action="<?php echo URLROOT . "/admin/user/" . str_replace(" ", "_", $user->user) ?>" method="POST"><input type="submit" value="View"></form>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
    <?php require APPROOT . "/views/includes/footer.php" ?>
    <script src="<?php echo URLROOT ?>/public/javascript/dashboard.js"></script>
</div>
