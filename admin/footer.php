<?php

/**
 * Copyright (C) 2013 ModernBB
 * Based on code by FluxBB copyright (C) 2008-2012 FluxBB
 * Based on code by Rickard Andersson copyright (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<pun_main>', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <pun_main>


// START SUBST - <pun_footer>
ob_start();

?>
<div id="brdfooter" class="block">
	<h2><span><?php echo $lang_common['Board footer'] ?></span></h2>
	<div class="box"
		<div id="brdfooternav" class="inbox">
			<div class="conr"
				<p id="poweredby"><?php printf($lang_common['Powered by'], '<a href="http://modernbb.be/">ModernBB</a>'.(($pun_config['o_show_version'] == '1') ? ' '.$pun_config['o_cur_version'] : '')) ?></p>
			</div>
			<div class="clearer"></div>
		</div>
	</div>
</div>
<?php

// Display debug info (if enabled/defined)
if (defined('PUN_DEBUG'))
{
	echo '<p id="debugtime">[ ';

	// Calculate script generation time
	$time_diff = sprintf('%.3f', get_microtime() - $pun_start);
	echo sprintf($lang_common['Querytime'], $time_diff, $db->get_num_queries());

	if (function_exists('memory_get_usage'))
	{
		echo ' - '.sprintf($lang_common['Memory usage'], file_size(memory_get_usage()));

		if (function_exists('memory_get_peak_usage'))
			echo ' '.sprintf($lang_common['Peak usage'], file_size(memory_get_peak_usage()));
	}

	echo ' ]</p>'."\n";
}


// End the transaction
$db->end_transaction();

// Display executed queries (if enabled)
if (defined('PUN_SHOW_QUERIES'))
	display_saved_queries();

$tpl_temp = trim(ob_get_contents());
$tpl_main = str_replace('<pun_footer>', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <pun_footer>


// Close the db connection (and free up any result data)
$db->close();

// Spit out the page
exit($tpl_main);
