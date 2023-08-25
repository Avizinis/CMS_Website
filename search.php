<?php include 'includes/header.php'?>


    <!-- Navigation -->
    <?php include 'includes/navigation.php'?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

 
            <?php // custom search engine
            if(isset($_POST['submit'])){
                $search = sanitize_string($_POST['search']);
                $search = '%'.$search.'%';
                $query = "SELECT * FROM posts WHERE ";
                $query.= "post_title LIKE ? ";
                $query.= "|| post_author LIKE ? ";
                $query.= "|| post_content LIKE ?";
                $query.= "|| post_tags LIKE ?";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, 'ssss', $search, $search, $search, $search);
                mysqli_stmt_execute($stmt);
                $search_query = mysqli_stmt_get_result($stmt);

                confirm_stmt_result($search_query);

                while($row = mysqli_fetch_assoc($search_query)){
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

                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>

                    <?php }}?>
            
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'?>

        </div>
        <!-- /.row -->

        <hr>

        <?php include 'includes/footer.php'?>
