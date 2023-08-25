<?php
global $connection;

function sanitize_string($input){
    global $connection;
    $username = mysqli_real_escape_string($connection, $input);  // sanitizing username input
    if(empty($username)){
        echo 'Please enter your credentials';
    } if(!empty($username) && (mb_strlen($username, 'UTF-8') < 255)){                               
        return $username;
    } else {
        exit(1);
    }
}


// sanitize string. No length check.
function sanitize_empty_string_any_length($input){
    global $connection;
    $esc_input = mysqli_real_escape_string($connection, $input);  // sanitizing username input
    return $esc_input;
}


function check_for_input_length($input, $length){
    if(mb_strlen($input, 'UTF-8') > $length){
        echo 'Please use shorter input';
        exit(1);
    } else {
        return $input;
    }
}


// id input sanitization. Validate if input is an int and sanitize it.
function sanitize_id($id){
    if(empty($id)){
        echo 'id is empty';
    }
    if($id = filter_var($id,FILTER_VALIDATE_INT)){             // validating if input is int
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    } else {
        die('id is not an integer');
    }
    return $id;
}


// i random bytes generator
function rnd_string($i){
    $result = bin2hex(random_bytes($i));
    return $result;
}


// Category create
function cat_create(){
    global $connection;
    if(isset($_POST['submit'])){
        if(!empty($_POST['cat_title'])){
            $new_cat = sanitize_string($_POST['cat_title']);

            $query = "INSERT INTO categories(cat_title) ";
            $query.= "VALUES (?)";
            $stmt_cat_create = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt_cat_create, 's', $new_cat);
            $result = mysqli_stmt_execute($stmt_cat_create);
            if(!$result){
                die('Error: no connection to database '. mysqli_error($connection));
            } else{
                echo 'Record Created';
            }
            header("Location: categories.php"); // page refresh
        } else {
            echo 'This field should not be empty' . '<br>';
            // header("Location: categories.php"); // page refresh
        }
    }
}


// Delete a selected category via id; _POST
function cat_delete(){
    global $connection;
    if(isset($_POST['delete_submit'])){ 
        // echo "delete button pressed" . "<br>" . "delete cat id " . $_GET['delete'];
        $get_cat_id = $_POST['del_id'];
        $esc_cat_id = sanitize_id($get_cat_id);
        $query = "DELETE FROM categories WHERE cat_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'i', $esc_cat_id);
        if(!$stmt){
            die ("<h1>stmt gone wrong</h1>");
        }
        // if post table uses this cat_id then removal not allowed
        $post_query = "SELECT * FROM posts WHERE post_category_id = ?";
        $post_result = fetch_stmt_result_by_id($esc_cat_id, $post_query);
        $num_rows = mysqli_num_rows($post_result);
        if($num_rows == 0){
            mysqli_stmt_execute($stmt);
            header("Location: categories.php"); // page refresh
            echo "cat deleted";
        } else {
            echo "<div class='alert alert-warning' role='alert'>
                    Some posts are using this category. Free the category first.
                </div>";
        }

        
    }
}


function confirm_stmt_result($result){
    global $connection;
    if(!$result){
        echo "SQL query error: " . mysqli_error($connection);
    // return confirm_prepared_stmt_result_data($result);
    }
}


function confirm_prepared_stmt_result_data($result){
    $num_rows = mysqli_num_rows($result);
    if($num_rows == 0){
        return False; // result empty.
    } else {
        return True;  // result confirmed.
    }
}


// read and list all categories
function FindAllCategories(){
    global $connection;
    $cat_limit = "";
    $query = "SELECT * FROM categories" . $cat_limit;
    $select_categories_admin = mysqli_query($connection, $query);
    // $rnd3 = rnd_string(3);
    while($row = mysqli_fetch_assoc($select_categories_admin)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td> {$cat_id} </td>";
        echo "<td> {$cat_title} </td>";

        // delete button
        echo "<form action='categories.php' method='post'>
                <td>
                    <button class='btn btn-danger' type='submit' name='delete_submit'><i class='fa fa-trash'></i> Delete</button>
                    <input hidden name='del_id' value='{$cat_id}'>
                </td>
            </form>";
        
        // edit button
        echo "<form action='categories.php' method='post'>
                <td>
                    <button class='btn btn-primary' type='submit' name='edit_submit'><i class='fa fa-pencil'></i> Edit</button>
                    <input hidden name='update_id' value='{$cat_id}'>
                </td>
            </form>";
        echo "</tr>";
    }
}


// on success returns result. One int input in query.
function fetch_stmt_result_by_id($id, $query){
    global $connection;
    $esc_id = sanitize_id($id);
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $esc_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $i = mysqli_stmt_errno($stmt);
    if($result){
        return $result;
    } elseif(mysqli_stmt_errno($stmt)) {
        echo "SQL query error: {$i} " . mysqli_error($connection);
    }
}


// on success returns result. One string input in query.
function fetch_stmt_result_by_string($string, $query){
    global $connection;
    $string = sanitize_string($string);
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 's', $string);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $i = mysqli_stmt_errno($stmt);
    if($result){
        return $result;
    } elseif(mysqli_stmt_errno($stmt)) {
        echo "SQL query error: {$i} " . mysqli_error($connection);
    }
}


// returns category title for its id
function cat_title_by_id($id){
    $query = "SELECT cat_title FROM categories WHERE cat_id = ?";
    $result = fetch_stmt_result_by_id($id, $query);
    while($row = mysqli_fetch_assoc($result)){
        $cat_title = $row['cat_title'];
        return $cat_title;
    }
}


// returns post title for its id
function post_title_by_id($id){
    $query = "SELECT post_title FROM posts WHERE post_id = ?";
    $result = fetch_stmt_result_by_id($id, $query);
    while($row = mysqli_fetch_assoc($result)){
        $post_title = $row['post_title'];
        return $post_title;
    }
}


// sanitize post array. No length check.
function sanitize_post_input($array){
    foreach($array as &$v){
        $v = sanitize_empty_string_any_length($v);
    }
    return $array;
}


// secure password generation with BCRYPT. sanitizes input, checks for 72 max bytes and empty input
// make sure you don't ever pass NULL-bytes to password_hash, using bcrypt
function hash_pwd($password){
    $esc_pwd = sanitize_string($password);
    if(mb_strlen($esc_pwd, 'UTF-8') > 72){          // check for max byte input for BCRYPT algo safety
        die('Please use shorter password');
    } if(!empty($esc_pwd) && !is_null($esc_pwd)){
        $hashed_pwd = password_hash($esc_pwd, PASSWORD_BCRYPT);
        return $hashed_pwd;
    } else{
        exit(1);
    }
}


function username_by_session_id($id){
    $query = "SELECT username FROM users WHERE user_id = ?";
    $result = fetch_stmt_result_by_id($id, $query);
    while($row = mysqli_fetch_assoc($result)){
        $username = $row['username'];
        return $username;
    }
}


// * FROM users table
function users_table(){
    global $connection;
    $query = "SELECT * FROM users";
    $users_table = mysqli_query($connection, $query);
    return $users_table;
}


// No duplicate username in db? True - unique. False - duplicate
function is_unique_username($username){
    $good_username = True;
    $users_table = users_table();
    while($row = mysqli_fetch_assoc($users_table)){
        if($row['username'] === $username){
            $good_username = False;
        }
    }
    return $good_username;
}


// No duplicate email in db? True - unique. False - duplicate
function is_unique_email($email){
    $good_email = True;
    $users_table = users_table();
    while($row = mysqli_fetch_assoc($users_table)){
        if($row['user_email'] === $email){
            $good_email = False;
        }
    }
    return $good_email;
}


// Returns True if usernames are the same. False otherwise.
function is_the_same_username($user_id, $new_username){
    $query = "SELECT username FROM users WHERE user_id = ?";
    $username_result = fetch_stmt_result_by_id($user_id, $query);
    $i = 0;
    while($row = mysqli_fetch_assoc($username_result)){
        $old_username = $row['username'];
        $i = $i + 1;
    }
    if($i > 1){
        echo "Error. Duplicate unique user id";
    }
    if($old_username === $new_username){
        return True; // same username
    } else {
        return False;
    }
}


// Returns True if emails are the same. False otherwise.
function is_the_same_email($user_id, $new_email){
    $query = "SELECT user_email FROM users WHERE user_id = ?";
    $email_result = fetch_stmt_result_by_id($user_id, $query);
    $i = 0;
    while($row = mysqli_fetch_assoc($email_result)){
        $old_email = $row['user_email'];
        $i = $i + 1;
    }
    if($i > 1){
        echo "Error. Duplicate unique user id";
    }
    if($old_email === $new_email){
        return True; // same email
    } else {
        return False;
    }
}


// Create user. Check if no username and email duplicates. True - Verified. False - duplicates found.
function is_username_email_unique($username, $email){
    if(is_unique_username($username) && is_unique_email($email)){
        return True; 
    } else {
        return False;
    }
}


// Update user conditional function if True. False - condition below not satisfied.
// (username same OR unique) AND (email same OR unique)
function is_user_eligible_update($user_id, $new_username, $new_email){
    if( (is_the_same_username($user_id, $new_username) || is_unique_username($new_username)) && (is_the_same_email($user_id, $new_email) || is_unique_email($new_email)) ){
        return True;
    } else {
        return False;
    }
}


function post_quantity(){
    global $connection;
    $query = "SELECT * FROM posts";
    $result = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}


function post_quantity_by_status($string){
    $query = "SELECT * FROM posts WHERE post_status = ?";
    $result = fetch_stmt_result_by_string($string, $query);
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}


function comment_quantity(){
    global $connection;
    $query = "SELECT * FROM comments";
    $result = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}


function comment_quantity_by_status($string){
    $query = "SELECT * FROM comments WHERE comment_status = ?";
    $result = fetch_stmt_result_by_string($string, $query);
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}


function user_quantity(){
    return mysqli_num_rows(users_table());
}


function user_quantity_by_role($string){
    $query = "SELECT * FROM users WHERE user_role = ?";
    $result = fetch_stmt_result_by_string($string, $query);
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}


function category_quantity(){
    global $connection;
    $query = "SELECT * FROM categories";
    $result = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}


?>