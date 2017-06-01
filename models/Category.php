<?php
/**
 * Created by PhpStorm.
 * User: PavelL
 * Date: 01.06.2017
 * Time: 13:55
 */

namespace app\models;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function getProducts()       // Образуем связь с таблицей категории
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);       // 1 категория может содержать  много продуктов. Связь hasMany
    }
}