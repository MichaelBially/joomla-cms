<?php
defined('_JEXEC') or die;


use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon-pinned.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#000']);

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

// Template path
$templatePath = 'templates/' . $this->template;

HTMLHelper::_('jquery.framework');

// Color Theme
$paramsColorName = $this->params->get('colorName', 'colors_standard');
$assetColorName  = 'theme.' . $paramsColorName;
$wa->registerAndUseStyle($assetColorName, $templatePath . '/css/global/' . $paramsColorName . '.css');
$this->getPreloadManager()->prefetch($wa->getAsset('style', $assetColorName)->getUri(), ['as' => 'style']);

// Use a font scheme if set in the template style options
$paramsFontScheme = $this->params->get('useFontScheme', false);

if ($paramsFontScheme)
{
    // Prefetch the stylesheet for the font scheme, actually we need to prefetch the font(s)
    $assetFontScheme  = 'fontscheme.' . $paramsFontScheme;
    $wa->registerAndUseStyle($assetFontScheme, $templatePath . '/css/global/' . $paramsFontScheme . '.css');
    $this->getPreloadManager()->prefetch($wa->getAsset('style', $assetFontScheme)->getUri(), ['as' => 'style']);
}

// Enable assets
$wa->usePreset('template.tsv.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'))
->useStyle('template.active.language')
->useStyle('template.user')
->useScript('template.user');

// Override 'template.active' asset to set correct ltr/rtl dependency
$wa->registerStyle('template.active', '', [], [], ['template.tsv.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr')]);

$wa->registerAndUseStyle('bootstrap-icons', $templatePath . '/css/bootstrap-icons-1.5.0/bootstrap-icons.css');
$wa->registerAndUseStyle('chosen', $templatePath . '/css/chosen.min.css');
$wa->registerAndUseStyle('autocomplete', $templatePath . '/css/easy-autocomplete.min.css');
$wa->registerAndUseStyle('photoswipe', $templatePath.'/css/photoswipe.css');
$wa->registerAndUseStyle('photoswipe-default-skin', $templatePath.'/css/default-skin/default-skin.css');
$wa->registerAndUseScript('chosen', $templatePath . '/js/chosen.jquery.min.js');
$wa->registerAndUseScript('cookie', $templatePath . '/js/js.cookie.js');
$wa->registerAndUseScript('autocomplete', $templatePath . '/js/jquery.easy-autocomplete.min.js');
$wa->registerAndUseScript('records', $templatePath . '/js/records.js');
$wa->registerAndUseScript('photoswipe', $templatePath. '/js/photoswipe.min.js');
$wa->registerAndUseScript('photoswipe-default', $templatePath. '/js/photoswipe-ui-default.min.js');

/*$logo_xxl = '<img class="mx-auto d-none d-xxl-block" style="width: 300px" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/logo_xxl.jpg', ENT_QUOTES) . '" alt="' . $sitename . '">';
$logo_xl = '<img class="mx-auto d-none d-xl-block d-xxl-none" style="width: 250px" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/logo_xl.jpg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$logo_lg = '<img class="mx-auto d-none d-lg-block d-xl-none" style="width: 200px" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/logo_lg.jpg', ENT_QUOTES) . '" alt="' . $sitename . '">';
$logo_md = '<img class="mx-auto d-none d-sm-block d-lg-none" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/logo_md.jpg', ENT_QUOTES) . '" alt="' . $sitename . '">';
$logo_xs = '<img class="mx-auto d-block d-sm-none" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/logo_xs.jpg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$logo = $logo_xxl . $logo_xl . $logo_lg . $logo_md . $logo_xs;
*/
//$logo = '<img style="width: 100%" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/TSV-Logo.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';


//$icons = '<img class="d-none d-lg-block" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/kopf-md.png', ENT_QUOTES) . '" alt="' . $sitename . '">';
$icons = '';
$width = '8%';
//$icons = '<div class="container"><div class="d-none d-lg-block "><div class="row"><div  class="col d-flex " style="justify-content: space-around">';
$icons .= '<div class="d-flex flex-nowrap">';
$icons .= '<img style="width: 30%" class="img-fluid pe-5" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/TSV-Logo.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';
//$icons .= $logo_xl;

$icons .= '<img style="width: '.$width.'" class="img-fluid ps-3" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/ballspiele.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$icons .= '<img style="width: '.$width.'" class="img-fluid ps-3" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/fasching.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$icons .= '<img style="width: '.$width.'" class="img-fluid ps-3" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/leichtathletik.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$icons .= '<img style="width: '.$width.'" class="img-fluid ps-3" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/gymnastik.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$icons .= '<img style="width: '.$width.'" class="img-fluid ps-3" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/nordicwalking.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$icons .= '<img style="width: '.$width.'" class="img-fluid ps-3" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/tischtennis.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$icons .= '<img style="width: '.$width.'" class="img-fluid ps-3" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/turnen.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$icons .= '<img style="width: '.$width.'" class="img-fluid ps-3" src="' . Uri::root(true) . '/' . htmlspecialchars('templates/tsv/images/orientierungslauf.svg', ENT_QUOTES) . '" alt="' . $sitename . '">';

$icons .= '</div>';
//$icons .= '</div></div></div></div>';

$hasClass = '';

if ($this->countModules('sidebar-left', true))
{
    $hasClass .= ' has-sidebar-left';
}

if ($this->countModules('sidebar-right', true))
{
    $hasClass .= ' has-sidebar-right';
}

// Container
$wrapper = $this->params->get('fluidContainer') ? 'wrapper-fluid' : 'wrapper-static';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$stickyHeader = $this->params->get('stickyHeader') ? 'position-sticky sticky-top' : '';

// Defer font awesome
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');


?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />
</head>

<script src="/cms/media/vendor/bootstrap/js/bootstrap-es5.min.js"></script>

<?php /*?>
<script>

// siehe https://bootstrap-menu.com/detail-basic-hover.html


document.addEventListener("DOMContentLoaded", function(){
	// make it as accordion for smaller screens
	if (window.innerWidth > 992) {

		document.querySelectorAll('.navbar .nav-item').forEach(function(everyitem){

			everyitem.addEventListener('mouseover', function(e){

				let el_link = this.querySelector('a[data-bs-toggle]');

				if(el_link != null){
					let nextEl = el_link.nextElementSibling;
					el_link.classList.add('show');
					nextEl.classList.add('show');
				}

			});
			everyitem.addEventListener('mouseleave', function(e){
				let el_link = this.querySelector('a[data-bs-toggle]');

				if(el_link != null){
					let nextEl = el_link.nextElementSibling;
					el_link.classList.remove('show');
					nextEl.classList.remove('show');
				}


			})
		});

	}
	// end if innerWidth
	}); 
</script>

<?php */ ?>

<body>

<?php /*?>
	<header class="mb-4">
		<div class="container">
		<div class="row">
			<div class="col-3 gy-3 d-none d-lg-block">
				<div class="navbar-brand">
					<a class="brand-logo" href="<?php echo $this->baseurl; ?>/">
						<?php echo $logo; ?>
					</a>
				</div>
			</div>
			<div class="col-lg-9 gy-3">
				
				<div class="row">
					<div class="col-lg-11 col-md-8 col-sm-6 col-6">
						<div class="navbar-brand">
							<a class="brand-logo" href="<?php echo $this->baseurl; ?>/">
								<?php echo $icons ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</header>
	<?php */?>
	
	<header class="mb-4 mt-4"  style="xxbackground-color: #eaedf0">
		<div class="container">
			<a class="brand-logo" href="<?php echo $this->baseurl; ?>/">
				<?php echo $icons ?>
			</a>
		</div>
	</header>
	
	<style type="text/css">


</style>
	

	<nav class="navbar sticky-top navbar-expand-lg navbar-light" style="display: block; padding-top: 0px;">
		<div class="container">
			<a class="navbar-brand d-lg-none ps-2"  href="/cms">TSV Ipsheim</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse bg-tsv-topmenu rounded-top" id="navbarSupportedContent" style="height: 3rem; ">
				
					<jdoc:include type="modules" name="menu1" style="none" />
			</div>
		</div>
<?php /* */?>
		<div class="container">
			<div class="collapse navbar-collapse bg-tsv-topmenu-second-line rounded-bottom" style="xheight: 3.8rem; padding-top: 2px; padding-bottom: 2px; border-top: 1px solid white" id="navbarSupportedContent">

					<jdoc:include type="modules" name="menu2" style="none" />
				
			</div>
		</div>
		<?php /**/?>
	</nav>











<!--   
<div class="container">
	<header>
		<div class="row">
			<div class="col-3 gy-3 d-none d-lg-block">
				<div class="navbar-brand">
					<a class="brand-logo" href="<?php echo $this->baseurl; ?>/">
						<?php echo $logo; ?>
					</a>
					
					<div class="site-description text-center ">
						<a class="text-decoration-none link-danger fw-bold" href="<?php echo $this->baseurl; ?>">tsv-ipsheim.de</a>
					</div>
				</div>
			</div>
			<div class="col-lg-9 gy-3">
				
				<div class="row">
					<div class="col-lg-11 col-md-8 col-sm-6 col-6">
						<div class="navbar-brand">
							<a class="brand-logo" href="<?php echo $this->baseurl; ?>/">
								<?php echo $icons ?>
							</a>
						</div>
					</div>
				
<?php /*?>						<div class="col-lg-3 col-md-4 col-sm-6 col-6 gy-2">
							<?php if ($this->countModules('search', true)) : ?>
								<div class="container-search">
									<jdoc:include type="modules" name="search" style="none" />
								</div>
							<?php endif;?>
						</div> <?php */?>
				</div>
				
				<div class="row gy-2">
					<div class="col-12">
			
					<?php if ($this->countModules('menu', true) ) : ?>
		
					<nav class="navbar navbar-expand-lg navbar-light" >
						<div class="container-fluid" style="padding-left: 0px; padding-right: 0px;" >
							<a class="navbar-brand d-lg-none" href="/cms">TSV Ipsheim</a> 
							<button style="float: right" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      							<span class="navbar-toggler-icon"></span>
    						</button>
		
							<div class="collapse navbar-collapse bg-tsv-topmenu" id="navbarSupportedContent">
							
							
								<?php if ($this->countModules('menu', true)) : ?>
									<jdoc:include type="modules" name="menu" style="none" />
								<?php endif; ?>

							</div>
						</div>
					</nav>
					<?php endif; ?>
			
					</div>
				</div>


			</div>
		</div>
	</header>
</div>
 -->







<!-- -->

	<div class="container">
	<div class="row" style="margin-top: 10px;">
		
			<?php /*if ($this->countModules('sidebar-left', true)) : ?>
				<div class="col-3  d-none d-lg-block ">
					<div class="grid-child container-sidebar-left">
						<jdoc:include type="modules" name="sidebar-left" style="card" />
					</div>
					

				</div>
			<?php endif; */?>

		<?php if ($this->countModules('sidebar-right', true)) : ?>
			<div class="col col-lg-9">
		<?php else :?>
			<div class="col col-lg-12">
		<?php endif; ?>
					<jdoc:include type="modules" name="xbreadcrumbs" />				

		
		<!-- 
							<div class="d-block d-sm-none">its xs</div>
		<div class="d-none d-sm-block d-md-none">its sm</div>
		<div class="d-none d-md-block d-lg-none">its md</div>
		<div class="d-none d-lg-block d-xl-none">its lg</div>
		<div class="d-none d-xl-block d-xxl-none">its xl</div>
		<div class="d-none d-xxl-block">its xxl</div>
		 -->
		
		
		<main style="padding-left: 0.5rem;">
		<div>
		<jdoc:include type="component" />
		</div>
		</main>
		
		

	</div>

			<?php if ($this->countModules('sidebar-right', true)) : ?>
			<div class="col-lg-3 bg-light" >

				<div class="grid-child container-sidebar-right">
					<jdoc:include type="modules" name="sidebar-right" style="card" />
				</div>
			</div>
			<?php endif; ?>
</div>

</body>
</html>