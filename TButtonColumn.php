<?php

/**
 * TButtonColumn class file.
 *
 * @author Tonin de Rosso Bolzan <admin@tonybolzan.com>
 * @copyright 2012, tonybolzan.com
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
Yii::import('zii.widgets.grid.CButtonColumn');

/**
 * TButtonColumn represents a grid view column to extends CButtonColumn ajax functions.
 *
 * This extension function clones ajax "click" of delete button.
 *
 *    array(
 *        'class' => 'ext.TButtonColumn',
 *        'header' => 'Actions',
 *        'template' =>'{teste}',
 *        'buttons'=>array(
 *            'teste'=>array(
 *                'url'=>'Yii::app()->controller->createUrl("controller/action",array("id"=>$data->primaryKey))',
 *                'imageUrl' => false,
 *                'label' => 'Teste',
 *                'options' => array(
 *                    'title' => 'Test',
 *                    'ajaxConfirm' => 'Testing', // NEW
 *                    'ajaxClick' => true,        // NEW
 *                ),
 *            ),
 *        ),
 *    ),
 * 
 * ajaxConfirm
 *     String - Msg to confirm javascript or starting with "js:" make a javascript personalized
 * 
 * ajaxClick
 *     Boolean - Enable/Normal
 * 
 */
class TButtonColumn extends CButtonColumn {

    /**
     * Initializes the column.
     * This method registers necessary client script for the button column.
     */
    public function init() {
        
        foreach ($this->buttons as $id => $button) {
            if (isset($button['options']['ajaxClick']) and $button['options']['ajaxClick']) {
                
                $confirmation = isset($button['options']['ajaxConfirm']) ? $button['options']['ajaxConfirm'] : false;
                
                $this->initAjaxClickButtons($id, $confirmation);
            }
        }

        parent::init();
    }

    protected function initAjaxClickButtons($button_id, $confirmation = false) {
        if (is_string($confirmation)) {
            $confirmation = "if(!confirm(" . CJavaScript::encode($confirmation) . ")) return false;";
        } else {
            $confirmation = '';
        }

        if (Yii::app()->request->enableCsrfValidation) {
            $csrfTokenName = Yii::app()->request->csrfTokenName;
            $csrfToken = Yii::app()->request->csrfToken;
            $csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
        } else {
            $csrf = '';
        }

        $this->buttons[$button_id]['click'] = <<<EOD
function() {
	$confirmation
	var th=this;
	$.fn.yiiGridView.update('{$this->grid->id}', {
		type:'POST',
		url:$(this).attr('href'),$csrf
		success:function(data) {
			$.fn.yiiGridView.update('{$this->grid->id}');
		}
	});
	return false;
}
EOD;
    }

}