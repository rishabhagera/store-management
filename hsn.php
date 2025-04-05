<?php
include 'db.php';

// Handle search
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM mstHsn WHERE Hsncode LIKE '%$search%' OR RateOfGst LIKE '%$search%'";
} else {
    $query = "SELECT * FROM mstHsn";
}
$result = $conn->query($query);

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM mstHsn WHERE HsnId=$id");
    header("Location: hsn.php");
    exit;
}

// Handle insertion
if (isset($_POST['add'])) {
    $hsnCode = $_POST['hsnCode'];
    $gstRate = $_POST['gstRate'];

    $stmt = $conn->prepare("INSERT INTO mstHsn (Hsncode, RateOfGst) VALUES (?, ?)");
    $stmt->bind_param("sd", $hsnCode, $gstRate);
    $stmt->execute();

    header("Location: hsn.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HSN Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h2 {
            color: #3498db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        input[type="text"], input[type="number"] {
            padding: 6px;
            width: 200px;
            margin: 5px;
        }

        .btn {
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            margin: 5px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .action-btn {
            color: white;
            background-color: #e74c3c;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .action-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h2>HSN Code Management</h2>

    <form method="POST" class="form-section">
        <input type="text" name="search" placeholder="Search by HSN or GST Rate" value="<?= htmlspecialchars($search) ?>">
        <button class="btn" type="submit">Search</button>
    </form>

    <form method="POST" class="form-section">
        <input type="text" name="hsnCode" placeholder="HSN Code" maxlength="8" required>
        <input type="number" name="gstRate" placeholder="GST Rate (%)" step="0.01" min="0" required>
        <button class="btn" type="submit" name="add">Add HSN</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>HSN ID</th>
                <th>HSN Code</th>
                <th>GST Rate (%)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['HsnId']) ?></td>
                    <td><?= htmlspecialchars($row['Hsncode']) ?></td>
                    <td><?= htmlspecialchars(number_format($row['RateOfGst'], 2)) ?></td>
                    <td>
                        <a class="action-btn" href="hsn.php?delete=<?= $row['HsnId'] ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
