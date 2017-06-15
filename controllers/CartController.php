<?php
/**
 * Created by PhpStorm.
 * User: Иван
 * Date: 13.06.2017
 * Time: 17:49
 */

namespace app\controllers;
use app\models\Product;
use app\models\Cart;
use Yii;


class CartController extends AppController
{
    public function actionAdd()
    {
            // получаем id  товара
        $id = Yii::$app->request->get('id');
            // получаем количество
        $qty = (int)Yii::$app->request->get('qty');
        $qty = !$qty ? 1 : $qty;
            // Отладочная печать. Проверяем, что $id имеется.
//        debug($id);
            // Получаем товар по его  id
        $product = Product::findOne($id);
            // Если товара с таким id  нет в БД, то завершаем.
        if (empty($product)) return false;
            // Отладочная печать.
//        debug($product);
        $session = Yii::$app->session;
            // Открытие сессии
        $session->open();
            // Создаем объект нашей модели
        $cart = new Cart();
        $cart->addToCart($product, $qty);
            // Отладочная печать корзины товаров
//        debug($session['cart']);
//        debug($session['cart.qty']);
//        debug($session['cart.sum']);

            // Если мы получаем данные не методом Ajax, то мы делаем редирект на страницу с которой пришел пользователь.
            // то есть получится, что даже если не сработает Ajax, то сработает код выше (товар положится в корзину) и пользователь вернется на страницу с которой пришел
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer);
        }
            // Выставим параметр в  false,  чтобы шаблон не попадал в отображение (хотим выводить просто таблицу)
        $this->layout = false;
            // Рендерим вид и передаем в него нашу переменную с сохраненной в нем сессией
        return $this->render('cart-modal', compact('session'));
    }

    public function actionClear()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem()
    {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
            // Новый объект модели и ее метод рекалькуляция (пересчет)
        $cart = new Cart();
        $cart->recal($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow()
    {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionView()
    {
        return $this->render('view');
    }
}
