<?php
include 'db.php';

// Handle search
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM mstLabourCode WHERE Labourcode LIKE '%$search%' OR LabourType LIKE '%$search%' OR ShortCodeL LIKE '%$search%'";
} else {
    $query = "SELECT * FROM mstLabourCode";
}
$result = $conn->query($query);

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM mstLabourCode WHERE LabourId=$id");
    header("Location: labourcode.php");
    exit;
}

// Handle insertion
if (isset($_POST['add'])) {
    $labourCode = $_POST['labourCode'];
    $labourType = $_POST['labourType'];
    $shortCodeL = $_POST['shortCodeL'];

    $stmt = $conn->prepare("INSERT INTO mstLabourCode (Labourcode, LabourType, ShortCodeL) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $labourCode, $labourType, $shortCodeL);
    $stmt->execute();

    header("Location: labourcode.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Labour Code Management</title>
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
    <h2>Labour Code Management</h2>

    <form method="POST" class="form-section">
        <input type="text" name="search" placeholder="Search by Labour Code, Type, or Short Code" value="<?= htmlspecialchars($search) ?>">
        <button class="btn" type="submit">Search</button>
    </form>

    <form method="POST" class="form-section">
        <input type="text" name="labourCode" placeholder="Labour Code" required>
        <input type="text" name="labourType" placeholder="Labour Type" required>
        <input type="text" name="shortCodeL" placeholder="Short Code" required>
        <button class="btn" type="submit" name="add">Add Labour Code</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Labour ID</th>
                <th>Labour Code</th>
                <th>Labour Type</th>
                <th>Short Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['LabourId']) ?></td>
                    <td><?= htmlspecialchars($row['Labourcode']) ?></td>
                    <td><?= htmlspecialchars($row['LabourType']) ?></td>
                    <td><?= htmlspecialchars($row['ShortCodeL']) ?></td>
                    <td>
                        <a class="action-btn" href="labourcode.php?delete=<?= $row['LabourId'] ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
