<?php

/* @var $this yii\web\View */
use app\models\CatEvent;
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

    <div class="body-content">

        <div class="row">
            
            <?php 
                $contador=1;
                foreach ($arrayMainEvents as $value) { ?>
                
            <div class="col-lg-4">
                <h2>Evento <?php echo $contador ?></h2>

                <p><?php echo  $arrayMainEvents[$contador-1]->tx_DescriptionEvent ?></p>

                
            </div>
            
            <?php 
                $contador++;
                } ?>
            
            
        </div>

    </div>
</div>
