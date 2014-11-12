<?php

/*
	$t = $type['Type']['alias'];
	$p = $type['Params'];

	// distinguish between add and edit
	$isEdit = false;
	if (strpos($this->params['action'], 'edit') !== false) {
		$isEdit = true;
	}

	$detailModelName = Inflector::classify($t) . 'Detail';
	$detailFields = ClassRegistry::init($detailModelName)->schema();

	$jsReady = '';

	foreach ($detailFields as $fieldName => $meta) {

		$f = "{$detailModelName}.{$fieldName}";
		$jsLabel = Inflector::classify(str_replace('.','_',$f));

		if ($fieldName == 'id') {
			if ($isEdit) {
				echo $this->Form->input($f);
			}
			continue;
		}
		if ($fieldName == 'node_id') {
			if ($isEdit) {
				echo $this->Form->input($f, array('type'=>'hidden', 'value'=>$this->data['Node']['id']));
			}
			continue;
		}

		switch ($meta['type']) {
		case 'datetime':
			echo $this->Form->input($f, array('class'=>'datetimepicker', 'type'=>'text'));
			$jsReady .= "\$('#{$jsLabel}').datetimepicker({dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});";
			break;
		case 'boolean':
			echo $this->Form->input($f, array('class'=>'checkbox', 'type'=>'checkbox'));
			break;
		case 'integer':
		default:
			echo $this->Form->input($f, array('class'=>'text', 'type'=>'text'));
		}
	}

	if (!empty($jsReady)) {
		$this->Html->script(array('/details/js/jquery.datetimepicker'), array('inline'=>false));
		$this->Html->css(array('/details/css/theme'), null, array('inline'=>false));
		$js = '$(document).ready(function(){' . $jsReady . '});';
		echo '<script type="text/javascript">';
		echo $js;
		echo '</script>';
	}
 */

    $data = $this->request->data;

    if (!empty($data) && strpos($data['Menu']['alias'], 'slider-') === 0) {
        $link = $data['Link'];
        $menu = $data['Menu'];
        CakeLog::write('debug','hello');
        CakeLog::write('debug',print_r($link,true));
        CakeLog::write('debug',print_r($menu,true));

        $linkChooserUrl = $this->Html->url(array(
            'admin' => true,
            'plugin' => 'menus',
            'controllers' => 'links',
            'action' => 'link_chooser',
        ));

        echo $this->Form->input('image', array(
            'label' => __d('croogo', 'Image'),
            'append' => true,
            'addon' => $this->Html->link('', '#image_choosers', array(
                'button' => 'default',
                'icon' => $_icons['link'],
                'iconSize' => 'small',
                'data-title' => __d('croogo', 'Image Chooser'),
                'data-toggle' => 'modal',
                'data-remote' => $linkChooserUrl,
            )),
        ));

        $this->append('page-footer', $this->element('admin/modal', array(
            'id' => 'image_choosers',
            'title' => __d('croogo', 'Choose Image'),
        )));

        echo $this->Form->input('caption', array(
            'label' => __d('croogo', 'Caption'),
        ));

    } else {
        echo '<div class="input text">This tab only used for Slider links. To make a Slider Link, assign this link to a Menu with an alias in the format:<br/><em>slider-&lt;your slider alias&gt;</em></div>';
    }


?>
