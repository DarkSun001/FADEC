<?php

namespace App\Controllers;

use App\Core\View;
use App\Forms\Register;
use App\Forms\Login;
use App\Models\User;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Auth
{
    public function login()
    {
        $form = new Login();
        $view = new View("Auth/login", "front");
        $view->assign("formErrors", $form->errors);
        $view->assign("form", $form->getConfig());
        $view->assign("pageTitle", "Connexion - Movie Reviews");
        $view->assign("pageDescription", "Page de connexion.");


        if($form->isSubmited() && $form->isValid()){
            $formData = $form->getFields();
            //echo "formdata";
            //var_dump($formData);
            if ($formData['email'] && $formData['pwd']) {
                //echo "formdata2";
                $user = new User();
                $user = $user->getOneWhere(['email' => $formData['email']]);
                //var_dump($user);
                // Assuming you have a getPassword method in User model which return the user's password.
                if($user && password_verify($formData['pwd'], $user->getPwd())) {
                    // Start session and store user details in session
                    session_start();
                    echo "session start";
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['email'] = $user->getEmail();
                    $_SESSION['firstname'] = $user->getFirstname();
                    if ($user->getStatus() == 2) {
                        header('Location: /dashboard');
                        exit();
                    }

                    // Redirect to homepage after successful login
                    header('Location: /');
                    exit();
                } else {
                    // Invalid email or password
                    $view->assign("formErrors", "Invalid email or password");
                }
            }
        }
    }

    public function register(): void
    {
        $form = new Register();
        $view = new View("Auth/register", "front");
        $view->assign("formErrors", $form->errors);
        $view->assign("form", $form->getConfig());

        $view->assign("pageTitle", "Inscription - Movie Reviews");
        $view->assign("pageDescription", "Page inscription.");

        //Form validé ? et correct ?
        if($form->isSubmited() && $form->isValid()){
            $formData = $form->getFields();
            if ($formData['firstname'] && $formData['lastname'] && $formData['email'] && $formData['pwd']) {
                $user = new User();
                $user->setFirstname($formData['firstname']);
                $user->setLastname($formData['lastname']);
                $user->setEmail($formData['email']);
                $user->setPwd($formData['pwd']);
                $user->setCountry($formData['country']);
                $user->setStatus(0);
                $token = bin2hex(random_bytes(50));  // generate a verification token
                $user->setToken($token);
                $user->save();

                // Send verification email
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = 2;
                    $mail->isSMTP();
                    $mail->Host = 'mail';
                    $mail->SMTPAuth = false;
                    $mail->Username = 'user';
                    $mail->Password = 'pass';
                    $mail->SMTPSecure = false;
                    $mail->Port = 25;

                    //Recipients
                    $mail->setFrom('from@example.com', 'Mailer');
                    $mail->addAddress($user->getEmail(), $user->getFirstname() . ' ' . $user->getLastname());

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'CMS - Welcome - Verification';
                    $mail->Body    = 'Welcome to our website <b>' . $user->getFirstname() . '</b><br> Please click on the below link to verify your email address<br><a target="_blank" href="http://localhost/verify?token=' . $token . '">Verify Email</a>';

                    if($mail->send()){
                        session_start();
                        $_SESSION['email'] = $user->getEmail();
                        $_SESSION['firstname'] = $user->getFirstname();
                        $_SESSION['user_id'] = $user->getId();
                        // get
                        header('Location: /');
                        exit();
                    }

                    } catch (Exception $e) {
                        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                    }

            }
        }
    }

    public function verify(): void
    {
        if (!isset($_GET['token'])) {
            die('User not found with this token');
        }

        $token = $_GET['token'];
        $user = (new \App\Models\User)->getOneWhere(['token' => $token]);
        if ($user) {
            echo 'User found';
            $user->setStatus(1);
            $user->save();
            session_start();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['firstname'] = $user->getFirstname();
            header('Location: /');
            exit();
        } else {
            echo 'User not found';
        }

    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: /');
        exit();
    }

}