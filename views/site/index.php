<?php

/* @var $this yii\web\View */
use app\models\CatEvent;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'My Yii Application';

//echo $arrayMainEvents[0]->i_Score;
//echo $arrayMainEvents[1]->i_Score;
//echo $arr//echo $arrayMainEvents[0]->i_Score;ayMainEvents[2]->i_Score;
//echo $arrayMainEvents[3]->i_Score;
//echo $arrayMainEvents[4]->i_Score;
//echo $arrayMainEvents[5]->i_Score;
//echo $arrayMainEvents[6]->i_Score;
//echo $arrayMainEvents[7]->i_Score;
//echo $arrayMainEvents[8]->i_Score;
//echo $arrayMainEvents[9]->i_Score;


//foreach ($arrayMainEvents as $value) {
//    echo $value->i_Score;
//}

?>

<div class="site-index">

    <div class="jumbotron">
        <h1>Eventos principales</h1>
    </div>

    <div class="body-content" align="center">

        <div class="row">
            
            <?php 
                $contador=1;
                foreach ($arrayMainEvents as $value) { ?>
                
            <div class="col-lg-4">
                
                <h2>Evento <?php echo $contador." - ".$value->vc_EventName ?></h2>
                
                <?php 
                         //echo  $arrayMainEvents[$contador-1]->evtImages[0]->vc_DirectoryName
                         if($value->evtImages!=null){
                             //echo $value->evtImages[0]->vc_DirectoryName
                             echo Html::img("@web/files/".$value->evtImages[0]->vc_DirectoryName,['width'=>'340px','height'=>'225px','align'=>'center']);
                         }else{
                             echo Html::img("@web/files/imagenNoDisponible.png",['width'=>'340px','height'=>'225px','align'=>'center']);
                         }
                         
                         ?>
                <p><textarea rows="4" cols="40" readonly style="overflow: hidden; resize: none; border: none; outline: none" ><?php echo  $value->tx_DescriptionEvent;?></textarea></p>
                <p><a class="btn" href="<?php echo Url::to(['cat-event/view','id'=> $value->i_Pk_Event]);?>">Ver más</a></p>
                
            </div>
            
            <?php 
                $contador++;
                } ?>

        </div>

    </div>
</div>
    