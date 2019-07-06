<?php

use Phinx\Migration\AbstractMigration;

class Initialisation extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sqlFile = fopen(__DIR__.'/initialisation.sql', 'rb');
        while($query = fgets($sqlFile)) {
            if ($query !== "\n") {
                $this->query($query);
            }
        }

        $sqlFile = fopen(__DIR__.'/cities.sql', 'rb');
        while($query = fgets($sqlFile)) {
            if ($query !== "\n") {
                $this->query($query);
            }
        }

        $date = new \DateTime('2019-01-01');
        $day = 0;
        while ($day < 3653) {
            $this->query("INSERT INTO jlm_core_calendar (dt) VALUES ('{$date->format('Y-m-d')}');");
            $date->modify('+1 day');
            $day++;
        }
    }
}
