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

use pkgRu\imagerPhp\Imager;

$imager = new Imager;
$group = $imager->clone()->quality(75)->size(150, 150)->trim(true, 10);

echo $group->getConvert("my_path_image.png", "webp"), "\n";  // return: my_path_image/DqcECgCWSwoAlg.webp
echo $group->getConvert("my_path_image2.jpg", "webp"), "\n"; // return: my_path_image2/DqcBCgCWSwoAlg.webp
echo $group->getConvert("my_path_image3.gif", "webp"), "\n"; // return: my_path_image3/DqcDCgCWSwoAlg.webp
echo $group->getConvert("my_path_image3.png", "gif"), "\n";  // return: my_path_image3/DqcEAwCWSwoAlg.gif

?>
```

так-же можно установить нак компонент для Yii

```php
<?php
return [
	'components' => [
		'imager' => [
			'class' => \pkgRu\imagerPhp\ImagerYii::class,
			// можно передать настройки компанента по умолчанию
			// !!!ВНИМАНИЕ: нужно и можно передавать только те параметры,
			// которые разрешены в настройках thumb сервиса Imager
			// по умолчанию thumb = default
			'config' => [
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
	],
];
?>
```

```php
<?php

echo Yii::$app->imager->size(50, 50)->getConvert("my_path_image.png", "webp"), "\n";
// так-же применится установленный ранее размер
echo Yii::$app->imager->quality(60)->getConvert("my_path_image2.jpg", "webp"), "\n";
// так-же применится установленое ранее качество и размер
echo Yii::$app->imager->getConvert("my_path_image3.gif", "webp"), "\n";

// используйте clone() чтобы уникализировать настройки для группы ассетов или для индивидуального ассета
$group = Yii::$app->imager->clone()->size(50, 50)->quality(50);
echo $group->getConvert("my_path_image.png", "webp"), "\n";
echo $group->getConvert("my_path_image2.jpg", "webp"), "\n";

?>
```
[GIT](https://github.com/pkg-ru/imager-php) / [Packagist](https://packagist.org/packages/pkg-ru/imager-php)
