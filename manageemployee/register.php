<!DOCTYPE html>
<html lang="en">
    <?php //require_once '../database/db.php'; 
    //require_once '../manageemployee/manageemployee.php'?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
    //register employee
    if(isset($_POST['fname'])){
        //get all data with correct format
        $dob = date("Y-m-d", strtotime($_POST['dob']));
        $register = ManageEmployee::registerEmployee($conn,$_POST['fname'],$_POST['lname'],$_POST['mname'],
        $_POST['idno'],$_POST['contact'],$dob,$_POST['kra'],$_POST['nhif'],$_POST['nssf'],
        $_POST['email'],$_POST['salary'],0,$_POST['etype'],$_POST['a/c'],$_POST['bname'],
        $_POST['branch'],$_POST['gender'],$_POST['department'],date('Y-m-d'),$_POST['kinname'],
        $_POST['kinaddress'],$_POST['kincontact']);

        if($register==true){
          header('location:../index.php');
        }else{
            echo "dds";
        }
    }


?>
    
</body>
</html>