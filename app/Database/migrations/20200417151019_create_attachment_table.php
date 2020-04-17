<?php

use Phinx\Migration\AbstractMigration;

class CreateAttachmentTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html
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
    public function change()
    {
        $attachmentTable = $this->table('attachment');
        $attachmentTable
            ->addColumn('chatId', 'integer')
            ->addColumn('messageId', 'integer', ['null' => true])
            ->addColumn('serverPath', 'string', ['limit' => 255])
            ->addColumn('clientPath', 'string', ['limit' => 255])
            ->addColumn('width', 'integer')
            ->addColumn('height', 'integer')
            ->addColumn('createdAt', 'datetime')
            ->create()
        ;
    }
}
