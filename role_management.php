<!-- <!DOCTYPE html>
<html>

    <head>
        <title>Role Management</title>
    </head>

    <body>
        <?php
        // session_start();
        

        // if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] === 'admin' ) {
        
        //     echo "<h1>Welcome to Role Management Page</h1>";
        
        //     }
        // else {
        
        //     echo "<h1>Access Denied</h1>";
        //     echo "You do not have permission to access this page.";
        //     }
        // ?>
    </body>

</html>
 -->

<?php
session_start();

if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] === 'admin' ) {
    echo "<h1>Welcome to Role Management Page</h1>";

    $roleDataFile = 'roles.txt';

    // Function to read roles from a file
    function readRolesFromFile ($file)
        {
        if ( file_exists( $file ) ) {
            $data = file_get_contents( $file );
            return json_decode( $data, true );
            }
        return [];
        }

    // Function to save roles to a file
    function saveRolesToFile ($file, $roles)
        {
        $data = json_encode( $roles );
        file_put_contents( $file, $data );
        }

    if ( isset( $_POST['create_role'] ) && ! empty( $_POST['user_name'] ) && ! empty( $_POST['email'] ) && ! empty( $_POST['password'] ) && ! empty( $_POST['new_role'] ) ) {
        $newRole = [ 
            'user_name' => $_POST['user_name'],
            'email'     => $_POST['email'],
            'password'  => $_POST['password'],
            'role'      => $_POST['new_role'],
        ];
        $roles   = readRolesFromFile( $roleDataFile );
        $roles[] = $newRole;
        saveRolesToFile( $roleDataFile, $roles );
        }

    // Example: Delete an existing role
    if ( isset( $_POST['delete_role'] ) && ! empty( $_POST['user_name_to_delete'] ) && ! empty( $_POST['role_to_delete'] ) ) {
        $userToDelete = $_POST['user_name_to_delete'];
        $roleToDelete = $_POST['role_to_delete'];
        $roles        = readRolesFromFile( $roleDataFile );
        foreach ( $roles as $key => $role ) {
            if ( $role['user_name'] === $userToDelete && $role['role'] === $roleToDelete ) {
                unset($roles[ $key ]);
                }
            }
        saveRolesToFile( $roleDataFile, $roles );
        }

    // Example: Edit an existing role
    if ( isset( $_POST['edit_role'] ) && ! empty( $_POST['new_role_name'] ) && ! empty( $_POST['old_role_name'] ) ) {
        $newRoleName = $_POST['new_role_name'];
        $oldRoleName = $_POST['old_role_name'];
        $roles       = readRolesFromFile( $roleDataFile );
        foreach ( $roles as &$role ) {
            if ( $role['role'] === $oldRoleName ) {
                $role['role'] = $newRoleName;
                }
            }
        saveRolesToFile( $roleDataFile, $roles );
        }

    // Display the form to create, edit, and delete roles
    echo "
        <h2>Role Management</h2>
        <form method='POST'>
            <h3>Create a New Role</h3>
            <input type='text' name='user_name' placeholder='New User Name'>
            <input type='email' name='email' placeholder='Enter Your Email'>
            <input type='password' name='password' placeholder='Enter Your Password'>
            <input type='text' name='new_role' placeholder='New Role Name'>
            <button type='submit' name='create_role'>Create Role</button>
            
            <h3>Edit an Existing Role</h3>
           
            <input type='text' name='old_role_name' placeholder='Existing Role Name'>
            <input type='text' name='new_role_name' placeholder='New Role Name'>
            <button type='submit' name='edit_role'>Edit Role</button>
            
            <h3>Delete an Existing Role</h3>
            <input type='text' name='user_name_to_delete' placeholder='Existing User Name'>
            <input type='text' name='role_to_delete' placeholder='Role Name to Delete'>
            <button type='submit' name='delete_role'>Delete Role</button>
        </form>
    ";
    }
else {
    echo "<h1>Access Denied</h1>";
    echo "You do not have permission to access this page.";
    }
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Role Management</title>

        <style>
            /* styles.css */

            /* Styling for the form */
            form {
                margin: 20px 200px 118px 500px;
                padding: 80px;
                background-color: #f4f4f4;
                border: 1px solid #ddd;
                border-radius: 5px;
                width: 300px;
            }

            /* Styling for form headings */
            h3 {
                font-size: 18px;
                margin-top: 10px;
            }

            /* Styling for form input fields and buttons */
            input[type="text"],
            input[type="email"],
            input[type="password"] {
                display: block;
                margin: 10px 0;
                padding: 5px;
                width: 100%;
                border: 1px solid #ccc;
                border-radius: 3px;
            }

            button {
                background-color: #007BFF;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 3px;
                cursor: pointer;
            }

            /* Styling for the page title */
            h2 {
                text-align: center;
            }

            /* Styling for the "Access Denied" message */
            h1 {
                text-align: center;
                color: red;
            }
        </style>
    </head>

    <body>
    </body>

</html>