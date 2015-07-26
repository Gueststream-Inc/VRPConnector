<?php
/**
 * [vrpComplexes] ShortCode view
 */

foreach($data as $complex) { ?>
    <div class="row">
        <div class="row">
            <h2>
                <a href="/vrp/complex/<?php echo esc_attr($complex->page_slug); ?>">
                    <?php echo esc_html($complex->name); ?>
                </a>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo esc_url($complex->Photo); ?>" style="width:100%">
            </div>
            <div class="col-md-8">
                <?php echo wp_kses_post($complex->shortdescription); ?>
            </div>
        </div>
    </div>
<?php
}

