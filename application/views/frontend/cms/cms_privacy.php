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
        
        <section class="page-header overlay-gradient top-banner-main" style="background: url(<?=FRONT_IMG?>slider1-2.jpg); background-size: cover;background-position: center;">
            <div class="container">
                <div class="inner">
                    <h2 class="title"><?= $pageTitle ?></h2>
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url();?>">Home</a></li>
                        <li><?= $pageTitle ?></li>
                    </ol>
                </div>
            </div>
        </section>

        <main class="contact-page ptb100 inner-main-custom">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="storyline">
                            <h2><?= $pageTitle ?></h2>
                            <p>AT SOLE SOLUTIONS, WE RESPECT AND PROTECT THE PRIVACY OF VISITORS TO OUR WEBSITE, <a href="#">WWW.SOLESOLUTIONS.TECH.</a> (THE “SITE”), AND OUR CUSTOMERS WHO USE OUR PLATFORM, TOOLS AND SERVICES OFFERED ON THE SITE (THE “SERVICE”). SOLE SOLUTIONS KNOWS THAT YOU CARE ABOUT HOW YOUR INFORMATION IS USED AND SHARED. WE WANT TO MAKE SURE THAT YOU UNDERSTAND THE TYPE OF INFORMATION WE COLLECT ABOUT YOU, HOW IT IS USED AND THE SAFEGUARDS WE USE TO PROTECT IT. THIS PRIVACY POLICY (“POLICY”) EXPLAINS HOW WE COLLECT AND USE VISITORS’ AND CUSTOMERS’ INFORMATION AS PART OF OUR SITE AND OUR SERVICE.</p>

                            <p>Last revision: January 15, 2017</p>
                            
                            <h3>1. INFORMATION YOU PROVIDE</h3>
                            <p>In this Policy, “personal information” is data that can be used to uniquely identify or contact a single person, such as the individual’s name, postal address, email address and telephone number. When You register for the Service, We ask for information such as your name, company name and address, site name, phone number, e-mail address and credit card information. If You sign-up for the free trial account, You are not required to enter your credit card information until You decide to continue with a paid plan. Sole Solutions uses a third-party intermediary to manage credit card processing. This intermediary is not permitted to store, retain, or use your billing information, except for the sole purpose of credit card processing on Sole Solutions behalf.</p>

                            <h3>2. INFORMATION WE COLLECT</h3>
                            <p>As is true with most web sites, Sole Solutions gathers certain information automatically and stores it in log files. This information includes internet protocol addresses as well as browser, internet service provider, referring/exit pages, operating system,date/time stamp, and clickstream data. Occasionally We may connect personal information to data gathered in our log files, as necessary to improve the Service to individual customers. Otherwise We mostly use this information with no connection to individual users, to analyze trends, administer the Site, or track usage of various features within the Site.The application will use <a href="#">https://www.googleapis.com/auth/gmail.readonly</a> to pull information such as supplier order ID, order cost, and supplier tracking number into the system, so users can view complete order information, and tracking information. </p>

                            <h3>3. COOKIES</h3>
                            <p>A “cookie” is a piece of information either stored temporarily (session cookie) or placed on your computer’s hard drive (persistent cookie). The main purpose of a cookie is to allow a web server to identify a user, and serve up customized web pages and/or login information to the user’s web browser when revisiting a web page. Cookies help us promptly display the information You need and other information which We consider to be of interest to You. By gathering and remembering information about your website preferences through cookies We can provide a better web and marketing experience.</p>
                            <p>When You visit the Site or use the Service, We use “session cookies” to allow the Site or Service to uniquely identify your browser while You are logged in and to enable Sole Solutions to process your online transactions. Session cookies also help us confirm your identity and are required in order to use the Service. We also use “persistent cookies” that only We can read and use, to identify You as a Sole Solutions customer and make it easier for You to log into the Service.</p>
                            <p>As a user You can accept or decline the use of cookies through a functionality built into most web browsers. Users who disable their web browsers’ ability to accept cookies will be able to browse our Site, but will not be able to access or take advantage of the Service.</p>

                            <h3>4. CLEAR GIFS</h3>
                            <p>Our third-party tracking utility company employs a software technology called clear gifs that helps us better manage content on our site by informing us what content is effective. Clear gifs are tiny graphics with a unique identifier, similar in function to cookies, and are used to track the online movements of Web users. Unlike cookies, which are stored on a user’s computer hard drive, clear gifs are embedded invisibly on Web pages, and emails.</p>

                            <p>We tie the information gathered by clear gifs to our customers’ personal information, and use them in our HTML-based emails to learn which emails have been opened by recipients. This allows us to gauge the effectiveness of certain communications and our marketing campaigns. If You would like to opt-out of these emails, please follow the unsubscribe instructions within our marketing emails.</p>


                            <h3>5. HOW WE USE THE INFORMATION WE COLLECT</h3>
                            <p>Sole Solutions may use the personal information and other information We collect about your use of the Service:
                                a) To operate the Service and tailor it to your needs
                                b) For billing, identification and authentication
                                c) To contact You about Your use of the Service
                                d) To send you exclusive offers and other communications
                                e) For research purposes
                                f) To generally improve the content and functionality of the Service and the Site.
                                Although Sole Solutions owns all rights to the software, code, databases, and other Service applications.
                            </p>
                            
                            <h3>6. HOW THIRD PARTIES USE THE INFORMATION WE COLLECT</h3>
                            <p>Sole Solutions may also share your personal information with its third-party vendors (such as its credit card processor) and hosting partners to provide the necessary hardware, software, networking, storage, and other services We use to operate the Service and maintain quality user experience. Our service providers will be permitted to obtain only the personal information they need to deliver the service. They are required to maintain the confidentiality of the information and are prohibited from using it for any other purpose than for delivering the service to Sole Solutions in accordance with Sole Solutions instructions and policies.
                            </p>
                            <p>Except as described in this Policy, Sole Solutions will not give, sell, rent or loan any personal information to any third party. We may disclose such information to respond to subpoenas, court orders, or legal process, or to establish or exercise our legal rights or defend against legal claims. We may also share such information if we believe it is necessary in order to investigate, prevent, or take action regarding illegal activities, suspected fraud, situations involving potential threats to the physical safety of any person, violations of our Terms of Service, or as otherwise required by law. </p>

                            <h3>7. LINKS TO OTHER SITES</h3>
                            <p>Our Site contains links to other websites that are not owned or controlled by Sole Solutions. Please be aware that We do not determine and We are not responsible for the privacy practices or content of such other sites. We encourage You to be aware when you leave our Site, and read the privacy statements of other websites linked to our Site. This Policy applies only to information collected by this Site.
                            </p>

                            <h3>8. CUSTOMER TESTIMONIALS/COMMENTS/REVIEWS</h3>
                            <p>From time to time, We post customer testimonials on the Site which may contain personal information. We do obtain the customers’ consent to post their names along with their testimonials.
                            </p>

                            <h3>9. PROTECTION OF INFORMATION</h3>
                            <p>Sole Solutions is committed to ensuring the security of your personal information. We take every precaution to protect the confidentiality and security of the personal information placed on the Site or used within the Service, by employing technological, physical and administrative security safeguards, such as firewalls and carefully-developed security procedures. For example, when You enter sensitive information (such as login credentials and all your activity on our Service platform) We encrypt the transmission of that information using secure socket layer technology (SSL). These technologies, procedures and other measures help ensure that your data is safe, secure, and only available to You and to those You authorized access.
                            </p>

                            <h3>10. OPTING-OUT</h3>
                            <p>We process and store information on behalf of our customers. If You are our customer and would like to opt-out of getting communications from Sole Solutions please contact us at info@Solesolutions.tech email address or follow the unsubscribe instructions included in each marketing email.
                            </p>
                            <h3>11. DATA RETENTION</h3>
                            <p>Sole Solutions will retain personal information We process on behalf of our customers for as long as needed to provide Service to our customers, subject to our compliance with this Policy. We retain and use this personal information as necessary to comply with our legal obligations, resolve disputes, and enforce our agreements.
                            </p>

                            <h3>12. CHILDREN</h3>
                            <p>Sole Solutions does not knowingly collect any personal information from children under the age of 13. If we learn that we have collected the personal information of a child under 13 we will take steps to delete the information.
                            </p>

                            <h3>13. BUSINESS TRANSACTIONS</h3>
                            <p>Sole Solutions may assign or transfer this Policy, and your user account and related information and data, to any person or entity that acquires or is merged with Sole Solutions.
                            </p>

                            <h3>14. CHANGES TO THE PRIVACY POLICY</h3>
                            <p>If We make any material changes to this Policy We will notify You by email or by posting a prominent notice on the Site prior to the change becoming effective. We encourage You to periodically review this page for the latest information on our privacy practices. Your continued use of the Site or Service constitutes your agreement to be bound by such changes to this Policy. Your only remedy, if You do not accept the terms of this Policy, is to discontinue use of the Site and Service.
                            </p>

                            <h3>15. TERMS OF SERVICE</h3>
                            <p>When You access and use the Service, You are subject to the Sole Solutions Terms of Service, found here: <a href="#">Terms of Service</a>
                            </p>


                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- footer -->
        <?php $this->load->view(FRONTEND."include/footer"); ?>
    </div>

    <?php $this->load->view(FRONTEND."include/include_js"); ?>
</body>      
</html>