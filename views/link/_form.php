<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\modules\shorts\models\Link $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="link-form">


    <?php $form = ActiveForm::begin(['id'=>'link-form']); ?>

    <?= $form->field($model, 'url', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Ok', ['class' => 'btn btn-success', 'id' => 'submit-button']) ?>
    </div>

    

    <?php ActiveForm::end(); 

    ?>
    <div id="short_res"></div>

</div>

<?php
$js = <<<JS
    $('form').on('Submit', function(){//beforeSubmit
        alert('Работает!');

        var data = $(this).serialize();
        var serv = $(this)[0].action;
        //alert(serv);
        console.log(serv);
        $.ajax({
            url: serv,
            type: 'POST',
            data: data,
            success: function(res){
                //console.log(res);
                //var short_link = '<a href="/shorts/goto/'+ res + '}">short_url</a>';
                //$('#short_res').append(short_link );
                
                $('#submit-button').hide();
                $('#short_res').append(res );
            },
            error: function(){
                alert('Error!');
            }
        });

        return false;
    });
JS;
 
$this->registerJs($js);
?>
