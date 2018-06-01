<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;
use yii\web\JsExpression;

// widget with default options
echo Dialog::widget();
?>

<?php
// buttons for testing the krajee dialog boxes
$btns = <<< HTML
<button type="button" id="btn-alert" class="btn btn-info">Alert</button>
<button type="button" id="btn-confirm" class="btn btn-warning">Confirm</button>
<button type="button" id="btn-prompt" class="btn btn-primary">Prompt</button>
<button type="button" id="btn-dialog" class="btn btn-default">Dialog</button>
HTML;
echo $btns;

// javascript for triggering the dialogs
$js = <<< JS
$("#btn-alert").on("click", function() {
    krajeeDialog.alert("This is a Krajee Dialog Alert!")
});
$("#btn-confirm").on("click", function() {
    krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
        if (result) {
            alert('Great! You accepted!');
        } else {
            alert('Oops! You declined!');
        }
    });
});
$("#btn-prompt").on("click", function() {
    krajeeDialog.prompt({label:'Provide reason', placeholder:'Upto 30 characters...'}, function (result) {
        if (result) {
            alert('Great! You provided a reason: ' + result);
        } else {
            alert('Oops! You declined to provide a reason!');
        }
    });
});
$("#btn-dialog").on("click", function() {
    krajeeDialog.dialog(
        'This is a <b>custom dialog</b>. The dialog box is <em>draggable</em> by default and <em>closable</em> ' +
        '(try it). Note that the Ok and Cancel buttons will do nothing here until you write the relevant JS code ' +
        'for the buttons within "options". Exit the dialog by clicking the cross icon on the top right.',
        function (result) {alert(result);}
    );
});
JS;

// register your javascript
$this->registerJs($js);
?>
<?php
// widget with advanced custom options
echo Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'options' => [  // customized BootstrapDialog options
        'size' => Dialog::SIZE_LARGE, // large dialog text
        'type' => Dialog::TYPE_SUCCESS, // bootstrap contextual color
        'title' => 'My Dialog',
        'message' => 'This is an entirely customized bootstrap dialog from scratch. Click buttons below to test this:',
        'buttons' => [
            [
                'id' => 'cust-btn-1',
                'label' => 'Button 1',
                'action' => new JsExpression("function(dialog) {
                    dialog.setTitle('Title 1');
                    dialog.setMessage('This is a custom message for button number 1');
                }"),
            ],
            [
                'id' => 'cust-btn-2',
                'label' => 'Button 2',
                'action' => new JsExpression("function(dialog) {
                    dialog.setTitle('Title 2');
                    dialog.setMessage('This is a custom message for button number 2');
                }"),
            ],
            [
                'id' => 'cust-btn-3',
                'label' => 'Begin Loading',
                'action' => new JsExpression("function(dialog) {
                    // 'this' here is a jQuery object wrapping the <button> DOM element.
                    var button = this;
                    dialog.setTitle('Loading...');
                    dialog.setMessage('Content loading. Wait...');
                    button.disable();
                    button.spin();
                    dialog.setClosable(false);
                }"),
            ],
            [
                'id' => 'cust-btn-4',
                'label' => 'End Loading',
                'action' => new JsExpression("function(dialog) {
                    // get loading button
                    var button = dialog.getButton('cust-btn-3');
                    button.enable();
                    button.stopSpin();
                    dialog.setTitle('Information');
                    dialog.setMessage('Loading Complete.');
                    dialog.setClosable(true);
                }"),
            ],
        ],
    ],
]);

// button for testing the custom krajee dialog box
echo '<button type="button" id="btn-custom" class="btn btn-success">Custom Dialog</button>';

// javascript for triggering the dialogs
$js = <<< JS
$("#btn-custom").on("click", function() {
    krajeeDialogCust.dialog(
        "Welcome to a customized Krajee Dialog! Click the close icon on the top right to exit.",
        function(result) {
            // do something
            //console.log(result);
            //krajeeDialog.alert("测试测试测试测试！")
            alert('test');
        }
    );
});
JS;

// register your javascript
$this->registerJs($js);
?>
