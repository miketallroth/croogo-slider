<?php

	// load required style and selected theme
	$this->Html->css('NivoSlider.nivo-slider', array('inline'=>false));
	$themeName = Configure::read('NivoSlider.themeName');
	if (!empty($themeName)) {
		$this->Html->css("NivoSlider.themes/{$themeName}/{$themeName}", array('inline'=>false));
	}
    $themeName = 'default';
    $sliderAlias = $block['Block']['alias'];
    //CakeLog::write('debug',print_r($block,true));

	// commented jquery because it is loaded by default anyway (a different version)
	if (Configure::read('NivoSlider.loadJquery')) {
		$this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js', array('inline'=>false));
	}
	$this->Html->script('NivoSlider.jquery-nivo-slider-pack', array('inline'=>false));

?>

	<div class="slider-wrapper theme-<?php echo $themeName; ?>">
        <div class="ribbon"></div>
        <div id="slider-<?php echo $sliderAlias; ?>" class="nivoSlider">
            <?php echo $block['Block']['body']; ?>
        </div>
	</div>
