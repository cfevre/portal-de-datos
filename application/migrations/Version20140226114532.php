<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140226114532 extends AbstractMigration
{
    protected $recursos = array();
    protected $config = array();
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("CREATE TABLE vista_junar (id INT AUTO_INCREMENT NOT NULL, recurso_id INT DEFAULT NULL, junar_guid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, tags VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, meta_data VARCHAR(255) NOT NULL, table_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6E080871E52B6C4E (recurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE vista_junar ADD CONSTRAINT FK_6E080871E52B6C4E FOREIGN KEY (recurso_id) REFERENCES recurso (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE recurso DROP junar_guid");
    }

    public function preUp(Schema $schema)
    {
        require_once APPPATH.'config/config.php';

        if((!isset($config['junar_baseuri']) || empty($config['junar_baseuri'])) || (!isset($config['junar_authkey']) || empty($config['junar_authkey']))){
            echo "No se puede ejecutar la migración, revise la configuración de acceso a la api de Junar.";
            die();
        }

        $this->config = $config;

        global $cli;
        $em = $cli->getHelperSet()->get('em')->getEntityManager();

        $sql = "SELECT r.id AS id, junar_guid, d.id AS dataset_id FROM recurso r LEFT JOIN dataset d ON d.id = r.dataset_id WHERE junar_guid IS NOT NULL AND d.maestro = 1 AND d.publicado = 1";
        $query = $em->getConnection()->prepare($sql);
        $query->execute();

        $this->recursos = $query->fetchAll();
    }


    public function postUp(Schema $schema)
    {
        global $cli;
        $em = $cli->getHelperSet()->get('em')->getEntityManager();

        $sqlInsert = "INSERT INTO vista_junar (recurso_id, junar_guid, title, description, tags, source, category, meta_data, table_id, created_at, updated_at)"
                    ." VALUES (:recurso_id, :junar_guid, :title, :description, :tags, :source, :category, :meta_data, :table_id, :created_at, :updated_at)";

        $errores = 0;
        $total = 0;
        foreach($this->recursos as $recurso){
            $junar_url = $this->config['junar_baseuri'] . "/datastreams/" . $recurso['junar_guid'] . "?auth_key=" . $this->config['junar_authkey'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $junar_url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

            $result = json_decode(curl_exec($ch));
            curl_close($ch);

            if($result && !isset($result->error) && property_exists($result, 'id')){
                $query = $em->getConnection()->prepare($sqlInsert);
                $query->bindValue('recurso_id',$recurso['id']);
                $query->bindValue('junar_guid',$result->id);
                $query->bindValue('title',$result->title);
                $query->bindValue('description',$result->description);
                $query->bindValue('tags',implode(',', $result->tags));
                $query->bindValue('source',$result->source);
                $query->bindValue('meta_data',$recurso['dataset_id']);
                $query->bindValue('table_id', '0');
                $query->bindValue('category','');
                $query->bindValue('created_at',$result->created_at);
                $query->bindValue('updated_at',$result->created_at);

                $query->execute();
                $this->write("Recurso importado correctamente: ID: ". $recurso['id'] . " - GUID: " . $recurso['junar_guid']);
            } else {
                $this->write("Recurso con error. ID: ". $recurso['id'] . " - GUID: " . $recurso['junar_guid']);
                $errores++;
            }
            $total++;
        }

        $this->write("\n---------------------------------");
        $this->write("Total de vistas procesadas: ". $total);
        $this->write("Total de vistas con errores: ". $errores);
        $this->write("---------------------------------");
    }


    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("DROP TABLE vista_junar");
        $this->addSql("ALTER TABLE recurso ADD junar_guid VARCHAR(255) DEFAULT NULL");
    }
}
