<?php
namespace frontend\controllers;

use frontend\models\Objects;
use yii\web\Controller;

class ElasticController extends Controller
{

    public function actionIndex()
    {

        $elastic        = new Objects();
        $elastic->name  = 'stan';
        $elastic->parent = 36;
        if ($elastic->insert()) {
            echo "Added Successfully";
        } else {
            echo "Error";
        }

    }

}