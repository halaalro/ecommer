<?php

namespace common\models;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;


use Yii;

/**
 * This is the model class for table "{{%prodects}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property float $price
 * @property int $status
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Prodects extends \yii\db\ActiveRecord
{const STATUS_UNACTIVE = 0;
    
    
  
    const STATUS_Active = 1;
/**
     * @var yii\web\UploadedFile */
     
    public $imageFile;
    

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%prodects}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','price','status'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 2000],
            [['imageFile'], 'image','extensions'=>'png,jpg,jpeg,webp', 'maxSize' => 10*1024*1024],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Prodect Image',
            'imageFile' => 'Prodect Image',
            'price' => 'Price',
            'status' => 'published',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProdectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProdectsQuery(get_called_class());
    }
    public function getCretedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
    public function getUpdatededBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
    public  function save($runValidation = true , $attributeNames = null)
    {   



        $isInsert=$this->isNewRecord;
        if($isInsert){

            
            $this->created_by=Yii::$app->user->identity->getId();
            $this->updated_by=Yii::$app->user->identity->getId();
          
        }
        if( $this->imageFile){
            $this->image='/prodects/'.Yii::$app->security->generateRandomString(32).'/'.$this->imageFile->name;
        }
        $transaction=Yii::$app->db->beginTransaction();

       $ok= parent::save($runValidation,$attributeNames);

       if($ok && $this->imageFile){
        $fullPath=yii::getAlias('@frontend/web/storage'.$this->image);
        $dir=dirname($fullPath);
        if(!FileHelper::createDirectory($dir) | !$this->imageFile->saveAs($fullPath)){
            $transaction->rollBack();
            return false;


        }
       
       }
       $transaction->commit();
       return $ok;
    }


    public function getImageUrl()
    {
        return self::formatImageUrl($this->image);
        
        //' http://frontend.ecommerce.localhost/img/noimg.svg';
    
      
    }
    public static function formatImageUrl($imagPath)
    {
        if($imagPath){
            return ' http://localhost/ecommerce/frontend/web/storage/'.$imagPath;
              }
             return 'http://localhost/ecommerce/frontend/web/img/notfound.png';
    }
    public function afterDelete()
    {
        parent::afterDelete();
        if ($this->image) {
            $dir = Yii::getAlias('@frontend/web/storage'). dirname($this->image);
            FileHelper::removeDirectory($dir);
        }
    }
    public static function getProdectsLabels()
    {
        return [
            self::STATUS_UNACTIVE => 'Unactive',
            self::STATUS_Active => 'Active',
            
        ];
    }
}
