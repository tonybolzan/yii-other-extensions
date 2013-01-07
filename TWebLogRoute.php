<?php

/**
 * TWebLogRoute
 * 
 * Need jQuery and Toastr
 * 
 * @author Tonin De Rosso Bolzan <admin@tonybolzan.com>
 * @copyright 2012, Odig Marketing Digital <odig.net>
 * @version 0.2
 */

class TWebLogRoute extends CWebLogRoute {

    public function init() {
        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            $css = <<<CSS
.twebLogroute-btn {
    position: fixed;
    margin: 3px;
    right: 0;
    bottom: 0;

    display: inline-block;
    padding: 4px 10px 4px;
    font-size: 13px;
    line-height: 18px;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    
    background-color: #414141;
    background-image: -moz-linear-gradient(top,#555,#222);
    background-image: -ms-linear-gradient(top,#555,#222);
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#555),to(#222));
    background-image: -webkit-linear-gradient(top,#555,#222);
    background-image: -o-linear-gradient(top,#555,#222);
    background-image: linear-gradient(top,#555,#222);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#555555',endColorstr='#222222',GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
    
    border: 1px solid;
    border-color: #222 #222 black;
    border-bottom-color: #B3B3B3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .2),0 1px 2px rgba(0, 0, 0, .05);
    -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,.2),0 1px 2px rgba(0,0,0,.05);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .2),0 1px 2px rgba(0, 0, 0, .05);
    
    z-index: 99999;
}

.twebLogroute-btn,
.twebLogroute-btn:hover
{
    color: white;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    text-decoration: none;
}
CSS;
            
            $js = <<<JS
(function($){
    var log = $('.yiiLog').hide(),
        btn = $(document.createElement('a'));
 
    btn.text("Yii LOG")
       .addClass('twebLogroute-btn')
       .click(function(e){
            log.toggle();
            
            log.is(':visible') && window.scrollTo(0,log.offset().top - 40);

            e.preventDefault();
            e.stopPropagation();
            return false;
        });

    $('body').append(btn);
    
    $('td', log).each( function () {
        if ($(this).text() == "info") {
            var msg = $(this).parent().find('pre').text();
            
            toastr && toastr.info('<pre>'+  msg +'</pre>','Yii LOG');
        }
    });
})(jQuery);
JS;

            Yii::app()->getClientScript()->registerCss('TWebLogRouteCss', $css);
            Yii::app()->getClientScript()->registerScript('TWebLogRouteScript', $js, CClientScript::POS_READY);
        }

        parent::init();
    }

}