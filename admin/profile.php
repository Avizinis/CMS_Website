<?php include "includes/admin_header.php" ?>

<div id="wrapper">

<!-- Navigation -->
<?php include "includes/admin_navigation.php" ?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to admin
                    <small><?=username_by_session_id($_SESSION['user_id'])?></small>
                </h1>

                <?php 

                $p_id = $_SESSION['user_id'];
                $query = "SELECT * FROM users WHERE user_id = ?";
                $select_user = fetch_stmt_result_by_id($p_id, $query);
                while($row = mysqli_fetch_assoc($select_user)){
                    $u_id =         $row['user_id'];
                    $u_name =       $row['username'];
                    $u_psw =        $row['user_password'];
                    $u_first =      $row['user_firstname'];
                    $u_lastname =   $row['user_lastname'];
                    $u_email =      $row['user_email'];
                    $u_image =      $row['user_image'];
                    $u_role =       $row['user_role'];
                }

                if(isset($_POST['update_user'])){
                    $post = sanitize_post_input($_POST);
                
                    $username =   $post['username'];
                    $password =  $post['password'];
                    $firstname =  $post['first_name'];
                    $lastname =  $post['last_name'];
                    $email =  $post['email'];
                
                    $image =   $_FILES['image']['name'];
                    $image_temp = $_FILES['image']['tmp_name'];
                
                    $role =    $post['role'];
                    
                    move_uploaded_file($image_temp, "../images/$image");
                
                    // reupload the same picture if not specified new.
                    if(empty($image)){
                        $query = "SELECT user_image FROM users WHERE user_id = ?";
                        $p_image = fetch_stmt_result_by_id($u_id, $query);
                        while($row = mysqli_fetch_assoc($p_image)){
                            $image = $row['user_image'];
                        }
                    }
                
                    // reupload old password if left empty
                    if(empty($password)){
                        $query = "SELECT user_password FROM users WHERE user_id = ?";
                        $old_pass = fetch_stmt_result_by_id($u_id, $query);
                        while($row = mysqli_fetch_assoc($old_pass)){
                            $hashed_pwd = $row['user_password'];
                        }
                    } else{
                        $hashed_pwd = hash_pwd($password);
                    }
                
                
                    // Update a user SQL query
                    $query = "UPDATE users ";
                    $query .= "SET username = ?, user_password = ?, user_firstname = ?, user_lastname = ?, user_email = ?, user_image = ?, user_role = ? ";
                    $query .= "WHERE user_id = ?";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, 'sssssssi', $username, $hashed_pwd, $firstname, $lastname, $email, $image, $role, $u_id);
                    if(is_user_eligible_update($p_id, $username, $email)){
                        mysqli_stmt_execute($stmt);
                        header("Location: profile.php"); // page refresh
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>
                                Username or email already taken!
                                </div>";
                    }
                }

                ?>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">New Username</label>
                        <input type="text" class="form-control" name="username" value="<?=$u_name?>">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" name="password" value="">
                    </div>
                    <?php if($u_role === 'admin'): ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-3">
                            <label for="role">New Role</label><br>
                            <select class="form-control" name="role" id="role">
                                <option value="<?=$u_role?>" selected><?php echo $u_role; ?></option>
                                <option value="subscriber">subscriber</option>
                                <option value="user">user</option>
                                <option value="senior">senior</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <?php endif ?>
                    <div class="form-group">
                        <label for="image">New Image</label><br>
                        <img src="../images/<?=$u_image?>" width="300"><br><br>
                        <input type="file" class="form-control-file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="first name">New First Name</label>
                        <input type="text" class="form-control" name="first_name" value="<?=$u_first?>">
                    </div>
                    <div class="form-group">
                        <label for="last name">New Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="<?=$u_lastname?>">
                    </div>
                    <div class="form-group">
                        <label for="email">New E-mail</label>
                        <input type="email" class="form-control" name="email" value="<?=$u_email?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
                    </div>
                </form>
                
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>