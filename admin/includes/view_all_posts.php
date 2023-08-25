<?php


// Update multiple post status using checkboxes
if(isset($_POST['checkBoxArray'])){
    $options = $_POST['checkBoxArray'];
    $bulk_options = $_POST['bulk_options'];
    foreach($options as $post_id){
        switch($bulk_options){
            case "Published":
                $query = "UPDATE posts SET post_status = 'Published' WHERE post_id = ?";
                fetch_stmt_result_by_id($post_id, $query);
                break;
            case "Draft":
                $query = "UPDATE posts SET post_status = 'Draft' WHERE post_id = ?";
                fetch_stmt_result_by_id($post_id, $query);
                break;
        }
    }
}


?>

<form class="form-group" action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="Published">Publish</option>
                <option value="Draft">Draft</option>
                <option value="Delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-s">
            <input type="submit" name="option_submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
        <br>

        <thead>
            <tr>
                <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th style="width:15%">Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>

        <?php 
        
        // list posts query
        $post_limit = "";
        $query = "SELECT * FROM posts" . $post_limit;
        $select_posts = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_posts)){
            $post_id =          $row['post_id'];
            $post_title =       $row['post_title'];
            $post_author =      $row['post_author'];
            $post_date =        $row['post_date'];
            $post_image =       $row['post_image'];
            $post_tags =        $row['post_tags'];
            $post_comments =    $row['post_comment_count'];
            $post_catid =       $row['post_category_id'];
            $post_status =      $row['post_status'];

            // post comment count query
            $c_query = "SELECT COUNT(*) AS post_comment_count FROM comments WHERE comment_post_id = ?";
            $stmt = mysqli_prepare($connection, $c_query);
            mysqli_stmt_bind_param($stmt, 'i', $post_id);
            mysqli_stmt_execute($stmt);
            $c_count_result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($c_count_result)){
                $comment_count = $row['post_comment_count'];
            }

            echo "<tr>";
        
        ?>
                <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?=$post_id?>"></td>
                <td><?=$post_id?></td>
                <td><?=$post_author?></td>
                <td><a href="../post.php?p_id=<?=$post_id?>"><?=$post_title?></a></td>
                <td><?php echo cat_title_by_id($post_catid); ?></td>
                <td><?=$post_status?></td>
                <td><img class="img-rounded img-responsive" src="../images/<?=$post_image?>" alt="image"></td>
                <td><?=$post_tags?></td>
                <td><?=$comment_count?></td>
                <td><?=$post_date?></td>
                <td class="text-center" style="width:1%"><a button class='btn btn-primary' href="posts.php?source=edit_post&p_id=<?=$post_id?>"><i class='fa fa-pencil'></i> Edit</button></a></td>
                <td class="text-center" style="width:8%"><a button class='btn btn-danger' href="posts.php?delete=<?=$post_id?>"><i class='fa fa-trash'></i> Delete</button></a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</form>

<?php

// delete a post via GET
if(isset($_GET['delete'])){
    $post_delete_id = sanitize_id($_GET['delete']);
    $query = "DELETE FROM posts WHERE post_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $post_delete_id);
    if(!$stmt){
        die ("<h1>stmt gone wrong</h1>");
    }
    $post_delete = mysqli_stmt_execute($stmt);
    header("Location: posts.php"); // page refresh
}

?>