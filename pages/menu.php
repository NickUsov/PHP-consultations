<?php
    include_once 'classes.php';
    if(isset($_POST['log_in'])) {
        //echo "<script>alert('log_in')</script>";
        if($row = Tools::signIn($_POST['log_check'], $_POST['pas_check'])){
            if($row['role_id'] == 1){
              $_SESSION['admin'] = $row['login'];
              $_SESSION['user_id'] = $row['id'];
            }
            else if($row['role_id'] == 2){
              $_SESSION['user'] = $row['login'];
              $_SESSION['user_id'] = $row['id'];
            }
        }
        else echo 'Uncorrect login or password';  
    }
    if(isset($_POST['log_out'])) {
        if(isset($_SESSION['admin'])){
            unset($_SESSION['admin']);
            unset($_SESSION['user_id']); 
        }
        else if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            unset($_SESSION['user_id']);
        }   
    }
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="container">
    <div class="row">
      <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php?page=1">Consultations</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <?php $page=$_GET['page']?$_GET['page']:1?>
        <li <?=($page==1)? 'class="active"':''?>>
          <a href="index.php?page=1">Schedule</a>
        </li>
        <li <?=$page==2? 'class="active"':''?>>
          <a href="index.php?page=2">Consultations</a>
        </li>
        <li <?=$page==3? 'class="active"':''?>>
          <a href="index.php?page=3">Registration</a>
        </li>
        <li <?=$page==4? 'class="active"':''?>>
          <a href="index.php?page=4">Admin</a>
        </li>
        <li>
        
            <?php if(isset($_SESSION['user_id'])):?>
              <div style="display:flex;margin-top:8px;margin-left:230px">
                <?php $user = $_SESSION['user'];?>
                <span style="color:white;margin-right:50px;margin-top:8px">Welcome, <?=$user?></span>
                <form action="" method="post" >
                  <input type="submit" class="btn btn-warning" value="Unsign" name="log_out">
                </form>
              </div> 
            <? else:?>
            <form class="navbar-form navbar-left" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="log_check" placeholder="Login">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="pas_check" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-warning" name="log_in">Sign in</button>
            </form>
            <? endif;?>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
    </div>
    </div>
  </div><!-- /.container-fluid -->
</nav>