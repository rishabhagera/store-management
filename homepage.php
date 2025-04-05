<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Homepage with Navbar</title>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f5f5f7;
    }

    header {
      background-color: #6c63ff;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 24px;
    }

    nav.navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      padding: 10px 0;
    }

    nav ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
    }

    nav ul li {
      position: relative;
      margin: 0 15px;
    }

    nav ul li a {
      text-decoration: none;
      color: #333;
      padding: 10px 15px;
      display: block;
      cursor: pointer;
      transition: background 0.3s;
    }

    nav ul li a:hover {
      background-color: #f0f0f0;
    }

    .submenu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: white;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      min-width: 200px;
      z-index: 999;
    }

    .submenu li a {
      padding: 10px 15px;
      border-bottom: 1px solid #eee;
      white-space: nowrap;
    }

    .submenu li a:hover {
      background-color: #f9f9f9;
    }

    .submenu.active {
      display: block;
    }

    .content {
      padding: 40px;
      text-align: center;
    }
  </style>
</head>
<body>

  <header>Welcome to Store Management System</header>

  <nav class="navbar">
    <ul>
      <li>
        <a onclick="toggleSubmenu('master')">Master</a>
        <ul class="submenu" id="master">
          <li><a href="customer.php">Customer</a></li>
          <li><a href="other.php">Other</a></li>
          <li><a href="city.php">City</a></li>
          <li><a href="labourcode.php">Labour Code</a></li>
          <li><a href="salesman.php">Salesman</a></li>
          <li><a href="hsn.php">HSN</a></li>
          <li><a href="product.php">Product</a></li>
          <li><a href="itemgroup.php">Item Group</a></li>
          <li><a href="item.php">Item</a></li>
        </ul>
      </li>
      <li>
        <a onclick="toggleSubmenu('transaction')">Transaction</a>
        <ul class="submenu" id="transaction">
          <li><a href="#">Cash</a></li>
          <li><a href="#">Bank</a></li>
          <li><a href="#">Sales</a></li>
          <li><a href="#">Purchase</a></li>
          <li><a href="#">Lot Generate</a></li>
          <li><a href="#">Tag Generate</a></li>
          <li><a href="#">Sales Return</a></li>
          <li><a href="#">Purchase Return</a></li>
          <li><a href="#">Order</a></li>
          <li><a href="#">Karigar Issue</a></li>
          <li><a href="#">Karigar Receipt</a></li>
          <li><a href="#">Labour Bill</a></li>
          <li><a href="#">Advance</a></li>
          <li><a href="#">Tag Cancel</a></li>
          <li><a href="#">Outstanding Adjustment</a></li>
        </ul>
      </li>
      <li>
        <a onclick="toggleSubmenu('reports')">Reports</a>
        <ul class="submenu" id="reports">
          <li><a href="#">Customer Report</a></li>
          <li><a href="#">Stock Report</a></li>
          <li><a href="#">Sales Report</a></li>
          <li><a href="#">Purchase Report</a></li>
          <li><a href="#">Outstanding Report</a></li>
        </ul>
      </li>
      <li>
        <a onclick="toggleSubmenu('utility')">Utility</a>
        <ul class="submenu" id="utility">
          <li><a href="#">Rights to User</a></li>
        </ul>
      </li>


      <li style="margin-left:auto;">
      <a href="logout.php" style="color: white; background-color: #6c63ff; border-radius: 4px;">Logout</a>
    </li>

    </ul>
  </nav>

  <div class="content">
    <h2>Dashboard</h2>
    <p>Select a menu option to get started.</p>
  </div>

  <script>
    function toggleSubmenu(id) {
      // Close all other submenus
      const submenus = document.querySelectorAll('.submenu');
      submenus.forEach(menu => {
        if (menu.id !== id) {
          menu.classList.remove('active');
        }
      });

      // Toggle selected submenu
      const currentMenu = document.getElementById(id);
      currentMenu.classList.toggle('active');
    }

    // Close menu if clicked outside
    document.addEventListener('click', function (e) {
      if (!e.target.closest('nav')) {
        document.querySelectorAll('.submenu').forEach(menu => {
          menu.classList.remove('active');
        });
      }
    });
  </script>

</body>
</html>
