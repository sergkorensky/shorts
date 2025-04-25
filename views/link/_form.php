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

    <?= $form->field($model, 'url', ['enableAjaxValidation' => true, 'validateOnBlur'=> false, 'validateOnChange'=> false,])->textInput(['maxlength' => true, 'id' => 'link-url']) ?>

    <div class="form-group">
        <?= Html::submitButton('Ok', ['class' => 'btn btn-success',  'id' => 'submit-button']) ?>
    </div>

    

    <?php ActiveForm::end(); 
       
    ?>
    <div id="short_res"></div>
    <div id="qr"></div>

</div>

<?php
$js = <<<JS
    $('#link-form').on('beforeSubmit', function(){
        
        return false;
    });
JS;

$js2 = "$('#link-form').on('ajaxComplete', function (event, jqXHR, textStatus) {
    //alert(JSON.stringify(jqXHR));

    var res = jqXHR.responseJSON;

    if(res.id) {
                    var short_link = res.short_url;
                    $('#short_res').html(short_link);
                    $.ajax({
                        url:res.qr_url, 
                        data:'',
                        success: function(r2){
                            $('#qr').html('<img src=\"'+r2+'\" />');
                        },
                    });


                    $('#submit-button').hide();
                    $('#link-url').on('focus', function(){
                      $(this).blur(); 
                     });
                    
                }

});
";
 
$this->registerJs($js2);
$this->registerJs($js);
?>
