<?php

if(isset($_POST['create_post'])){
    $post = sanitize_post_input($_POST);
    $post_title =   $post['title'];
    $post_author =  $post['author'];
    $post_cat_id =  $post['post_category'];
    $post_status =  $post['status'];

    $post_image =   $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags =    $post['tags'];
    $post_content = $post['content'];
    $post_date = date('Y-m-d');// d-m-y
    $post_comment_count = 0;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    // Create a post SQL query
    $query = "INSERT INTO posts (post_title, post_author, post_category_id, post_status, post_image, post_tags, post_content, post_date, post_comment_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'ssisssssi', $post_title, $post_author, $post_cat_id, $post_status, $post_image, $post_tags, $post_content, $post_date, $post_comment_count);
    mysqli_stmt_execute($stmt);
    header("Location: posts.php"); // page refresh
}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="Post title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label for="Post author">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <label for="Post category">Post Category</label><br>
            <select class="form-control" name="post_category" id="post category">

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
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <label for="Post status">Post Status</label><br>
            <select class="form-control" name="status" id="post status">
                <option value="Draft">Draft</option>
                <option value="Published">Published</option>
            </select>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="Post image">Post Image</label>
        <input type="file" class="form-control-file" name="image">
    </div>
    <div class="form-group">
        <label for="Post tags">Post Tags</label>
        <input type="text" class="form-control" name="tags">
    </div>
    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea class="form-control" name="content" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div id="summernote"><p>Hello Summernote</p></div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>