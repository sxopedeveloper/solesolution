<?php $SocialInfo = FrontSiteInfo(); ?>
<footer class="footer1">
   <div class="footer-widget-area ptb100">
       <div class="container">
           <div class="row">

               <div class="col-lg-4 col-md-4 col-sm-12">
                   <div class="widget widget-about">
                      	<a class="navbar-brand" href="<?php echo base_url();?>">
                       		<img src="<?php echo base_url('public/front/images/logo/'.$SocialInfo['site_logo'] );?>" alt="white logo" class="logo-white">
                      	</a>
                   </div>
               </div>

               <div class="col-lg-4 col-md-4 col-sm-12">
                   <div class="widget widget-links">
                       <h4 class="widget-title">Sitemap:</h4>
                       <ul class="general-listing">
                           <li><a href="javascript:void(0);">SERVICES</a></li>
                           <li><a href="javascript:void(0);">FAQ</a></li>
                           <li><a href="javascript:void(0);">CASE STUDY</a></li>
                           <li>
                           		<a href="javascript:void(0);">WEBINAR</a>
                           		<ul class="p-0 m-0">
                           			<li><a href="javascript:void(0);">BRANDS</a></li>
                           			<li><a href="javascript:void(0);">SELLERS</a></li>
                           		</ul>
                           </li>
                           <li><a href="javascript:void(0);">LOGIN</a></li>
                           <li><a href="javascript:void(0);" data-toggle="modal" data-target=".contact_modal">CONTACT NOW</a></li>
                       </ul>
                   </div>
               </div>

               <div class="col-lg-4 col-md-4 col-sm-12">
                   <div class="widget widget-social">
                       <h4 class="widget-title">Sign up to newsletter:</h4>
                       <form action="#" class="mailchimp mt50" novalidate="true">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="email" name="EMAIL" class="form-control" id="mc-email" placeholder="Your E-mail" autocomplete="off">
                                    <label for="mc-email"></label>
                                    <button type="submit" class="btn btn-main btn-effect">Subscribe</button>
                                </div>
                            </div>
                        </form>

                       <h4 class="widget-title">Social:</h4>
                       <ul class="social-btns">
                            <?php
                            if($SocialInfo['fb_link']!="")
                            {
                            ?>
                            <li>
                               <a href="<?php echo $SocialInfo['fb_link']; ?>" class="social-btn-roll facebook">
                                   <div class="social-btn-roll-icons">
                                       <i class="social-btn-roll-icon fab fa-facebook-f"></i>
                                       <i class="social-btn-roll-icon fab fa-facebook-f"></i>
                                   </div>
                               </a>
                            </li>
                            <?php
                            }

                            if($SocialInfo['twitter_link']!="")
                            {
                            ?>
                            <li>
                               <a href="<?php echo $SocialInfo['twitter_link']; ?>" class="social-btn-roll twitter">
                                   <div class="social-btn-roll-icons">
                                       <i class="social-btn-roll-icon fab fa-twitter"></i>
                                       <i class="social-btn-roll-icon fab fa-twitter"></i>
                                   </div>
                               </a>
                            </li>
                            <?php
                            }

                            if($SocialInfo['google_plus_link']!="")
                            {
                            ?>
                            <li>
                               <a href="<?php echo $SocialInfo['google_plus_link']; ?>" class="social-btn-roll google-plus">
                                   <div class="social-btn-roll-icons">
                                       <i class="social-btn-roll-icon fab fa-instagram"></i>
                                       <i class="social-btn-roll-icon fab fa-instagram"></i>
                                   </div>
                               </a>
                            </li>
                            <?php
                            }

                            if($SocialInfo['instagram_link']!="")
                            {
                            ?>
                            <li>
                               <a href="<?php echo $SocialInfo['instagram_link']; ?>" class="social-btn-roll youtube">
                                   <div class="social-btn-roll-icons">
                                       <i class="social-btn-roll-icon fab fa-youtube"></i>
                                       <i class="social-btn-roll-icon fab fa-youtube"></i>
                                   </div>
                               </a>
                            </li>
                            <?php
                            }
                            ?>
                       </ul>

                   </div>
               </div>

           </div>
       </div>
   </div>

   <div class="footer-copyright-area ptb30">
       <div class="container">
           <div class="row">
               <div class="col-md-12">
                   <div class="d-block d-sm-block d-md-flex justify-content-between">
                        <div class="links">
                            <ul class="list-inline d-block d-md-inline-block d-lg-flex">
                                <li class="list-inline-item d-block"><a href="<?php echo base_url("privacy/")?>">Privacy & Policies</a></li>
                                <li class="list-inline-item d-block d-md-inline-block"><a href="<?php echo base_url("terms/")?>">Terms & Conditions</a></li>
                            </ul>
                        </div>
                       <div class="copyright ml-auto mt-25">© <?= date("Y");?> | <a href="<?= base_url();?>"><?php echo $SocialInfo['pageTitle']; ?></a> | All Right Reserved</div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</footer>

<!-- contact modal start -->
<div class="modal fade contact_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contact Us</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <form id="myContactForm" method="post" action="<?=URL?>contactusprocess" autocomplete="off">
                    <div class="form-group">
                        <input class="form-control input-box" type="text" id="name" name="name" placeholder="Your Name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control input-box" type="email" id="email" name="email" placeholder="Your email address" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control input-box" type="text" id="phone" name="phone" placeholder="Your phone number" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control input-box" type="text" name="subject" id="subject" placeholder="Subject" autocomplete="off">
                    </div>
                    <div class="form-group mb20">
                        <textarea class="form-control textarea-box" rows="8" name="message" id="message" placeholder="Type your message..."></textarea>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" id="contactus-btn" class="btn btn-main btn-effect">Send message</button>
      </div>
    </div>
  </div>
</div>
<!-- contact modal start -->