<?php

namespace app\components\url;

use Yii;
use app\models\Url as UrlModel;
use yii\base\BaseObject;
use yii\base\Component;

class Url extends Component
{
    public function checkUrl($url): array
    {
        // Проверка существования URL в таблице
        $model = UrlModel::findOne(['hash_string' => md5($url)]);

        $urlStatusCode = $this->getStatusCode($url);

        if($urlStatusCode != 200) {
            $errorCount = 1;
        } else {
            $errorCount = 0;
        }
        if ($model) {
            // Если прошло более 10 минут с момента последнего обновления
            if (time() - $model->updated_at > 600) {
                // Обновление данных в таблице
                $model->status_code = $urlStatusCode;
                $model->query_count += 1;
                $model->error_count += $errorCount;
                $model->updated_at = time();
                $model->save();
            } else {
                // Получение данных из таблицы
                $urlStatusCode = $model->status_code;
                $queryCount = $model->query_count + 1;

                $model->query_count = $queryCount;
                $model->save();
            }
        } else {
            // Создание новой записи
            $model = new UrlModel();
            $model->hash_string = md5($url);
            $model->created_at = time();
            $model->updated_at = time();
            $model->status_code = $urlStatusCode;
            $model->url = $url;
            $model->query_count = 1;
            $model->error_count += $errorCount;
            $model->save();
        }

        return [$url, $urlStatusCode];
    }

    private function getStatusCode($url): int
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