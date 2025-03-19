<?php

namespace pkgRu\imagerPhp;

use yii\base\Component;

/**
 * Imager
 * 
 * Горячее создание миниатюр для картинок
 * 
 * @see https://github.com/pkg-ru/imager
 */
class ImagerYii extends Component
{
	use base\ImagerActionTrait;

	public $config = [];

	public function init()
	{
		parent::init();
		$this->_init($this->config);
		$this->config = null;
	}
}
