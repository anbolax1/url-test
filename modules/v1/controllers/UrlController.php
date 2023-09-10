<?php


namespace app\modules\v1\controllers;

use app\models\Url;
use Yii;
use yii\base\BaseObject;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;

class UrlController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);


        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }*/

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return '1234';
    }

    public function actionCheckStatus()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        try {
            $request = Yii::$app->request;
            $urls = $request->getBodyParams();

            $response = [];

            if(empty($urls)){
                throw new \Exception('Не переданы url!');
            }

            foreach ($urls as $url) {
                [$url, $urlStatusCode] = Yii::$app->Url->checkUrl($url);

                // Формирование ответа в JSON
                $response[] = [
                    'url' => $url,
                    'code' => $urlStatusCode,
                ];
            }
        } catch (\Exception $e) {
            $response[] = [
                'error' => $e->getMessage(),
                'code' => 400,
            ];
        }

        return $response;
    }

    private function getStatusCode($url)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request('GET', $url, ['timeout' => 5]);
            $statusCode = $response->getStatusCode();
        } catch (\GuzzleHttp\Exception\RequestException | \Exception $e) {
            $statusCode = 0;
        }

        return $statusCode;
    }
}