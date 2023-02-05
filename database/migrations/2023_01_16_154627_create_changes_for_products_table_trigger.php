<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * @var string
     */
    protected string $insertChangesTriggerName = 'insert_changes_for_products_table_trigger';

    /**
     * @var string
     */
    protected string $updateChangesTriggerName = 'update_changes_for_products_table_trigger';

    /**
     * @var string
     */
    protected string $deleteChangesTriggerName = 'delete_changes_for_products_table_trigger';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $trackTable = 'tables_changes';
        $insertType = 'insert';
        $updateType = 'update';
        $deleteType = 'delete';
        $table = 'products';

        $insertStatement = "CREATE TRIGGER `{$this->insertChangesTriggerName}` AFTER INSERT ON `$table`
        FOR EACH ROW
            BEGIN
                INSERT INTO `$trackTable`(`type`, `table_name`, `entity_id`, `trigger_name`, `created_at`) VALUES ('$insertType', '$table', NEW.id, '{$this->insertChangesTriggerName}', NOW());
            END";
        DB::statement($insertStatement);

        $updateStatement = "CREATE TRIGGER `{$this->updateChangesTriggerName}` AFTER UPDATE ON `$table`
        FOR EACH ROW
            BEGIN
                INSERT INTO `$trackTable`(`type`, `table_name`, `entity_id`, `trigger_name`, `created_at`) VALUES ('$updateType', '$table', NEW.id, '{$this->updateChangesTriggerName}', NOW());
            END";
        DB::statement($updateStatement);

        $deleteStatement = "CREATE TRIGGER `{$this->deleteChangesTriggerName}` AFTER DELETE ON `$table`
        FOR EACH ROW
            BEGIN
                INSERT INTO `$trackTable`(`type`, `table_name`, `entity_id`, `trigger_name`, `created_at`) VALUES ('$deleteType', '$table', OLD.id, '{$this->deleteChangesTriggerName}', NOW());
            END";
        DB::statement($deleteStatement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(sprintf('DROP TRIGGER `%s`', $this->insertChangesTriggerName));
        DB::statement(sprintf('DROP TRIGGER `%s`', $this->updateChangesTriggerName));
        DB::statement(sprintf('DROP TRIGGER `%s`', $this->deleteChangesTriggerName));
    }
};
