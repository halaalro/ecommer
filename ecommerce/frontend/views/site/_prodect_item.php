<?php
/** @var common\models\Prodects $model */
use \yii\helpers\StringHelper;

?>
<section class="py-2 h-100  "style="width: 17rem;">

            <div class="card h-100">
                <!-- Product image-->
                <a href="#" class="img-wrapper">
                <img class="card-img-top " src="<?php echo $model->getImageUrl()?>" alt="..." />
                </a>
                <!-- Product details-->
                <div class="card-body p-4">
                    <div class="text-center">
                        <!-- Product name-->
                        <h5 class="card-title ">
                            <a href="#"class="text-dark "><?php echo \yii\helpers\StringHelper::truncateWords( $model->name,7);?></a></h5>
                       
                        <!-- Product price-->
                        <h5><?php echo Yii::$app->formatter->asCurrency($model->price)?></h5>
                    </div>
                    <div class="card-text">
                    <?php echo StringHelper::truncateWords(strip_tags($model->description),count:30)?>

                    </div>
                </div>
                <!-- Product actions-->
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><a class="btn btn-outline-dark mt-auto btn-add-to-cart"
                     href="<?php echo \yii\helpers\Url::to(['/cart/add'])?>">Add to Cart</a></div>
                </div>
            </div>

</section>
