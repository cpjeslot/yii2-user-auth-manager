<?php

namespace app\modules\auth\controllers;

use Yii;
use app\modules\auth\models\Assignment;
use app\modules\auth\models\search\Assignment as AssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 *
 * @author Chetan Jeslot <cpjeslot@gmail.com>
 * @since 1.0.0
 * 
 */
class AssignmentController extends Controller
{
    public $userClassName;
    public $idField = 'id';
    public $usernameField = 'username';
    public $fullnameField;
    public $searchClass;
    public $extraColumns = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->user->identityClass;
            $this->userClassName = $this->userClassName ? : 'app\modules\auth\models\User';
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'assign' => ['post'],
                    'revoke' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Assignment models.
     * @return mixed
     */
    public function actionIndex()
    {

        if ($this->searchClass === null) {
            $searchModel = new AssignmentSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $this->userClassName, $this->usernameField);
        } else {
            $class = $this->searchClass;
            $searchModel = new $class;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        }

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'idField' => $this->idField,
                'usernameField' => $this->usernameField,
                'extraColumns' => $this->extraColumns,
        ]);
    }

    /**
     * Displays a single Assignment model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
                'model' => $model,
                'idField' => $this->idField,
                'usernameField' => $this->usernameField,
                'fullnameField' => $this->fullnameField,
        ]);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->request->post('items', []);
        $model = new Assignment($id);
        $success = $model->assign($items);
        Yii::$app->response->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionRevoke($id)
    {
        $items = Yii::$app->request->post('items', []);
        $model = new Assignment($id);
        $success = $model->revoke($items);
        Yii::$app->response->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return Assignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $class = $this->userClassName;
        if (($user = $class::findIdentity($id)) !== null) {
            return new Assignment($id, $user);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
