<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html><html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Aplikasi Undian</title>
  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/ico.png">
  <meta property="og:title" content="Aplikasi Undian">
  <meta name="author" content="kacrut.site">
  <meta property="og:locale" content="id_ID">
  <link rel="canonical" href="">
  <meta property="og:url" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/home.css">    
</head>
<body>
  <div class="bingkai-top"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="text-center menu">
                    <a href="<?php echo base_url("login")?>" id="undian">FORM LOGIN</a>                                        
                </div>
            </div>
        </div>
    </div>
    <div class="container page" id="pemenang" style="margin-top: 100px;">
        <div class="row mb-2">
            <div class="col-md-4 offset-md-4">
                <div class="content">
                  <?php echo form_open("login/auth", 'class="login" id="login"') ?>
                    <h4>Form Login</h4>
                    <?php 
                    if($this->session->flashdata('error')!= null){
                      echo '<div style="color:red; text-align:center; margin-bottom:10px;">'.$this->session->flashdata('error').'</div>';
                    }
                    ?>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary" value="Login" name="">
                    </div>
                  <?php echo form_close() ?>
                </div>  
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">Copyright &copy; </div>
            <div class="col-md-6 text-right">
                Developed By IT BUM
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/custom.js"></script>
</body>
</html>