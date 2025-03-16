<?php

namespace app\modules\auth\models\search;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use app\modules\auth\components\Configs;
use yii\rbac\Item;

/**
 * 
 * @author Chetan Jeslot <cpjeslot@gmail.com>
 * @since 1.0.0
 * 
 */
class AuthItem extends Model
{
    const TYPE_ROUTE = 101;

    public $name;
    public $type;
    public $description;
    public $ruleName;
    public $data;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ruleName', 'description'], 'safe'],
            [['type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('auth', 'Name'),
            'item_name' => Yii::t('auth', 'Name'),
            'type' => Yii::t('auth', 'Type'),
            'description' => Yii::t('auth', 'Description'),
            'ruleName' => Yii::t('auth', 'Rule Name'),
            'data' => Yii::t('auth', 'Data'),
        ];
    }

    /**
     * Search authitem
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        /* @var \yii\rbac\Manager $authManager */
        $authManager = Configs::authManager();
        $advanced = Configs::instance()->advanced;
        if ($this->type == Item::TYPE_ROLE) {
            $items = $authManager->getRoles();
        } else {
            $items = array_filter($authManager->getPermissions(), function($item) use ($advanced){
              $isPermission = $this->type == Item::TYPE_PERMISSION;
              if ($advanced) {
                return $isPermission xor (strncmp($item->name, '/', 1) === 0 or strncmp($item->name, '@', 1) === 0);
              }
              else {
                return $isPermission xor strncmp($item->name, '/', 1) === 0;
              }
            });
        }
        $this->load($params);
        if ($this->validate()) {

            $search = mb_strtolower(trim((string)$this->name));
            $desc = mb_strtolower(trim((string)$this->description));
            $ruleName = $this->ruleName;
            foreach ($items as $name => $item) {
                $f = (empty($search) || mb_strpos(mb_strtolower($item->name), $search) !== false) &&
                    (empty($desc) || mb_strpos(mb_strtolower($item->description), $desc) !== false) &&
                    (empty($ruleName) || $item->ruleName == $ruleName);
                if (!$f) {
                    unset($items[$name]);
                }
            }
        }

        return new ArrayDataProvider([
            'allModels' => $items,
        ]);
    }
}
