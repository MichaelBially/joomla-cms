<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
//$wa->registerAndUseScript('mod_menu', 'mod_menu/menu.min.js', [], ['type' => 'module']);
//$wa->registerAndUseScript('mod_menu', 'mod_menu/menu-es5.min.js', [], ['nomodule' => true, 'defer' => true]);

$id = '';

if ($tagId = $params->get('tag_id', ''))
{
	$id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use mod-menu instead
?>

<?php // mx-auto sorgt für die Zentrierung!!!! ?>
<ul class="navbar-nav flex-wrap mb-2 mb-lg-0 xxxxmx-auto <?php echo $class_sfx; ?>">

<pre>
<?php //print_r($list);
//dump($list);
?>
</pre>


<?php foreach ($list as $i => &$item)
{
	$itemParams = $item->getParams();
	
	$class='';

	if ($item->level == 1)
	{
	    $class      = 'nav-item item-' . $item->id;
	    $class .= ' dropdown ';
	}
	
	if($item->level > 1 && $item->type !== 'separator')
	{
	    $class      = 'dropdown-item item-' . $item->id;
	}

	if($item->level == 1 && $item->type === 'separator')
	{
	    echo str_repeat('</ul></div><div id="navbarSupportedContent" class="collapse navbar-collapse bg-tsv-topmenu-second-line"><ul class=" navbar-nav d-flex flex-wrap me-auto mb-2 mb-lg-0">', 1);
	    //echo str_repeat('</ul><ul class="navbar-nav me-auto mb-2 mb-lg-0">', 1);
	   // echo str_repeat('</ul><div style="clear:both"></div><ul>', 1);
	}
	
	if ($item->id == $default_id)
	{
		$class .= ' default';
	}

	if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id))
	{
		$class .= ' current';
	}

	if (in_array($item->id, $path))
	{
		$class .= ' active';
	}
	elseif ($item->type === 'alias')
	{
		$aliasToId = $itemParams->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type === 'separator' && $item->level == 1)
	{
		$class .= ' divider';
	}
	else if($item->type === 'separator' && $item->level > 1)
	{
	    $class .= ' dropdown-divider';
	}

	if ($item->deeper)
	{
		$class .= ' deeper';
	}

	if ($item->parent)
	{
		$class .= ' parent';
	}
	
	$class .= ' ps-4';

	echo '<li class="' . $class . '">';

	switch ($item->type) :
		case 'separator':
		case 'component':
		case 'heading':
		case 'url':
			require ModuleHelper::getLayoutPath('mod_menu', 'topmenusecondline_' . $item->type);
			break;

		default:
			require ModuleHelper::getLayoutPath('mod_menu', 'topmenu_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper)
	{
		echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
	}
	// The next item is shallower.
	elseif ($item->shallower)
	{
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else
	{
		echo '</li>';
	}
}
?></ul>

