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
    'controllers' => [],
    'templates'   => [],
    'blocks'      => [
        [
            'template' => 'layout/page.tpl',
            'block'    => 'content_main',
            'file'     => 'views/blocks/banner.tpl'
        ]
    ],
    'events'      => [
        'onActivate' => 'seb\banner\Core\Events\Setup::onActivate'
    ]
];