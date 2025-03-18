<?php

namespace ruPkg\imagerPhp;


/**
 * Imager
 * 
 * Горячее создание миниатюр для картинок
 * 
 * @see https://github.com/pkg-ru/imager
 */
class NewImage extends ImagerFormat
{
	public function __construct(string|null $thumb = null)
	{
		$this->thumb = $thumb;
	}

	/**
	 * Клонируем, чтобы не вносить изменения в общий экземпляр
	 *
	 * @return NewImage
	 */
	public function clone(): NewImage
	{
		return clone $this;
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
		$this->width = $width;
		$this->height = $height;
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
		$this->quality = $quality;
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
		$this->crop = $crop;
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
		$this->color = [$r, $g, $b];
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
		$this->loop = $loop;
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
		$this->thumb = $thumb;
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
		$this->trimActive = $active;
		$this->trimRate = $rate;
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
			$this->color = $newColors;
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
		$this->format = $file_arr[$lastIndex];
		if (!in_array(strtolower($this->format), self::FormatList)) {
			return $file;
		}


		if ($format == "") {
			$format = strtolower($this->format);
		}

		$nf = $this->getFormat($format);
		if ($nf === false) {
			return $file;
		}

		$this->formatTo = $nf;
		if ($this->format == $format) {
			// если запрашиваемый формат совпадает с текущим то не пишем в данные
			$this->format = "";
		}

		if ($this->format != "" && $this->format == strtolower($this->format)) {
			//если формат файла в нижнем регистре, пишем в данные только 1 байт
			$nf = $this->getFormat($this->format);
			if ($nf !== false) {
				$this->formatFrom = $nf;
				$this->format = "";
			}
		}

		$code = $this->encode();
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
