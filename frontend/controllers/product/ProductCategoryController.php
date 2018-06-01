<?php
namespace frontend\controllers\product;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

use frontend\models\product\ProductCategory;

/**
 * productCategory controller
 */
class ProductCategoryController extends Controller
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
     * 按层级获取所有分类.
     */
    public function actionGetProductCategories()
    {
        $categoriesData = [];
        $categories = ProductCategory::getCategories();
        if ($categories) {
            foreach ($categories as $category) {
                $categoriesData[$category->id]['topCategory'] = $category;

                $subCategories = ProductCategory::getCategories($category->id);
                if ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $categoriesData[$category->id]['categories'][$subCategory->id]['subCategory'] = $subCategory;

                        $thirdCategories = ProductCategory::getCategories($subCategory->id);
                        if ($thirdCategories) {
                            $categoriesData[$category->id]['categories'][$subCategory->id]['thirdCategory'] = $thirdCategories;
                        }
                    }
                }
            }
        }

        return $categoriesData;
    }
}
