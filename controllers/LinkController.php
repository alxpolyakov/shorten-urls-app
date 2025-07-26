<?php

namespace app\controllers;
use app\models\Link;
use app\models\Hit;
use yii\helpers\Url;
use Yii;



class LinkController extends \yii\web\Controller
{
    public function actionCreate()
    {
//        var_dump(Yii::$app->request->method);
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if($request->isPost) {
            $longURL = $request->post('long_url');
            $item = Link::findOne(['long_url'=>$longURL]);

            if($item) {
                $session->addFlash('warnings', 'Short link already exists.');
//
                $to = Url::to(['link/view', 'short_url'=>$item->short_url]);

                return $this->redirect($to);
            }
            $errors = [];
            if (!filter_var($longURL, FILTER_VALIDATE_URL)) {
                $errors[] = 'Incorrect URL';
                return $this->render('link/create', ['errors'=>$errors]);
            }

            $segments = parse_url($longURL);
            if(gethostbyname($segments['host']) === $segments['host']){
                $errors[] = 'Cannot resolve host name';
                return $this->render('link/create', ['errors'=>$errors]);
            }
            do{
                $short = Link::generateShortCode();
                $item = Link::find()->where(['short_url'=>$short])->one();
            }while($item !== null);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $longURL);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);

            if (!curl_errno($ch)) {
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            } else {
                $code = 0;
            }
            curl_close($ch);

            /*
             * URL maybe temporally unavailable...
             * >>> Доступность данного ресурса (если не доступен выводим: Данный URL не доступен)
            */
            if($code === 0) {
                $errors[] = 'URL is not available';
                return $this->render('link/create', ['errors'=>$errors]);
            }


            $data = [
                'long_url' =>$longURL,
                'short_url' => $short,
                'hits_count' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'response_code' => $code
            ];
            $item = new Link();
            foreach ($data as $k=>$v){
                $item->$k = $v;
            }

            $item->save(true, array_keys($data));
            return $this->redirect(Url::to(['link/view', 'short_url'=>$item->short_url]));
        }
        return $this->render('create');
    }

    public function actionHit()
    {
        echo 'hit';
        $short_url = Yii::$app->request->get('short_url');
        $item = Link::find()->where(['short_url'=>$short_url])->one();
        if(!$item) {
            throw new \yii\web\NotFoundHttpException("Short url $short_url not found");
        }
        $item->hits_count++;
        $item->save();
        $data = [
            'link_id' => $item->id,
            'ts' => date('Y-m-d H:i:s'),
            'remote_ip' =>Yii::$app->request->getRemoteIP()
        ];
        $hit = new Hit();
        foreach ($data as $k=>$v){
            $hit->$k = $v;
        }
        $hit->save();
        return $this->redirect($item->long_url);
    }

    public function actionView() {
        $request = Yii::$app->request;
        $shortURL = $request->get('short_url');
        $item = Link::find()->where(['short_url'=>$shortURL])->one();
        if ($item === null) {
            throw new \yii\web\NotFoundHttpException("Short url $shortURL not found");
        }
        return $this->render('view', ['item'=>$item]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
