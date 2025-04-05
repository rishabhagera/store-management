<?php
include 'db.php'; // Database connection

// Handle customer addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
    $customerId = 'C' . rand(1000, 9999); // Generate random ID starting with 'C'
    $customerName = $_POST['customerName'];
    $cityId = $_POST['cityId'];
    $customerArea = $_POST['customerArea'];
    $customerMobileNo = $_POST['customerMobileNo'];
    $customerAddress = $_POST['customerAddress'];
    $customerType = $_POST['customerType'];

    $stmt = $conn->prepare("INSERT INTO mstCustomer (CustomerId, CustomerName, Cityid, CustomerArea, CustomerMobileNo, CustomerAddress, CustomerType) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiissi", $customerId, $customerName, $cityId, $customerArea, $customerMobileNo, $customerAddress, $customerType);

    if ($stmt->execute()) {
        echo "<script>alert('Customer added successfully!');</script>";
    } else {
        echo "<script>alert('Failed to add customer!');</script>";
    }
}

// Handle customer deletion
if (isset($_GET['delete'])) {
    $customerId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM mstCustomer WHERE CustomerId = ?");
    $stmt->bind_param("s", $customerId);
    $stmt->execute();
    header("Location: customer.php");
    exit();
}

// Fetch customers for display
$search = isset($_GET['search']) ? $_GET['search'] : "";
$sql = "SELECT * FROM mstCustomer WHERE CustomerName LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        input, button { margin: 5px; padding: 5px; }

        /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f9f9f9;
}

h2 {
    text-align: center;
    color: #333;
}

button {
    padding: 10px 15px;
    border: none;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
}

button:hover {
    background-color: #0056b3;
}

input[type="text"], input[type="number"] {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Search Box */
.search-container {
    text-align: center;
    margin-bottom: 20px;
}

.search-container input {
    width: 50%;
    padding: 10px;
}

.search-container button {
    margin-left: 10px;
}

/* Form Styling */
.form-container {
    max-width: 400px;
    background: white;
    padding: 15px;
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.form-container h3 {
    text-align: center;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: white;
}

td {
    background-color: #fff;
}

td a {
    color: red;
    text-decoration: none;
    font-weight: bold;
}

td a:hover {
    text-decoration: underline;
}


    </style>
</head>
<body>

<h2>Customer Management</h2>

<!-- Search Bar -->
<form method="GET">
    <input type="text" name="search" placeholder="Search Customer Name" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
</form>

<!-- Add Customer Form -->
<form method="POST">
    <input type="text" name="customerName" placeholder="Customer Name" required>
    <input type="number" name="cityId" placeholder="City ID" required>
    <input type="text" name="customerArea" placeholder="Area" required>
    <input type="number" name="customerMobileNo" placeholder="Mobile Number" required>
    <input type="text" name="customerAddress" placeholder="Address" required>
    <input type="text" name="customerType" placeholder="Customer Type" required>
    <button type="submit" name="add_customer">Add Customer</button>
</form>

<!-- Customer Table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>City ID</th>
            <th>Area</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>Customer Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['CustomerId']) ?></td>
                <td><?= htmlspecialchars($row['CustomerName']) ?></td>
                <td><?= htmlspecialchars($row['Cityid']) ?></td>
                <td><?= htmlspecialchars($row['CustomerArea']) ?></td>
                <td><?= htmlspecialchars($row['CustomerMobileNo']) ?></td>
                <td><?= htmlspecialchars($row['CustomerAddress']) ?></td>
                <td><?= htmlspecialchars($row['CustomerType']) ?></td>
                <td><a href="customer.php?delete=<?= $row['CustomerId'] ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
