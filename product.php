<?php
include 'db.php';

// Handle search
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM mstProduct WHERE ProductName LIKE '%$search%' OR ShortCodeP LIKE '%$search%'";
} else {
    $query = "SELECT * FROM mstProduct";
}
$result = $conn->query($query);

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM mstProduct WHERE ProductId = $id");
    header("Location: product.php");
    exit;
}

// Handle insertion
if (isset($_POST['add'])) {
    $productName = $_POST['productName'];
    $shortCodeP = $_POST['shortCodeP'];

    $stmt = $conn->prepare("INSERT INTO mstProduct (ProductName, ShortCodeP) VALUES (?, ?)");
    $stmt->bind_param("ss", $productName, $shortCodeP);
    $stmt->execute();

    header("Location: product.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
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
        input[type="text"] {
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
    <h2>Product Management</h2>

    <form method="POST" class="form-section">
        <input type="text" name="search" placeholder="Search by Name or Code" value="<?= $search ?>">
        <button class="btn" type="submit">Search</button>
    </form>

    <form method="POST" class="form-section">
        <input type="text" name="productName" placeholder="Product Name" required>
        <input type="text" name="shortCodeP" placeholder="Short Code" required>
        <button class="btn" type="submit" name="add">Add Product</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Short Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['ProductId']) ?></td>
                <td><?= htmlspecialchars($row['ProductName']) ?></td>
                <td><?= htmlspecialchars($row['ShortCodeP']) ?></td>
                <td>
                    <a class="action-btn" href="product.php?delete=<?= $row['ProductId'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
