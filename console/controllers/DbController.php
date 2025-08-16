<?php

namespace console\controllers;

use common\models\shop\Product;
use common\models\shop\Review;
use Faker\Factory;
use Yii;
use yii\base\BaseObject;
use yii\console\ExitCode;
use yii\helpers\Console;

class DbController extends \yii\console\Controller
{

    /**
     * Converts tables’ character sets and collations. (MySQL only)
     *
     * Example:
     * ```
     * php craft db/convert-charset utf8 utf8_unicode_ci
     * ```
     *
     * @param string|null $charset The target character set, which honors `DbConfig::$charset`
     *                               or defaults to `utf8`.
     * @param string|null $collation The target collation, which honors `DbConfig::$collation`
     *                               or defaults to `utf8_unicode_ci`.
     * @return int
     */
    public function actionConvertCharset(?string $charset = null, ?string $collation = null): int
    {
        $db = Yii::$app->getDb();

//        if (!$db->getIsMysql()) {
//            $this->stderr('This command is only available when using MySQL.' . PHP_EOL, Console::FG_RED);
//            return ExitCode::UNSPECIFIED_ERROR;
//        }

        $schema = $db->getSchema();
        $tableNames = $schema->getTableNames();

        if (empty($tableNames)) {
            $this->stderr('Could not find any database tables.' . PHP_EOL, Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $dbConfig = Yii::$app->getDb();

        if ($charset === null) {
            $charset = $this->prompt('Which character set should be used?', [
                'default' => $dbConfig->charset ?? 'utf8',
            ]);
        }

        if ($collation === null) {
            $collation = $this->prompt('Which collation should be used?', [
                'default' => $dbConfig->collation ?? 'utf8_unicode_ci',
            ]);
        }

        foreach ($tableNames as $tableName) {
            $tableName = $schema->getRawTableName($tableName);
            $this->stdout('Converting ');
            $this->stdout($tableName, Console::FG_CYAN);
            $this->stdout(' ... ');
            $db->createCommand("ALTER TABLE `$tableName` CONVERT TO CHARACTER SET $charset COLLATE $collation")->execute();
            $this->stdout('done' . PHP_EOL, Console::FG_GREEN);
        }

        $this->stdout("Finished converting tables to $charset/$collation." . PHP_EOL, Console::FG_GREEN);
        return ExitCode::OK;
    }


}