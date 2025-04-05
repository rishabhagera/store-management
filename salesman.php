<?php
include 'db.php';

// Handle Add Salesman
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['addSalesman'])) {
    $name = $_POST['SalesManName'];
    $cityid = $_POST['Cityid'];
    $area = $_POST['SalesManArea'];
    $mobile = $_POST['SalesManMobileNo'];
    $address = $_POST['SalesManAddress'];
    $type = $_POST['SalesManType'];

    $query = "SELECT SalesManId FROM mstSalesMan ORDER BY SalesManId DESC LIMIT 1";
    $result = $conn->query($query);
    $lastId = 'S0001';

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $num = intval(substr($row['SalesManId'], 1)) + 1;
        $lastId = 'S' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    $stmt = $conn->prepare("INSERT INTO mstSalesMan (SalesManId, SalesManName, Cityid, SalesManArea, SalesManMobileNo, SalesManAddress, SalesManType) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $lastId, $name, $cityid, $area, $mobile, $address, $type);
    $stmt->execute();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM mstSalesMan WHERE SalesManId = '$id'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salesman Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        .form-box {
            background-color: #f8f8f8;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
            width: 60%;
            margin: auto;
        }

        input, select {
            padding: 8px;
            margin: 6px 0;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            margin-top: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .action-btn {
            background-color: #3498db;
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .action-btn:hover {
            background-color: #2980b9;
        }

        .search-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-box input {
            width: 40%;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Salesman Management</h2>

    <div class="form-box">
        <form method="POST">
            <label>Salesman Name:</label>
            <input type="text" name="SalesManName" required>

            <label>City ID:</label>
            <input type="number" name="Cityid" required>

            <label>Salesman Area:</label>
            <input type="text" name="SalesManArea" required>

            <label>Mobile Number:</label>
            <input type="number" name="SalesManMobileNo" required>

            <label>Address:</label>
            <input type="text" name="SalesManAddress" required>

            <label>Salesman Type:</label>
            <input type="text" name="SalesManType" required>

            <button type="submit" name="addSalesman">Add Salesman</button>
        </form>
    </div>

    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Search by Name or Area">
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Salesman ID</th>
                <th>Name</th>
                <th>City ID</th>
                <th>Area</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $where = "";
        if (isset($_GET['search'])) {
            $search = $conn->real_escape_string($_GET['search']);
            $where = "WHERE SalesManName LIKE '%$search%' OR SalesManArea LIKE '%$search%'";
        }

        $result = $conn->query("SELECT * FROM mstSalesMan $where ORDER BY SalesManId ASC");

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['SalesManId']}</td>
                    <td>{$row['SalesManName']}</td>
                    <td>{$row['Cityid']}</td>
                    <td>{$row['SalesManArea']}</td>
                    <td>{$row['SalesManMobileNo']}</td>
                    <td>{$row['SalesManAddress']}</td>
                    <td>{$row['SalesManType']}</td>
                    <td><a class='action-btn' href='?delete={$row['SalesManId']}' onclick=\"return confirm('Are you sure?')\">Delete</a></td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>
