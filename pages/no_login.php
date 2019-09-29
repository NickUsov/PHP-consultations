<?php
    include_once 'classes.php';
    $pdo = Tools::connect();
    $ps = $pdo->prepare("select * from rooms");            
    $ps->execute();
    $rows = ceil($ps->rowCount() / 4);
    if(isset($_POST['datepicker'])){
        $_SESSION['date'] = $_POST['datepicker'];
    }
    $date = $_SESSION['date'];
?>
<div class="row" style="margin:20px 0">
    <div class="col-md-12">
        <?=$_SESSION['date']?>
    </div>
</div>
<?php for($i = 0; $i < $rows; $i ++):?>
    <div class="row">
        <?php for($j = 0; $j < 4; $j ++):?>
            <div class="col-md-3">
            <?php if($line = $ps->fetch()):?>    
                <div class="panel panel-default">
                    <div style="color:white;background-color:gray" class="panel-heading">
                        <h4><?=$line['number']?></h4>
                    </div>
                    <div class="panel-body">
                        <?php 
                            $room_id = $line['id'];
                            $ps_consult = $pdo->prepare("select consults.pare, consults.customer_id, consults.students, consults.info, customers.login from consults, customers where consults.customer_id = customers.id and consults.room_id = $room_id and date = '$date'");
                            $ps_consult->execute();
                        ?>
                        <ol style="padding-left: 20px">
                            <? for($k = 1; $k < 9; $k ++):?>
                                <?php $ps_consult = $pdo->prepare("select consults.pare, consults.customer_id, consults.students, consults.info, customers.login from consults, customers where consults.customer_id = customers.id and consults.room_id = $room_id and date = '$date' and pare = $k");
                                    $ps_consult->execute();
                                ?>
                                <? if($consult = $ps_consult->fetch(PDO::FETCH_BOTH)):?>
                                    <li style="border-bottom: 1px solid gray"><span style="padding:0 10px"><?=$consult[4]?></span><span><?=$consult[2]?></span></li>
                                <? else:?>
                                    <li style="border-bottom: 1px solid gray"></li>
                                <? endif;?>
                            <? endfor;?>
                        </ol>
                    </div>
                </div>
                <?php endif;?>    
            </div>
        <?php endfor;?>
    </div>
<?php endfor;?>