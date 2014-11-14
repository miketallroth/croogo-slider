<?php

// TODO
// need to write this to config/settings somewhere (when settings updated?)
// Configure::write('Slider.themeName','default');

	// load required style and selected theme
	$this->Html->css('Slider.nivo-slider', array('inline'=>false));
	$themeName = Configure::read('Slider.themeName');
	if (!empty($themeName)) {
		$this->Html->css("Slider.themes/{$themeName}/{$themeName}", array('inline'=>false));
	}
	$sliderAlias = $block['Block']['alias'];

	// get the associated content and its children (with images)
	$content = $this->requestAction(array(
		'plugin'=>'nivo_slider',
		'controller'=>'nivo_slider',
		'action'=>'get_slider_content',
		$sliderAlias,
	), array('return'));

	$slider = $content['slider'];
	$images = $content['images'];

	$sliderBody = '';
	$sliderCaptions = '';
	if (isset($images[0])) {
		foreach ($images as $sequence => $image) {
			$options = array(
				'alt' => '',
			);
			if (!empty($image['Node']['body'])) {
				$options['title'] = "#slider-{$sliderAlias}-{$image['Node']['slug']}-caption";
				$sliderCaptions .= $this->Html->tag('div',
					$image['Node']['body'],
					array(
						'id' => "slider-{$sliderAlias}-{$image['Node']['slug']}-caption",
						'class' => 'nivo-html-caption',
					)
				);
			}
			$el = $this->Html->image($image['SliderDetail']['image'], $options);
			if (!empty($image['SliderDetail']['link'])) {
				$el = $this->Html->link($el, $image['SliderDetail']['link'], array('escape'=>false));
			}
			$sliderBody .= $el;
		}
	}

	// setup required js to run slider
	// commented jquery because it is loaded by default anyway (a different version)
	if (Configure::read('Slider.loadJquery')) {
		$this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js', array('inline'=>false));
	}
	$this->Html->script('Slider.jquery-nivo-slider-pack', array('inline'=>false));
	$this->Html->scriptBlock("$(window).load(function() { $('#slider-{$sliderAlias}').nivoSlider(); });", array('inline'=>false));
?>

	<div class="slider-wrapper theme-<?php echo $themeName; ?>">
		<div class="ribbon"></div>
		<div id="slider-<?php echo $sliderAlias; ?>" class="nivoSlider">
			<?php echo $sliderBody; ?>
		</div>
		<?php echo $sliderCaptions; ?>
	</div>

