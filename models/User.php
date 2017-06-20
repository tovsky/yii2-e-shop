<?php

namespace app\models;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
            // Здесь эти свойства больше не нужны, так как ActiveRecord получит поля из БД автоматически
//    public $id;
//    public $username;
//    public $password;
//    public $authKey;
//    public $accessToken;

            // Эти юзеры тоже больше не нужны.
//    private static $users = [
//        '100' => [
//            'id' => '100',
//            'username' => 'admin',
//            'password' => 'admin',
//            'authKey' => 'test100key',
//            'accessToken' => '100-token',
//        ],
//        '101' => [
//            'id' => '101',
//            'username' => 'demo',
//            'password' => 'demo',
//            'authKey' => 'test101key',
//            'accessToken' => '101-token',
//        ],
//    ];

            // метод указывает с какой таблицей будет работать указанная модель.
            // в принципе имя класса совпадает с именем таблицы и ActiveRecord подхватит автоматически
            // но хороший тон явно указать таблицу.
    public static function  tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Этот метод обязаны объявить, но у нас он будет пустым
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
            // поле 'username'  в таблице должно соответствовать тому, что передано в форму пользователем
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
//        return $this->password === $password;
         return \Yii::$app->security->validatePassword($password, $this->password);
    }

        // метод создает случайную строку до 32 символов и записывает его в поле таблицы 
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }
}
