# Imager PHP компонент

> Создание ассетов/привью картинок на лету (горячее)
> Для работы нужно настроить и запустить [микро-сервис Imager](https://github.com/pkg-ru/imager)

```bash
php composer.phar require pkg-ru/imager-php:*
```

> **ВНИМАНИЕ**
> нужно и можно передавать только те параметры,
> которые разрешены в настройках `thumb` сервиса Imager
> по умолчанию `thumb` = `default`

```php
<?php

use pkgRu\imagerPhp\NewImage;

$imager = new NewImage;
$imager->quality(75)->size(150, 150)->trim(true, 10);

echo $imager->getConvert("my_path_image.png", "webp"), "\n"; // return uri image to webp format
echo $imager->getConvert("my_path_image2.jpg", "webp"), "\n"; // return uri image to webp format
echo $imager->getConvert("my_path_image3.gif", "webp"), "\n"; // return uri image to webp format
echo $imager->getConvert("my_path_image3.png", "gif"), "\n"; // return uri image to gif format

?>
```

так-же можно установить нак компонент для Yii

```php
<?php
return [
	'components' => [
		'imager' => [
			'class' => \pkgRu\imagerPhp\NewImage::class,
			// можно передать настройки компанента по умолчанию
			// !!!ВНИМАНИЕ: нужно и можно передавать только те параметры,
			// которые разрешены в настройках thumb сервиса Imager
			// по умолчанию thumb = default
			'thumb'      => 'default',
			'color'      => [255, 255, 255],
			'width'      => 150,
			'height'     => 150,
			'quality'    => 85,
			'crop'       => true,
			'loop'       => true,
			'trimActive' => true,
			'trimRate'   => 10,
			'trimColor'  => [[255, 255, 255], [0, 0, 0]],

		],
	],
];
?>
```
