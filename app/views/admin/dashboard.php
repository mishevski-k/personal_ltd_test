<?php require APPROOT . "/views/includes/head.php" ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php" ?>
    <?php printNav("Home") ?>
    <div class="main-container">
    <a href="<?php echo URLROOT ?>/admin/newCall"><i class="gg-add-r"></i></a>
        <div class="calls-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Client</th>
                        <th>Client Type</th>
                        <th>Date</th>
                        <th>Duration</th>
                        <th>Type of Call</th>
                        <th>Еxternal call score</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['calls'] as $call): ?>
                        <?php if($call->duration > 10): ?>
                            <tr>
                                <td><?php echo $call->id ?></td>
                                <td><?php echo $call->user ?></td>
                                <td><?php echo $call->client ?></td>
                                <td><?php echo $call->client_type ?></td>
                                <td><?php echo $call->date ?></td>
                                <td><?php echo formatSeconds($call->duration) ?></td>
                                <?php if($call->type_of_call === "Outgoing"): ?>
                                    <td class="clr-info call-type"><?php echo $call->type_of_call ?><i class="gg-arrow-top-left"></i></td>
                                <?php elseif($call->type_of_call === "Incoming"): ?>
                                    <td class="clr-success call-type"><?php echo $call->type_of_call ?><i class="gg-arrow-bottom-right"></i></td>
                                <?php endif; ?>
                                
                                <td><?php echo $call->external_call_score ?></td>
                                <td class="edit-item"><form action="<?php echo URLROOT . "/admin/call/" . $call->id ?>" method="POST"><input type="submit" value="Edit"></form></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach;?>
                </tbody>
            </table>
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
</div>
