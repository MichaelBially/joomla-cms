<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;

$attributes = array();

if ($item->anchor_title)
{
	$attributes['title'] = $item->anchor_title;
}

if ($item->anchor_css)
{
	$attributes['class'] = $item->anchor_css;
}

if ($item->anchor_rel)
{
	$attributes['rel'] = $item->anchor_rel;
}

if ($item->id == $active_id)
{
	$attributes['aria-current'] = 'location';

	if ($item->current)
	{
		$attributes['aria-current'] = 'page';
	}
}

/* nur für die 2. Zeile
if(str_contains($item->title, '//'))
{
    $menuitem = explode('//', $item->title);
    
    if($menuitem[1] == null || $menuitem[1] == '')
        $menuitem[1]='&nbsp;';
 
    $newitem = '<div>'.$menuitem[0].'</div><div class="d-none d-lg-block" style="text-align: center; font-size: 80%">'.$menuitem[1].'</div>';
    $item->title = $newitem;
}
*/
$linktype = $item->title;

if ($item->menu_image)
{
	if ($item->menu_image_css)
	{
		$image_attributes['class'] = $item->menu_image_css;
		$linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);
	}
	else
	{
		$linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
	}

	if ($itemParams->get('menu_text', 1))
	{
		$linktype .= '<span class="image-title">' . $item->title . '</span>';
	}
}

if ($item->browserNav == 1)
{
	$attributes['target'] = '_blank';
}
elseif ($item->browserNav == 2)
{
	$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes';

	$attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

$active = '';
if (in_array($item->id, $path))
{
    $active = ' active';
}
elseif ($item->type === 'alias')
{
    $aliasToId = $itemParams->get('aliasoptions');
    
    if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
    {
        $active = ' active';
    }
    elseif (in_array($aliasToId, $path))
    {
        $active = ' alias-parent-active';
    }
}

//if($item->level == 1)
if($item->deeper)
{?>
  	<a class="nav-link dropdown-toggle <?php echo $active;?>" 
  		href="#" 
  		id="navbarDropdown" 
  		role="button" 
  		data-bs-toggle="dropdown" 
  		aria-expanded="false">
       <?php echo $linktype; ?>  <span class="caret"></span> 
       </a>
<?php	
}
else 
{   
    ?>
  	<a class="nav-link <?php echo $active;?>" 
  		href="<?php echo $item->flink;?>" 
  		id="navbarDropdown" 
  		role="button"
  		
  		aria-expanded="false">
       <?php echo $linktype; ?></a>
<?php	
    //echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
}
