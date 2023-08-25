<?php include "includes/admin_header.php" ?>

<div id="wrapper">

<!-- Navigation -->
<?php include "includes/admin_navigation.php" ?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to admin
                    <small>Author</small>
                </h1>

                

                <div class="col-xs-6">

                    <!-- Create a new category -->
                    <?php cat_create(); ?>

                    <form action="categories.php" method="post">
                        <div class="form-group">
                            <label for="cat_title">Name a category</label>
                            <input type="text" class="form-control" name="cat_title" id="cat_title">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                        </div>
                    </form>

                    <!-- Update category form -->
                    <?php 
                    if(isset($_POST['edit_submit']) || isset($_POST['submit_update'])){
                        include "includes/update_categories.php";
                    }
                    ?>
                    
                </div> 

                <!-- Add Category form -->
                <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Title</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            // read and list all categories
                            FindAllCategories();

                            // Delete a selected category via id; _POST
                            cat_delete();
                            ?>
                            
                        </tbody>
                    </table>
                </div>
                <!-- Category table -->

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>