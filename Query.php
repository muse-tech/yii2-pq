<?php

declare(strict_types=1);

namespace sammaye\pq;

use Yii;
use yii\db\Connection;
use yii\db\Query as BaseQuery;

class Query extends BaseQuery
{
    /**
     * Starts a batch query.
     *
     * A batch query supports fetching data in batches, which can keep the memory usage under a limit.
     * This method will return a [[BatchQueryResult]] object which implements the [[\Iterator]] interface
     * and can be traversed to retrieve the data in batches.
     *
     * For example,
     *
     * ```php
     * $query = (new Query)->from('user');
     * foreach ($query->batch() as $rows) {
     *     // $rows is an array of 10 or fewer rows from user table
     * }
     * ```
     *
     * @param integer $batchSize the number of records to be fetched in each batch.
     * @param Connection|null $db the database connection. If not set, the "db" application component will be used.
     * @return PagedQueryResult the batch query result. It implements the [[\Iterator]] interface
     * and can be traversed to retrieve the data in batches.
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function batch($batchSize = 100, ?COnnection $db = null, bool $page = true): PagedQueryResult
    {
        /** @var PagedQueryResult */
        return Yii::createObject([
            'class' => PagedQueryResult::class,
            'query' => $this,
            'batchSize' => $batchSize,
            'db' => $db,
            'each' => false,
            'page' => $page
        ]);
    }

    /**
     * Starts a batch query and retrieves data row by row.
     * This method is similar to [[batch()]] except that in each iteration of the result,
     * only one row of data is returned. For example,
     *
     * ```php
     * $query = (new Query)->from('user');
     * foreach ($query->each() as $row) {
     * }
     * ```
     *
     * @param integer $batchSize the number of records to be fetched in each batch.
     * @param Connection|null $db the database connection. If not set, the "db" application component will be used.
     * @return PagedQueryResult the batch query result. It implements the [[\Iterator]] interface
     * and can be traversed to retrieve the data in batches.
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function each($batchSize = 100, ?Connection $db = null, bool $page = true): PagedQueryResult
    {
        /** @var PagedQueryResult */
        return Yii::createObject([
            'class' => PagedQueryResult::class,
            'query' => $this,
            'batchSize' => $batchSize,
            'db' => $db,
            'each' => true,
            'page' => $page
        ]);
    }
}