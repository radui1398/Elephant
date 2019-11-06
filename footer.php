<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); ?>
<?php global $footerMenu;?>
	<footer>
        <h1><?=_f('f_c_title',1)?></h1>
        <a href="<?=_f('f_c_b_l',1)?>" title="<?=_f('f_c_b_t',1)?>" class="cta-button">
            <?=_f('f_c_b_t',1)?>
        </a>
        <div class="container">
            <nav>
                <?php $footerMenu->printMenu()?>
            </nav>
        </div>
        <?php $socialLinks = new Repeater('social_links',1);?>
        <div class="social-links">
            <?php $socialLinks->startLoop();?>
            <a href="{{url}}" title="Visit" rel="nofollow" target="_blank">
                {{icon}}
            </a>
            <?php $socialLinks->endLoop();?>
        </div>
        <?php $socialLinks->finish();?>
        <p class="copyright">® COPYRIGHT <?=auto_copyright('2019')?>. ALL RIGHTS RESERVED.</p>
	</footer>

    <?php //echo  auto_copyright(2019); ?>

	<?php wp_footer(); ?>
</body>
</html>