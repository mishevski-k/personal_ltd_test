<?php 

function printNav($page) {
    ?>

        <nav>
            <div class="nav-brand">
                <a href=""><?php echo $page ?></a>
                <div class="nav-menu">
                    <i class="gg-menu"></i>
                </div>
            </div>
            <div class="nav-links">
                <ul>
                    <li class="nav-link"><a href="<?php echo URLROOT ?>/admin">Dashboard</a></li>
                    <li class="nav-link"><a href="<?php echo URLROOT ?>/admin/import">Import</a></li>
                </ul>
            </div>
        </nav>

    <?php
}

?>