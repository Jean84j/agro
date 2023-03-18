<?php
//debug($model);
?>
<!-- site__body -->
<div class="site__body">
    <div class="block about-us">
        <div class="about-us__image"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="about-us__body" style="padding: 14px 92px;">
                        <h1 class="about-us__title" style=" margin-bottom: 30px;"><?=$model->name?></h1>
                        <div class="about-us__text_no_center typography" >
                           <?=$model->description?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- site__body / end -->
