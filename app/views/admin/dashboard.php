<?php require APPROOT . "/views/includes/head.php" ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php" ?>
    <?php printNav("Home") ?>
    <div class="main-container">
        <div class="calls-container">
            <a href=""><i class="gg-add-r"></i></a>
            
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
                        <tr>
                            <td><?php echo $call->id ?></td>
                            <td><?php echo $call->user ?></td>
                            <td><?php echo $call->client ?></td>
                            <td><?php echo $call->client_type ?></td>
                            <td><?php echo $call->date ?></td>
                            <td><?php echo $call->duration ?></td>
                            <?php if($call->type_of_call === "Outgoing"): ?>
                                <td class="clr-info call-type"><?php echo $call->type_of_call ?><i class="gg-arrow-top-left"></i></td>
                            <?php elseif($call->type_of_call === "Incoming"): ?>
                                <td class="clr-success call-type"><?php echo $call->type_of_call ?><i class="gg-arrow-bottom-right"></i></td>
                            <?php endif; ?>
                            
                            <td><?php echo $call->external_call_score ?></td>
                            <td class="edit-item"><form action="<?php echo URLROOT . "/admin/call/" . $call->id ?>" method="POST"><input type="submit" value="Edit"></form></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        
    </div>
    <?php require APPROOT . "/views/includes/footer.php" ?>
</div>
