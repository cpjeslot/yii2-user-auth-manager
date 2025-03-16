<?php

namespace app\modules\auth\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * 
 * @author Chetan Jeslot <cpjeslot@gmail.com>
 * @since 1.0.0
 * 
 */
class User extends Model
{
    public $id;
    public $username;
    public $email;
    public $status;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status',], 'integer'],
            [['username', 'email'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /* @var $query \yii\db\ActiveQuery */
        $class = Yii::$app->user->identityClass ? : 'app\modules\auth\models\User';
        $query = $class::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
