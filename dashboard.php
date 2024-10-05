<?php 
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

// Set active page (dashboard, transactions, etc.)
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9f5ec; /* Light green background */
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #2e7d32; /* Dark green sidebar */
            padding-top: 20px;
            transition: all 0.3s ease;
            transform: translateX(-100%); /* Initially hidden */
        }

        .sidebar.active {
            transform: translateX(0); /* Show sidebar when active */
        }

        .sidebar h1 {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 40px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 10px 20px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #c8e6c9; /* Light green text */
            font-size: 18px;
            display: block;
            transition: all 0.3s ease;
        }

        .sidebar ul li.active a {
            color: #ffffff;
            background-color: #66bb6a; /* Highlight active link */
            border-radius: 4px;
        }

        .sidebar ul li a:hover {
            color: #ffffff;
            background-color: #388e3c; /* Darker green on hover */
            border-radius: 4px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }

        .main-content.active {
            margin-left: 0; /* Adjust margin when sidebar is hidden */
            width: 100%; /* Full width when sidebar is hidden */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #c8e6c9; /* Light green header */
            border-bottom: 2px solid #a5d6a7; /* Darker border */
        }

        .header h2 {
            font-size: 28px; /* Increased font size for prominence */
            color: #2e7d32;
            font-weight: bold; /* Bold font for header */
        }

        .header .admin {
            font-size: 16px;
            color: #2e7d32;
        }

        .search-bar {
            margin-top: 20px;
        }

        .search-bar input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #c8e6c9; /* Light green header for table */
        }

        td {
            background-color: #fff;
        }

        /* Burger Menu Styles */
        .menu {
            --s: 50px; /* control the size */
            --c: black; /* the color */
            height: var(--s);
            aspect-ratio: 1;
            border: none;
            padding: 0;
            border-inline: calc(var(--s)/2) solid #0000;
            box-sizing: content-box;
            --_g1: linear-gradient(var(--c) 20%, #0000 0 80%, var(--c) 0) no-repeat content-box border-box;
            --_g2: radial-gradient(circle closest-side at 50% 12.5%, var(--c) 95%, #0000) repeat-y content-box border-box;
            background: 
                var(--_g2) left  var(--_p, 0px) top,
                var(--_g1) left  calc(var(--s)/10 + var(--_p, 0px)) top,
                var(--_g2) right var(--_p, 0px) top,
                var(--_g1) right calc(var(--s)/10 + var(--_p, 0px)) top;
            background-size: 
                20% 80%,
                40% 100%;
            position: relative;
            clip-path: inset(0 25%);
            cursor: pointer;
            transition: 
                background-position .3s var(--_s, .3s), 
                clip-path 0s var(--_s, .6s);
            appearance: none;
        }

        .menu:before,
        .menu:after {
            content: "";
            position: absolute;
            border-radius: var(--s);
            inset: 40% 0;
            background: var(--c);
            transition: transform .3s;
        }

        .menu:checked {
            clip-path: inset(0);
            --_p: calc(-1*var(--s));
            --_s: 0s;
        }

        .menu:checked:before {
            transform: rotate(45deg);
        }

        .menu:checked:after {
            transform: rotate(-45deg);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .menu {
                display: block;
                position: absolute;
                top: 20px;
                left: 10px;
                z-index: 9999;
            }

            .sidebar {
                width: 250px;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h1>PCS</h1>
        <ul>
            <li class="<?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>"><a href="dashboard.php">Dashboard</a></li>
            <li class="<?php echo ($activePage == 'view-transactions') ? 'active' : ''; ?>"><a href="view-transactions.php">View Transactions</a></li>
            <li class="<?php echo ($activePage == 'add-custodian') ? 'active' : ''; ?>"><a href="add-custodian.php">Add Custodian</a></li>
            <li class="<?php echo ($activePage == 'update-fund') ? 'active' : ''; ?>"><a href="update-fund.php">Update Fund</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="header">
            <!-- Burger Menu Input Checkbox -->
            <input type="checkbox" role="button" aria-label="Display the menu" class="menu" id="menu-toggle">

            <h2>Petty Cash System</h2>
            <div class="admin">Admin</div>
        </div>

        <div class="search-bar">
            <input type="text" placeholder="Search...">
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <th>Custodian No.</th>
                    <th>Custodian ID</th>
                    <th>Cash Fund</th>
                </tr>
                <tr>
                    <td><strong>Custodian 1</strong></td>
                    <td>XXXXXXXXXX</td>
                    <td>₱5000.00</td>
                </tr>
                <tr>
                    <td><strong>Custodian 2</strong></td>
                    <td>XXXXXXXXXX</td>
                    <td>₱10000.00</td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        // Toggle sidebar visibility based on the checkbox state
        document.getElementById('menu-toggle').addEventListener('change', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            if (this.checked) {
                sidebar.classList.add('active');
                mainContent.classList.remove('active'); // Reset margin when menu is open
            } else {
                sidebar.classList.remove('active');
                mainContent.classList.add('active'); // Adjust margin when menu is closed
            }
        });
    </script>
</body>
</html>
