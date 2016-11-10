<?php
header( 'Content-Type:text/xml' );
echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	<?php foreach ( $data->units as $v ) : ?>
		<url>
			<loc><?php bloginfo( 'url' ); ?>/vrp/unit/<?php echo esc_attr( $v->page_slug ); ?></loc>
			<changefreq>weekly</changefreq>
			<lastmod><?php echo esc_attr( date( 'Y-m-d', strtotime( $v->updated ) ) ); ?></lastmod>
		</url>
	<?php endforeach; ?>
	<?php
	if ( isset( $data->complexes ) ) {
		foreach ( $data->complexes as $v ) : ?>
			<url>
				<loc><?php bloginfo( 'url' ); ?>/vrp/complex/<?php echo esc_attr( $v->page_slug ); ?></loc>
				<changefreq>weekly</changefreq>
				<lastmod><?php echo esc_attr( date( 'Y-m-d', strtotime( $v->updated ) ) ); ?></lastmod>
			</url>
		<?php endforeach;
	} ?>
</urlset>
