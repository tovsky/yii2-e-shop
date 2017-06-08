<?php
/**
 * Created by PhpStorm.
 * User: PavelL
 * Date: 07.06.2017
 * Time: 17:30
 */

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class CategoryController extends AppController
{
    public function actionIndex()
    {
        // Переменная $hit обращается к модели  Product (которая ActiveRecord) и выбирает все с условием hit = 1
        // Определенное кол-во limit(6)
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        // debug($hits);   // Распечатка для отладки
        // Значение переменной передаем в вид с помощью ф-ции compact() , но можно массивом.
        // Теперь массив   hits  будет доступен в виде, там можем пройтись по нему циклом и вывести нужные значения.
        return $this->render('index', compact('hits'));
    }
}