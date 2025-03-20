<?php

namespace pkgRu\imagerPhp\base;

/**
 * Imager
 * 
 * Горячее создание миниатюр для картинок
 * 
 * @see https://github.com/pkg-ru/imager
 */
trait ImagerActionTrait
{
	/** @var ImagerEncode */
	private $instance;

	/**
	 * Инициализация настроек
	 *
	 * @param array $config
	 */
	public function _init($config = [])
	{
		$this->instance = new ImagerEncode;
		foreach ($config as $key => $value) {
			if (property_exists($this->instance, $key)) {
				$this->instance->$key = $value;
			}
		}
	}

	/**
	 * Клонируем, чтобы не вносить изменения в общий экземпляр
	 *
	 * @return self
	 */
	public function clone(): self
	{
		$self = new self;
		$self->instance = clone $this->instance;
		return $self;
	}

	/**
	 * Изменяем размер
	 *
	 * @param int $width
	 * @param int $height
	 *
	 * @return self
	 */
	public function size(int $width = 0, int $height = 0): self
	{
		$this->instance->width = $width;
		$this->instance->height = $height;
		return $this;
	}

	/**
	 * Качество
	 *
	 * @param int $quality
	 *
	 * @return self
	 */
	public function quality(int $quality): self
	{
		$this->instance->quality = $quality;
		return $this;
	}

	/**
	 * Кроп
	 *
	 * @param bool $crop
	 *
	 * @return self
	 */
	public function crop(bool $crop): self
	{
		$this->instance->crop = $crop;
		return $this;
	}

	/**
	 * Цвет фона
	 *
	 * @param int $r
	 * @param int $g
	 * @param int $b
	 *
	 * @return self
	 */
	public function color(int $r, int $g, int $b): self
	{
		$this->instance->color = [$r, $g, $b];
		return $this;
	}

	/**
	 * Зацикливание анимации
	 *
	 * @param bool $loop false - проиграть 1 раз, true - зациклить (по умолчанию)
	 *
	 * @return self
	 */
	public function loop(bool $loop): self
	{
		$this->instance->loop = $loop;
		return $this;
	}

	/**
	 * Шаблон настроек на сервере Imager
	 *
	 * @param string $thumb
	 *
	 * @return self
	 */
	public function thumb(string $thumb): self
	{
		$this->instance->thumb = $thumb;
		return $this;
	}

	/**
	 * Обрезать по краям прозрачные пиксели/рамку/и т.д.
	 *
	 * @param bool $active
	 * @param int $rate степень сравнения цветов
	 * @param array $color список цветов rgb
	 * ```
	 * $color = [[255,255,255], [200,200,200]];
	 * ```
	 *
	 * @return self
	 */
	public function trim(bool $active, int $rate = 0, array $color = []): self
	{
		$this->instance->trimActive = $active;
		$this->instance->trimRate = $rate;
		if ($color) {
			$newColors = [];
			foreach ($color as $item) {
				if (is_array($item) && count($item) == 3) {
					$newColors[] = array_filter($item, 'is_numeric');
				} else {
					break;
				}
			}
			if (!$newColors) {
				$newColors[] = array_filter($color, 'is_numeric');
			}
			$this->instance->trimColor = $newColors;
		}
		return $this;
	}

	/**
	 * Получаем ассет на миниатюру в указаном формате
	 *
	 * @param string $file
	 * @param string $format
	 *
	 * @return string
	 */
	public function getConvert(string $file, string $format = ""): string
	{
		$file_arr = explode('.', $file);
		$lastIndex = count($file_arr) - 1;
		$this->instance->format = $file_arr[$lastIndex];
		if (!in_array(strtolower($this->instance->format), ImagerEncode::FormatList)) {
			return $file;
		}


		if ($format == "") {
			$format = strtolower($this->instance->format);
		}

		$nf = $this->instance->getFormat($format);
		if ($nf === false) {
			return $file;
		}

		$this->instance->formatTo = $nf;
		if ($this->instance->format == $format) {
			// если запрашиваемый формат совпадает с текущим то не пишем в данные
			$this->instance->format = "";
		}

		if ($this->instance->format != "" && $this->instance->format == strtolower($this->instance->format)) {
			//если формат файла в нижнем регистре, пишем в данные только 1 байт
			$nf = $this->instance->getFormat($this->instance->format);
			if ($nf !== false) {
				$this->instance->formatFrom = $nf;
				$this->instance->format = "";
			}
		}

		$code = $this->instance->encode();
		if (!$code) {
			return $file;
		}

		unset($file_arr[$lastIndex]);
		return implode('.', $file_arr) . "/" . $code . "." . $format;
	}

	/**
	 * Получаем ассет на миниатюру в формате исходного файла
	 *
	 * @param string $file
	 *
	 * @return string
	 */
	public function get(string $file): string
	{
		return $this->getConvert($file);
	}
}
