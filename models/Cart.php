<?php
/**
 * Created by PhpStorm.
 * User: Иван
 * Date: 13.06.2017
 * Time: 17:54
 */

namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public function addToCart($product, $qty = 1)
    {
            // Если товар есть в корзине, то добавляем количество  $qty
        if (isset($_SESSION['cart'][$product->id])) {
                // Обращаемся к свойству массива и увеличиваем его значение на количество  $qty  заданное пользователем
            $_SESSION['cart'][$product->id]['qty'] += $qty;
        } else {
                // Если товара в корзине еще нет, то мы его добавляем в массив корзины
            $_SESSION['cart'][$product->id] = [
                'qty' => $qty,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $product->img
            ];
        }
            // В сессии кроме массивов товаров будут еще 2 значения  $qty - кол-во товаров   и  $sum  общая сумма.
            // Если в сесии есть   cart.qty  то   cart.qty увеличиваем  на  $qty , а если создается первый товар, то просто кладем это количество
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;
    }

    public function recal($id)
    {
            // проверка на существование
        if (!isset($_SESSION['cart'][$id])) return false;
        $qtyMinus = $_SESSION['cart'][$id]['qty'];
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.qty'] -= $qtyMinus;
        $_SESSION['cart.sum'] -= $sumMinus;
        unset($_SESSION['cart'][$id]);
    }
}