<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Usuario;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class UsuarioController extends ActiveController
{
    public $modelClass = 'app\models\Usuario';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Configuración CORS
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        // Formateo de respuestas en JSON
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    public function actionIndex()
    {
        $searchModel = new Usuario();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $dataProvider->getModels();
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }
    public function actionCreate()
{
    $model = new Usuario(['scenario' => Usuario::SCENARIO_CREAR]);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $model;
    }

    Yii::$app->response->statusCode = 422; // Unprocessable Entity
    return ['errors' => $model->errors];
}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Usuario::SCENARIO_ACTUALIZAR;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $model;
        }

        Yii::$app->response->statusCode = 422; // Unprocessable Entity
        return ['errors' => $model->errors];
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->response->statusCode = 204; // No Content
        return null;
    }

    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        Yii::$app->response->statusCode = 404; // Not Found
        return ['message' => 'La página solicitada no existe.'];
    }
}
