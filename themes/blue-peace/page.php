<?php get_header(); ?>


<div class="contentbox">

<?php if ( ! have_posts() ) : ?>  
        <h1>Not Found</h1>  
            <p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post</p>  
<?php endif; ?> 

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

     	<div class="post clear" id="post-<?php the_ID(); ?>">
	
<div class="loophead">
<h2 class="boxh3"><?php the_title(); ?></h2>
<span class="postauthor"><?php the_author(); ?></span>
<span class="postcomment"><?php comments_popup_link('Leave a comment', '1 Comment', '% Comments'); ?></span>
</div>
		<div class="entry clear">
 
                <?php the_content('Read More'); ?>  

			</div>	
            
            <?php wp_link_pages(); ?>
            
            
            </div>

	<?php endwhile; ?>
    
<?php comments_template( '', true ); ?>  


    <?php else: ?>


<?php endif; ?>





   
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>