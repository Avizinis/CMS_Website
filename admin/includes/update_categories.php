<form action="categories.php" method="post">
    <div class="">
        <label for="cat_title">Edit category</label>

    <?php // Get category title from db for update
    if(isset($_POST['edit_submit'])){
        $get_cat_update_id = $_POST['update_id'];
        $esc_get_cat_update_id = sanitize_id($get_cat_update_id);

        $query = "SELECT * FROM categories WHERE cat_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'i', $esc_get_cat_update_id);
        if(!$stmt){
            die ("<h1>stmt gone wrong</h1>");
        }
        mysqli_stmt_execute($stmt);
        $cat_update_result = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($cat_update_result)){
            $cat_id_update = $row['cat_id'];
            $cat_title_update = $row['cat_title'];
            
    ?>
    <input type="text" class="form-control" name="cat_title_update" placeholder="<?php if(isset($_POST['edit_submit'])) {echo "Enter new name for " . $cat_title_update;} ?>">

    <?php 
    
    }
    }
    

    ?>

        
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="submit_update" value="Update Category">
        <input type="hidden" name="cat_id" value="<?=$cat_id_update?>">
        <input type="hidden" name="cat_name" value="<?=$cat_title_update?>">
        <?php 

        // update category title
        if(isset($_POST['submit_update'])){
            $new_cat_name = sanitize_string($_POST['cat_title_update']);
            if(!empty($new_cat_name)){
                $cat_id = $_POST['cat_id'];
                $query = "UPDATE categories SET ";
                $query .= "cat_title = ? ";
                $query .= "WHERE cat_id = ?";
                $stmt_update = mysqli_prepare($connection, $query);
                if(!$stmt_update){
                    echo 'stmt error';
                }
                mysqli_stmt_bind_param($stmt_update, 'si', $new_cat_name, $cat_id);
                mysqli_stmt_execute($stmt_update);
                $result = mysqli_stmt_store_result($stmt_update);
                if(!$result){
                    die("Update category title sequence went wrong" . mysqli_error($connection));
                }
            }
            header("Location: categories.php"); // page refresh
        }
        
        
        ?>

    </div>
</form>

<?php 



?>