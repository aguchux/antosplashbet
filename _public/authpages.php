<?php


$Route->add('/auth/login', function () {
    $Core = new Apps\Core;
    $Template = new Apps\Template();
    $Template->addheader("layouts.auth.header");
    $Template->addfooter("layouts.auth.footer");
    $Template->assign("title", "Secure Login | EBSG Finance");
    $Template->assign("menukey", "login");
    $Template->render("login");
}, 'GET');


$Route->add('/auth/reset', function () {
    $Core = new Apps\Core;
    $Template = new Apps\Template();
    $Template->addheader("layouts.auth.header");
    $Template->addfooter("layouts.auth.footer");
    $Template->assign("title", "Reset Account | EBSG Finance");
    $Template->assign("menukey", "login");
    $Template->render("reset");
}, 'GET');


$Route->add('/auth/otp', function () {
    $Core = new Apps\Core;
    $Template = new Apps\Template();
    $Template->addheader("layouts.auth.header");
    $Template->addfooter("layouts.auth.footer");
    $Template->assign("title", "Enter Secure OTP | EBSG Finance");
    $Template->assign("menukey", "login");
    $Template->render("otp");
}, 'GET');


$Route->add('/auth/forms/{action}', function ($action) {

    $Core = new Apps\Core;
    $Template = new Apps\Template();
    $Template->token($Template->data['token']);

    $data = $Core->post($_POST);

    $SMSLive = new Apps\SMSLive;

    if ($action == "splash") {

        $Template->redirect("/auth/login");
    } elseif ($action == "login") {

        if ($Template->auth) {
            $Template->redirect("/dashboard");
        }

        $username = $data->username;
        $password = $data->password;
        $Login = $Core->UserLogin($username, $password);


        if ($Login->accid) {

            //Check if user is disenabled//
            if (!$Login->enabled){
                $Template->redirect("/auth/login?err=02"); 
            }
            //Check if user is disenabled//

            //Check if OTP is enabled//
            if ($Login->enable_otp) {

                $otp = $Core->GenOTP(6);

                $Core->SetUserInfo($Login->accid, "otp_pending", 1);
                $Core->SetUserInfo($Login->accid, "otp", strtoupper($otp));
                $Core->SetUserInfo($Login->accid, "otp_time", date("Y-m-d g:i:S"));

                $Template->store("accid", $Login->accid);

                $message = "NEVER DISCLOSE YOUR OTP TO ANYONE. Your OTP to login is {$otp}. Enquiry? Call: 08068573376";
                $sent = $SMSLive->send($Login->mobile, $message);

                $subject = "Your OTP to login is {$otp}";
              
                //Email Notix//
                $Mailer = new Apps\Emailer();
                $EmailTemplate = new Apps\EmailTemplate('mails.otp');
                $EmailTemplate->subject = $subject;
                $EmailTemplate->otp = $otp;
                $EmailTemplate->fullname = $Login->fullname;
                $EmailTemplate->mailbody = $message;
                $Mailer->subject = $subject;
                $Mailer->SetTemplate($EmailTemplate);
                $Mailer->toEmail = $Login->email;
                $Mailer->send();
                //Email Notix//

                $Template->redirect("/auth/otp");

            } else {
                if ($Login->device_protection){
                    //Log device info//
                    //Email user about login//
                    //Log device info//
                    $Template->authorize($Login->accid);
                }else{
                    $Template->authorize($Login->accid);                  
                }
                $Template->redirect("/dashboard");
            }
            //Check if OTP is enabled//
        } else {
            $Template->redirect("/auth/login");
        }
    } elseif ($action == "reset") {

        if ($Template->auth) {
            $Template->redirect("/dashboard");
        }

        $username = $data->username;
        $UserInfo = $Core->UserInfo($username);

        if ($UserInfo->accid) {
            $password = $Core->GenPassword(5);
            $Core->SetUserInfo($UserInfo->accid, "password", $password);

            $message = "Your temporary password to login is {$password}. Enquiry? Call: 08068573376";
            $sent = $SMSLive->send($UserInfo->mobile, $message);

            $subject = "New Password Reset";

            //Email Notix//
            $Mailer = new Apps\Emailer();
            $EmailTemplate = new Apps\EmailTemplate('mails.reset');
            $EmailTemplate->subject = $subject;
            $EmailTemplate->fullname = $UserInfo->fullname;
            $EmailTemplate->mailbody = $message;
            $Mailer->subject = $subject;
            $Mailer->SetTemplate($EmailTemplate);
            $Mailer->toEmail = $UserInfo->email;
            $Mailer->send();
            //Email Notix//

        }

        $Template->redirect("/auth/login");
    } elseif ($action == "otp") {

        if ($Template->auth) {
            $Template->redirect("/dashboard");
        }

        if (!isset($Template->data['accid'])) {
            $Template->redirect("/auth/login");
        }

        $accid = $Template->data['accid'];
        $otp = strtoupper($data->otp);
        $VerifyOTP = $Core->VerifyOTP($accid, $otp);

        if ($VerifyOTP) {
            //Authorize this login//
            $Core->SetUserInfo($accid, "otp_pending", 0);
            $Core->SetUserInfo($accid, "otp", "");
            $Template->authorize($accid);
            $Template->redirect("/dashboard");
            //Authorize this login//
        }
        $Template->redirect("/auth/otp");
    } else {
        $Template->redirect("/auth/login");
    }
}, 'POST');
