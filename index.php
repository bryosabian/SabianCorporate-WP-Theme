<?php
$header_type = SabianThemeSettings::getHeaderType();

get_header($header_type);

do_action("sabian_before_body");
?>

<body>
    <div class="container">
        <?php do_action("sabian_main_content"); ?>
    </div>
</body>

<?php do_action("sabian_after_body"); ?>

<?php get_footer(); ?>
