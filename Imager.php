<?php

namespace pkgRu\imagerPhp;

/**
 * Imager
 * 
 * Горячее создание миниатюр для картинок
 * 
 * @see https://github.com/pkg-ru/imager
 */
class Imager
{
	use base\ImagerActionTrait;

	public $config = [];

	public function __construct(array $config = [])
	{
		$this->_init($config ?: $this->config);
		$this->config = null;
	}
}
