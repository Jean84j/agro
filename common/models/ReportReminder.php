<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "report_reminder".
 *
 * @property int $id
 * @property int|null $report_id
 * @property int|null $date
 * @property string|null $event
 * @property int|null $status
 * @property string|null $comment
 */
class ReportReminder extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_reminder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_id', 'date', 'status'], 'integer'],
            [['event', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'report_id' => 'Report ID',
            'date' => 'Date',
            'event' => 'Event',
            'status' => 'Status',
            'comment' => 'Comment',
        ];
    }

    public function getReport()
    {
        return $this->hasOne(Report::class, ['id' => 'report_id']);
    }
}
