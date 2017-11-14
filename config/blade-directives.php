<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Directives
    |--------------------------------------------------------------------------
    |
    | This is a list of directives you'd like to register.
    | Use the directive name as key, and a closure.
    |
    */

    'directives' => [

        'select_status' => function($expresion) {
            return admin()->html->selectStatus();
        },
        'submit_loading'=>function($val){
            return admin()->html->submitLoading($val);
        },
        'size_recomendation'=>function($val){
            return admin()->html->size_recomendation($val);
        },

    ],

];
