<?php
include 'db.php';

$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM mstItemGroup WHERE GroupName LIKE '%$search%' OR ShortCodeGroup LIKE '%$search%' OR GroupType LIKE '%$search%'";
} else {
    $query = "SELECT * FROM mstItemGroup";
}
$result = $conn->query($query);

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM mstItemGroup WHERE GroupId='$id'");
    header("Location: itemgroup.php");
    exit;
}

// Handle insertion
if (isset($_POST['add'])) {
    $groupName = $_POST['groupName'];
    $shortCodeGroup = $_POST['shortCodeGroup'];
    $groupType = $_POST['groupType'];

    $stmt = $conn->prepare("INSERT INTO mstItemGroup (GroupName, ShortCodeGroup, GroupType) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $groupName, $shortCodeGroup, $groupType);
    $stmt->execute();

    header("Location: itemgroup.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Group Management</title>
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
    <h2>Item Group Management</h2>

    <form method="POST" class="form-section">
        <input type="text" name="search" placeholder="Search by Group Name, Type or Code" value="<?= htmlspecialchars($search) ?>">
        <button class="btn" type="submit">Search</button>
    </form>

    <form method="POST" class="form-section">
        <input type="text" name="groupName" placeholder="Group Name" required>
        <input type="text" name="shortCodeGroup" placeholder="Short Code" required>
        <input type="text" name="groupType" placeholder="Group Type" required>
        <button class="btn" type="submit" name="add">Add Group</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Group ID</th>
                <th>Group Name</th>
                <th>Short Code</th>
                <th>Group Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['GroupId']) ?></td>
                <td><?= htmlspecialchars($row['GroupName']) ?></td>
                <td><?= htmlspecialchars($row['ShortCodeGroup']) ?></td>
                <td><?= htmlspecialchars($row['GroupType']) ?></td>
                <td>
                    <a class="action-btn" href="itemgroup.php?delete=<?= $row['GroupId'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
