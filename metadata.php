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
        'sebbannercontroller'     => \seb\banner\Controller\Admin\BannerAdminController::class,
        'sebbannerlistcontroller' => \seb\banner\Controller\Admin\BannerAdminListController::class,
        'sebbannerdetailscontroller' => \seb\banner\Controller\Admin\BannerAdminDetailsController::class,
    ],
    'templates'   => [
        'banner_admin.tpl'      => 'seb/banner/views/admin/tpl/banner_admin.tpl',
        'banner_admin_list.tpl' => 'seb/banner/views/admin/tpl/banner_admin_list.tpl',
        'banner_admin_details.tpl' => 'seb/banner/views/admin/tpl/banner_admin_details.tpl',
    ],
    'blocks'      => [
        [
            'template' => 'layout/page.tpl',
            'block'    => 'content_main',
            'file'     => 'views/blocks/banner.tpl'
        ],
        [
            'template' => 'article_main.tpl',
            'block'    => 'admin_article_main_form',
            'file'     => 'views/blocks/admin/article_main.tpl'
        ]
    ],
    'events'      => [
        'onActivate' => 'seb\banner\Core\Events\Setup::onActivate'
    ],
    'extend'      => [
        \OxidEsales\Eshop\Application\Controller\Admin\ArticleMain::class => \seb\banner\Controller\Admin\ArticleMain::class
    ],
];