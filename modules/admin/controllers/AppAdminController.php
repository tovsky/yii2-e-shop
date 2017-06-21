<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
//use yii\filters\AccessControl;

class AppAdminController extends Controller
{
        // Будем использовать поведение
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@']
//                    ]
//                ]
//            ]
//        ];
//    }

    // в контроллере OrderController там у нас имеется  свой behaviors и он переписывает наш.
    //  Но здесь также есть  behaviors   и он перепишет родительский. Поэтому перенесен
    //  в
}

