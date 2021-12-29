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
//$jcfields  = $displayData;    // ToDo


// Öffnet ein Unterverzeichnis mit dem Namen aus "alias"

$verzeichnis = 'images/'.$displayData->alias;   // <<<<<<< ToDo

if(!is_dir(JPATH_ROOT.'/'.$verzeichnis)) :
?>
	<div class="alert alert-danger" role="alert">
  		Verzeichnis <?php echo $verzeichnis; ?> existiert nicht!
	</div>

<?php else : ?>

<?php     
$path = openDir(JPATH_ROOT.'/'.$verzeichnis);    


// Verzeichnis lesen
while ($file = readDir($path)) {
    // Höhere Verzeichnisse nicht anzeigen!
    if ($file != "." && $file != "..") {
        
        if (strstr($file, ".jpg")) {
            // Dateiendung vom Dateinamen filtern
            
            $image = new stdClass();
            $image->file = Uri::base().$verzeichnis."/".$file;
            $image->thumb = Uri::base().$verzeichnis."/thumbs/".$file;
            $images[] = $image;
        }
    }
}
closeDir($path); // Verzeichnis schließen
?>


<?php /* ?><div class="xmy-gallery" itemscope itemtype="http://schema.org/ImageGallery"> <?php */?>
<div class="my-gallery row row-cols-1 row-cols-sm-2 row-cols-md-3">
<?php foreach ($images as $image) :?>
	<div class="col" style="--bs-gutter-x: 0.2rem;"> 
	
    <figure class="tsv_gallery" 
    		data-caption="<?php //echo htmlspecialchars($image['bildunterschrift-gross']->rawvalue);?>" 
	   		itemprop="associatedMedia" 
	   		itemscope 
	  		itemtype="http://schema.org/ImageObject">

			<?php 
						
			// File liegt in der Form images/headers/windows.jpg?width=700&height=300 vor. Der Letzte Teil wird hiermit abgeschnitten:
			$imagefile = (explode('?',$image->file))[0];

			$i = getimagesize($image->file); 
			$width = $i[0];
			$height = $i[1];
			?>
						
      		<a href="<?php echo $image->file;?>" itemprop="contentUrl" data-size="<?php echo $width;?>x<?php echo $height;?>">
      			<?php // img-fluid pass die größe des Bilder automatisch an?>
      			<img class="img-fluid img-thumbnail" src="<?php echo $image->thumb?>" itemprop="thumbnail" alt = "test" />          					
			</a>
			<?php /*?>
			<figcaption class="figure-caption text-center" itemprop="caption description">test</figcaption>
			<?php */?>
    </figure>

	</div>
<?php endforeach;?>
</div>
<?php /*?></div> <?php */?>

<div class="clearfix"></div>

<?php endif; ?>
			