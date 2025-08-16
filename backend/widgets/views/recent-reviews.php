<?php

?>
<div class="col-12 col-lg-6 d-flex">
    <div class="card flex-grow-1">
        <div class="card-body">
            <div class="sa-widget-header">
                <h2 class="sa-widget-header__title"><?= $title ?></h2>
                <div class="sa-widget-header__actions">
                    <div class="dropdown">
                        <button
                                type="button"
                                class="btn btn-sm btn-sa-muted d-block"
                                id="widget-context-menu-9"
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
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="widget-context-menu-9">
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
        </div>
        <ul class="list-group list-group-flush">
            <?php foreach ($reviews as $review): ?>
                <li class="list-group-item py-2">
                    <div class="d-flex align-items-center py-3">
                        <a href="/<?= $catalog ?>/<?= $review['slug'] ?>" target="_blank" class="me-4">
                            <div class="sa-symbol sa-symbol--shape--rounded sa-symbol--size--lg">
                                <img src="/<?= $catalogImg ?>/<?= $review['image'] ?>" width="40"
                                     height="40" alt=""/>
                            </div>
                        </a>
                        <div class="d-flex align-items-center flex-grow-1 flex-wrap">
                            <div class="col">
                                <a href="/<?= $catalog ?>/<?= $review['slug'] ?>"
                                   target="_blank"
                                   class="text-reset fs-exact-14"> <?= mb_strlen($review['name']) > 55 ? mb_substr($review['name'], 0, 55) . '...' : $review['name'] ?></a>
                                <div class="text-muted fs-exact-13">
                                    Відгук від
                                    <span class="text-reset" style="padding-right: 10px"><?= $review['fio'] ?></span>
                                    <span class="text-dark"
                                          style="background: #0b5be538; padding: 1px 5px 1px 5px; border-radius: 4px">
                                        <?= Yii::$app->formatter->asDatetime($review['created_at'], 'medium'); ?>
                                    </span>
                                </div>
                            </div>
                            <a style="padding-right: 20px; color: rgba(43,129,195,0.7)" data-bs-toggle="tooltip"
                               data-bs-placement="left"
                               title=" <?= $review['message'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                            </a>
                            <div class="col-12 col-sm-auto">
                                <div class="sa-rating ms-sm-3 my-2 my-sm-0"
                                     style="--sa-rating--value: <?= $review['rating'] / 5 ?> ">
                                    <div class="sa-rating__body"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>