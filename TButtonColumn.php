<?php

/**
 * TButtonColumn class file.
 *
 * @author Tonin de Rosso Bolzan <admin@tonybolzan.com>
 * @copyright 2013, tonybolzan.com
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * 
 * @version 1.2
 */
Yii::import('zii.widgets.grid.CButtonColumn');

/**
 * TButtonColumn Represents a grid view column to extends CButtonColumn POST ajax functions.
 * This extension function clones ajax "click" of delete button.
 *
 * array(
 *     'class' => 'ext.TButtonColumn',
 *     'header' => 'Actions',
 *     'template' =>'{teste}',
 *     'buttons'=>array(
 *         'teste'=>array(
 *             'url'=>'Yii::app()->controller->createUrl("controller/action",array("id"=>$data->primaryKey))',
 *             'imageUrl' => false,
 *             'label' => 'Teste',
 *             'options' => array(
 *                 'title' => 'Test',
 *                 'ajaxClick' => true,        // NEW v1.0
 *                 'ajaxConfirm' => 'Testing', // NEW v1.0
 *                 'ajaxSuccess' => 'js: $.fn.yiiGridView.update("other-grid");', // NEW v1.2
 *                 'ajaxData' => array(        // NEW v1.1
 *                     'test1Post' => 'dataPostTest', // Raw data
 *                     'test2Post' => 'js: $(th).data("test")', // JS function to get data
 *                 ),
 *             ),
 *         ),
 *     ),
 * ),
 * 
 * ajaxClick
 *  Boolean
 *      True => Enable (Ajax POST) / False => Normal button (GET)
 * 
 * ajaxConfirm
 *  String
 *      The confirmation message to be displayed when button is clicked.
 *      If not set or false, no confirmation message will be displayed.
 *      If starting with `js:` make a javascript personalized
 *      `this` refers to <a> tag
 * 
 * ajaxSuccess
 *  String
 *      Must start with `js:` to make a custom javascript
 *      `th` refers `this` of the <a> tag
 * 
 * ajaxData
 *  Array
 *      Aditional Data to send in POST request header @see CJavaScript::encode()
 *      `this` refers to <a> tag
 */
class TButtonColumn extends CButtonColumn {

    /**
     * Initializes the column.
     * This method registers necessary client script for the button column.
     */
    public function init() {
        
        foreach ($this->buttons as $id => &$button) {
            if (isset($button['options']['ajaxClick']) and $button['options']['ajaxClick']) {
                
                $data = (isset($button['options']['ajaxData']) and is_array($button['options']['ajaxData'])) ? $button['options']['ajaxData'] : array();
                $confirmation = isset($button['options']['ajaxConfirm']) ? $button['options']['ajaxConfirm'] : false;
                $success = isset($button['options']['ajaxSuccess']) ? $button['options']['ajaxSuccess'] : false;
                
                unset($button['options']['ajaxClick']);
                unset($button['options']['ajaxData']);
                unset($button['options']['ajaxConfirm']);
                unset($button['options']['ajaxSuccess']);
                
                $this->initAjaxClickButtons($id, $data, $confirmation, $success);
            }
        }

        parent::init();
    }

    protected function initAjaxClickButtons($button_id, $data = array(), $confirmation = false, $success = false) {
        if (is_string($confirmation)) {
            $jsConfirmation = "if(!confirm(" . CJavaScript::encode($confirmation) . ")) return false;";
        } else {
            $jsConfirmation = '';
        }
        
        if (is_string($success)) {
            $jsSuccess = CJavaScript::encode($success) . ";";
        } else {
            $jsSuccess = '';
        }

        if (Yii::app()->request->enableCsrfValidation) {
            $data[Yii::app()->request->csrfTokenName] = Yii::app()->request->csrfToken;
        }

        if($data) {
            $jsData = ' data:' . CJavaScript::encode($data) . ', ';
        } else {
            $jsData = '';
        }
        
        $this->buttons[$button_id]['click'] = <<<JS
function() {
    if(this.classList.contains('disabled') || this.disabled) return false;
    $jsConfirmation
    var th=this;
    $.fn.yiiGridView.update('{$this->grid->id}', {
        type: 'POST',
        url: $(this).attr('href'),$jsData
        success: function(data) {
            $.fn.yiiGridView.update('{$this->grid->id}');
            $jsSuccess
        }
    });
    return false;
}
JS;
    }

}