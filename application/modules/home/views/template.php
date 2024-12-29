<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html><html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title ?></title>
  <link rel="shortcut icon" href="<?php echo base_url() ?>assets/favicon/favicon.ico">
  <meta property="og:locale" content="id_ID">
  <meta property="og:site_name" content="<?php echo $title ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendor/datatables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css">  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/home.css">   
  <style>
    body{ Background: url('<?php echo base_url()?>assets/img/<?php echo $pengaturan->background ?>');
    background-size:auto;
    background-attachment:fixed;}
  </style>
  <script>var base_url = "<?php echo base_url() ?>";</script> 
</head>
<body>  
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="text-center menu">
                    <a href="<?php echo base_url("home")?>" id="undian">Undian</a>
                    <a href="<?php echo base_url("home/peserta")?>" id="peserta">Peserta</a>                    
                    <a href="<?php echo base_url("home/pemenang")?>" id="pemenang">Pemenang</a>
                    <a href="<?php echo base_url("home/batal")?>" id="batal">Pemenang Batal</a>                    
                    <a href="<?php echo base_url("home/pengaturan")?>" id="pengaturan">Pengaturan</a>
                    <a href="<?php echo base_url("login/logout")?>" id="pengaturan">Keluar</a>
                </div>
            </div>
        </div>
    </div>
  <?php $this->load->view($content) ?>
</body>
</html>