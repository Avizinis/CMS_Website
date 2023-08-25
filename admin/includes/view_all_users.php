<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:6%">User Image</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role</th>
            <th>Email</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>

    <?php 
    
    $user_limit = "";
    $query = "SELECT * FROM users " . $user_limit;
    $query .= "ORDER BY user_id DESC ";
    $select_users = mysqli_query($connection, $query);
    // $rnd3 = rnd_string(3);
    while($row = mysqli_fetch_assoc($select_users)){
        $u_id =         $row['user_id'];
        $u_name =       $row['username'];
        $u_psw =        $row['user_password'];
        $u_first =      $row['user_firstname'];
        $u_lastname =   $row['user_lastname'];
        $u_email =      $row['user_email'];
        $u_image =      $row['user_image'];
        $u_role =       $row['user_role'];

        echo "<tr>";
    
    ?>
            <td><img class="img-rounded img-responsive" src="../images/<?=$u_image?>" alt="image"></td>
            <td><?=$u_name?></td>
            <td><?=$u_first?></td>
            <td><?=$u_lastname?></td>
            <td><?=$u_role?></td>
            <td><?=$u_email?></td>
            <td class="text-center" style="width:4%"><a button class='btn btn-primary' href="users.php?source=edit_user&u_id=<?=$u_id?>"><i class='fa fa-pencil fa-2x'></i></button></a></td>
            <td class="text-center" style="width:4%"><a button class='btn btn-danger'  href="users.php?delete=               <?=$u_id?>"><i class='fa fa-trash fa-2x'></i></button></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php
// approve a post via GET
if(isset($_GET['approve'])){
    $c_approve_id = sanitize_id($_GET['approve']);
    $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $c_approve_id);
    if(!$stmt){
        die ("<h1>stmt gone wrong</h1>");
    }
    mysqli_stmt_execute($stmt);
    header("Location: comments.php"); // page refresh
}

// unapprove a post via GET
if(isset($_GET['unapprove'])){
    $c_unapprove_id = sanitize_id($_GET['unapprove']);
    $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $c_unapprove_id);
    if(!$stmt){
        die ("<h1>stmt gone wrong</h1>");
    }
    mysqli_stmt_execute($stmt);
    header("Location: comments.php"); // page refresh
}

// delete user via GET
if(isset($_GET['delete'])){
    $c_delete_id = sanitize_id($_GET['delete']);
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $c_delete_id);
    if(!$stmt){
        die ("<h1>stmt gone wrong</h1>");
    }
    mysqli_stmt_execute($stmt);
    header("Location: users.php"); // page refresh
}

?>