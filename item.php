<?php
include 'db.php';

// Fetch dropdown values
$hsns = $conn->query("SELECT Hsncode FROM mstHsn");
$groups = $conn->query("SELECT GroupName FROM mstItemGroup");
$products = $conn->query("SELECT ProductName FROM mstProduct");
$labours = $conn->query("SELECT Labourcode FROM mstLabourCode");

// Handle search
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM mstItem WHERE ItemName LIKE '%$search%' OR ItemId LIKE '%$search%'";
} else {
    $query = "SELECT * FROM mstItem";
}
$result = $conn->query($query);

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM mstItem WHERE ItemId='$id'");
    header("Location: item.php");
    exit;
}

// Handle add
if (isset($_POST['add'])) {
    $itemName = $_POST['itemName'];
    $hsncode = $_POST['hsncode'];
    $groupName = $_POST['groupName'];
    $productName = $_POST['productName'];
    $labourcode = $_POST['labourcode'];

    // Generate ItemId
    $resultId = $conn->query("SELECT ItemId FROM mstItem ORDER BY ItemId DESC LIMIT 1");
    $lastId = $resultId->fetch_assoc()['ItemId'] ?? 'I00';
    $num = intval(substr($lastId, 1)) + 1;
    $newId = 'I' . str_pad($num, 2, '0', STR_PAD_LEFT);

    $stmt = $conn->prepare("INSERT INTO mstItem (ItemId, ItemName, Hsncode, GroupName, ProductName, Labourcode) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $newId, $itemName, $hsncode, $groupName, $productName, $labourcode);
    $stmt->execute();

    header("Location: item.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { color: #3498db; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #3498db; color: white; }
        input, select { padding: 6px; margin: 5px; width: 200px; }
        .btn { padding: 8px 15px; background-color: #3498db; color: white; border: none; cursor: pointer; margin: 5px; }
        .btn:hover { background-color: #2980b9; }
        .action-btn { color: white; background-color: #e74c3c; border: none; padding: 5px 10px; cursor: pointer; }
        .action-btn:hover { background-color: #c0392b; }
    </style>
</head>
<body>
    <h2>Item Management</h2>

    <form method="POST">
        <input type="text" name="search" placeholder="Search Item" value="<?= $search ?>">
        <button class="btn" type="submit">Search</button>
    </form>

    <form method="POST">
        <input type="text" name="itemName" placeholder="Item Name" required>
        <select name="hsncode" required>
            <option value="">Select HSN</option>
            <?php while($row = $hsns->fetch_assoc()): ?>
                <option value="<?= $row['Hsncode'] ?>"><?= $row['Hsncode'] ?></option>
            <?php endwhile; ?>
        </select>
        <select name="groupName" required>
            <option value="">Select Group</option>
            <?php while($row = $groups->fetch_assoc()): ?>
                <option value="<?= $row['GroupName'] ?>"><?= $row['GroupName'] ?></option>
            <?php endwhile; ?>
        </select>
        <select name="productName" required>
            <option value="">Select Product</option>
            <?php while($row = $products->fetch_assoc()): ?>
                <option value="<?= $row['ProductName'] ?>"><?= $row['ProductName'] ?></option>
            <?php endwhile; ?>
        </select>
        <select name="labourcode" required>
            <option value="">Select Labour</option>
            <?php while($row = $labours->fetch_assoc()): ?>
                <option value="<?= $row['Labourcode'] ?>"><?= $row['Labourcode'] ?></option>
            <?php endwhile; ?>
        </select>
        <button class="btn" type="submit" name="add">Add Item</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>HSN Code</th>
                <th>Group Name</th>
                <th>Product Name</th>
                <th>Labour Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['ItemId'] ?></td>
                    <td><?= $row['ItemName'] ?></td>
                    <td><?= $row['Hsncode'] ?></td>
                    <td><?= $row['GroupName'] ?></td>
                    <td><?= $row['ProductName'] ?></td>
                    <td><?= $row['Labourcode'] ?></td>
                    <td><a class="action-btn" href="item.php?delete=<?= $row['ItemId'] ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
