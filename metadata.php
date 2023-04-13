<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.1';
/**
 * Module information
 */
$aModule = [
    'id'          => 'fcSeb_banner',
    'title'       => 'Banner placeholder title',
    'description' => 'placeholder description or this module',
    'version'     => '1.0',
    'author'      => 'FC-Sebastian',
    'controllers' => [
        'seb_base'            => \fcSeb\banner\Controller\Admin\SebBaseController::class,
        'article_banner'      => \fcSeb\banner\Controller\Admin\ArticleBannerController::class,
        'category_banner'     => \fcSeb\banner\Controller\Admin\CategoryBannerController::class,
        'manufacturer_banner' => \fcSeb\banner\Controller\Admin\ManufacturerBannerController::class
    ],
    'templates'   => [
        'article_banner.tpl'      => 'fcSeb/banner/views/admin/tpl/article_banner.tpl',
        'category_banner.tpl'     => 'fcSeb/banner/views/admin/tpl/category_banner.tpl',
        'manufacturer_banner.tpl' => 'fcSeb/banner/views/admin/tpl/manufacturer_banner.tpl'
    ],
    'blocks'      => [
        [
            'template' => 'layout/page.tpl',
            'block'    => 'content_main',
            'file'     => 'views/blocks/banner.tpl'
        ],
    ],
    'events'      => [
        'onActivate' => 'fcSeb\banner\Core\Events\Setup::onActivate',
    ],
    'extend'      => [
        \OxidEsales\Eshop\Core\UtilsPic::class                  => \fcSeb\banner\Core\UtilsPic::class,
        \OxidEsales\Eshop\Core\UtilsFile::class                 => \fcSeb\banner\Core\UtilsFile::class,
        \OxidEsales\Eshop\Application\Model\Article::class      => \fcSeb\banner\Model\Article::class,
        \OxidEsales\Eshop\Application\Model\Category::class     => \fcSeb\banner\Model\Category::class,
        \OxidEsales\Eshop\Application\Model\Manufacturer::class => \fcSeb\banner\Model\Manufacturer::class,

    ]
];