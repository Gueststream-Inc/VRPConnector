<html>
    <head>
        <title>Rental Agreement</title>
        <?php // wp_head();?>
	</head>
	<body style="background:none !important;">
		<h3>Rental Agreement</h3>
		<?php echo wp_kses_post( nl2br( $data->booksettings->Contract ) ); ?>
	</body>
	<?php // wp_footer();?>
	<script>
	window.print();
	window.close();</script>
</html>
