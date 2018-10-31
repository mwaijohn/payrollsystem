<?php
require_once '../database/db.php';
require('../manageemployee/manageemployee.php');
if(isset($_POST['search'])){
    $term = $_POST['search'];
    $sql = "SELECT firstname ,lastname,empnumber,idnumber FROM employee WHERE idnumber LIKE  :term AND status=0";

    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':term'=>$term.'%'));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
    
    return sizeof($result);//json_encode($result);
}
if(isset($_POST['activate'])){
    ManageEmployee::activate($conn,$_POST['activate']);
}
?>
<form method="POST" action="">
    <h5 class="bio">Activate employee</h5>
    <div class="form-row">
        <div class="col col-sm-6">
            <!-- <label for="idno">Id number</label> -->
            <input type="search" class="form-control" placeholder="Search id number" id="search" name="search">
        </div>
    </div>
</form><br>
<div class="result" class="col col-12">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Fist name</th>
                <th scope="col">Last name</th>
                <th scope="col">member number</th>
                <th scope="col">Activate</th>
            </tr>
        </thead>
        <tbody class="tbody">
            
        </tbody>
    </table>
</div>