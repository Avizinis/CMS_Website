<?php ob_start(); ?>
<?php //session_start(); ?>
<?php //include "../includes/db.php"; ?>
<?php //include "includes/admin_functions.php"; ?>

<?php

// if(!isset($_SESSION['user_role'])){
//     header("Location: ../index.php");
// } elseif($_SESSION['user_role'] !== 'admin'){
//     header("Location: ../index.php");
// } ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <script src="js/jquery_new.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Summernote WYSIWYG -->
    <!-- include libraries(jQuery, bootstrap) -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

    <script src="js/bootstrap_3.4.1.min.js"></script>

    

    <!-- include summernote css/js -->
    <link rel="stylesheet" href="css/summernote/summernote.css">

    <script src="js/summernote.min.js"></script>

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    

    <script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
    </script>

</head>

<body>
    <div id="summernote"><p>Hello Summernote</p></div>

    <div class="form-group">
                    <label for="summernote">Text edit</label>
                    <textarea class="form-control" id="summernote">Sample text</textarea>
                </div>
    
                

    


    <!-- <div class="form-group">
        <label for="test">Text edit</label>
        <textarea class="form-control" id="summernote">Sample text</textarea>
    </div> -->


    



    <div id="wrapper">

        <!-- Navigation -->
        <?php // include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <!-- <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            
                            <small> </small>
                        </h1>
                    </div>
                </div> -->
                <!-- /.row -->

                <?php //include "admin_widgets.php" ?>

            

                <!-- <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            ['Active Posts', <?=post_quantity_by_status("Published")?>],
                            ['Draft Posts', <?=post_quantity_by_status("Draft")?>],
                            ['Comments', <?=comment_quantity()?>],
                            ['Pending Comments', <?=comment_quantity_by_status("Unapproved")?>],
                            ['Users', <?=user_quantity()?>],
                            ['Subscribers', <?=user_quantity_by_role("subscriber")?>],
                            ['Categories', <?=category_quantity()?>],
                            ]);

                            var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>
                    <div id="columnchart_material" style="max-width: 75%; width: auto; height: 500px;"></div>
                </div> -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>