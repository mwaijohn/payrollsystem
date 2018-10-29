<?php

require_once 'database/db.php';
require_once 'formulas.php';
/**
 * @contain functions for managing employess
 */
interface IEmployees
{
  public function registerEmployee($connection,$fname,$mname,$lname,$id,$contact,$krapin,$nhifno,$nssfno,$email,$basicsalary
,$status,$emptype,$accno,$bankname,$branch,$gender,$department,$startdate,$nextofkin,$kinaddress,$kincontact);
  // public function register allowances
  public function allowances($code,$connection,$description,$amount,$taxable);
  //register departments
  public static function departments($connection,$code,$name);

  //to record all deductions for an employee
  public function empDeductions($connection,$empno,$description,$amount,$paid);
}

class ManageEmployee implements IEmployees{

  // register an employee
  public function __construct(Type $foo = null){}
    public function registerEmployee($connection,$fname,$mname,$lname,$id,$contact,$krapin,$nhifno,$nssfno,$email,$basicsalary
  ,$status,$emptype,$accno,$bankname,$branch,$gender,$department,$startdate,$nextofkin,$kinaddress,$kincontact){
    try {
      //begin transactions
      $connection->beginTransaction();
      $sql = "INSERT INTO employee (firstname,middlename,lastname,idnumber,contact,krapin,nhifnumber,nssfnumber,email,basicsalary
      ,status,emptype,accountnumber,bankname,bankbranch,gender,department,startdate,nextofkin,nextofkinaddress,nextofkincontact) VALUES(:fname,:mname,:lname,:id,
      :contact,:krapin,:nhifno,:nssfno,:email,:basicsalary
      ,:status,:emptype,:accno,:bankname,:branch,:gender,:department,:startdate,
      :nextofkin,:kinaddress,:kincontact)";
      echo $sql;
      $statement = $connection->prepare($sql);
      $statement->execute(array(':fname' => $fname,':mname'=>$mname,':lname'=>$lname,':id'=>$id,':contact'=>$contact,':krapin'=>$krapin,':nhifno'=>$nhifno,':nssfno'=>$nssfno,
      ':email'=>$email,':basicsalary'=>$basicsalary,'status'=>$status,':emptype'=>$emptype,':accno'=>$accno,':bankname'=>$bankname,':branch'=>$branch,':gender'=>$gender,':department'=>$department,
      ':startdate'=>$startdate,':nextofkin'=>$nextofkin,':kinaddress'=>$kinaddress,':kincontact'=>$kincontact));
      $connection->commit();

      if($statement->rowCount()>0){
        echo "staff added";
        return true;
      }

    } catch (\Exception $e) {
      $connection->rollBack();
      echo "error occured";
      //$e->getMassage();

      return false;
    }


  }

  //for all standard allowance to register allowances
  public function allowances($connection,$code,$description,$amount,$taxable){
    try {
      $sql = "INSERT INTO allowances (allowancecode,description,amount,taxable) VALUES(:code,:description,:amount,:taxable)";

      $connection->beginTransaction();
      $statement = $connection->prepare($sql);
      $statement->execute(array(':code'=>$code,':description'=>$description,':amount'=>$amount,':taxable'=>$taxable));

      $connection->commit();
      if($statement->rowCount()>0){
        return true;
      }

    } catch (\Exception $e) {
      $connection->rollBack();
      echo "error occured";
    }

  }

  //assign/entitle allowance to an employee
  public static function assignAllowance($connection,$empno,$code){
    $sql = "INSERT INTO employee_allowances (empnumber,allowancecode) VALUES(:empno,:code)";
    try {
      //check if user is already assigned allowance
      $connection->beginTransaction();
      $check = "SELECT empnumber,allowancecode FROM employee_allowances WHERE empnumber=:empno AND allowancecode=:code";
      $check_stmt = $connection->prepare($check);
      $check_stmt->execute(array(':empno'=>$empno,':code'=>$code));

      if($check_stmt->rowCount()<1){
        $statement = $connection->prepare($sql);
        $statement->execute(array(':empno'=>$empno,':code'=>$code));

        $connection->commit();
        echo "assigned allowances " . $code;
      }else{
        echo "duplicate allowance assined to one person";
      }
    } catch (\Exception $e) {
      echo "anana";//$e->getMassage();
    }


  }


  //revoke allowances to a particular employeee
  public static function revokeAllowance($connection,$empno,$code){
    $sql = "DELETE FROM employee_allowances WHERE empnumber= :empno AND allowancecode= :code";
    try {
      //check if user is already assigned allowance
      $connection->beginTransaction();
      $statement = $connection->prepare($sql);
      $statement->execute(array(':empno'=>$empno,':code'=>$code));

      $connection->commit();
      echo "revoked  allowances " . $code . "to ". $empno;
    } catch (\Exception $e) {
      echo "anana";
    }


  }

//for all deductions to an employee
  public function empDeductions($connection,$empno,$description,$amount,$paid){
     $sql = "INSERT INTO employeedeductions (empnumber,description,amount,paid) VALUES(:empno,:description,:amount,:paid)";
     try {
       $connection->beginTransaction();
       $statement = $connection->prepare($sql);
       $statement->execute(array(':empno'=>$empno,':description'=>$description,':amount'=>$amount,':paid'=>$paid));

       $connection->commit();

       if($statement->rowCount()>0){
         return true;
       }
     } catch (\Exception $e) {

       $connection->rollBack();
       echo "error occured";
     }

  }

//register all departments
  public static function departments($connection,$code,$name){
    $sql = "INSERT INTO departments (departmentcode,departmentname) VALUES(:code,:name)";
    try {
      $connection->beginTransaction();
      $statement = $connection->prepare($sql);
      $statement->execute(array(':code'=>$code,':name'=>$name));

      $connection->commit();
      if($statement->rowCount()>0){
        return true;
      }

    } catch (\Exception $e) {
      $connection->rollBack();
      echo "error occured";
    }

  }
  //get gross pay for an employee including all taxable allowances and basic salary
  public static function grossPay($connection,$empno){
    //get all taxable allowances entitled to this employeee
    $select_sql = "SELECT * FROM allowances NATURAL JOIN employee_allowances WHERE employee_allowances.empnumber =:empno";
    $select_basic_salary = "SELECT basicsalary FROM employee WHERE empnumber=:empno";
    try {

      $connection->beginTransaction();
      $statement = $connection->prepare($select_sql);
      $statement->execute(array(':empno'=>$empno));

      $statement_basic = $connection->prepare($select_basic_salary);
      $statement_basic->execute(array(':empno'=>$empno));


      $connection->commit();

      $result = $statement->fetchall();
      $result_basic = $statement_basic->fetch();

      //echo $result_basic['basicsalary'];

      $amounttaxable = 0; $amountnottaxable =  0;
      if($statement->rowCount()>0){
        foreach ($result as $key => $value) {

          if((int)$value['taxable'] == 1){
            $amounttaxable +=  $value['amount'];

          }elseif ((int)$value['taxable'] == 0) {
            $amountnottaxable += $value['amount'];
          }

        }

        //return  $result_basic['basicsalary'];
      }

      //if all is okay INSERT TO grossPay table
      $gross_update = "INSERT INTO grosspay (empnumber,totaltaxableallowance,totalnontaxableallowance,basicsalary) VALUES(
        :empno,:ttx,:nttx,:basic
      ) ";

      $connection->beginTransaction();

      $gross_update_stmt = $connection->prepare($gross_update);
      $gross_update_stmt->execute(array(':empno'=>$empno,':ttx'=>$amounttaxable,':nttx'=>$amountnottaxable,':basic'=>$result_basic['basicsalary']));

      $connection->commit();
      if($gross_update_stmt->rowCount()>0){
        echo "insert succeeded";
      }else {
        echo "nothing inserted";
      }

      //return json_encode($gross_update_stmt->fetchall());

    } catch (\Exception $e) {
      $connection->rollBack();
      echo $e->getMessage();
      echo "error occured in update";
    }

  }

  //register all deductions here for a particular employee
  public static function registerDeductions($connection,$empno,$description,$amount,$paid){
    $sql = "INSERT INTO employeedeductions VALUES(:empno,:description,:amount,:paid)";

    $connection->beginTransaction();

    $stmt = $connection->prepare($sql);

    $stmt->execute(array(':empno'=>$empno,':description'=>$description,':amount'=>$amount,':paid'=>$paid));
    if($stmt->rowCount()>0){
      echo "insert succeded";
      $connection->commit();
    }else {
      $connection->rollBack();
    }

  }

  //revoke deductions
  public static function revokeDeductions($connection,$empno,$description){
    $sql = "DELETE FROM employeedeductions WHERE empnumber=:empno AND description=:description AND paid=0";

    $connection->beginTransaction();

    $stmt = $connection->prepare($sql);

    $stmt->execute(array(':empno'=>$empno,':description'=>$description));
    if($stmt->rowCount()>0){
      echo "delete succeded";
      $connection->commit();
    }else {
      $connection->rollBack();
    }

  }
}


class TaxPayment{
  public function __construct(){}

    //get what we need to pay taxed 1:gross salary,2:rates for duduction,3:
    public function payTax(){

    }
}
$mnge = new ManageEmployee();
//$mnge->registerEmployee($conn,"John","Mwai","Mungai","3389138","0819883977","AD06BF07","88833878","687666","mwaiuohn@gmail.com",25000,0,"permanent","978725436872","National Bank","CBD","male","sales",date('Y-m-d'),"John Njau","346 Njoro","0765983878");
//$mnge->allowances($conn,"009","hardship allowances",5500,0);
//$mnge->empDeductions($conn,1234581,"ytt",5000,1);
//ManageEmployee::departments($conn,"communication","Communication");
//ManageEmployee::grossPay($conn,"1234567");
//ManageEmployee::registerDeductions($conn,"1234581","breakages",1080,0);
//ManageEmployee::assignAllowance($conn,"1234581","009");
//ManageEmployee::revokeAllowance($conn,"1234581","009");
ManageEmployee::revokeDeductions($conn,"1234581","breakages");

$empP = new EmployeePayment();
//EmployeePayment::getGrossPay($conn,"1234569");
//EmployeePayment::getDeductions($conn,"1234569");
//EmployeePayment::getAllowances($conn,"1234569")





 ?>
