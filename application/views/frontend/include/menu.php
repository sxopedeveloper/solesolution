<?php 
$FrontSiteInfo = FrontSiteInfo(); 
?>
<header class="header header-fixed header-transparent text-white">
	<div class="container-fluid">
	<nav class="navbar navbar-expand-lg">
		<a class="navbar-brand mx-auto" href="<?php echo base_url();?>">
		<img src="<?php echo base_url('public/front/images/logo/'.$FrontSiteInfo['site_logo'] );?>" alt="<?php echo $FrontSiteInfo['pageTitle'];?>" width="150" class="logo-white">
		</a>
		<button id="mobile-nav-toggler" class="hamburger hamburger--collapse" type="button">
		<span class="hamburger-box">
		<span class="hamburger-inner"></span>
		</span>
		</button>
		<div class="navbar-collapse" id="main-nav">
			<ul class="navbar-nav mx-auto" id="main-menu">
                <li class="nav-item">
					<a class="nav-link" href="javascript:void(0);">SERVICES</a>
				</li>
                <li class="nav-item">
					<a class="nav-link" href="javascript:void(0);">FAQ</a>
				</li>
                <li class="nav-item">
					<a class="nav-link" href="javascript:void(0);">CASE STUDY</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">WEBINAR</a>
					<ul class="dropdown-menu">
						<li>
							<a class="dropdown-item" href="javascript:void(0);">BRANDS</a>
						</li>
						<li>
							<a class="dropdown-item" href="javascript:void(0);">SELLERS</a>
						</li>
					</ul>
				</li>
                <li class="nav-item">
					<a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target=".contact_modal">CONTACT NOW</a>
				</li>
			</ul>
			<ul class="navbar-nav extra-nav">
				<li class="nav-item m-auto">
					<a href="<?php echo base_url('admin/login')?>" class="btn btn-main btn-effect login-btn popup-with-zoom-anim">
					<i class="icon-user"></i>login
					</a>
				</li>
			</ul>
	</nav>
	</div>
</header>