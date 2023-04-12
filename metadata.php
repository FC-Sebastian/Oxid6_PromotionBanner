<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.1';
/**
 * Module information
 */
$aModule = [
    'id'          => 'seb_banner',
    'title'       => 'Banner placeholder title',
    'description' => 'placeholder description or this module',
    'version'     => '1.0',
    'author'      => 'FC-Sebastian',
    'controllers' => [
        'seb_base'            => \fc_seb\banner\Controller\Admin\SebBaseController::class,
        'article_banner'      => \fc_seb\banner\Controller\Admin\ArticleBannerController::class,
        'category_banner'     => \fc_seb\banner\Controller\Admin\CategoryBannerController::class,
        'manufacturer_banner' => \fc_seb\banner\Controller\Admin\ManufacturerBannerController::class
    ],
    'templates'   => [
        'article_banner.tpl'      => 'seb/banner/views/admin/tpl/article_banner.tpl',
        'category_banner.tpl'     => 'seb/banner/views/admin/tpl/category_banner.tpl',
        'manufacturer_banner.tpl' => 'seb/banner/views/admin/tpl/manufacturer_banner.tpl'
    ],
    'blocks'      => [
        [
            'template' => 'layout/page.tpl',
            'block'    => 'content_main',
            'file'     => 'views/blocks/banner.tpl'
        ],
    ],
    'events'      => [
        'onActivate' => 'fc_seb\banner\Core\Events\Setup::onActivate',
    ],
    'extend'      => [
        \OxidEsales\Eshop\Core\UtilsPic::class                  => \fc_seb\banner\Core\UtilsPic::class,
        \OxidEsales\Eshop\Core\UtilsFile::class                 => \fc_seb\banner\Core\UtilsFile::class,
        \OxidEsales\Eshop\Application\Model\Article::class      => \fc_seb\banner\Model\Article::class,
        \OxidEsales\Eshop\Application\Model\Category::class     => \fc_seb\banner\Model\Category::class,
        \OxidEsales\Eshop\Application\Model\Manufacturer::class => \fc_seb\banner\Model\Manufacturer::class,

    ]
];