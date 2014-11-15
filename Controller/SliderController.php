<?php

App::uses('SliderAppController', 'Slider.Controller');

/**
 * Slider Controller
 *
 * @category Slider.Controller
 * @package  Slider
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://github.com/miketallroth/croogo-slider
 */
class SliderController extends SliderAppController {

	public $uses = array(
		'Nodes.Node',
	);

/**
 * get slider content
 *
 * @param string alias of slider
 * @return array grouping slider and slider images
 *  array(
 *      'slider' => single grouping slider content item
 *      'images' => array of images in slider
 *  )
 * @access public
 */
	public function get_slider_content($alias = null) {

		$this->Node->type = 'slider';

		// Get (grouping) slider that matches exactly.
		$slider = $this->Node->find('first', array(
			'conditions' => array(
				'Node.slug' => "{$alias}",
				'Node.type' => "slider",
				'Node.status' => 1,
			),
		));
		CakeLog::write('debug','the grouping slider = '. $alias);
		CakeLog::write('debug',print_r($slider,true));

		// Using its lft/rght, find all children.
		$images = $this->Node->find('all', array(
			'conditions' => array(
				'Node.type' => "slider",
				'Node.status' => 1,
				'Node.lft >' => $slider['Node']['lft'],
				'Node.rght <' => $slider['Node']['rght'],
			),
			'order' => 'Node.lft',
		));

		$this->autoRender = false;
		return array(
			'slider' => $slider,
			'images' => $images,
		);
	}

}
