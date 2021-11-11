<?php
defined('BASEPATH') OR exit('No direct script access allowed');


?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <?php $this->load->view(FRONTEND."include/include_css"); ?>
</head>
<body>
    <?php $this->load->view(FRONTEND."include/pre_loader"); ?>
    
    <div class="wrapper">
        <?php $this->load->view(FRONTEND."include/menu"); ?>
        
        <section id="slider" class="full-slider">
            <div class="rev-slider-wrapper fullscreen-container overlay-gradient">
                <div id="fullscreen-slider" class="rev_slider fullscreenbanner" style="display:none" data-version="5.4.1">
                    <ul>

                        <li data-transition="fade">

                            <img src="<?=FRONT_IMG?>amazon-banner.jpg" alt="Image" title="slider-bg" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina="">

                            <div class="container">
                                <div class="tp-caption tp-resizeme alignment" data-x="center" data-hoffset="" data-y="middle" data-voffset="['-30','-30','-30','-30']" data-responsive_offset="on" data-fontsize="['60','50','40','30']" data-lineheight="['60','50','40','30']" data-whitespace="nowrap" data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":500,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' style="z-index: 5; color: #fff; font-weight: 900;">
                                    <h4><span>THE BEST WAY FOR</span><br> BRANDS TO SUCCEED <span><br>ON AMAZON TODAY</span></h4>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target=".contact_modal" class="btn btn-main btn-effect login-btn popup-with-zoom-anim pad-diff-main">Contact Now</a>
                                </div>
                            </div>
                        </li>

                        <li data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="2000">

                            <img src="<?=FRONT_IMG?>amazon-banner.jpg" alt="Image" title="slider-bg" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina="">

                            <div class="container">
                                <div class="tp-caption tp-resizeme alignment" data-x="center" data-hoffset="" data-y="middle" data-voffset="['-30','-30','-30','-30']" data-responsive_offset="on" data-fontsize="['60','50','40','30']" data-lineheight="['60','50','40','30']" data-whitespace="nowrap" data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":500,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' style="z-index: 5; color: #fff; font-weight: 900; ">
                                    <h4><span>THE BEST WAY FOR</span><br> BRANDS TO SUCCEED <span><br>ON AMAZON TODAY</span></h4>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target=".contact_modal" class="btn btn-main btn-effect login-btn popup-with-zoom-anim pad-diff-main">Contact Now</a>
                                </div>
                            </div>
                        </li>

                        <li data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="2000">

                            <img src="<?=FRONT_IMG?>amazon-banner.jpg   " alt="Image" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="3" class="rev-slidebg" data-no-retina>

                            <div class="container">
                                <div class="tp-caption tp-resizeme alignment" data-x="center" data-hoffset="" data-y="middle" data-voffset="['-30','-30','-30','-30']" data-responsive_offset="on" data-fontsize="['60','50','40','30']" data-lineheight="['60','50','40','30']" data-whitespace="nowrap" data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":500,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' style="z-index: 5; color: #fff; font-weight: 900;">
                                    <h4><span>THE BEST WAY FOR</span><br> BRANDS TO SUCCEED <span><br>ON AMAZON TODAY</span></h4>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target=".contact_modal" class="btn btn-main btn-effect login-btn popup-with-zoom-anim pad-diff-main">Contact Now</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </section>

        <section class="how-it-works3 ptb100">
            <div class="container">
                <div class="row mt50">
                    <div class="col-lg-4 col-sm-12">
                        <ul class="nav features-tab">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" aria-expanded="false">
                                    <div class="icon-wrapper">
                                    <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <h5 class="title">Success hub for high-value emerging brands</h5>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="plan-tab" data-toggle="tab" href="#plan" aria-controls="home" aria-expanded="false">
                                    <div class="icon-wrapper">
                                        <i class="icon-layers"></i>
                                    </div>
                                    <div>
                                        <h5 class="title">Your brand to be #1 in your niche</h5>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="movie-tab" data-toggle="tab" href="#search" aria-controls="home" aria-expanded="false">
                                    <div class="icon-wrapper">
                                    <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h5 class="title">We Are That Team</h5>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-7 ml-auto">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-expanded="false">
                                <h5>SOLE SOLUTIONS IS THE DONE-FOR-YOU SUCCESS HUB FOR HIGH-VALUE EMERGING BRANDS THAT WANT TO OWN THEIR SPACE ON AMAZON…</h5>
                                <h2>And increase yearly sales by up to <span>1000% or even more</span></h2>
                                <img src="<?=FRONT_IMG?>amazon-prime.jpg" alt="Image">
                                <p class="mt20">See how we can help your brand increase the percentage of skus you sell through the online marketplaces – schedule your private demo to see if Sole Solutions is the right distribution partner for your brand:</p>
                            </div>
                            <div class="tab-pane fade" id="plan" role="tabpanel" aria-expanded="true">
                                <h2>Amazon is a virtually limitless marketplace. You’re just a few small “tweaks” away from unlocking it’s true potential for <span>YOUR BRAND TO BE #1 IN YOUR NICHE</span></h2>
                                <img src="<?=FRONT_IMG?>amazon-banner-2.jpg" alt="Image">
                                <p class="mt20">Almost anyone who has ever even thought about selling a product – let alone building a brand – has looked at Amazon as a potential goldmine for endless sales and ever-increasing revenues.</p>
                                <h5>BUT FOR MANY, THE RETURN HAS HARDLY BEEN WORTH THE HEADACHE.</h5>
                                <p>They make enough sales to justify staying on Amazon, but not nearly enough to make up for eroding revenues and what can sometimes seem like endless snags… plus, it would take an entire team just to manage everything and make Amazon a brand profit center.</p>
                            </div>
                            <div class="tab-pane fade" id="search" role="tabpanel">
                                <h2>We Are <span>THAT TEAM</span></h2>
                                <img src="<?=FRONT_IMG?>team-banner.jpg" alt="Image">
                                <p class="mt20">I’m Jason ONeil, Founder of Sole Solutions, and I know where you’re coming from. I’ve been a retailer for nearly a decade, and have worked hand-in-hand with product wholesalers for the past 4 years.</p>
                                <p class="mt20">But, more importantly to you, I’ve helped brands and resellers generate more than $375 MILLION worth of product sales on Amazon to date. I feel like we have barely scratched the surface of what’s out there and that’s why I’m writing this to you.</p>
                                <p class="mt20">My vetted, highly trained team and I serve as both turnkey store builders/operators, or as reliable (and even exclusive) done-for-you distributors.</p>
                                <p class="mt20">Our goal is simply to maximize sales while giving you complete control of your brand’s image, reputation, and distribution on the #1 largest online retailer in the U.S.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-it-works bg-light ptb100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center">
                        <h2 class="title">WHY DO BRANDS WORK WITH US?</h2>
                    </div>
                </div>
                <div class="timeline">
                    <span class="main-line"></span>
                    <div class="timeline-step row align-items-center">
                        <span class="timeline-step-btn">1</span>
                        <div class="col-md-6 col-sm-12 timeline-text-wrapper">
                            <div class="timeline-text">
                                <h3>Leverage</h3>
                                <p>Instead of traffic dribbles, you get a steady stream of the right buyers coming to your product pages day after day. Predictable sales means predictable growth.</p>

                                <p>Because we maintain relationships with a thoroughly vetted, actively monitored network of online retailers, we can offer you greater buying power than many brands can ever hope to achieve on Amazon. What this means, is we buy from you and leverage our network of buyers to help us increase our buying power.</p>

                                <p>They pay us, and we pay you.</p>

                                <p>That means a vast increase in sales – many of our brands are on pace to achieve 10X increases in product sales within a year of choosing Sole Solutions as their exclusive Amazon distributors.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 timeline-image-wrapper">
                            <div class="timeline-image">
                                <img src="<?=FRONT_IMG?>leverage.svg" alt="Leverage">
                            </div>
                        </div>
                    </div>
                    <div class="timeline-step row align-items-center">
                        <span class="timeline-step-btn">2</span>
                        <div class="col-md-6 col-sm-12 timeline-image-wrapper">
                            <div class="timeline-image">
                                <img src="<?=FRONT_IMG?>box.svg" alt="Turn Key distribution">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 timeline-text-wrapper">
                            <div class="timeline-text-right">
                                <h3>Turn Key distribution</h3>
                                <p>When we buy, we buy in bulk quantities. In some cases we may fill up an entire truckload with pallets.</p>

                                <p>Just ship the products to our warehouse and we handle the rest.</p>

                                <p>From here, we’re going to receive your products and get them distributed into the Amazon fulfillment networks leveraging Amazon Prime shoppers.</p>

                                <p>By doing this, in our experience skus that have FBA fulfillment increase up to 400% in sales.</p>

                                <p>Ultimately our goal is to help you have a better representation of your product offering, inside the Amazon fulfillment networks. This, alone, can make a dramatic difference in your bottom line.</p>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-step row align-items-center">
                        <span class="timeline-step-btn">3</span>
                        <div class="col-md-6 col-sm-12 timeline-text-wrapper">
                            <div class="timeline-text">
                                <h3>Data driven insights</h3>
                                <p>Our proprietary technology identifies demand surges in the Amazon marketplace that your product line can fill. What this means is we identify products that have demand, but don’t have enough FBA supply.</p>

                                <p>We do this by looking at over 10 data points that helps us quickly and accurately identify supply and demand gaps, so we can help you meet those imbalances. This data is how we fuel the buying power of our network as we look through the information and present them to our network of buyers.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 timeline-image-wrapper">
                            <div class="timeline-image">
                                <img src="<?=FRONT_IMG?>insight.svg" alt="Data driven insights">
                            </div>
                        </div>
                    </div>
                    <div class="timeline-step row align-items-center">
                        <span class="timeline-step-btn">4</span>
                        <div class="col-md-6 col-sm-12 timeline-image-wrapper">
                            <div class="timeline-image">
                                <img src="<?=FRONT_IMG?>pencil.svg" alt="Brand Registry on Amazon">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 timeline-text-wrapper">
                            <div class="timeline-text-right">
                                <h3>Brand Registry on Amazon</h3>
                                <p>By registering your brand, we can ensure that you show up on Amazon exactly the way you want – Brand Registry unlocks valuable tools to protect your brand trademarks, proprietary text/image search, and predictive automation</p>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-step row align-items-center">
                        <span class="timeline-step-btn">5</span>
                        <div class="col-md-6 col-sm-12 timeline-text-wrapper">
                            <div class="timeline-text">
                                <h3>Product Gating and Monitoring</h3>
                                <p>It does not prevent other sellers from selling the same product, potentially at lower prices.</p><p>We monitor our network using real-time technology to ensure that our resellers:</p><ul><li>Present your brand positively and consistently</li><li>Adhere to your marketing standards and use only approved graphics, text, titles, bullet points, descriptions, etc.</li><li>Follow minimum pricing requirements</li><li>Vigilantly watch for and report unauthorized reseller activity.</li></ul><p>Our exclusive brands enjoy the highest degree of product gating, virtually eliminating the threat of third party sellers eroding your profits.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 timeline-image-wrapper">
                            <div class="timeline-image">
                                <img src="<?=FRONT_IMG?>monitoring.svg" alt="Product Gating and Monitoring">
                            </div>
                        </div>
                    </div>
                    <div class="timeline-step row align-items-center">
                        <span class="timeline-step-btn">6</span>
                        <div class="col-md-6 col-sm-12 timeline-image-wrapper">
                            <div class="timeline-image">
                                <img src="<?=FRONT_IMG?>profits.svg" alt="An invested partner in your success">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 timeline-text-wrapper">
                            <div class="timeline-text-right">
                                <h3>An invested partner in your success</h3>
                                <p>We don’t just store, and distribute your products for you – we’re on your side every step of the way.</p><p>You can rest easy knowing that we’re doing all the work for you – we add at least 50 brand-new, premium quality products every single day on behalf of the brands we serve… and that number is rapidly growing!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="our-call-custom">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="movie-list-1 mb30">
                        <div class="listing-container">
                            <div class="listing-content">
                                <div class="inner">
                                    <h2 class="title">IF YOUR BRAND IS A GOOD FIT, <br>GETTING STARTED WITH SOLE SOLUTIONS IS SIMPLE:</h2>

                                    <p>See how we’re helping brands sell more products than ever – schedule your private demo to see if Sole Solutions is right for your brand: <br>You know you’re getting a trickle of the sales you could be making. We have the technology, infrastructure, network, and know how to optimize sales for your brand.</p>

                                    <h2 class="title">It all starts with one brief, casual phone call.</h2>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target=".contact_modal" class="btn btn-main btn-effect">CLICK HERE TO CONTACT TODAY</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="features">
            <div class="row">
                <div class="col-md-6 col-sm-12 with-bg overlay-gradient" style="background: url(<?=FRONT_IMG?>banner-call.jpg)"></div>
                <div class="col-md-6 col-sm-12 bg-light">
                    <div class="features-wrapper">
                        <h3 class="title">Here’s what <br>YOU’LL GET ON OUR CALL:</h3>
                        <p>Regardless of whether we decide to work together, you’ll have a much better understanding of how to improve sales in the Amazon marketplace.</p><p>You’ll also find out your brand’s current Amazon “score,” and how to improve your score to position yourself for greater visibility and sales volume.</p><p>Of course, we’d love to work toward becoming your exclusive Amazon distributor – this would allow you to optimize your income from Amazon virtually hands-free.</p><p>But let’s get to know each other first, and get you the insider info you need to thrive on Amazon today.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- footer -->
        <?php $this->load->view(FRONTEND."include/footer"); ?>
    </div>

    <?php $this->load->view(FRONTEND."include/include_js"); ?>
</body>      
</html>