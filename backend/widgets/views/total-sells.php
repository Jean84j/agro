<?php

?>

<div class="col-12 col-md-4 d-flex">
    <div class="card saw-indicator flex-grow-1" data-sa-container-query='{"340":"saw-indicator--size--lg"}'>
        <div class="sa-widget-header saw-indicator__header">
            <h2 class="sa-widget-header__title"><?= $title ?></h2>
            <div class="sa-widget-header__actions">
                <div class="dropdown">
                    <button
                            type="button"
                            class="btn btn-sm btn-sa-muted d-block"
                            id="widget-context-menu-1"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-label="More"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="3" height="13" fill="currentColor">
                            <path
                                    d="M1.5,8C0.7,8,0,7.3,0,6.5S0.7,5,1.5,5S3,5.7,3,6.5S2.3,8,1.5,8z M1.5,3C0.7,3,0,2.3,0,1.5S0.7,0,1.5,0 S3,0.7,3,1.5S2.3,3,1.5,3z M1.5,10C2.3,10,3,10.7,3,11.5S2.3,13,1.5,13S0,12.3,0,11.5S0.7,10,1.5,10z"
                            ></path>
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="widget-context-menu-1">
                        <li><a class="dropdown-item" href="/#">Settings</a></li>
                        <li><a class="dropdown-item" href="/#">Move</a></li>
                        <li>
                            <hr class="dropdown-divider"/>
                        </li>
                        <li><a class="dropdown-item text-danger" href="/#">Remove</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="saw-indicator__body">
            <div class="saw-indicator__value">
                <?php if (isset($count)): ?>
                    <?= $sum ?>
                <?php else: ?>
                    <?= Yii::$app->formatter->asCurrency($sum, 'UAH') ?>
                <?php endif; ?>
            </div>
            <?php if ($arrow == 'up') { ?>
                <div class="saw-indicator__delta saw-indicator__delta--rise">
                    <div class="saw-indicator__delta-direction">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                             fill="currentColor">
                            <path d="M9,0L8,6.1L2.8,1L9,0z"></path>
                            <circle cx="1" cy="8" r="1"></circle>
                            <rect
                                    x="0"
                                    y="4.5"
                                    transform="matrix(0.7071 -0.7071 0.7071 0.7071 -2.864 4.0858)"
                                    width="7.1"
                                    height="2"
                            ></rect>
                        </svg>
                    </div>
                    <div class="saw-indicator__delta-value"><?php echo $percentage ?> %</div>
                </div>
            <?php } else { ?>
                <div class="saw-indicator__delta saw-indicator__delta--fall">
                    <div class="saw-indicator__delta-direction">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                             fill="currentColor">
                            <path d="M2.8,8L8,2.9L9,9L2.8,8z"></path>
                            <circle cx="1" cy="1" r="1"></circle>
                            <rect
                                    x="0"
                                    y="2.5"
                                    transform="matrix(0.7071 0.7071 -0.7071 0.7071 3.5 -1.4497)"
                                    width="7.1"
                                    height="2"
                            ></rect>
                        </svg>
                    </div>
                    <div class="saw-indicator__delta-value"><?php echo $percentage ?> %</div>
                </div>
            <?php } ?>
            <div class="saw-indicator__caption">У порівнянні з <?= $formattedDate ?></div>
        </div>
    </div>
</div>
