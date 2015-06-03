<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div style="margin-bottom: 20px;">
        <?= Html::beginForm(['index'], 'get') ?>
             <div style="margin-bottom: 20px;">
                Автор
                <?= Html::activeDropDownList($searchModel, 'author_id', $aAuthor, ['class' => 'form-control', 'style' => 'width: 30%; display: inline-block; margin-right: 20px;']) ?>

                Название книги
                <?= Html::activeInput('text', $searchModel, 'name', ['class' => 'form-control', 'style' => 'width: 30%; display: inline-block; ']) ?>
            </div>

            <div style="margin-bottom: 20px;">
                Дата выхода книги  

                <?= Html::input('text', 'BookSearch[from]', isset($queryParams['BookSearch']['from']) ? $queryParams['BookSearch']['from'] : '', ['class' => 'form-control', 'style' => 'width: 30%; display: inline-block; margin-right: 20px;', 'id' => 'from']) ?> до 
                <?= Html::input('text', 'BookSearch[to]', isset($queryParams['BookSearch']['to']) ? $queryParams['BookSearch']['to'] : '', ['class' => 'form-control', 'style' => 'width: 30%; display: inline-block;', 'id' => 'to']) ?> 

                <?= Html::submitButton('Найти', ['class' => 'btn btn-success submit', 'style' => 'float: right;']) ?>
            </div>

            <div style="clear: right;"></div>
            

        <?= Html::endForm() ?>
    </div>


    <p>
        <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'author_id',
                'value' => 'author.FIO'
            ],            
            'name',
            [
                'attribute' => 'preview',
                'value'=> function($data) { return Html::a(Html::img(Yii::$app->homeUrl.'/uploads/'.$data->preview, ['width'=>'100']), Yii::$app->homeUrl.'/uploads/'.$data->preview, ['rel' => 'fancybox']); },
                'format' => 'raw',
            ],
            [
                'attribute' => 'date_release',
                'value' => 'release'
            ],
            [
                'attribute' => 'date_create',
                'value' => 'create'
            ], 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => 'Просмотр',
                                'class' => 'ajax-view',
                                'data-id' => $key,
                        ]);
                    }
                ],  
            ],
        ],
    ]); ?>

</div>

<div id="book-view"></div>

<script type="text/javascript">
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 2,
      dateFormat: 'dd/mm/yy',
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 2,
      dateFormat: 'dd/mm/yy',
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

    $( "#book-view" ).dialog({
          autoOpen: false,
          modal: true,
          width: 500,
    })

    $('.ajax-view').click(function(e){
        e.preventDefault();
        id = $(this).attr('data-id');

        $.post("<?php echo Url::toRoute(['ajaxview']);?>", {'id' : id}, function(data){
            $('#book-view').empty();
            $(data).appendTo('#book-view');
            $('#book-view').dialog('open');
        });

    });
  </script>


<?php
echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);

?>