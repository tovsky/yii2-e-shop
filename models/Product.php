<?php
/**
 * Created by PhpStorm.
 * User: PavelL
 * Date: 01.06.2017
 * Time: 13:55
 */

namespace app\models;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function getCategory()       // Образуем связь с таблицей категории
    {
        return $this->hasOne(Category::className(), ['id' =>'category_id']);       // Один продукт может иметь только одну  категорию. Связь hasOne
                                                                                    // В таблице категории поле id связано с полем категории-айди  таблицы Продукты
    }
}