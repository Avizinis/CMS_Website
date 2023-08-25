<?php

// catch the post to be edited data via post id from GET
if(isset($_GET['p_id'])){
    $p_id = sanitize_id($_GET['p_id']);

    $query = "SELECT * FROM posts WHERE post_id = ?";
    $select_posts = fetch_stmt_result_by_id($p_id, $query);

    while($row = mysqli_fetch_assoc($select_posts)){
        $p_id =          $row['post_id'];
        $p_title =       $row['post_title'];
        $p_author =      $row['post_author'];
        $p_date =        $row['post_date'];
        $p_image =       $row['post_image'];
        $p_tags =        $row['post_tags'];
        $p_content =     $row['post_content'];
        $p_comments =    $row['post_comment_count'];
        $p_catid =       $row['post_category_id'];
        $p_status =      $row['post_status'];
    }
    echo "<h3>Post to be edited: ". $p_title . "</h3>";
}

// Update post sequence. Starting by collecting info from forms, then creating an SQL query.
if(isset($_POST['update_post'])){
    $post = $_POST;
    $post = sanitize_post_input($_POST);
    // foreach($post as &$v){ // sanitize post input
    //     $v = sanitize_empty_string_any_length($v);
    //     echo $v;
    //     echo '<br>';
    // }
    $post_title =   $post['title'];
    $post_author =  $post['author'];
    $post_cat_id =  $post['post_category'];
    $post_status =  $post['status'];

    $post_image =   $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags =    $post['tags'];
    $post_content = $post['content'];
    $post_date = date('Y-m-d');
    $post_comment_count = 4;
    
    move_uploaded_file($post_image_temp, "../images/$post_image");

    // reupload the same picture if not specified new.
    if(empty($post_image)){
        $query = "SELECT post_image FROM posts WHERE post_id = ?";
        $p_image = fetch_stmt_result_by_id($p_id, $query);
        while($row = mysqli_fetch_assoc($p_image)){
            $post_image = $row['post_image'];
        }
    }

    // Update a post SQL query
    $query = "UPDATE posts ";
    $query .= "SET post_title = ?, post_author = ?, post_category_id = ?, post_status = ?, post_image = ?, post_tags = ?, post_content = ?, post_date = ?, post_comment_count = ? ";
    $query .= "WHERE post_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'ssisssssii', $post_title, $post_author, $post_cat_id, $post_status, $post_image, $post_tags, $post_content, $post_date, $post_comment_count, $p_id);
    mysqli_stmt_execute($stmt);
    $post_update_result = mysqli_stmt_get_result($stmt);
    header("Location: posts.php"); // page refresh
}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post title">New Post Title</label>
        <input type="text" id="post title" class="form-control" name="title" value="<?=$p_title?>">
    </div>
    <div class="form-group">
        <?php $cat_title = cat_title_by_id($p_catid); ?>
        <label>Post Category - <?=$cat_title?></label>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <label for="post category">New Post Category</label><br>
            <select class="form-control" name="post_category" id="post category">
                <option value="<?=$p_catid?>" selected><?php echo cat_title_by_id($p_catid); ?></option>

                <?php // List all categories by name
                $query = "SELECT * FROM categories";
                $select_categories_p = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_categories_p)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value='$cat_id'>$cat_title</option>";
                } ?>

            </select>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="Post author">New Post Author</label>
        <input type="text" id="Post author" class="form-control" name="author" value="<?=$p_author?>">
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <label for="Post status">New Post Status</label><br>
            <select class="form-control" name="status" id="Post status">
                <option value="<?=$p_status?>" selected><?php echo $p_status; ?></option>
                <option value="Draft">Draft</option>
                <option value="Published">Published</option>
            </select>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="Post image">New Post Image</label><br>
        <img src="../images/<?=$p_image?>" width="300"><br><br>
        <input type="file" id="Post image" class="form-control-file" name="image">
    </div>
    <div class="form-group">
        <label for="Post tags">New Post Tags</label>
        <input type="text" id="Post tags" class="form-control" name="tags" value="<?=$p_tags?>">
    </div>
    <div class="form-group">
        <label for="summernote">New Post Content</label>
        <textarea class="form-control" name="content" id="summernote" cols="30" rows="10"><?=$p_content?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>