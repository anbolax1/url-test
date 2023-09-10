<?php
namespace app\commands;

use yii\console\Controller;
use app\models\Url;
use yii\console\ExitCode;

class CheckStatusController extends Controller
{
    public function actionStatistics(): int
    {
        $requests = Url::find()
            ->where(['>', 'updated_at', strtotime('-24 hours')])
            ->andWhere(['!=', 'status_code', 200])
            ->all();

        foreach ($requests as $request) {
            echo "URL: " . $request->url . ", Status Code: " . $request->status_code . "\n";
        }
        return ExitCode::OK;
    }

    public function actionTestUrl(): int
    {
        $requests = Url::find()
            ->where(['<', 'error_count', 5])
            ->all();

        if(empty($requests)){
            echo "URL не найдены";
            return ExitCode::OK;
        }

        foreach ($requests as $request) {
            [$url, $urlStatusCode] = \Yii::$app->Url->checkUrl($request->url);
            echo "URL: " . $url . ", Status Code: " . $urlStatusCode . "\n";
        }
        return ExitCode::OK;
    }
}