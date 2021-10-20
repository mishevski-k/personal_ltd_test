<?php require APPROOT . "/views/includes/head.php" ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php" ?>
    <?php printNav("Edit Call ") ?>
    <div class="call-container">
        <div class="call-form">
            <form action="<?php echo URLROOT . "/admin/editCall/" . $data['call']->id ?>" method="POST">
                <h1>Edit call</h1>
                <div class="form-item">
                    <label for="select-user" class="form-label">User:</label>
                    <select name="select-user" id="select-user" class="form-select">
                        <option value="<?php echo $data['call']->user ?>" selected class="form-option"><?php echo $data['call']->user ?></option>
                        <?php foreach($data['users'] as $user): ?>
                            <option value="<?php echo $user->user ?>" class="form-option"><?php echo $user->user ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-item">
                    <label for="select-client" class="form-label">Client:</label>
                    <select name="select-client" id="select-client" class="form-select">
                        <option value="<?php echo $data['call']->client ?>" selected class="form-option"><?php echo $data['call']->client ?></option>
                        <?php foreach($data['clients'] as $client): ?>
                            <option value="<?php echo $client->client ?>" class="form-option"><?php echo $client->client ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-item">
                    <label for="select-client-type" class="form-label">Client Type:</label>
                    <select name="select-client-type" id="select-client-type" class="form-select">
                        <option value="<?php echo $data['call']->client_type ?>" selected class="form-option"><?php echo $data['call']->client_type ?></option>
                        <?php foreach($data['client_typies'] as $type): ?>
                            <option value="<?php echo $type->client_type ?>" class="form-option"><?php echo $type->client_type ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-item">
                    <label for="date" class="form-label">Date:</label>
                    <input type="text" name="date" id="date" class="form-date" value="<?php echo $data['call']->date ?>">
                    <p class="form-error"><?php echo $data['date_error'] ?></p>
                </div>
                <div class="form-item">
                    <label for="duration">Duration:</label>
                    <input type="number" name="duration" id="duration" class="form-input" min="0" value="<?php echo $data['call']->duration ?>">
                    <p class="form-error"><?php echo $data['duration_error'] ?></p>
                </div>
                <div class="form-item">
                    <label for="type_of_call" class="form-label">Type of Call:</label>
                    <select name="type_of_call" id="type_of_call" class="form-select">
                        <option value="<?php echo $data['call']->type_of_call ?>" selected><?php echo $data['call']->type_of_call ?></option>
                        <?php if($data['call']->type_of_call === "Outgoing"): ?>
                            <option value="Incoming" name="type">Incoming</option>
                        <?php else: ?>
                            <option value="Outgoing" name="type">Outgoing</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-item">
                    <label for="external_call_score" class="form-label">External Call Score:</label>
                    <input type="number" name="external_call_score" id="external_call_score" min="0" value="<?php echo $data['call']->external_call_score ?>" class="form-input">
                    <p class="form-error"><?php echo $data['score_error'] ?></p>
                </div>
                <div class="form-item">
                    <input type="submit" name="update" value="Update" class="form-submit">
                </div>
            </form>
            <form action="<?php echo URLROOT . "/admin/deleteCall/" . $data['call']->id ?>" method="POST">
                <input type="submit" name="delete" value="delete" class="delete-call">
            </form>
        </div>
    </div>
    <?php require APPROOT . "/views/includes/footer.php" ?>
</div>
