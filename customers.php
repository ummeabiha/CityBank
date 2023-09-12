<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link rel="stylesheet" href="bank.css">
    <link rel="stylesheet" href="customers.css">
    

</head>
<body>
    <table id="all-cust">
        <tr><th colspan="4"><h1>CITY BANK CUSTOMERS</h1></th></tr>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php
        $DBname = "CityBank";
        $con = mysqli_connect("localhost", "root", "");
        $db = mysqli_select_db($con, $DBname);
        $query = "SELECT * FROM Customers";
        $result = $con->query($query) or die($con->error . _LINE_);

        while ($row = mysqli_fetch_assoc($result)) {
            echo
                "<tr>
                    <td>" . $row['Name'] . "</td>
                    <td>" . $row['Email'] . "</td>
                    <td><a href='customer.php?Email=$row[Email]'>View</a></td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>
