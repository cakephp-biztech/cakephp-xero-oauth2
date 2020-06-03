<?php
use Migrations\AbstractMigration;

class CreateXeroOauthTokens extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('xero_oauth_tokens');
        $table->addColumn('access_token', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('tenant_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('refresh_token', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('id_token', 'text', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('expires_at', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
