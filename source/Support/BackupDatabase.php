<?php

namespace Source\Support;

use \Ifsnop\Mysqldump\Mysqldump;

/**
 * Class BackupDatabase
 * @package Source\Support
 */
class BackupDatabase
{
    /*** @var string $backupFolder */
    private $backupFolder;

    /*** @var int $maxNumberFiles */
    private $maxNumberFiles;

    /*** @var $host*/
    private $host;

    /*** @var $database*/
    private $database;

    /*** @var $username*/
    private $username;

    /*** @var $password */
    private $password;

    /**
     * Construtor
     * @param string $backupFolder Pasta onde serão armazenados os backups
     * @param int $maxNumberFiles Número máximo de backups que serão mantidos
     */
    public function __construct($backupFolder, $maxNumberFiles)
    {
        $this->backupFolder = $backupFolder;
        $this->maxNumberFiles = $maxNumberFiles;
    }

    /**
     * Define as informações de conexão com o banco de dados
     *
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     */
    public function setDatabase($host, $database, $username, $password)
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @throws \Exception
     */
    public function generate()
    {
        // Se as informações de conexão com o banco de dados não foram definidas
        if (empty($this->database) or empty($this->username) or empty($this->host)) {
            throw new \Exception('As informações de conexão com o banco de dados não foram definidas');
        }

        // Gerando nome único para o arquivo
        $filePath = $this->backupFolder . '/' . DATA_LAYER_CONFIG['dbname'] . '.sql.gz';

        // Definindo informações para geração do backup
        $dump = new Mysqldump("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password, array(
            'compress' => Mysqldump::GZIP,
        ));

        // Gerando backup
        $dump->start($filePath);
        //echo "Gerado backup '{$filePath}'" . PHP_EOL;

        // Limpando backups antigos
        $this->clearOldFiles();
    }

    /**
     * Limpa os arquivos de backups antigos
     * @return void
     */
    private function clearOldFiles()
    {
        // Buscando itens na pasta
        $files = new \DirectoryIterator($this->backupFolder);

        // Passando pelos itens
        $sortedFiles = array();
        foreach ($files as $file) {
            // Se for um arquivo
            if ($file->isFile()) {
                // Adicionando em um vetor, sendo o índice a data de modificação
                // do arquivo, para assim ordenarmos posteriormente
                $sortedFiles[$file->getMTime()] = $file->getPathName();
            }
        }

        // Ordena o vetor em ordem decrescente
        arsort($sortedFiles);

        // Passando pelos arquivos
        $numberFiles = 0;
        foreach ($sortedFiles as $file) {
            $numberFiles++;
            // Se a quantidade de arquivo for maior que a quantidade
            // máxima definida
            if ($numberFiles > $this->maxNumberFiles) {
                // Removemos o arquivo da pasta
                unlink($file);
                //echo "Apagado backup '{$file}'" . PHP_EOL;
            }
        }

    }
}