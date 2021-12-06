<?php

    require 'connect.php';

    if(!isset($_POST["code"]))
    {
      $array = array("status"=>false,"message"=>"Code was not found.");
      echo json_encode($array);
      exit();
    }

    $code = $_POST["code"];

    $sql = "SELECT COUNT(email) as num, email FROM reset_password WHERE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':code', $code);

    // Execute
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row['num'] == 0)
    {
      $array = array("status"=>false,"message"=>"Email does not exist.");
      echo json_encode($array);
      exit();
    }

    $email = $row["email"];

    if(isset($_POST["password"]))
    {
        $newPassword = $_POST["password"];
        $newPassword = hash('sha256', $newPassword);

        $sql = "UPDATE professors SET password = :newPassword WHERE email = :email";
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
            echo json_encode($array);
        }
        else
        {
          $array = array("status"=>false,"message"=>"An internal error occured.");
          echo json_encode($array);
        }
    }
    else
    {
      $array = array("status"=>false,"message"=>"Missing required parameter: password.");
      echo json_encode($array);
      exit();
    }

?>
