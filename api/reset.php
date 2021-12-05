<?php

    require 'connect.php';

    if(!isset($_GET["code"])) 
    {
        exit("Can't find page");
    }
    
    $code = $_GET["code"];

    $sql = "SELECT COUNT(email) as num FROM reset_password WHERE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':code', $code);

    // Execute
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row['num'] == 0)
    {
        exit("Can't find email");
    }

    $email = $row["email"];

    if(isset($_POST["password"])) 
    {
        $newPassword = $_POST["password"]
        $newPassword = hash('sha256', $newPassword);

        $sql = "UPDATE professor SET password = :newPassword WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':newPassword', $newPassword);
        $stmt->bindValue(':email', $email);

        $result = $stmt->execute();

        if($result)
        {
            $sql = "DELETE FROM reset_password WHERE code = :code";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':code', $code);
            $delete = $stmt->execute();
            $array = array("status"=>true);
        }
        else 
        {
            $array = array("status"=>false,"message"=>"An internal error occured.");
	        echo json_encode($array);
        }
    }
    
?>