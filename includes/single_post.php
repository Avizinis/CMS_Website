<!-- Blog Posts -->
<h2>
    <a href="post.php?p_id=<?=$post_id?>"><?=$post_title?></a>
</h2>

<p class="lead">
    by <a href="author.php?q=<?=$post_author?>"><?=$post_author?></a>
</p>

<p><span class="glyphicon glyphicon-time"></span><?=$post_date?></p>

<hr>

<a href="post.php?p_id=<?=$post_id?>">
<img class="img-responsive" src="images/<?=$post_image?>" alt="">
</a>

<hr>

<p><?=$post_content?></p>

<a class="btn btn-primary" href="post.php?p_id=<?=$post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
<hr>