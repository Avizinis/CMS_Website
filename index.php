<?php include 'includes/header.php'?>


    <!-- Navigation -->
    <?php include 'includes/navigation.php'?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 
            $query = "SELECT * FROM posts WHERE post_status = 'Published'";
            $select_all_posts_query = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_all_posts_query)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 90);
                ?>

                <h1 class="page-header">
                    Page Heading
                    <?php if(isset($_SESSION['username'])){
                        echo "<small>Hello {$_SESSION['username']}</small>";
                    } ?>
                    
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
<!-- testing github Fork and pull request funcionality -->
