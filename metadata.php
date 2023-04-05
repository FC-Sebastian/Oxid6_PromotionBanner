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
        'article_banner'     => \seb\banner\Controller\Admin\ArticleBannerController::class,
    ],
    'templates'   => [
        'article_banner.tpl'      => 'seb/banner/views/admin/tpl/article_banner.tpl',
    ],
    'blocks'      => [
        [
            'template' => 'layout/page.tpl',
            'block'    => 'content_main',
            'file'     => 'views/blocks/banner.tpl'
        ],
    ],
    'events'      => [
        'onActivate' => 'seb\banner\Core\Events\Setup::onActivate',
    ],
    'extend'      => [
        \OxidEsales\Eshop\Application\Model\Article::class => \seb\banner\Model\Article::class,
        \OxidEsales\Eshop\Core\UtilsFile::class            => \seb\banner\Core\UtilsFile::class
    ]
];