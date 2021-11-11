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

                            <p>Last Revision: 2/4/2021</p>

                            <h3>1. ACCEPTANCE OF TERMS OF USE</h3>
                            <p>These terms of use are entered into by and between You and Sole Solutions LLC (”Company”, “we”, or “us”). The following terms and conditions, together with any documents they expressly incorporate by reference (collectively, these “Terms of Use”), govern your access to and use of <a href="#">www.solesolutions.tech,</a> <a href="#">app.solesolutions.tech,</a> <a href="#">ext.solesolutions.tech</a> including any content, functionality, apps, APIs, widgets, or services offered on or through www.solesolutions.tech (the “Website”), whether as a guest or a registered user.</p>

                            <p>Please read the Terms of Use carefully before you start to use the Website. By using the Website, or by clicking to accept or agree to the Terms of Use when this option is made available to you, you accept and agree to be bound and abide by these Terms of Use and our <a href="#">Privacy Policy,</a> found at <a href="#">https://www.solesolutions.tech/privacy-policy,</a> incorporated herein by reference. If you do not want to agree to these Terms of Use you must not access or use the Website.</p>

                            <p>This Website is offered and available to users who are 18 years of age or older, and reside in the United States or any of its territories or possessions. By using this Website, you represent and warrant that you are of legal age to form a binding contract with the Company and meet all of the foregoing eligibility requirements. If you do not meet all of these requirements, you must not access or use the Website.</p>

                            <p>Changes to the Terms of Use</p>
                            <p>We may revise and update these Terms of Use from time to time at our sole discretion. All changes are effective immediately when we post them, and apply to all access to and use of the Website thereafter. However, any changes to the dispute resolution provisions set out in Governing Law and Jurisdiction will not apply to any disputes for which the parties have actual notice, on or, before the date the change is posted on the Website.</p>
                            <p>Your continued use of the Website following the posting of revised Terms of Use means that you accept and agree to the changes. You are expected to check this page from time to time so you are aware of any changes, as they are binding on you.</p>

                            <p>Using Sole Solutions May include downloading software to your computer, phone, tablet, or other device. You agree that we may automatically update that software, and these Terms of Use will apply to any updates.</p>
                            <p>Accessing the Website and Account Security
                            We reserve the right to withdraw or amend this Website, and any service or material we provide on the Website, in our sole discretion without notice. We will not be liable if for any reason all or any part of the Website is unavailable at any time or for any period. From time to time, we may restrict access to some parts of the Website, or the entire Website, to users, including registered users.
                            </p>
                            <p><strong>You are responsible for:</strong></p>
                            <ul>
                               <li>Making all arrangements necessary for you to have access to the Website.</li>
                               <li>Ensuring that all persons who access the Website through your internet connection are aware of these Terms of Use and comply with them.</li>
                            </ul>

                            <p>To access the Website or some of the resources it offers, you may be asked to provide certain registration details or other information. It is a condition of your use of the Website that all the information you provide on the Website is correct, current, and complete. You agree that all information you provide to register with this Website or otherwise, including but not limited to through the use of any interactive features on the Website, is governed by our Privacy Policy, and you consent to all actions we take with respect to your information consistent with our <a href="#">Privacy Policy.</a></p>
                            <p>If you choose, or are provided with, a user name, password, or any other piece of information as part of our security procedures, you must treat such information as confidential, and you must not disclose it to any other person or entity. You also acknowledge that your account is personal to you and agree not to provide any other person with access to this Website or portions of it using your user name, password, or other security information. You agree to notify us immediately of any unauthorized access to or use of your user name or password or any other breach of security. You also agree to ensure that you exit from your account at the end of each session. You should use particular caution when accessing your account from a public or shared computer so that others are not able to view or record your password or other personal information.</p>
                            <p>We have the right to disable any user name, password, or other identifier, whether chosen by you or provided by us, at any time in our sole discretion for any or no reason, including if, in our opinion, you have violated any provision of these Terms of Use.</p>

                            <p><strong>Refunds and Downgrades:</strong></p>

                            <p>Auto-renewal ensures continued use of your product, service, or other offering until you choose to cancel, with no need to keep
                            track of renewal dates. Sole Solutions will automatically renew your subscription using the payment method on file until you cancel.   There shall be no refunds or prorates on any downgrades of service after the monthly billing date has passed.   It is your sole responsibility to upgrade, downgrade or cancel your service.
                            </p>

                            <p><strong>Intellectual Property Rights</strong></p>
                            <p>The Website and its entire contents, features, and functionality (including but not limited to all information, software, text, displays, images, video, and audio, and the design, selection, and arrangement thereof) are owned by the Company, its licensors, or other providers of such material and are protected by United States and international copyright, trademark, patent, trade secret, and other intellectual property or proprietary rights laws.</p>

                            <p>These Terms of Use permit you to use the Website for your personal, non-commercial use only. You must not reproduce, distribute, modify, create derivative works of, publicly display, publicly perform, republish, download, store, or transmit any of the material on our Website, except as follows:</p>
                            <ul>
                               <li>Your computer may temporarily store copies of such materials in RAM incidental to your accessing and viewing those materials.</li>
                               <li>You may store files that are automatically cached by your Web browser for display enhancement purposes.</li>
                            </ul>

                            <p><strong>You must not:</strong></p>
                            <ul>
                               <li>Modify copies of any materials from this site.</li>
                               <li>Use any illustrations, photographs, video or audio sequences, or any graphics separately from the accompanying text.</li>
                               <li>Delete or alter any copyright, trademark, or other proprietary rights notices from copies of materials from this site.</li>

                            </ul>

                            <p>If you print, copy, modify, download, or otherwise use or provide any other person with access to any part of the Website in breach of the Terms of Use, your right to use the Website will stop immediately and you must, at our option, return or destroy any copies of the materials you have made. No right, title, or interest in or to the Website or any content on the Website is transferred to you, and all rights not expressly granted are reserved by the Company. Any use of the Website not expressly permitted by these Terms of Use is a breach of these Terms of Use and may violate copyright, trademark, and other laws.</p>

                            <p><strong>Trademarks</strong></p>

                            <p>The Company name, the terms, the Company logo, and all related names, logos, product and service names, designs, and slogans are trademarks of the Company or its affiliates or licensors. You must not use such marks without the prior written permission of the Company. All other names, logos, product and service names, designs, and slogans on this Website are the trademarks of their respective owners.</p>

                            <p><strong>Sole Solutions Fulfillment Chrome Extension</strong></p>

                            <p></p>The extension is provided for your convenience.  Usage of the extension is your voluntary choice.  We will not be liable if for any reason for any errors that may result from any automated ordering functionality, including but not limited to the fetching of client orders, fulfillment of orders, and marking the ordered items as fulfilled.  </p>

                            <p><strong>Automated Ordering</strong></p>

                            <p>Our automated ordering feature is supported in part by sponsored links from third-party merchants and advertisers. We sometimes use specially formatted links for which we receive a commission on resulting sales or clicks from affiliate partners (“Affiliate Links”).  We will use links to other websites belonging to Sole Solutions advertisers and other third parties. Sole Solutions does not endorse, warrant or guarantee the products or services available through the sponsored advertiser link, (or any other third -party products or services advertised, presented on or linked from any portion of our Sole Solutions system), whether or not sponsored. Sole Solutions is not an agent, distributor, re-seller, broker or otherwise responsible for such third-parties or the activities or policies of those websites or the products or services available on them. Sole Solutions does not promise or guarantee that the product details, prices, coupon availability or other service terms, rates or rewards offered by any particular advertiser or other third-party are the best prices, terms or lowest rates available in the market. By using the automated ordering service you agree that all revenue, income, and payment generated by and or from sponsored or affiliated links are the sole possession of Sole Solutions.</p>

                            <p>You accept that there are risks in accessing these third-party websites, and that Sole Solutions is not responsible for such risks.
Sole Solutions has no control over, and assumes no responsibility for, the content, accuracy, privacy policies, or practices of or opinions expressed in any third-party </p>
                          <p>websites or by any third-party that you interact with through our automated ordering feature. In addition, Sole Solutions will not and cannot monitor, verify, censor or edit the content of any third-party site or service. By using the Sole Solutions system, you release and hold us harmless from any and all liability arising from your use of any third-party website or service.</p>

                          <p>If there is a dispute between participants on Sole Solutions, or between users and any third-party you agree that Sole Solutions is under no obligation to become involved. To the maximum extent permitted by applicable law, in the event that you have a dispute with one or more other users, you release Sole Solutions, its officers, employees, agents, and successors from claims, demands, and damages of every kind or nature, known or unknown, suspected or unsuspected, disclosed or undisclosed, arising out of or in any way related to such disputes and/or our Services. If you are a California resident, you shall and hereby do waive California Civil Code Section 1542, which says: a general release does not extend to claims which the creditor does not know or suspect to exist in his favor at the time of executing the release, which, if known by him must have materially affected his settlement with the debtor.</p>

                          <p>If there is a dispute between participants on Sole Solutions, or between users and any third-party you agree that Sole Solutions is under no obligation to become involved. To the maximum extent permitted by applicable law, in the event that you have a dispute with one or more other users, you release Sole Solutions, its officers, employees, agents, and successors from claims, demands, and damages of every kind or nature, known or unknown, suspected or unsuspected, disclosed or undisclosed, arising out of or in any way related to such disputes and/or our Services. If you are a California resident, you shall and hereby do waive California Civil Code Section 1542, which says: a general release does not extend to claims which the creditor does not know or suspect to exist in his favor at the time of executing the release, which, if known by him must have materially affected his settlement with the debtor.</p>


                          <p><strong>Prohibited Uses</strong></p>

                            <p>You may use the Website only for lawful purposes and in accordance with these Terms of Use. You agree not to use the Website:</p>

                            <ul>
                              <li>In any way that violates any applicable federal, state, local, or international law or regulation (including, without limitation, any laws regarding the export of data or software to and from the US or other countries).</li>
                              <li>For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way by exposing them to inappropriate content, asking for personally identifiable information, or otherwise.</li>

                              <li>To send, knowingly receive, upload, download, use, or re-use any material that does not comply with these Terms of Use.</li>

                              <li>To transmit, or procure the sending of, any advertising or promotional material, including any “junk mail”, “chain letter”, “spam”, or any other similar solicitation.</li>

                              <li>To impersonate or attempt to impersonate the Company, a Company employee, another user, or any other person or entity (including, without limitation, by using email addresses, or screen names, associated with any of the foregoing).</li>

                              <li>To engage in any other conduct that restricts or inhibits anyone’s use or enjoyment of the Website, or which, as determined by us, may harm the Company or users of the Website or expose them to liability.</li>

                            </ul>

                            <p><strong>Additionally, you agree not to:</strong></p>

                            <ul>
                              <li>Use the Website in any manner that could disable, overburden, damage, or impair the site or interfere with any other party’s use of the Website, including their ability to engage in real time activities through the Website.</li>
                              <li>For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way by exposing them to inappropriate content, asking for personally identifiable information, or otherwise.</li>

                              <li>Use any robot, spider, or other automatic device, process, or means to access the Website for any purpose, including monitoring or copying any of the material on the Website.</li>

                              <li>Use any manual process to monitor or copy any of the material on the Website or for any other unauthorized purpose without our prior written consent.</li>

                              <li>Use any device, software, or routine that interferes with the proper working of the Website.</li>

                              <li>Introduce any viruses, Trojan horses, worms, logic bombs, or other material that is malicious or technologically harmful.</li>
                              <li>Introduce any viruses, Trojan horses, worms, logic bombs, or other material that is malicious or technologically harmful.</li>

                              <li>Attempt to gain unauthorized access to, interfere with, damage, or disrupt any parts of the Website, the server on which the Website is stored, or any server, computer, or database connected to the Website.</li>
                              <li>Attack the Website via a denial-of-service attack or a distributed denial-of-service attack.</li>
                              <li>Otherwise attempt to interfere with the proper working of the Website.</li>

                            </ul>
                            <p><strong>User Contributions</strong></p>
                            <p>The Website may contain message boards, chat rooms, personal web pages or profiles, forums, bulletin boards, and other interactive features (collectively, “Interactive Services”) that allow users to post, submit, publish, display, or transmit to other users or other persons (hereinafter, “post”) content or materials (collectively, “User Contributions”) on or through the Website.
All User Contributions must comply with the Content Standards set out in these Terms of Use.
Any User Contribution you post to the site will be considered non-confidential and non-proprietary. By providing any User Contribution on the Website, you grant us and [our affiliates and service providers, and each of their and] our [respective] licensees, successors, and assigns the right to use, reproduce, modify, perform, display, distribute, and otherwise disclose to third parties any such material [for any purpose/according to your account settings].
You represent and warrant that:
</p>                       
<ul>
                              <li>You own or control all rights in and to the User Contributions and have the right to grant the license granted above to us and our affiliates and service providers, and each of their and our respective licensees, successors, and assigns.</li>
                              <li>All of your User Contributions do and will comply with these Terms of Use.</li>
                              </ul>
                              <p>You understand and acknowledge that you are responsible for any User Contributions you submit or contribute, and you, not the Company, have full responsibility for such content, including its legality, reliability, accuracy, and appropriateness.
We are not responsible or liable to any third party for the content or accuracy of any User Contributions posted by you or any other user of the Website.
</p>
                            <p><strong>Monitoring and Enforcement; Termination
We have the right to:
</strong></p>

<ul>
                              <li>Remove or refuse to post any User Contributions for any or no reason in our sole discretion</li>
                              <li>Take any action with respect to any User Contribution that we deem necessary or appropriate in our sole discretion, including if we believe that such User Contribution violates the Terms of Use, including the Content Standards, infringes any intellectual property right or other right of any person or entity, threatens the personal safety of users of the Website or the public, or could create liability for the Company.</li>
                              <li>Disclose your identity or other information about you to any third party who claims that material posted by you violates their rights, including their intellectual property rights or their right to privacy.</li>
                              <li>Take appropriate legal action, including without limitation, referral to law enforcement, for any illegal or unauthorized use of the Website.</li>
                              <li>Terminate or suspend your access to all or part of the Website for any or no reason, including without limitation, any violation of these Terms of Use.</li>
                              </ul>

                              <p>Without limiting the foregoing, we have the right to cooperate fully with any law enforcement authorities or court order requesting or directing us to disclose the identity or other information of anyone posting any materials on or through the Website. YOU WAIVE AND HOLD HARMLESS THE COMPANY AND ITS AFFILIATES, LICENSEES, AND SERVICE PROVIDERS FROM ANY CLAIMS RESULTING FROM ANY ACTION TAKEN BY [THE COMPANY/ANY OF THE FOREGOING PARTIES] DURING, OR TAKEN AS A CONSEQUENCE OF, INVESTIGATIONS BY EITHER THE COMPANY/SUCH PARTIES OR LAW ENFORCEMENT AUTHORITIES.
However, we do not undertake to review all material before it is posted on the Website, and cannot ensure prompt removal of objectionable material after it has been posted. Accordingly, we assume no liability for any action or inaction regarding transmissions, communications, or content provided by any user or third party. We have no liability or responsibility to anyone for performance or nonperformance of the activities described in this section.
</p>


<p>Content Standards
These content standards apply to any and all User Contributions and use of Interactive Services. User Contributions must in their entirety comply with all applicable federal, state, local, and international laws and regulations. Without limiting the foregoing, User Contributions must not:
</p>

<ul>
                              <li>Contain any material that is defamatory, obscene, indecent, abusive, offensive, harassing, violent, hateful, inflammatory, or otherwise objectionable.</li>
                              <li>Promote sexually explicit or pornographic material, violence, or discrimination based on race, sex, religion, nationality, disability, sexual orientation, or age.</li>
                               <li>Infringe any patent, trademark, trade secret, copyright, or other intellectual property or other rights of any other person.</li>
                                <li>Violate the legal rights (including the rights of publicity and privacy) of others or contain any material that could give rise to any civil or criminal liability under applicable laws or regulations or that otherwise may be in conflict with these Terms of Use and our  <a href="#">Privacy Policy</a>.</li>
                                <li>Be likely to deceive any person.</li>
                                <li>Promote any illegal activity, or advocate, promote, or assist any unlawful act.</li>
                                <li>Cause annoyance, inconvenience, or needless anxiety or be likely to upset, embarrass, alarm, or annoy any other person.</li>
                                <li>Impersonate any person, or misrepresent your identity or affiliation with any person or organization.</li>
                                <li>Give the impression that they emanate from or are endorsed by us or any other person or entity, if this is not the case.</li>
                              </ul>

                              <p>Reliance on Information Posted</p>

<p>The information presented on or through the Website is made available solely for general information purposes. We do not warrant the accuracy, completeness, or usefulness of this information. Any reliance you place on such information is strictly at your own risk. We disclaim all liability and responsibility arising from any reliance placed on such materials by you or any other visitor to the Website, or by anyone who may be informed of any of its contents.</p>

<p>This Website may include content provided by third parties, including materials provided by other users, bloggers, and third-party licensors, syndicators, aggregators, and/or reporting services. All statements and/or opinions expressed in these materials, and all articles and responses to questions and other content, other than the content provided by the Company, are solely the opinions and the responsibility of the person or entity providing those materials. These materials do not necessarily reflect the opinion of the Company. We are not responsible, or liable to you or any third party, for the content or accuracy of any materials provided by any third parties.</p>

<p>Changes to the Website</p>

<p>We may update the content on this Website from time to time, but its content is not necessarily complete or up-to-date. Any of the material on the Website may be out of date at any given time, and we are under no obligation to update such material.</p>

<p>Information About You and Your Visits to the Website</p>

<p>All information we collect on this Website is subject to our <a href="#">Privacy Policy</a>.  By using the Website, you consent to all actions taken by us with respect to your information in compliance with the <a href="#">Privacy Policy</a>.</p>

<p>Linking to the Website and Social Media Features</p>

<p>You may link to our homepage, provided you do so in a way that is fair and legal and does not damage our reputation or take advantage of it, but you must not establish a link in such a way as to suggest any form of association, approval, or endorsement on our part without our express written consent.
This Website may provide certain social media features that enable you to:
</p>

<ul>
    <li>Link from your own or certain third-party websites to certain content on this Website.</li>
    <li>Send emails or other communications with certain content, or links to certain content, on this Website.</li>
    <li>Cause limited portions of content on this Website to be displayed or appear to be displayed on your own or certain third-party websites.</li>
</ul>

<p>You may use these features solely as they are provided by us, and solely with respect to the content they are displayed with and otherwise in accordance with any additional terms and conditions we provide with respect to such features. Subject to the foregoing, you must not:</p>

<ul>
  <li>Establish a link from any website that is not owned by you.</li>
  <li>Cause the Website or portions of it to be displayed on, or appear to be displayed by, any other site, for example, framing, deep linking, or in-line linking.</li>
  <li>Otherwise take any action with respect to the materials on this Website that is inconsistent with any other provision of these Terms of Use.</li>
</ul>

<p>The website from which you are linking, or on which you make certain content accessible, must comply in all respects with the Content Standards set out in these </p>

<p><b>Terms of Use.</b><br>
You agree to cooperate with us in causing any unauthorized framing or linking immediately to stop. We reserve the right to withdraw linking permission without notice.
We may disable all or any social media features and any links at any time without notice at our discretion.
</p>

<p>Links from the Website</p>

<p>If the Website contains links to other sites and resources provided by third parties, these links are provided for your convenience only. This includes links contained in advertisements, including banner advertisements and sponsored links. We have no control over the contents of those sites or resources, and accept no responsibility for them or for any loss or damage that may arise from your use of them. If you decide to access any of the third-party websites linked to this Website, you do so entirely at your own risk and subject to the terms and conditions of use for such websites.</p>

<p>Geographic Restrictions<br>
The owner of the Website is based in the state of Wyoming in the United States. We provide this Website for use only by persons located in the United States. We make no claims that the Website or any of its content is accessible or appropriate outside of the United States. Access to the Website may not be legal by certain persons or in certain countries. If you access the Website from outside the United States, you do so on your own initiative and are responsible for compliance with local laws.
</p>

<p>Disclaimer of Warranties</p>

<p>You understand that we cannot and do not guarantee or warrant that files available for downloading from the internet or the Website will be free of viruses or other destructive code. You are responsible for implementing sufficient procedures and checkpoints to satisfy your particular requirements for anti-virus protection and accuracy of data input and output, and for maintaining a means external to our site for any reconstruction of any lost data. TO THE FULLEST EXTENT PROVIDED BY LAW, WE WILL NOT BE LIABLE FOR ANY LOSS OR DAMAGE CAUSED BY A DISTRIBUTED DENIAL-OF-SERVICE ATTACK, VIRUSES, OR OTHER TECHNOLOGICALLY HARMFUL MATERIAL THAT MAY INFECT YOUR COMPUTER EQUIPMENT, COMPUTER PROGRAMS, DATA, OR OTHER PROPRIETARY MATERIAL DUE TO YOUR USE OF THE WEBSITE OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE OR TO YOUR DOWNLOADING OF ANY MATERIAL POSTED ON IT, OR ON ANY WEBSITE LINKED TO IT.<br>
YOUR USE OF THE WEBSITE, ITS CONTENT, AND ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE IS AT YOUR OWN RISK. THE WEBSITE, ITS CONTENT, AND ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE ARE PROVIDED ON AN “AS IS” AND “AS AVAILABLE” BASIS, WITHOUT ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED. NEITHER THE COMPANY NOR ANY PERSON ASSOCIATED WITH THE COMPANY MAKES ANY WARRANTY OR REPRESENTATION WITH RESPECT TO THE COMPLETENESS, SECURITY, RELIABILITY, QUALITY, ACCURACY, OR AVAILABILITY OF THE WEBSITE. WITHOUT LIMITING THE FOREGOING, NEITHER THE COMPANY NOR ANYONE ASSOCIATED WITH THE COMPANY REPRESENTS OR WARRANTS THAT THE WEBSITE, ITS CONTENT, OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE WILL BE ACCURATE, RELIABLE, ERROR-FREE, OR UNINTERRUPTED, THAT DEFECTS WILL BE CORRECTED, THAT OUR SITE OR THE SERVER THAT MAKES IT AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS, OR THAT THE WEBSITE OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE WEBSITE WILL OTHERWISE MEET YOUR NEEDS OR EXPECTATIONS.<br>
TO THE FULLEST EXTENT PROVIDED BY LAW, THE COMPANY HEREBY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, STATUTORY, OR OTHERWISE, INCLUDING BUT NOT LIMITED TO ANY WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT, AND FITNESS FOR PARTICULAR PURPOSE.<br>
ALL CALCULATIONS MADE BY THE WEBSITE OR ON THE WEBSITE ARE ALGORITHMIC ESTIMATES.  THE COMPANY DOES NOT WARRANT THE ACCURACY OF ANY ESTIMATES CREATED BY OR ON THE WEBSITE.  TO THE FULLEST EXTENT PROVIDED BY LAW, WE WILL NOT BE LIABLE FOR LOSS OF REVENUE, LOSS OF PROFITS, LOSS OF BUSINESS OR ANTICIPATED SAVINGS DUE TO ANY ESTIMATES CREATED BY OR ON THE WEBSITE.<br>
THE FOREGOING DOES NOT AFFECT ANY WARRANTIES THAT CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.<br>
</p>

<p>Sole Solutions LLC is not affiliated or endorsed by Amazon Inc or any of the suppliers listed on our site in any way. While every effort has been made to accurately represent our products and their potential there is no guarantee that you will earn any money using the techniques and ideas in these materials. Examples in these materials are not to be interpreted as a promise or guarantee of earnings. Your use of Sole Solutions is entirely at your own risk and we will not be held liable for any losses that may result from using our software. </p>

<p><b>Limitation on Liability</b></p>

<p>TO THE FULLEST EXTENT PROVIDED BY LAW, IN NO EVENT WILL THE COMPANY, ITS AFFILIATES, OR THEIR LICENSORS, SERVICE PROVIDERS, EMPLOYEES, AGENTS, OFFICERS, OR DIRECTORS BE LIABLE FOR DAMAGES OF ANY KIND, UNDER ANY LEGAL THEORY, ARISING OUT OF OR IN CONNECTION WITH YOUR USE, OR INABILITY TO USE, THE WEBSITE, ANY WEBSITES LINKED TO IT, INCLUDING BUT NOT LIMITED TO AMAZON.COM OR ANY OF ITS AFFILIATED SITES, ANY CONTENT ON THE WEBSITE OR SUCH OTHER WEBSITES, INCLUDING ANY DIRECT, INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, INCLUDING BUT NOT LIMITED TO, PERSONAL INJURY, PAIN AND SUFFERING, EMOTIONAL DISTRESS, LOSS OF REVENUE, LOSS OF PROFITS, LOSS OF BUSINESS OR ANTICIPATED SAVINGS, LOSS OF USE, LOSS OF GOODWILL, LOSS OF DATA, AND WHETHER CAUSED BY TORT (INCLUDING NEGLIGENCE), BREACH OF CONTRACT, OR OTHERWISE, EVEN IF FORESEEABLE.<br>
THE FOREGOING DOES NOT AFFECT ANY LIABILITY THAT CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.</p>

<p><b>Indemnification</b></p>
<p>You agree to defend, indemnify, and hold harmless the Company, its affiliates, licensors, and service providers, and its and their respective officers, directors, employees, contractors, agents, licensors, suppliers, successors, and assigns from and against any claims, liabilities, damages, judgments, awards, losses, costs, expenses, or fees (including reasonable attorneys’ fees) arising out of or relating to your violation of these Terms of Use or your use of the Website, including, but not limited to, your User Contributions, any use of the Website’s content, services, and products other than as expressly authorized in these Terms of Use or your use of any information obtained from the Website.</p>

<p><b>Governing Law and Jurisdiction</b></p>

<p>All matters relating to the Website and these Terms of Use and any dispute or claim arising there from or related thereto (in each case, including non-contractual disputes or claims), shall be governed by and construed in accordance with the internal laws of the State of Wyoming without giving effect to any choice or conflict of law provision or rule (whether of the State of Wyoming or any other jurisdiction).<br>
Any legal suit, action, or proceeding arising out of, or related to, these Terms of Use or the Website shall be instituted exclusively in the federal courts of the United States or the courts of the State of Wyoming, although we retain the right to bring any suit, action, or proceeding against you for breach of these Terms of Use in your country of residence or any other relevant country. You waive any and all objections to the exercise of jurisdiction over you by such courts and to venue in such courts.
</p>

<p><b>Arbitration</b></p>
<p>At Company’s sole discretion, it may require You to submit any disputes arising from the use of these Terms of Use or the Website, including disputes arising from or concerning their interpretation, violation, invalidity, non-performance, or termination, to final and binding arbitration under the Rules of Arbitration of the American Arbitration Association applying Wyoming law.</p>

<p><b>Limitation on Time to File Claims</b></p>

<p>ANY CAUSE OF ACTION OR CLAIM YOU MAY HAVE ARISING OUT OF OR RELATING TO THESE TERMS OF USE OR THE WEBSITE MUST BE COMMENCED WITHIN ONE (1) YEAR AFTER THE CAUSE OF ACTION ACCRUES, OTHERWISE, SUCH CAUSE OF ACTION OR CLAIM IS PERMANENTLY BARRED.</p>

<p><b>Waiver and Severability</b></p>

<p>No waiver by the Company of any term or condition set out in these Terms of Use shall be deemed a further or continuing waiver of such term or condition or a waiver of any other term or condition, and any failure of the Company to assert a right or provision under these Terms of Use shall not constitute a waiver of such right or provision.
If any provision of these Terms of Use is held by a court or other tribunal of competent jurisdiction to be invalid, illegal, or unenforceable for any reason, such provision shall be eliminated or limited to the minimum extent such that the remaining provisions of the Terms of Use will continue in full force and effect.
</p>

<p><b>Entire Agreement</b></p>

<p>The Terms of Use and, our Privacy Policy, Subscription Agreement constitute the sole and entire agreement between you and Sole Solutions regarding the Website and supersede all prior and contemporaneous understandings, agreements, representations, and warranties, both written and oral, regarding the Website.</p>

<p><b>Your Comments and Concerns</b></p>

<p>This website is operated by Sole Solutions LLC. 412 N Main St Ste 100 Buffalo, WY 82834. All other feedback, comments, requests for technical support, and other communications relating to the Website should be directed to: <a href="#">info@Sole Solutions.com.</a>.</p>

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