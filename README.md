# Yii Other Extensions


## TWebLogRoute
Alternative for CWebLogRoute with button to show the log

## TButtonColumn
Represents a grid view column to extends CButtonColumn ajax functions.

This extension function clones ajax "click" of delete button.
```php
array(
    'class'    => 'ext.TButtonColumn',
    'header'   => 'Actions',
    'template' => '{teste}',
    'buttons'  => array(
        'teste'=> array(
            'url' => 'Yii::app()->controller->createUrl("controller/action",array("id"=>$data->primaryKey))',
            'imageUrl'  => false,
            'label'     => 'Teste',
            'options'   => array(
                'title' => 'Test',
                'ajaxConfirm' => 'Testing', // NEW
                'ajaxClick'   => true,      // NEW
            ),
        ),
    ),
),
```
`ajaxConfirm` => String - Msg to confirm javascript or starting with `js:` make a javascript personalized

`ajaxClick` => Boolean - True => Enable / False => Normal