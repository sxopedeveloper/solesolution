<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?=$site_title?></title>
<style>
    .content-block h2 {
        background: linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
        background: -webkit-linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
        background: -moz-linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
        background: -o-linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
        color: #fff !important;
        padding: 15px;
        border-radius: 5px;
    }
</style>
</head>

<body style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #fff; margin: 0;"
bgcolor="#f9fbfd">

<table class="body-wrap"
style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background: linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
background: -webkit-linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
background: -moz-linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
background: -o-linear-gradient(to right, #116bf8 0%, #00d5a0 100%); margin: 0;"
bgcolor="#f9fbfd">
<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
    valign="top"></td>
<td class="container" width="600"
    style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
    valign="top">
    <div class="content"
         style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
        <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope
               itemtype="http://schema.org/ConfirmAction"
               style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
               >
            <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                <td class="content-wrap"
                    style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;padding: 30px;border: 5px solid #edf2f9;border-radius: 7px; background-color: #fff;"
                    valign="top">
                    <meta itemprop="name" content="Confirm Email"
                          style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
                    <table width="100%" cellpadding="0" cellspacing="0"
                           style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr>
                            <td style="text-align: center">
                                <a href="<?=base_url();?>" target="_blank" style="display: block;margin-bottom: 10px;"> <img src="<?=$site_logo;?>" alt="logo" style="width: 200px;" ></a> <br/>
                            </td>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;"
                                valign="top">
                                <h2 style="font-size: 30px;line-height: 36px;color: #116bf8;">New Inquiry Received</h2>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td style="text-align: center">
                                <img src="https://i.postimg.cc/j2vtfq6h/thank-you.jpg" alt="thank-you-img" style="width: 60%;height: auto;" style="margin: 0 auto;display: table;">
                            </td>
                        </tr> -->
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                valign="top">
                                Hey! There,
                            </td>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                valign="top">
                                Please find below details of new inquiry:-
                                <p>Name : <?=isset($name) ? $name : '';?></p>
                                <p>Email : <?=isset($email) ? $email : '';?></p>
                                <p>Phone Number : <?=isset($phone) ? $phone : '';?></p>
                                <p>Subject : <?=isset($subject) ? $subject : '';?></p>
                                <p>Message : <?=isset($message) ? $message : '';?></p>
                                <p>Added On : <?=isset($created_at) ? $created_at : '';?></p>
                            </td>
                        </tr>
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block" itemprop="handler" itemscope
                                itemtype="http://schema.org/HttpActionHandler"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                valign="top">
                                <!-- <a href="<?=isset($url) ? $url : '';?>" class="btn-primary" itemprop="url"
                                   style="    background: linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
    background: -webkit-linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
    background: -moz-linear-gradient(to right, #116bf8 0%, #00d5a0 100%);
    background: -o-linear-gradient(to right, #116bf8 0%, #00d5a0 100%);color: #fff;text-decoration: none;padding: 10px 50px;text-align: center;border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px;-ms-border-radius: 5px;margin: 0 auto;display: table;">Login</a> -->
                            </td>
                        </tr>
                        <!-- <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                valign="top">
                                &mdash; <b>UBold</b> - Admin Dashboard
                            </td>
                        </tr> -->
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-block"
                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;"
                                valign="top">
                                <h3>Connect With Us</h3>
                                <ul style="margin: 0px auto;padding: 0px;list-style: none;display: table;">
                                    <li style="display: inline-block;vertical-align: middle;margin: 0px 10px;">
                                    <a href="<?=isset($fb_link) ? $fb_link : '';?>">
                                        <img src="https://i.postimg.cc/6p0X8p0b/facebook-icon.png" alt="facebook-icon" style="height: 30px;">
                                    </a>
                                </li>
                                <li style="display: inline-block;vertical-align: middle;margin: 0px 10px;">
                                    <a href="<?=isset($twitter_link) ? $twitter_link : '';?>">
                                        <img src="https://i.postimg.cc/Dzk2XNkm/twitter-icon.png" alt="twitter-icon" style="height: 30px;">
                                    </a>
                                </li>
                                <li style="display: inline-block;vertical-align: middle;margin: 0px 10px;">
                                    <a href="<?=isset($instagram_link) ? $instagram_link : '';?>">
                                        <img src="https://i.postimg.cc/4NgqpTnD/instagram-icon.png" alt="insta-icon" style="height: 30px;">
                                    </a>
                                </li>
                            </ul>
                            </td>
                            
                        </tr>
                         <tr>
                            <td style="text-align: center">
                                <a href="mailto:<?=$site_email;?>" target="_blank" style="display: block;margin-bottom: 10px;text-decoration: none;color: #72849a;font-weight: bold;"><?=$site_email;?></a><br/>
                                <span><?=$site_name?>, <?=$address?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!-- <div class="footer"
             style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
            <table width="100%"
                   style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="aligncenter content-block"
                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #fff; text-align: center; margin: 0; padding: 0 0 20px;"
                        align="center" valign="top"><a href="#"
                                                       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #fff; text-decoration: underline; margin: 0;">Unsubscribe</a>
                    </td>
                </tr>
            </table>
        </div> -->
    </div>
</td>
<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
    valign="top"></td>
</tr>
</table>
</body>
</html>