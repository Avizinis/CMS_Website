<?php   include "db.php";
        include "../admin/includes/admin_functions.php"; 
        session_start(); ?>
<?php

// sanitize login input
if(isset($_POST['submit_login'])){
    $post = sanitize_post_input($_POST);
    $username = $post['username'];
    $password = $post['password'];

    // fetch user data from db
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $select_result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($select_result)){
        $u_id =         $row['user_id'];
        $u_name =       $row['username'];
        $u_psw =        $row['user_password'];
        $u_first =      $row['user_firstname'];
        $u_lastname =   $row['user_lastname'];
        $u_email =      $row['user_email'];
        $u_image =      $row['user_image'];
        $u_role =       $row['user_role'];
    }

    // Verify username and password with db
    if(mysqli_num_rows($select_result) == 0){
        echo 'Incorrect username or password';
    } elseif(strcmp($username, $u_name) !== 0){
        echo 'Incorrect username or password';
    } elseif(password_verify($password, $u_psw)){
        // At this point user is verified. Check if admin or user and add session data
        $_SESSION['username'] = $u_name;
        $_SESSION['firstname'] = $u_first;
        $_SESSION['lastname'] = $u_lastname;
        $_SESSION['user_role'] = $u_role;
        $_SESSION['user_id'] = $u_id;

        if($u_role == 'admin'){
            header("Location: ../admin");
        } else {
            header("Location: ../index.php");
        }
    } else{
        echo 'Incorrect username or password';
    }
}

?>