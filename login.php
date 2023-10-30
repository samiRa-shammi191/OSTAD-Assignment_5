<?php

function dd ($value)
    {
    echo "<pre>";
    print_r( $value );
    echo "</pre>";
    exit;
    }

function getDataFormFile ()
    {
    $users = array();
    $files = explode( ",", file_get_contents( "users.txt" ) );
    // dd( $files ); 
    foreach ( $files as $file ) {
        $lines = explode( "|", $file );
        array_push( $users, $lines );
        }
    return $users;
    }

session_start();


// if ( isset( $_SESSION['user_role'] ) ) {
//     header( "Location: role_management.php" );
//     exit;
//     }

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $email    = trim( $_POST['email'] );
    $password = trim( $_POST['password'] );
    $password = sha1( $password );
    // echo 'Password: ' . $password;
    // dd( $password );

    if ( isset( $_POST['login'] ) ) {
        $users = getDataFormFile();
        foreach ( $users as $user ) {
            list( $userName, $userEmail, $userPassword, $userRole ) = $user;
            // dd( $userPassword );
            if ( $email == $userEmail && $password == $userPassword ) {
                $_SESSION['user_role'] = $userRole;
                if ( $userRole === 'admin' ) {
                    header( "Location: role_management.php" );
                    }
                else {
                    header( "Location: user_page.php" );
                    }
                exit;
                }
            }
        echo "Invalid Username or Password";
        exit;
        }
    else {

        $_SESSION['error'] = 'Email and password are required';
        header( 'Location: login.php' );
        exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .container {
                background-color: #ffffff;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                text-align: center;
                margin-bottom: 30px;
            }

            form {
                max-width: 300px;
                margin: 0 auto;
            }

            label,
            input {
                display: block;
                margin-bottom: 20px;
            }

            input[type="email"],
            input[type="password"] {
                width: calc(100% - 20px);
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            button {
                width: 100%;
                background-color: #4caf50;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            button:hover {
                background-color: #45a049;
            }

            .error-message {
                color: red;
                text-align: center;
                margin-top: 20px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1>User Login From</h1>
            <?php if ( isset( $_SESSION['error'] ) ) : ?>
                <div class="error-message"><?php echo $_SESSION['error']; ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </body>

</html>