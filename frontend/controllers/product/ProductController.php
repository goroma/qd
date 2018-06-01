<?php
namespace frontend\controllers\product;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

use frontend\models\product\Product;

/**
 * productCategory controller
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['dashboard'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['dashboard'],
            'rules' => [
                [
                    'actions' => ['dashboard'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * 按层级获取分类下的商品.
     */
    public function actionGetProducts()
    {
        $products = [];
        $post = Yii::$app->request->post();
        $catId = empty($post['catId']) ? null : $post['catId'];
        $subcatId = empty($post['subcatId']) ? null : $post['subcatId'];
        $thirdcatId = empty($post['thirdcatId']) ? null : $post['thirdcatId'];

        if ($catId != null) {
            $products = Product::getProductListByCategory($catId, $subcatId, $thirdcatId);

            //$productsArray = ArrayHelper::map($products, 'id', 'product_name');

            //foreach ($productsArray as $id => $productName) {
                //$out[$id]['id'] = $id;
                //$out[$id]['name'] = $productName;
            //}
        }

        return $products;
    }
}
