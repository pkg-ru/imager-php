<?php

namespace pkgRu\imagerPhp;

/**
 * Imager
 * 
 * Горячее создание миниатюр для картинок
 * 
 * @see https://github.com/pkg-ru/imager
 */
class Imager extends ImagerEncode
{
	private NewImage $instance;

	public function __construct(array $config = [])
	{
		$this->instance = new NewImage();
		foreach ($config as $key => $value) {
			if (property_exists($this, $key)) {
				$this->instance->$key = $value;
			}
		}
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
