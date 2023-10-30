<!DOCTYPE html>
<html>

<head>
    <title>User Page</title>

    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
}

.user-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.user-table td, .user-table th {
    border: 1px solid #ddd;
    padding: 12px;
}

.user-table th {
    background-color: #f2f2f2;
    text-align: left;
}

.logout-button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 12px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 20px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.logout-button:hover {
    background-color: #45a049;
}


    </style>
</head>

<body>
    <?php
    session_start();

    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user') {
        echo "<h1>Welcome to User Page</h1>";

        // Read user data from roles.txt file
        $roleDataFile = 'roles.txt';
        $roles = readRolesFromFile($roleDataFile);

        // Display user information
       echo "<h2>User Information</h2>";
echo "<table border='1'>";
foreach ($roles as $role) {
    if ($role['role'] === 'user') {
        echo "<tr>";
        echo "<td><strong>Username:</strong></td><td>" . htmlspecialchars($role['user_name']) . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Email:</strong></td><td>" . htmlspecialchars($role['email']) . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Password:</strong></td><td>" . htmlspecialchars($role['password']) . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Role:</strong></td><td>" . htmlspecialchars($role['role']) . "</td>";
        echo "</tr>";
    }
}
echo "</table>";

echo "<form method='POST'>";
echo "<button type='submit' class='logout-button' name='logout'>Logout</button>";
echo "</form>";
    }

 else {
       
        echo "<h1>Access Denied</h1>";
      echo "<p>You do not have permission to access this page.</p>";
        
     }


    // Function to read roles from a file
    function readRolesFromFile($file)
    {
        if (file_exists($file)) {
            $data = file_get_contents($file);
            return json_decode($data, true);
        }
        return [];
    }

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
    ?>
</body>

</html>
