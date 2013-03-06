# Yii Other Extensions

## TWebLogRoute
Alternative for CWebLogRoute with button to show the log

## TButtonColumn
Represents a grid view column to extends CButtonColumn POST ajax functions.
This extension function clones ajax "click" of delete button.
```php
array(
    'class' => 'ext.TButtonColumn',
    'header' => 'Actions',
    'template' =>'{teste}',
    'buttons'=>array(
        'teste'=>array(
            'url'=>'Yii::app()->controller->createUrl("controller/action",array("id"=>$data->primaryKey))',
            'imageUrl' => false,
            'label' => 'Teste',
            'options' => array(
                'title' => 'Test',
                'ajaxClick' => true,        // NEW
                'ajaxConfirm' => 'Testing', // NEW
                'ajaxData' => array(        // NEW
                    'test1Post' => 'dataPostTest', // Raw data
                    'test2Post' => 'js: $(th).data("test")', // JS function to get data
                ),
            ),
        ),
    ),
),
```
<table>
    <thead>
        <tr>
            <td>Option</td>
            <td>Type</td>
            <td>Description</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>`ajaxClick`</td>
            <td>Boolean</td>
            <td>True => Enable (Ajax POST) / False => Normal button (GET)</td>
        </tr>
        <tr>
            <td>`ajaxConfirm`</td>
            <td>String</td>
            <td>
                The confirmation message to be displayed when button is clicked.<br>
                If not set or false, no confirmation message will be displayed.<br>
                If starting with `js:` make a javascript personalized (`this` refers to `<a>` tag).
            </td>
        </tr>
        <tr>
            <td>`ajaxData`</td>
            <td>Array</td>
            <td>
                Aditional Data to send in POST request header (@see CJavaScript::encode())<br>
                (`this` refers to `<a>` tag).
            </td>
        </tr>
    </tbody>
</table>
