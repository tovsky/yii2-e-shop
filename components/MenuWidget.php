<?php

namespace app\components;
use yii\base\Widget;
use app\models\Category;
use yii;

class MenuWidget extends Widget
{
    public $tpl;        // template От него будет зависеть будет это Категории для внутренней админки, или Посетителя сайта.  Соответсвенно будет или select   или   ul
    public $data;       // В этом свойстве будут храниться все записи категорий из БД.  (ввиде массива).
    public $tree;       // Здесь будет результат функции, которая из обычного массива $data  будет создавать  массив-дерево
    public $menuHtml;   // Здесь будет храниться готовый HTML  код в зависимости от того шаблона, который будет храниться в свойстве  $tpl

    public function init() {
        parent::init();
        if ($this->tpl === null) {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run()
    {
//        $this->data = Category::find()->all();           // в переменной   data  будет массив объектов
//        $this->data = Category::find()->asArray()->all();   // Мы хотим вернуть массив
        // get cache    Пробуем получить информацию из  кеша
        $menu = Yii::$app->cache->get('menu');      // Пытаемся получить данные из кеша по ключу (назовем ключ 'menu')
        if ($menu) return $menu;                    // Если у нас будет что-то получено из кеша, то сразу возвращаем.

        $this->data = Category::find()->indexBy('id')->asArray()->all();   // Мы хотим вернуть массив массивов И чтобы ключи совпадали с идентифкатором (добавили метод ->indexBy()  )
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        //set cache   Формируем кеш
        Yii::$app->cache->set('menu', $this->menuHtml, 60);         // 60 секунд  это время на сколько формируется файл кеша.
                                                                    // в Yii  кеш  хранится в каталоге   'runtime'

//        debug($this->tree);                              // Распечатываем для отладки, просматриваем разные моменты.
        return $this->menuHtml;
    }

    protected function getTree()        // метод проходит в цикле под одномерному массиву и из него строит дерево.
    {
        $tree = [];
        foreach ($this->data as $id=>&$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    protected function getMenuHtml($tree)       // Метод проходится в цикле по дереву. Берет каждый элемент и передает затем параметром
    {
        $str = '';                              // в эту переменную будем помещать готовый HTML код
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category);    //  в метод catToTemplate   каждый элемент дерева передается параметром
        }
        return $str;
    }

    protected function catToTemplate($category)     // Метод принимает параметром переданный элемент, помещает его в шаблон
    {
        ob_start();                                     // Чтобы не происходило вывода в браузер, мы используем буферизацию
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }

}