<?php
include 'db.php';

// Handle adding a new record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addOther'])) {
    $name = $_POST['OtherName'];
    $cityId = $_POST['Cityid'];
    $area = $_POST['OtherArea'];
    $mobile = $_POST['OtherMobileNo'];
    $address = $_POST['OtherAddress'];
    $type = $_POST['OtherType'];

    // Generate OtherId automatically
    $result = $conn->query("SELECT MAX(CAST(SUBSTRING(OtherId, 2) AS UNSIGNED)) AS max_id FROM mstOther");
    $row = $result->fetch_assoc();
    $newId = 'O' . str_pad(($row['max_id'] + 1), 5, '0', STR_PAD_LEFT);

    $stmt = $conn->prepare("INSERT INTO mstOther (OtherId, OtherName, Cityid, OtherArea, OtherMobileNo, OtherAddress, OtherType) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $newId, $name, $cityId, $area, $mobile, $address, $type);
    
    if ($stmt->execute()) {
        echo "<script>alert('Record added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding record');</script>";
    }
}

// Handle deleting a record
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM mstOther WHERE OtherId = ?");
    $stmt->bind_param("s", $deleteId);
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully!');</script>";
    }
}

// Handle search
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM mstOther WHERE OtherName LIKE '%$search%'";
} else {
    $query = "SELECT * FROM mstOther";
}
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Other Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form-container { margin-bottom: 20px; }

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
    <h2>Other Management</h2>

    <!-- Search Form -->
    <form method="GET">
        <input type="text" name="search" placeholder="Search by Name" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Add Other Form (Same UI as Customer Form) -->
    <div class="form-container">
        <h3>Add Other</h3>
        <form method="POST">
            <input type="text" name="OtherName" placeholder="Enter Name" required>
            <input type="number" name="Cityid" placeholder="Enter City ID" required>
            <input type="text" name="OtherArea" placeholder="Enter Area">
            <input type="text" name="OtherMobileNo" placeholder="Enter Mobile No" required>
            <input type="text" name="OtherAddress" placeholder="Enter Address" required>
            <input type="text" name="OtherType" placeholder="Enter Type" required>
            <button type="submit" name="addOther">Add Other</button>
        </form>
    </div>

    <!-- Display Records -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>City ID</th>
                <th>Area</th>
                <th>Mobile No</th>
                <th>Address</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['OtherId']) ?></td>
                    <td><?= htmlspecialchars($row['OtherName']) ?></td>
                    <td><?= htmlspecialchars($row['Cityid']) ?></td>
                    <td><?= htmlspecialchars($row['OtherArea']) ?></td>
                    <td><?= htmlspecialchars($row['OtherMobileNo']) ?></td>
                    <td><?= htmlspecialchars($row['OtherAddress']) ?></td>
                    <td><?= htmlspecialchars($row['OtherType']) ?></td>
                    <td>
                        <a href="?delete=<?= $row['OtherId'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
