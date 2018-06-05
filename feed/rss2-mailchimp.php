<?php
/*
 * Template Name: Mailchimp RSS Feed
 */

/** Set up the WordPress Environment. */
require_once( realpath( __DIR__ . '/../../../../wp-load.php' ) );

header('Content-Type: ' . feed_content_type('rss2') . '; charset=' . get_option('blog_charset'), true);

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?><rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/">

<channel>
	<title><?php bloginfo_rss('name'); ?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss('description') ?></description>
	<lastBuildDate><?php
		$date = new DateTime( get_lastpostmodified( 'GMT' ) );
		echo $date->format('D, d M Y H:i:s O');
	?></lastBuildDate>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<sy:updatePeriod><?php
		$duration = 'hourly';

		/**
		 * Filters how often to update the RSS feed.
		 *
		 * @since 2.1.0
		 *
		 * @param string $duration The update period. Accepts 'hourly', 'daily', 'weekly', 'monthly',
		 *                         'yearly'. Default 'hourly'.
		 */
		echo apply_filters( 'rss_update_period', $duration );
	?></sy:updatePeriod>
	<sy:updateFrequency><?php
		$frequency = '1';

		/**
		 * Filters the RSS update frequency.
		 *
		 * @since 2.1.0
		 *
		 * @param string $frequency An integer passed as a string representing the frequency
		 *                          of RSS updates within the update period. Default '1'.
		 */
		echo apply_filters( 'rss_update_frequency', $frequency );
	?></sy:updateFrequency>
	<?php
	$rss_args = array(
		'post_type' => array('post'),
		'post_status' => 'publish',
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$rss_query = new WP_Query( $rss_args );

	if( $rss_query->have_posts() ) {
	while( $rss_query->have_posts() ) { $rss_query->the_post(); 
	?>
	<item>
		<title><?php the_title_rss() ?></title>
		<link><?php the_permalink_rss() ?></link>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<dc:creator><![CDATA[<?php the_author() ?>]]></dc:creator>
		<?php the_category_rss('rss2') ?>

		<guid isPermaLink="false"><?php the_guid(); ?></guid>
		<description><![CDATA[<?php 
			echo tps_rss_post_image();
			the_excerpt_rss(); 
			echo tps_rss_read_more();
			echo tps_rss_first_published();
		?>]]></description>
		<?php rss_enclosure(); ?>
	</item>
	<?php
	} // while
	} // if

	wp_reset_postdata();
	?>
</channel>
</rss>
