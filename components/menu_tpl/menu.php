    <!-- Формирование шаблона для обычного пользовательского меню. -->
<li>
    <a href="<?= \yii\helpers\Url::to(['category/view', 'id' => $category['id']]) ?>">
        <?= $category['name'] ?>                          <!-- Вывод название категории -->
        <?php if (isset($category['childs'])): ?>       <!-- Категорию считаем родительской, если у нее есть свойство  child   -->
            <span class="badge pull-right">
                <i class="fa fa-plus"></i>              <!-- Если категория родительская то выводим  +   -->
            </span>
        <?php endif; ?>
    </a>
    <?php if (isset($category['childs'])): ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']) ?>
        </ul>
    <?php endif; ?>
</li>

