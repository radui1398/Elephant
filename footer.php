<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); ?>
<?php
global $footerMenu;
?>

<?php
$footerMenu->printMenu();
?>
	<footer>
        <p class="copyright">® COPYRIGHT <?=copyright('2019')?>. ALL RIGHTS RESERVED.</p>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>