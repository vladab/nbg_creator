<?php
/**
 * Created by PhpStorm.
 * Date: 15.11.14., 19.01
 */
class Migration_Create_articles extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'content' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('articles');
    }

    public function down()
    {
        $this->dbforge->drop_table('articles');
    }
}