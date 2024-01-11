<?php
include('conf/pdoconfig.php');
// Check if the "iBankAccountType" is not empty in the POST request
if (!empty($_POST["iBankAccountType"])) {
    // Get the selected bank account type
    $id = $_POST['iBankAccountType'];
    // Prepare and execute a PDO statement to fetch information based on the selected account type
    $stmt = $DB_con->prepare("SELECT * FROM iB_Acc_types WHERE  name = :id");
    $stmt->execute(array(':id' => $id));
?>
<?php
    // Fetch and display the information
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
    
<?php echo htmlentities($row['rate']); ?>
<?php
    }
}
//This code assumes that the "iBankAccountType" is sent via a POST request, 
//and it fetches and displays information from the "iB_Acc_types" table based on the selected account type. 
//Adjust the code as needed for your specific requirements.

// Check if the "iBankAccNumber" is not empty in the POST request
if (!empty($_POST["iBankAccNumber"])) {
    //get  back account transferables name
    $id = $_POST['iBankAccNumber'];
    // Prepare and execute a PDO statement to fetch information based on the selected account number
    $stmt = $DB_con->prepare("SELECT * FROM iB_bankAccounts WHERE  account_number= :id");
    $stmt->execute(array(':id' => $id));
?>
<?php
// Fetch and display the information
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<?php echo htmlentities($row['acc_name']); ?>
<?php
    }
}
// Check if the "iBankAccHolder" is not empty in the POST request
if (!empty($_POST["iBankAccHolder"])) {
    // Get the selected bank account holder
    $id = $_POST['iBankAccHolder'];
    // Prepare and execute a PDO statement to fetch information based on the selected account holder
    $stmt = $DB_con->prepare("SELECT * FROM iB_bankAccounts WHERE  account_number= :id");
    $stmt->execute(array(':id' => $id));
?>
<?php
    // Fetch and display the information
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<?php echo htmlentities($row['client_name']); ?>
<?php
    }
}

?>


