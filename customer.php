<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <link rel="stylesheet" href="bank.css">
    <link rel="stylesheet" href="customer.css">
</head>
<body>
    <?php
    $DBname = "CityBank";
    $con = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($con, $DBname);
    
    if (isset($_GET['Email'])) {
        $Email = $_GET['Email'];
        
        $query = "SELECT * FROM CUSTOMERS WHERE Email='$Email'";
        $result = $con->query($query) or die($con->error.__LINE__);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $Name = $row['Name'];
            $Email = $row['Email'];
            $Balance = $row['CurrentBalance'];

            echo '<div class="customer-container">';
                echo '<img src="./images/custImg.png" alt="Customer Image" class="customer-image">';
                echo '<div class="customer-info">';
                    echo '<span><h2>Name :</h2> ' . $Name . '</span>';
                    echo '<span><h2>Email :</h2> ' . $Email . '</span>';
                    echo '<span><h2>Balance :</h2> $ ' . $Balance . '</span>';
                echo '</div>';
                echo '<button><a href="transfer.php?Email=' . $Email . '">Transfer Money</a></button>';
            echo '</div>';
        }
        else {echo '<p>Customer not found.</p>';}
    }
    ?>

</body>
</html>
