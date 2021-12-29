<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagebreak
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Utility\Utility;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\String\StringHelper;
use Joomla\CMS\Layout\LayoutHelper;

/**
 * Page break plugin
 *
 * <strong>Usage:</strong>
 * <code><hr class="system-pagebreak" /></code>
 * <code><hr class="system-pagebreak" title="The page title" /></code>
 * or
 * <code><hr class="system-pagebreak" alt="The first page" /></code>
 * or
 * <code><hr class="system-pagebreak" title="The page title" alt="The first page" /></code>
 * or
 * <code><hr class="system-pagebreak" alt="The first page" title="The page title" /></code>
 *
 * @since  1.6
 */
class PlgContentPhotoalbum extends CMSPlugin
{
	/**
	 * The navigation list with all page objects if parameter 'multipage_toc' is active.
	 *
	 * @var    array
	 * @since  4.0.0
	 */
	protected $list = array();

	/**
	 * Plugin that adds a pagebreak into the text and truncates text at that point
	 *
	 * @param   string   $context  The context of the content being passed to the plugin.
	 * @param   object   &$row     The article object.  Note $article->text is also available
	 * @param   mixed    &$params  The article params
	 * @param   integer  $page     The 'page' number
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		$canProceed = $context === 'com_content.article';

		if (!$canProceed)
		{
			return;
		}

		$style = $this->params->get('style', 'pages');

		// Expression to search for.
		$regex = '#<hr(.*)class="system-pagebreak"(.*)\/?>#iU';

		$input = Factory::getApplication()->input;

		$print = $input->getBool('print');
		$showall = $input->getBool('showall');

		if (!$this->params->get('enabled', 1))
		{
			$print = true;
		}
		
////////////////////////

 //dump($row->attribs);		

        $hasPhotoalbum = false;
        
        if (isset($row->tsv_page_title))
        {
            if ($row->tsv_page_title == "Fotoalbum") 
            {
                $hasPhotoalbum = true;                
            }
        }
        
        if($hasPhotoalbum)
        {
            $txt = '<h2>Fotoalbum</h2>';
            $txt .= '<div class="row">';
            $txt .= '   <div class="col-md-8 col-xs-12">';
            $txt .=  LayoutHelper::render('joomla.content.tsv_photoalbum', $row);
			$txt .= $row->text;
			$txt .= '   </div>';
			$txt .= '   <div class="col-md-4">';
			$txt .= $row->toc;
			$txt .= '</div></div>';
			
			$row->text = $txt;
        }
        else
        {
//dump($row);        
        
            $my_image_column = null;
            foreach ($row->jcfields as $x)
            {
                if($x->title == "subform")            // ToDo  Name subform???
                    $my_image_column = $x;
            }

            if(isset($my_image_column->subform_rows)) 
            {
                $txt = '<div class="row">';
                $txt .= '   <div class="col-md-8">';
                $txt .= $row->text;
                $txt .= '   </div>';
                $txt .= '   <div class="col-md-4">';

                if(isset($row->toc))
                    $txt .= $row->toc;
            
                // Implementierung ist in templates/tsv/html/layout/joomla/content/tsv_image_column.php 
                $txt .= LayoutHelper::render('joomla.content.tsv_image_column', $row->jcfields); 
                $txt .= '</div></div>';
            }
            else 
            {
                $txt = $row->text;
            }
            
            $row->text = $txt;
        }

//dump('xxxxxxxxxxxxxxxxxxxx');
//dump($row->text);
////////////////////
	}


}
