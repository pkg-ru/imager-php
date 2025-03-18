<?php

namespace pkgRu\imagerPhp;

/**
 * Imager
 * 
 * Горячее создание миниатюр для картинок
 * 
 * @see https://github.com/pkg-ru/imager
 */
class Imager extends NewImage
{
	private NewImage $instance;

	public $config = [];

	public function __construct(array $config = [])
	{
		$this->instance = new NewImage;
		$this->instance->init($config ?: $this->config);
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
