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
<div class="filter-container">
    <?php
        if(count($data['calls']) >= 100){
            if($data['page_number'] == 0){
                for($i = 0; $i <= 4; $i++){
                    if($i == 0){
                        ?>
                            <button class="calls-page active"><?php echo $i ?></button>
                        <?php
                    }else{
                    ?>
                        <button class="calls-page"><?php echo $i ?></button>
                    <?php 
                    }
                }
            }elseif($data['page_number'] == 1){
                for($i = 1; $i <= 5; $i++){
                    if($i == 1){
                        ?>
                            <button class="calls-page active"><?php echo $i ?></button>
                        <?php
                    }else{
                    ?>
                        <button class="calls-page"><?php echo $i ?></button>
                    <?php }
                }
            }else{
                for($i = $data['page_number'] -2; $i <= $data['page_number'] + 4; $i++){
                    if($i == $data['page_number']){
                        ?>
                            <button class="calls-page active"><?php echo $i ?></button>
                        <?php
                    }else{
                        ?>
                            <button class="calls-page"><?php echo $i ?></button>
                        <?php
                    }
                }
            }
        }else{
            for($i = $data['page_number']-2; $i <= $data['page_number']; $i++){
                if($i == $data['page_number']){
                    ?>
                        <button class="calls-page active"><?php echo $i ?></button>
                    <?php
                }else{
                    ?>
                        <button class="calls-page"><?php echo $i ?></button>
                    <?php
                }
            }
        }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $(".calls-page").each(function(){
            $(this).click(function(){

                let page_number = $(this).html();

                $.ajax({
                    url: "admin/calls",
                    method: "POST",
                    data: {
                        page_number: page_number,
                    },
                    success:function(data){
                        $(".calls-container").html(data);
                    }
                })
            })
        })
    })
</script>
