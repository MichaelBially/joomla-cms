<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagebreak
 *
 * @copyright   (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;

?>
<div class="card article-index mb-3">
	<div class="card-body">
		
		<?php if ($this->onlyPhotoalbum) : ?>
		
			<?php foreach ($list as $listItem) : ?>
				<?php $class = $listItem->active ? ' active' : ''; ?>
				<button type="button" class="btn btn-light">
					<a href="<?php echo Route::_($listItem->link); ?>" class="fs-4 text-decoration-none toclink<?php echo $class; ?>">
						<i class="bi bi-images"></i><i class="bi bi-file-text"></i> <?php echo $listItem->title; ?>
					</a>
				</button>
			<?php endforeach; ?>
			
		<?php else :?>
		
			<?php if ($headingtext) : ?>
			<h3><?php echo $headingtext; ?></h3>
			<?php endif; ?>

			<ul class="nav flex-column">
			<?php foreach ($list as $listItem) : ?>
				<?php $class = $listItem->active ? ' active' : ''; ?>
				<li class="py-1">
					<a href="<?php echo Route::_($listItem->link); ?>" class="toclink<?php echo $class; ?>">
						<?php echo $listItem->title; ?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</div>
