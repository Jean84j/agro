<?php

use common\models\ActivePages;
use yii\helpers\Html;
use yii\helpers\Url;

ActivePages::setActiveUser();

?>
<div class="scene">
    <main class="stage" id="stage">

        <!-- robot -->
        <div class="robot" id="robot" data-mood="idle">

            <div class="bubble" id="bubble" role="status" aria-live="polite">
                <span id="bubbleText">Привіт! Я Вольт. Я охороняю цю форму.</span>
            </div>

            <div class="antenna" aria-hidden="true">
                <span class="antenna-rod"></span>
                <span class="antenna-tip"></span>
            </div>

            <div class="head3d" aria-hidden="true">
                <div class="head" id="head">
                    <span class="ear ear--l"></span>
                    <span class="ear ear--r"></span>

                    <!-- front -->
                    <div class="face face--front">
                        <div class="visor">
                            <div class="eyes" id="eyes">
                                <span class="eye eye--l"></span>
                                <span class="eye eye--r"></span>
                            </div>
                            <span class="cheek cheek--l"></span>
                            <span class="cheek cheek--r"></span>
                            <span class="mouth"></span>
                        </div>
                    </div>

                    <!-- back -->
                    <div class="face face--back">
                        <div class="panel">
                            <span class="panel-lights"><i></i><i></i><i></i></span>
                            <div class="meter" id="meter">
                                <i></i><i></i><i></i><i></i>
                            </div>
                            <p class="panel-label" id="panelLabel">НЕ ДИВЛЮСЯ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="login-form" class="card" action="<?= Url::to(['site/login']) ?>" method="post" novalidate>
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                   value="<?= Yii::$app->request->getCsrfToken() ?>">

            <span class="hand hand--l" aria-hidden="true"></span>
            <span class="hand hand--r" aria-hidden="true"></span>

            <h1 class="title">Біп-буп. Хто там йде?</h1>

            <label class="field">
                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4.5 4.5 0 1 0-4.5-4.5A4.5 4.5 0 0 0 12 12Zm0 2c-3.9 0-8 2-8 5v1.5h16V19c0-3-4.1-5-8-5Z"/></svg>
                <input
                        type="text"
                        id="name"
                        name="LoginForm[username]"
                        value="<?= Html::encode($model->username) ?>"
                        placeholder="Ваше ім'я"
                        autocomplete="username"
                        aria-label="Your name"
                        required
                >
            </label>

            <label class="field">
                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V7a5 5 0 0 0-5-5Zm-3 8V7a3 3 0 0 1 6 0v3H9Zm3 4a2 2 0 0 1 1 3.7V19h-2v-1.3a2 2 0 0 1 1-3.7Z"/></svg>
                <input
                        type="password"
                        id="password"
                        name="LoginForm[password]"
                        placeholder="Суперсекретний пароль"
                        autocomplete="current-password"
                        aria-label="Password"
                        required
                >
                <button class="peek" id="togglePass" type="button" aria-label="Show password" aria-pressed="false">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5c-5 0-9.3 3.1-11 7.5C2.7 16.9 7 20 12 20s9.3-3.1 11-7.5C21.3 8.1 17 5 12 5Zm0 12.5a5 5 0 1 1 5-5 5 5 0 0 1-5 5Zm0-8a3 3 0 1 0 3 3 3 3 0 0 0-3-3Z"/></svg>
                </button>
            </label>

            <button class="btn-robot" id="loginBtn" type="submit">
                <span class="btn-bolt" aria-hidden="true">⚡</span>
                <span class="btn-label" id="btnLabel">УВІЙТИ ДО КАБІНЕТУ</span>
            </button>

            <span class="foot foot--l" aria-hidden="true"></span>
            <span class="foot foot--r" aria-hidden="true"></span>
        </form>
    </main>
</div>
