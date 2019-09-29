<?php
    session_start();
    include_once 'pages/classes.php';
    $_SESSION['date'] = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consultations</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <header>
        <?php include_once 'pages/menu.php'?>
    </header>
    <div class="container">
        <div class="row">
            <section class="col-md-12">
                <?php if(isset($_GET['page'])){
                    $page = $_GET['page'];
                    if($page == 1){
                        if(isset($_SESSION['user']) || isset($_SESSION['admin'])){
                            include_once 'pages/schedule.php';
                        }
                        elseif(!isset($_SESSION['user']) || !isset($_SESSION['admin'])){
                            include_once 'pages/no_login.php';
                        }
                    }
                    else if($page == 2){
                        include_once 'pages/consultations.php';
                    }
                    else if($page == 3){
                        if(isset($_SESSION['user']) || isset($_SESSION['admin'])){
                            echo 'Welcome!';
                        }
                        elseif(!isset($_SESSION['user']) || !isset($_SESSION['admin'])){
                           include_once 'pages/registration.php';
                        }
                        
                    }
                    else if($page == 4){
                        include_once 'pages/admin.php';
                    }
                }
                else{
                    include_once 'pages/no_login.php';
                }
                ?>
            </section>
        </div>
        <div class="footer">NickUsov, company Step &copy; 2019</div>
    </div>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function getOrder() {
            let parent = $(event.target).parent();
            let room = $(event.target).attr('data-room');
            let pare = $(event.target).attr('data-pare');
            let date = $(event.target).attr('data-date');
            let user = $(event.target).attr('data-user');
            console.log('date: ' + date);
            $(parent).html(`<div style="display:flex"><input style="width:40px;height:20px;border:none;" type="number" class="number"><input style="width:130px;height:20px;border:none;" class="info" type="text"><button data-date="${date}" data-user="${user}" data-room="${room}" data-pare="${pare}" onclick="insertOrder()" class="btn btn-info" style="padding:0;font-size:12px;width:20px;height:20px">Ok</button><button onclick="delOrder()" class="btn btn-danger" style="font-size:12px;padding:0;width:20px;height:20px">X</button></div>`);
        };
        function delOrder() {
            let parent = $(event.target).parent();
            $(parent).html('<button onclick="getOrder()" style="height:16px; font-size:10px; margin: 3px 0 1px 170px; padding: 0;" class="btn btn-warning" name="btn_order" method="post">To order</button>');
        }
        function insertOrder() {
            let parent = $(event.target).parent();
            let room = $(event.target).attr('data-room');
            let pare = $(event.target).attr('data-pare');
            let students = $(event.target).siblings('.number').val();
            let info = $(event.target).siblings('.info').val(); 
            let date = $(event.target).attr('data-date');
            let user = $(event.target).attr('data-user');
            $.post('pages/ajax.php',{'user': user, 'date': date,'pare': pare, 'room_id': room, 'students':students, 'info':info}, (data)=>{
                if(data){
                   $(parent).html(data);
                };
            });
        };
    </script>
</body>
</html>