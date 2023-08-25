<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>E-mail</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th class="text-center">Approve</th>
            <th class="text-center">Unapprove</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>

    <?php 
    
    $comment_limit = "";
    $query = "SELECT * FROM comments " . $comment_limit;
    $query .= "ORDER BY comment_id DESC ";
    $select_comments = mysqli_query($connection, $query);
    // $rnd3 = rnd_string(3);
    while($row = mysqli_fetch_assoc($select_comments)){
        $comment_id =          $row['comment_id'];
        $comment_email =       $row['comment_email'];
        $comment_author =      $row['comment_author'];
        $comment_date =        $row['comment_date'];
        $comment_content =     $row['comment_content'];
        $comment_post_id =     $row['comment_post_id'];
        $comment_status =      $row['comment_status'];

        $post_title = post_title_by_id($comment_post_id);

        echo "<tr>";
    
    ?>
            <td><?=$comment_id?></td>
            <td><?=$comment_author?></td>
            <td style="width:40%"><?=$comment_content?></td>
            <td><?=$comment_email?></td>
            <td><?=$comment_status?></td>
            <td><a href="../post.php?p_id=<?=$comment_post_id?>" ><?=$post_title?></a></td>
            <td><?=$comment_date?></td>
            <td class="text-center" style="width:4%"><a button class='btn btn-primary' href="comments.php?approve=  <?=$comment_id?>"><i class='fa fa-check fa-2x'></i></button></a></td>
            <td class="text-center" style="width:4%"><a button class='btn btn-danger'  href="comments.php?unapprove=<?=$comment_id?>"><i class='fa fa-times-circle-o fa-2x'></i></button></a></td>
            <td class="text-center" style="width:4%"><a button class='btn btn-danger'  href="comments.php?delete=   <?=$comment_id?>"><i class='fa fa-trash fa-2x'></i></button></a></td>
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

// delete a post via GET
if(isset($_GET['delete'])){
    $c_delete_id = sanitize_id($_GET['delete']);
    $query = "DELETE FROM comments WHERE comment_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $c_delete_id);
    if(!$stmt){
        die ("<h1>stmt gone wrong</h1>");
    }
    mysqli_stmt_execute($stmt);
    header("Location: comments.php"); // page refresh
}

?>