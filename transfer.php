<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer</title>
    <link rel="stylesheet" href="bank.css">
    <link rel="stylesheet" href="customer.css">
    
</head>
<body>
<?php

    $DBname = "CityBank";
    $con = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($con, $DBname);

    if (isset($_GET['Email'])) {
        $SenderEmail = $_GET['Email'];

        $query = "SELECT * FROM CUSTOMERS WHERE Email='$SenderEmail'";
        $result = $con->query($query) or die($con->error . __LINE__);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $SenderName = $row['Name'];

            echo '<div class="customer-container">';
            $query = "SELECT Name, Email FROM CUSTOMERS WHERE Email != '$SenderEmail'";
            $result = $con->query($query) or die($con->error . __LINE__);

            if ($result->num_rows > 0) {
                echo '<form method="post" action="transfer.php">';
                echo '<div class="transfer">';
                echo '<div class="transfer-label">';
                echo '<label for="transfer-to">Transfer To : </label>';
                echo '<select id="transfer-to" name="ReceiverEmail">';
                while ($row = $result->fetch_assoc()) {
                    echo '<option id="drop-opt" value="' . $row['Email'] . '">' . $row['Name'] . " ("
                        . $row['Email'] . ')</option>';
                }
                echo '</select>';
                echo '</div>';
                echo '</div>';

                echo '<div class="transfer">';
                echo '<div class="transfer-label">';
                echo '<label for="transfer-amount">Enter Amount : </label>';
                echo '<input type="number" id="transfer-amount" name="Amount" min="1" required>';
                echo '</div>';
                echo '</div>';

                echo '<input type="hidden" name="SenderEmail" value="' . $SenderEmail . '">';
                echo '<input type="hidden" name="SenderName" value="' . $SenderName . '">';
                echo '<button type="submit">Transfer</button>';
                echo '</form>';
            } else {
                echo '<p>No eligible customers to transfer to.</p>';
            }

            echo '</div>';
        } else {
            echo '<p>Customer not found.</p>';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $SenderEmail = $_POST['SenderEmail'];
        $ReceiverEmail = $_POST['ReceiverEmail'];
        $Amount = $_POST['Amount'];
    
        $query = "SELECT CurrentBalance FROM CUSTOMERS WHERE Email='$SenderEmail'";
        $result = $con->query($query) or die($con->error . __LINE__);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $SenderBalance = $row['CurrentBalance'];
    
            if ($SenderBalance >= $Amount) {
                $query = "UPDATE CUSTOMERS SET CurrentBalance = CurrentBalance - $Amount WHERE Email='$SenderEmail'";
                $result = $con->query($query) or die($con->error . __LINE__);
    
                $query = "UPDATE CUSTOMERS SET CurrentBalance = CurrentBalance + $Amount WHERE Email='$ReceiverEmail'";
                $result = $con->query($query) or die($con->error . __LINE__);
    
                $query = "INSERT INTO TRANSFERS (SenderEmail, ReceiverEmail, Amount) VALUES ('$SenderEmail', '$ReceiverEmail', $Amount)";
                $result = $con->query($query) or die($con->error . __LINE__);
    
                echo '<div class="custom-alert">';
                echo '<div class="custom-alert-text">';
                echo '<span>Transfer successful!</span>';
                echo '<button onclick="window.location.href=\'customers.php\'" id="ok">OK</button>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="custom-alert">';
                echo '<div class="custom-alert-text">';
                echo '<span>Not Enough Money to Transfer!</span>';
                echo '<button onclick="window.location.href=\'transfer.php?Email=' . $SenderEmail . '\'">OK</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Customer not found.</p>';
        }
    }
    
?>
</body>
</html>
