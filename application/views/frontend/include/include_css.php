<?php $FrontSiteInfo = FrontSiteInfo(); ?>

<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
<!-- <meta name="description" content="<?php //echo $meta_description ?>">
<meta name="keywords" content="<?php //echo $meta_keywords ?>"> -->
<title> <?= $pageTitle;?> | <?= $FrontSiteInfo['pageTitle']?></title>

<link rel="shortcut icon" href="<?php echo base_url('public/front/images/logo/'.$FrontSiteInfo['site_favicon']);?>" type="image/x-icon">

<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?php echo FRONT_ASSETS;?>css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo FRONT_ASSETS;?>revolution/css/settings.css">
<link rel="stylesheet" type="text/css" href="<?php echo FRONT_ASSETS;?>revolution/css/layers.css">
<link rel="stylesheet" type="text/css" href="<?php echo FRONT_ASSETS;?>revolution/css/navigation.css">
<link rel="stylesheet" type="text/css" href="<?php echo FRONT_ASSETS;?>css/jquery.mmenu.css">
<link rel="stylesheet" type="text/css" href="<?php echo FRONT_ASSETS;?>css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo FRONT_ASSETS;?>css/responsive.css">

<link rel="stylesheet" type="text/css" href="<?php echo COMMON;?>developer.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>