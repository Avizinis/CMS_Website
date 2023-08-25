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
                            
                            <small><?=$_SESSION['username']?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <?php include "admin_widgets.php" ?>

                <div class="row">
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

                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>