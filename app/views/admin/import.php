<?php require APPROOT . "/views/includes/head.php" ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php" ?>
    <?php printNav("Import Data") ?>
    <div class="import-container">
            <div class="import-form">
                <form action="<?php echo URLROOT ?>/admin/import" method="POST" enctype="multipart/form-data">
                    <h1>Import data</h1>
                    <div class="form-item">
                        <label for="import-csv" id="import-label" class="form-label">Choose file</label>
                        <p class="selected-file"></p>
                        <input type="file" name="import-csv" id="import-csv" class="form-input">
                        <p class="form-error"><?php echo $data['file-error'] ?></p>
                    </div>
                    <div class="form-item">
                        <input type="submit" name="import" value="import" class="form-submit">
                    </div>
                </form>
            </div>
        </div>
    <?php require APPROOT . "/views/includes/footer.php" ?>
</div>