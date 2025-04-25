<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



/** @var yii\web\View $this */
/** @var app\modules\shorts\models\Link $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="link-form">


    <?php 
    
    $form = ActiveForm::begin(['id'=>'link-form']); ?>

    <?= $form->field($model, 'url', ['enableAjaxValidation' => true, 'validateOnBlur'=> false, 'validateOnChange'=> false,])->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Ok', ['class' => 'btn btn-success', 'id' => 'submit-button']) ?>
    </div>

    

    <?php ActiveForm::end(); 
       
    ?>
    <div id="short_res"></div>

</div>

<?php
$js = <<<JS
    $('#link-form').on('beforeSubmit', function(){
        /*
        var data = $(this).serialize();
        var serv = $(this)[0].action;
        //alert(serv);
        //console.log(serv);
        $.ajax({
            url: serv,
            type: 'POST',
            data: data,
            success: function(res){
                console.log(res);
                if(res.id) {
                    var short_link = res.short_url;
                    //$('#short_res').append(short_link);                    
                    //$('#submit-button').hide();
                    //return false;
                }
            },
            error: function(){
                alert('Error!');
            }
        });
*/
        return false;
    });
JS;


$js2 = "$('#link-form').on('ajaxComplete', function (event, jqXHR, textStatus) {//
//alert(JSON.stringify(jqXHR));
console.log(jqXHR.responseText);

var res = jqXHR.responseJSON;

if(res.id) {
                    var short_link = res.short_url;
                    $('#short_res').html(short_link);                    
                    $('#submit-button').hide();
                    
                }

event.preventDefault();
return false;

});
";
 
$this->registerJs($js2);
$this->registerJs($js);
?>
