<?php

require 'PayPal/autoload.php';
define('URL_SITIO', 'http://localhost/gdlwebcam');

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        /**CLIENTE ID */
        'AVP_jPzTEXG__z1JIota3lj8mPU1ASTfNsni-1Io5VbM5pckIjXXn4in3M5c0MtWYl1nMnfWQ3r2_Bgs',
        /**SECRET */
        'EMpTm_A_-hRTmKrd-fnQNA34tzYKexufSodcQiMRgnKPyIueT4DKlhwtpEn5foQQ7unlGSgvpWGQbc6-'
    )

);

