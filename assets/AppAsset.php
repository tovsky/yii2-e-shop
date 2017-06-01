<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//         'css/site.css',      // Это к оригинальному файлу стилю. Нам не нужно.
//        'css/bootstrap.min.css',
        '/web/css/font-awesome.min.css',
        '/web/css/prettyPhoto.css',
        '/web/css/price-range.css',
        '/web/css/animate.css',
        '/web/css/main.css',
        '/web/css/responsive.css',
    ];
    public $js = [
//        'js/jquery.js',
//        'js/bootstrap.min.js',
        '/web/js/jquery.scrollUp.min.js',
        '/web/js/price-range.js',
        '/web/js/jquery.prettyPhoto.js',
        '/web/js/jquery.cookie.js',                  // Используется для запоминания в куки открытой вкладки акордоена MenuWidget
        '/web/js/jquery.accordion.js',              // Испольльзуется в MenuWidget
        '/web/js/main.js',
    ];
    public $depends = [                     // Здесь указываются зависимости от скриптов.  Yii автоматом должен убедиться, что эти скрипты подключены.
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
