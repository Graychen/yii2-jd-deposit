<?php

namespace backend\controllers;

use Yii;
use common\models\OrderDeposit;
use common\models\Order;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\SearchDeposit;
use GuzzleHttp\Client;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class DepositController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionGame()
    {
        $params = Yii::$app->request->getBodyParams();
        $client = new Client();
        $data = base64_encode(json_encode(['orderId' =>$params['orderId'],'orderStatus'=>$params['orderStatus']]));
        $allData = [
            'customerId' => getenv('JINDONG_API_CUSTOMERID'),
            'timestamp'=>date("YmdHis"),
            'sign'=>$this->createSign($data),
            'data'=>$data
        ];
        $res = $client->request('POST', 'http://card.jd.com/api/gameApi.action', $allData);
        $body=$res->getBody();
        $arrBody=json_decode($body, true);
        if ($arrBody['retCode']==100) {
            $orderDeposit=OrderDeposit::find()->where(['sn'=>'JD'.$params['orderId']])->one();
            $orderDeposit->status=$params['orderStatus'];
            $orderDeposit->save();
        }
        return $body;
    }

    /**
     * 生成签名验证串sign
     * @param array $params post或get请求的请求参数数组
     * @return string sign签名验证串
     */
    public function createSign($params)
    {
        $data = $params;
        $signStr="customerId=".getenv('JINDONG_API_CUSTOMERID')."&data=".$data."&timestamp=".date("YmdHis")."&".getenv('JINDONG_API_PRIVATEKEY');
        $sign = md5($signStr);
        return $sign;
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchDeposit();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $total=Order::getOrderTotal();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'total'=>$total
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
