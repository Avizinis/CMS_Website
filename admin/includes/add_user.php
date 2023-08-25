<?php

$username_unique = True;
$email_unique = True;

if(isset($_POST['create_user'])){
    $user = sanitize_post_input($_POST);
    $u_username =   $user['username'];
    $u_password =   $user['password'];
    $u_firstname =  $user['user_firstname'];
    $u_lastname =   $user['user_lastname'];

    $u_image =      $_FILES['image']['name'];
    $u_image_temp = $_FILES['image']['tmp_name'];

    $u_email =      $user['user_email'];
    $u_role =       'subscriber';


    move_uploaded_file($u_image_temp, "../images/$u_image");

    $hashed_pwd = hash_pwd($u_password);
    $username_unique = is_unique_username($u_username);
    $email_unique = is_unique_email($u_email);

    

    // Create a post SQL query
    $query = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'sssssss', $u_username, $hashed_pwd, $u_firstname, $u_lastname, $u_email, $u_image, $u_role);
    if(is_username_email_unique($u_username, $u_email)){
        if(mb_strtolower($u_email) == mb_strtolower("minelga.aras@gmail.com")){
            echo "<div class='alert alert-warning' role='alert'>
                    Arai šitas e-mail jau užimtas!
                </div>";
        } elseif (mb_strtolower($u_username) == "aras" || mb_strtolower($u_firstname) == "aras") {
            echo "<div class='alert alert-warning' role='alert'>
                    Arai jau esi duombazėj!
                </div>";
        } else {
        mysqli_stmt_execute($stmt);
        echo "User created: " . " " . "<a href='users.php'>View Users</a>";
        // header("Location: users.php"); // page refresh
        }
    }

}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
        <?php if(!$username_unique): ?>
        <div class="alert alert-danger" role="alert">
            Username has already been taken
        </div>
        <?php endif ?>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="form-group">
        <label for="user_first_name">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_last_name">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_email">E-mail</label>
        <input type="email" class="form-control" name="user_email">
        <?php if(!$email_unique): ?>
        <div class="alert alert-danger" role="alert">
            Email has already been taken
        </div>
        <?php endif ?>
    </div>
    <div class="form-group">
        <label for="user_image">User Image</label>
        <input type="file" class="form-control-file" name="image">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
    </div>
</form>