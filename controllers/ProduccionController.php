<?php

namespace app\controllers;

use app\models\Calificacion;
use Yii;
use app\models\Produccion;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\Response;


class ProduccionController extends ActiveController
{
    public $modelClass = 'app\models\Produccion';

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

    public function actionIndex($tipo = null, $orden = null)
    {
        $query = Produccion::find();

        // Filtrar por tipo (película o serie)
        if ($tipo === 'pelicula') {
            $query->where(['tipo' => Produccion::TIPO_PELICULA]);
        } elseif ($tipo === 'serie') {
            $query->where(['tipo' => Produccion::TIPO_SERIE]);
        }

        // Ordenar alfabéticamente y por calificación
        if ($orden === 'alfabetico') {
            $query->orderBy('titulo ASC');
        } elseif ($orden === 'calificacion') {
            $query->orderBy('calificacion_promedio DESC');
        }

        return $query->all();
    }

    public function actionView($id)
    {
        $produccion = Produccion::findOne($id);

        if ($produccion === null) {
            Yii::$app->response->statusCode = 404; // Not Found
            return ['error' => 'Produccion no encontrada'];
        }

        return ['produccion' => $produccion];
    }

    public function actionCreate()
    {
        if (!Yii::$app->user->can('admin')) {
            Yii::$app->response->statusCode = 403; // Forbidden
            return ['error' => 'No tienes permisos para crear producciones'];
        }

        $produccion = new Produccion(['scenario' => Produccion::SCENARIO_CREAR]);

        if ($produccion->load(Yii::$app->request->post()) && $produccion->save()) {
            return ['produccion' => $produccion];
        }

        Yii::$app->response->statusCode = 422; // Unprocessable Entity
        return ['errors' => $produccion->errors];
    }

    public function actionUpdate($id)
{
    if (!Yii::$app->user->can('admin')) {
        Yii::$app->response->statusCode = 403; // Forbidden
        return ['error' => 'No tienes permisos para actualizar producciones'];
    }

    $produccion = Produccion::findOne($id);

    if ($produccion === null) {
        Yii::$app->response->statusCode = 404; // Not Found
        return ['error' => 'Produccion no encontrada'];
    }

    $produccion->scenario = Produccion::SCENARIO_ACTUALIZAR;

    if ($produccion->load(Yii::$app->request->post()) && $produccion->save()) {
        return ['produccion' => $produccion];
    }

    Yii::$app->response->statusCode = 422; // Unprocessable Entity
    return ['errors' => $produccion->errors];
}

public function actionDelete($id)
{
    if (!Yii::$app->user->can('admin')) {
        Yii::$app->response->statusCode = 403; // Forbidden
        return ['error' => 'No tienes permisos para eliminar producciones'];
    }
    $produccion = Produccion::findOne($id);
    if ($produccion === null) {
        Yii::$app->response->statusCode = 404; // Not Found
        return ['error' => 'Produccion no encontrada'];
    }
    if ($produccion->delete()) {
        return ['message' => 'Produccion eliminada exitosamente'];
    }
    Yii::$app->response->statusCode = 500; // Internal Server Error
    return ['error' => 'Hubo un error al eliminar la produccion'];
}

public function actionCalificar($id, $calificacion)
{
    if (!Yii::$app->user->can('usuario')) {
        Yii::$app->response->statusCode = 403; // Forbidden
        return ['error' => 'No tienes permisos para calificar producciones'];
    }

    $produccion = Produccion::findOne($id);
    if ($produccion === null) {
        Yii::$app->response->statusCode = 404; // Not Found
        return ['error' => 'Produccion no encontrada'];
    }

    if (!is_numeric($calificacion) || $calificacion < 1 || $calificacion > 5) {
        Yii::$app->response->statusCode = 400; // Bad Request
        return ['error' => 'La calificación debe ser un número entre 1 y 5'];
    }

    $usuario_id = Yii::$app->user->id;
    $calificacion_existente = Calificacion::findOne(['produccion_id' => $id, 'usuario_id' => $usuario_id]);

    if ($calificacion_existente !== null) {
        $calificacion_existente->puntuacion = $calificacion;
        if ($calificacion_existente->save()) {
            return ['success' => true];
        } else {
            Yii::$app->response->statusCode = 500; // Internal Server Error
            return ['error' => 'Error al guardar la calificación'];
        }
    } else {
        $calificacion_nueva = new Calificacion();
        $calificacion_nueva->produccion_id = $id;
        $calificacion_nueva->usuario_id = $usuario_id;
        $calificacion_nueva->puntuacion = $calificacion;

        if ($calificacion_nueva->save()) {
            return ['success' => true];
        } else {
            Yii::$app->response->statusCode = 500; // Internal Server Error
            return ['error' => 'Error al guardar la calificación'];
        }
    }
}

public function actionReduceString()
{
    // Obtener el string de entrada desde el request HTTP
    $inputString = Yii::$app->request->post('input_string');

    // Realizar la reducción del string
    $reducedString = $inputString;
    $reductionPerformed = true;
    while ($reductionPerformed && !empty($reducedString)) {
        $reductionPerformed = false;
        $i = 0;
        while ($i < strlen($reducedString) - 1) {
            if ($reducedString[$i] === $reducedString[$i + 1]) {
                $reducedString = substr($reducedString, 0, $i) . substr($reducedString, $i + 2);
                $reductionPerformed = true;
            } else {
                $i++;
            }
        }
    }

    // Verificar si el resultado está vacío
    if (empty($reducedString)) {
        $reducedString = "Empty String";
    }

    // Retornar el resultado como JSON
    return $this->asJson(['result' => $reducedString]);
}


}
