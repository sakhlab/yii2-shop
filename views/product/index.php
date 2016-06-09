<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use pistol88\shop\models\ProductOption;
use pistol88\shop\models\Category;
use pistol88\shop\models\Producer;
use kartik\export\ExportMenu;

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\shop\assets\BackendAsset::register($this);
?>
<div class="product-index">

    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Поступление', Url::toRoute(['/shop/incoming/create']), ['class' => 'btn btn-success']) ?>
    </p>
    
    <div class="export-block">
        <p><strong>Экспорт</strong></p>
        <?php
        $gridColumns = [
            'id',
            'code',
            'category.name',
            'producer.name',
            'name',
            'price',
            'amount',
        ];

        echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
        ]);
        ?>
    </div>
    <br style="clear: both;"></div>
    <?php
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
            'name',
            [
				'attribute' => 'images',
				'format' => 'images',
                'filter' => false,
				'content' => function ($image) {
                    if($image = $image->getImage()->getUrl('50x50')) {
                        return "<img src=\"{$image}\" class=\"thumb\" />";
                    }
				}
			],
			[
				'label' => 'Цена',
				'value' => 'price'
			],
            'amount',
            /*
			[
				'attribute' => 'available',
				'filter' => Html::activeDropDownList(
					$searchModel,
					'available',
					['no' => 'Нет', 'yes' => 'Да'],
					['class' => 'form-control', 'prompt' => 'Наличие']
				),
			],
            */
			[
				'attribute' => 'category_id',
				'filter' => Html::activeDropDownList(
					$searchModel,
					'category_id',
					Category::buildTextTree(),
					['class' => 'form-control', 'prompt' => 'Категория']
				),
				'value' => 'category.name'
			],
			[
				'attribute' => 'producer_id',
				'filter' => Html::activeDropDownList(
					$searchModel,
					'producer_id',
					ArrayHelper::map(Producer::find()->all(), 'id', 'name'),
					['class' => 'form-control', 'prompt' => 'Производитель']
				),
				'value' => 'producer.name'
			],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 125px;']],
        ],
    ]); ?>

</div>
