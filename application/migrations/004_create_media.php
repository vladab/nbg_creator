<?php
/**
 * Created by PhpStorm.
 * Date: 15.11.14., 19.01
 */
class Migration_Create_media extends CI_Migration
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
            'article_id' => array(
                'type' => 'INT',
                'constraint' => '10',
            ),
            'location' => array(
                'type' => 'VARCHAR',
                'constraint' => '200',
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('media');
    }

    public function down()
    {
        $this->dbforge->drop_table('media');
    }
}