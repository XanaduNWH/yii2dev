<?php

namespace common\models;

use yii\db\Migration;

class myMigration extends Migration
{
	const TYPE_TIMESTAMPTZ = 'timestamptz';

	public function timestamptz($precision = null) {
		return $this->getDb()->getSchema()->createColumnSchemaBuilder(self::TYPE_TIMESTAMPTZ, $precision);
	}

    /**
     * Builds and executes a SQL statement for creating a unique key.
     * The method will properly quote the table and column names.
     * @param string $name the name of the primary key constraint.
     * @param string $table the table that the primary key constraint will be added to.
     * @param string|array $columns comma separated string or array of columns that the primary key will consist of.
     */
    public function addUniqueKey($name, $table, $columns)
    {
		$string = NULL;
		if (is_array($columns)) {
			$string = '"'.implode('","', $columns).'"';
		} else {
			$string = $columns;
		}
        echo "    > add unique key $name on $table (" . (is_array($columns) ? implode(',', $columns) : $columns) . ') ...';
        $time = microtime(true);
        $this->db->createCommand()->setSql('ALTER TABLE ' . $this->db->quoteTableName($table) . ' ADD CONSTRAINT "'. $name .'" UNIQUE ('.$string.');')->execute();
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }
}
