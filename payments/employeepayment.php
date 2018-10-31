<?php
require_once '../database/db.php';
require_once '../formulas.php';


class EmployeePayment{
  public function __construct(){}

  //gets basicsalary taxable alowance , non taxable allowance for particular employeee
  public static function getGrossPay($connection,$empno){
    $sql = "SELECT * FROM grosspay WHERE empnumber=:empno";
    $stmt = $connection->prepare($sql);
    $stmt->execute(array(':empno'=>$empno));

    //echo $stmt->rowCount();
    //echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
  }

  public static function setNetPay($connection,$empno){
    //netpay = all allowances + basic pay - tax- deductions
  }

  //get alll employee_allowances
  public static function getAllowances($connection,$empno){
    $select_sql = "SELECT description,amount FROM allowances NATURAL JOIN employee_allowances WHERE employee_allowances.empnumber =:empno";
    $stmt = $connection->prepare($select_sql);

    $stmt->execute(array(':empno'=>$empno));
    echo json_encode($stmt->fetchall(PDO::FETCH_ASSOC));

    return json_encode($stmt->fetchall(PDO::FETCH_ASSOC));
  }

//get all deductions for particular employeee
  public static function getDeductions($connection,$empno){
    //get all deductions
    $sql = "SELECT description,amount FROM employeedeductions WHERE  empnumber=:empno AND paid=0";
    try {
      $stmt = $connection->prepare($sql);
      $stmt->execute(array(':empno'=>$empno));
      $deductions = $stmt->fetchall(PDO::FETCH_ASSOC);

      echo json_encode($deductions);
      return json_encode($deductions);
    } catch (\Exception $e) {
      echo $e->getMassage();
    }
  }
}

//$empP = new EmployeePayment();
//EmployeePayment::getGrossPay($conn,"1234569");
//EmployeePayment::getDeductions($conn,"1234569");
//EmployeePayment::getAllowances($conn,"1234569")

echo date('Y-m-d');
 ?>
