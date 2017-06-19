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
use app\models\OrderItems;
use app\models\Order;
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
        $session = Yii::$app->session;
        $session->open();
        $this->setMeta('Корзина');
        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if ($order->save()) {
                $this->saveOrderItems($session['cart'], $order->id);
                    // Для целостности данных нужно использовать механизм ТРАНЗАКЦИЙ (в этом курсе не рассмотренно)
                Yii::$app->session->setFlash('success', 'Ваш заказ принят. Скоро мы с Вами свяжемся для уточнения деталей.');
                    // Если у нас все сохранено, то перед рефреш, очистим корзину
                    $session->remove('cart');
                    $session->remove('cart.qty');
                    $session->remove('cart.sum');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка оформления заказа.');
            }
        }
        return $this->render('view', compact('session', 'order'));
    }

    protected function  saveOrderItems($items, $order_id)
    {
        foreach ($items as $id => $item) {
                // Мы работаем с моделью Active REcord, каждый объект которой соответствует одной строке в таблице
                // Нам нужно вставить несколько товаров (сделать несколько записей)
                // соответсвенно для каждой записи свой объект
            $order_items = new OrderItems();
            $order_items->order_id = $order_id;
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = $item['qty'] * $item['price'];
            $order_items->save();
        }
    }






}
