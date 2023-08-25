<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <label for="search"><h4>Blog Search</h4></label>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="search" class="form-control" id="search">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

    <!-- login -->
    <div class="well">
        <label for="login"><h4>Login</h4></label>
        <form action="includes/login.php" method="post" id="login">
            <div class="form-group">
                <label for="username">Username</label>
                <input name="username" type="text" class="form-control" id="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input name="password" type="password" class="form-control" id="password">
            </div>
            <div class="text-right">
                <button type="submit" name="submit_login" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>


    <?php          
    $cat_limit = "";
    $query = "SELECT * FROM categories" . $cat_limit;
    $select_categories_sidebar = mysqli_query($connection, $query);
    ?>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                <?php
                while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    echo "<li><a href='category.php?q={$cat_id}'> {$cat_title} </a></li>";
                }
                ?>

                </ul>
            </div>
            <!-- /.col-lg-6 -->
            <!-- <div class="col-lg-6">
                <ul class="list-unstyled">
                    <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li>
                </ul>
            </div> -->
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
<?php include "widget.php"; ?>

</div>