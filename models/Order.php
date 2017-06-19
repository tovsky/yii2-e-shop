<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
    // Также будет использоваться поведение
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $qty
 * @property double $sum
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 */
class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()     // Данный метод должен нам возвращать массив с конфигурацией нашего поведения.
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                        // Поведение будет срабатывать перед вставкой в поля 'created_at', 'updated_at'
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        // Здесь поведение будет срабатывать перед обновлением  поля  'updated_at'
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                        // Поведение TimestampBehavior заполняет обозначенные поля меткой времени UNIX (по умолчанию)
                ],
                'value' => new Expression('NOW()'),     // Чтобы время было понятного для нас формата
            ],
        ];
    }

    public function getOrderItems()
    {
            // Связь один ко многим. Один заказ может иметь много заказанных товаров внутри себя
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'address'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['qty'], 'integer'],
            [['sum'], 'number'],
            [['status'], 'boolean'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     * Ниже поля как они будут называться в нашей форме
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'address' => 'Адрес',
        ];
    }
}
