<?php include 'includes/header.php'?>

<?php
// catch the post id via GET
if(isset($_GET['p_id'])){
    $p_id = sanitize_id($_GET['p_id']);
}
?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 
            

            $query = "SELECT * FROM posts WHERE post_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'i', $p_id);
            mysqli_stmt_execute($stmt);
            $select_post = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($select_post)){
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- Blog Posts -->
                <h2>
                    <?php echo $post_title ?>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>

                <?php } ?>

                <!-- Blog Comments -->

                <?php // Create comment form
                if(isset($_POST['create_comment'])){
                    $post = sanitize_post_input($_POST);
                    $c_content = $post['comment'];
                    $c_status = 'Not yet approved';
                    $c_author = $post['comment_author'];
                    $c_email = $post['comment_email'];
                    $c_date = date('Y-m-d');// d-m-y

                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, 'isssss', $p_id, $c_author, $c_email, $c_content, $c_status, $c_date);
                    mysqli_stmt_execute($stmt);
                    // header("Location: posts.php"); // page refresh
                }

                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">
                        <div class="form-group">
                            <label for="Author">Author</label>
                            <input type="text" placeholder="Author" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="Email">E-mail</label>
                            <input type="email" placeholder="E-mail" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="Comment">Your comment</label>
                            <textarea class="form-control" name="comment" placeholder="Comment" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php 
                $query = "SELECT * FROM comments WHERE comment_post_id = ? ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_id DESC";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, 'i', $p_id);
                mysqli_stmt_execute($stmt);
                $p_comments = mysqli_stmt_get_result($stmt);
                confirm_stmt_result($p_comments);
                while($row = mysqli_fetch_assoc($p_comments)){
                    $comment_id = $row['comment_id'];
                    $comment_author = $row['comment_author'];
                    $comment_email = $row['comment_email'];
                    $comment_date = $row['comment_date'];
                    $comment_content = $row['comment_content'];
                    $comment_status = $row['comment_status'];
                    ?>
                    
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?=$comment_author?>
                                <small><?=$comment_date?></small>
                            </h4>
                            <?=$comment_content?>
                        </div>
                    </div>

                <?php } ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <!-- End Nested Comment -->
                    </div>
                </div>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>

        </div>
        <!-- /.row -->

        <hr>

        <?php include 'includes/footer.php'?>
