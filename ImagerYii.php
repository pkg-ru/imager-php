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
	private NewImage $instance;

	public $config = [];

	public function init()
	{
		parent::init();
		$this->instance = new NewImage;
		$this->instance->init($this->config);
		$this->config = null;
	}


	/**
	 * Новый экземпляр для формирования ассетов миниатюр картинок
	 *
	 * @param string|null $thumb
	 *
	 * @return NewImage
	 */
	public function newImage(string|null $thumb = null): NewImage
	{
		if ($this->instance) {
			$instance = $this->instance->clone();
			if ($thumb) {
				$instance->thumb($thumb);
			}
			return $instance;
		}
		return new NewImage($thumb);
	}
}
