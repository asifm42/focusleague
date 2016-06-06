<?php

/*
|--------------------------------------------------------------------------
| Delete form macro
|--------------------------------------------------------------------------
|
| This macro creates a form with only a submit button.
| We'll use it to generate forms that will post to a certain url with the DELETE method,
| following REST principles.4
|
| See: http://blog.elenakolevska.com/restful-deleting-in-laravel/
|
*/

Form::macro('delete',function($url, $button_label='Delete', $form_parameters = array(),$button_options=array()){

    $id = str_random(8);

    if(empty($form_parameters)){
        $form_parameters = array(
            'method'=>'DELETE',
            'class' =>'delete-form',
            'url'   =>$url,
            'id'    =>$id
            );
    } else {
        $form_parameters['url']     = $url;
        $form_parameters['method']  = 'DELETE';
        $form_parameters['id']      = $id;
    };

    if(empty($button_options)) {
        $button_options['class'] = 'btn btn-danger';
    }

    return Form::open($form_parameters)
            . '<button class ="' . $button_options['class'] . '" type="submit" form='. $id .' value="Submit" aria-label="delete">'
            . '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
            . '<span class="sr-only">' . $button_label . '</span>'
            . '</button>'
            . Form::close();

});