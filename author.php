<?php include 'includes/header.php'?>


    <!-- Navigation -->
    <?php include 'includes/navigation.php'?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 
            // Catch category id via GET
            if(isset($_GET['q'])){
                $c_id = sanitize_string($_GET['q']);
            }

            $query = "SELECT * FROM posts WHERE post_author = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 's', $c_id);
            mysqli_stmt_execute($stmt);
            $select_post = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($select_post)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image']; 
                $post_content = substr($row['post_content'], 0, 90);
                ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <?php include 'includes/single_post.php' ?>

                <?php } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>

        </div>
        <!-- /.row -->

        <hr>

        <?php include 'includes/footer.php'?>
