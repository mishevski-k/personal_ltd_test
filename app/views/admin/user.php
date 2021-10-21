<?php require APPROOT . "/views/includes/head.php" ?>
<div class="container">
    <?php require APPROOT . "/views/includes/nav.php" ?>
    <?php printNav("User ") ?>
    <div class="user-container">
        <div class="user">
            <h1>User Summary</h1>
            <div class="user-data">
                <div class="segment">
                    <h1>Name: <span><?php  echo $data['user_name'] ?></span></h1>
                </div>
                <div class="segment">
                    <h1>Surname: <span><?php  echo $data['user_surname'] ?></span></h1>
                </div>
                <div class="segment">
                    <h1>Avarage Score: <span><?php echo $data['avarage_score'] ?></span></h1>
                </div>
            </div>
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
                        <?php for($i = 0; $i < $data['limit']; $i++):  ?>
                            <tr>
                                <td><?php echo $data['calls'][$i]->id ?></td>
                                <td><?php echo $data['calls'][$i]->user ?></td>
                                <td><?php echo $data['calls'][$i]->client ?></td>
                                <td><?php echo $data['calls'][$i]->client_type ?></td>
                                <td><?php echo $data['calls'][$i]->date ?></td>
                                <td><?php echo formatSeconds($data['calls'][$i]->duration) ?></td>
                                <?php if($data['calls'][$i]->type_of_call === "Outgoing"): ?>
                                    <td class="clr-info call-type"><?php echo $data['calls'][$i]->type_of_call ?><i class="gg-arrow-top-left"></i></td>
                                <?php elseif($data['calls'][$i]->type_of_call === "Incoming"): ?>
                                    <td class="clr-success call-type"><?php echo $data['calls'][$i]->type_of_call ?><i class="gg-arrow-bottom-right"></i></td>
                                <?php endif; ?>
                                
                                <td><?php echo $data['calls'][$i]->external_call_score ?></td>
                                <td class="edit-item"><form action="<?php echo URLROOT . "/admin/call/" . $data['calls'][$i]->id ?>" method="POST"><input type="submit" value="Edit"></form></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require APPROOT . "/views/includes/footer.php" ?>
</div>
