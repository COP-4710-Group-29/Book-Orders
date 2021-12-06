<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//Load Composer's autoloader
require '../vendor/autoload.php';

require 'connect.php';

if(isset($_POST["email"]))
{
    $email = $_POST["email"];

    // Check if the email already exists
    $sql = "SELECT COUNT(email) AS num FROM professors WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);

    // Execute
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // If it returns anything != 0, throw an error
    if($row['num'] != 1)
    {
        $array = array("status"=>false,"message"=>"An account with that email does not exist!");
        echo json_encode($array);
        die();
    }

    $code= uniqid(true);
    $sql = "INSERT INTO reset_password (code, email) VALUES (:code, :email)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':code', $code);
    $stmt->bindValue(':email', $email);

    $result = $stmt->execute();

    if(!$result)
    {
      $array = array("status"=>false,"message"=>"An error occured.");
      echo json_encode($array);
      exit();
    }

    $result = $stmt->execute();

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cop4710group29@gmail.com';
        $mail->Password   = 'PASSWORD';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('cop4710group29@gmail.com', 'UCF Library');
        $mail->addAddress($email);
        $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

        //Content
        $url = "http://" . $_SERVER["HTTP_HOST"] . "/accounts/reset?code=$code";
        $mail->isHTML(true);
        $mail->Subject = 'Password Recovery link';
        $mail->Body    = '<h1>You reuested a password recovery</h1>
                            Click <a href='.$url.'> HERE </a> to change your password';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $array = array("status"=>true,"message"=>"Reset link was sent to your email.");
        echo json_encode($array);
    } catch (Exception $e) {
        $array = array("status"=>false,"message"=>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        echo json_encode($array);
    }
}
?>
