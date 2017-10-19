<?php
/**
 * Created by PhpStorm.
 * User: amin__000
 * Date: 10/18/2017
 * Time: 8:46 AM
 */

namespace amintado\pay\controllers;


use yii\filters\VerbFilter;
use yii\web\Controller;

class ManageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'verify' => ['post']
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'pdf', 'save-as-new', 'verify'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }
    public function actionIndex(){
        return 'sgfgdsgv';
    }
}