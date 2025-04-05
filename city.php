<?php
include 'db.php';

// Add new city
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addCity'])) {
    $cityName = $_POST['cityName'];

    if (!empty($cityName)) {
        // Auto-generate cityid (next available number)
        $result = $conn->query("SELECT MAX(cityid) AS max_id FROM mstCity");
        $row = $result->fetch_assoc();
        $newId = $row['max_id'] + 1;
        if ($newId < 1000) $newId = str_pad($newId, 4, "0", STR_PAD_LEFT);

        $stmt = $conn->prepare("INSERT INTO mstCity (cityid, cityName) VALUES (?, ?)");
        $stmt->bind_param("is", $newId, $cityName);
        $stmt->execute();
    }
}

// Delete city
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM mstCity WHERE cityid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Search logic
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM mstCity WHERE cityName LIKE ?";
    $stmt = $conn->prepare($query);
    $likeSearch = "%$search%";
    $stmt->bind_param("s", $likeSearch);
} else {
    $stmt = $conn->prepare("SELECT * FROM mstCity");
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>City Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #444;
        }
        .form-container, .search-container {
            margin: 20px auto;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        input[type="text"] {
            padding: 10px;
            width: calc(100% - 22px);
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background-color: #3498db;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 6px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        /* ... existing styles ... */

th {
    background-color: #3498db; /* same as button color */
    color: white;
}
    </style>
</head>
<body>
    <h2>City Management</h2>

    <div class="form-container">
        <form method="POST">
            <h3>Add a City</h3>
            <input type="text" name="cityName" placeholder="Enter City Name" required>
            <button type="submit" name="addCity">Add City</button>
        </form>
    </div>

    <div class="search-container">
        <form method="GET">
            <input type="text" name="search" placeholder="Search City..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>City ID</th>
                <th>City Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['cityid'] ?></td>
                    <td><?= htmlspecialchars($row['cityName']) ?></td>
                    <td><a href="?delete=<?= $row['cityid'] ?>" onclick="return confirm('Delete this city?')">Delete</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
