<?php
    // Здесь файл с нашими пользовательскими функциями Его нужно подключить в точке входа   'web/index.php'      require_once __DIR__ . '/../functions.php';

    function debug($arr)            // для лучшей форматированной распечатки массивов объектов
    {
        echo '<pre>' . print_r($arr, true) . '</pre>';
    }



