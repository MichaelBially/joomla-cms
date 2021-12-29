<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2021 Open Source Matters, Inc. <https://www.joomla.org>
 *              Michael Bially
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Uri\Uri;

//$params  = $displayData->params;
$jcfields  = $displayData;







$my_image_column = null;
foreach ($jcfields as $x)
{
    if($x->title == "subform")            // ToDo  Name subform???
        $my_image_column = $x;
}

if(isset($my_image_column->subform_rows)) :
    
//dump($my_image_column)
?>
				<div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
				<?php foreach($my_image_column->subform_rows as $image) : ?>
				    <figure class="tsv_gallery" 
				    		data-caption="<?php echo htmlspecialchars($image['bildunterschrift-gross']->rawvalue);?>" 
				    		itemprop="associatedMedia" 
				    		itemscope 
				    		itemtype="http://schema.org/ImageObject">

						<?php 
						
						// File liegt in der Form images/headers/windows.jpg?width=700&height=300 vor. Der Letzte Teil wird hiermit abgeschnitten:
						$imagefile = (explode('?',$image['media']->rawvalue['imagefile']))[0];

						// nur den Filename ermitteln
						$path = explode('/',$imagefile);
						$c = count($path);
						
						$filename = $path[$c-1];
						
						$path[$c-1] = 'thumbs';
						$path[$c] = $filename;
						$thumbfile = implode('/',$path);
						

						
						$i = getimagesize(Uri::base().$imagefile); 
						$width = $i[0];
						$height = $i[1];
						?>
						
      					<a href="<?php echo $imagefile;?>" itemprop="contentUrl" data-size="<?php echo $width;?>x<?php echo $height;?>">
      						<?php // img-fluid pass die größe des Bilder automatisch an?>
      						<img class="img-fluid img-thumbnail" src="<?php echo $thumbfile?>" itemprop="thumbnail" alt = "test" />          					
      					</a>
						<figcaption style="background-color: #eaedf0;" class="figure-caption text-center pt-1 pb-2" itemprop="caption description"><?php echo $image['bildunterschrift-klein']->rawvalue;?></figcaption>
				    </figure>
				
				<?php endforeach;?>
				</div>

<?php endif;?>
