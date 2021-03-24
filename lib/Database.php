<?php

namespace lib;

class Database
{
    private static $instance;

    public static function conn()
    {
        if (!isset(self::$instance)) :
            self::$instance = new \PDO(DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            try {
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                self::$instance = null;
                die($e->getMessage());
            }
        endif;
        return self::$instance;
    }

    public static function closeConn()
    {
        if (isset(self::$instance)) :
            self::$instance = null;
        endif;
        return self::$instance;
    }

    /**
     * create
     * @param string $table Nome da tabela
     * @param array $data Um array associativo para adicionar
     */

    public function create($table, $data)
    {
        ksort($data);
        $fieldName = "`" . implode('`, `', array_keys($data)) . "`";
        $fieldValues = ":" . implode(', :', array_keys($data));

        $stmt = $this::conn()->prepare("INSERT INTO $table ($fieldName) VALUES ($fieldValues)");
        foreach ($data as $key => $value) :
            $stmt->bindValue(":$key", $value);
        endforeach;
        $stmt->execute();
        $this::closeConn();
    }

    /**
     * read
     * @param string $table Nome da tabela
     * @param string $data Nome da coluna para extrair
     * @param string $where A parte WHERE da query (lembre: use '' ao enviar strings)
     * @param string $details Outros detalhes (LIMIT, OFFSET, DESC/ASC e outros)
     * @return array Uma array associativa com os dados do DB
     */
    public function read($table, $data, $where = "", $details = "")
    {
        if ($where != "") :
            $stmt = $this::conn()->prepare("SELECT $data FROM $table WHERE $where $details");
        else :
            $stmt = $this::conn()->prepare("SELECT $data FROM $table $details");
        endif;
        $stmt->execute();
        $this::closeConn();

        if ($stmt->rowCount() == 0) :
            return false;
        endif;

        if ($stmt->rowCount() > 1) :
            $multiData = 1;
            $info = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        else :
            $info = $stmt->fetch(\PDO::FETCH_ASSOC);
        endif;

        if (isset($multiData) and $data == "*") :
            $i = 0;
            foreach ($info as $value) :
                $dados[$i] = $this->showObj($value, $table);
                $i++;
            endforeach;
            return $dados;
        endif;

        if (!isset($multiData) and $data == "*") :
            $dados = $this->showObj($info, $table);
            return $dados;
        endif;

        return $info;
    }

    /**
     * showObj
     * @param array $row Array com valores a serem transformados em objeto
     * @param string $table Nome da tabela que o objeto pertence
     * @return object $obj Retorna objeto instanciado
     */
    public function showObj($row, $table)
    {
        $objName = "\obj\\" . $table;
        $obj = new $objName($row);
        return $obj;
    }

    /**
     * update
     * @param string $table Nome da tabela
     * @param array $data Uma array associativa para atualizar
     * @param string $where A parte WHERE da query (lembre: use '' ao enviar strings)
     */
    public function update($table, $data, $where)
    {
        ksort($data);
        $fieldDetails = null;
        foreach ($data as $key => $value) :
            $fieldDetails .= "`$key` = :$key, ";
        endforeach;
        $fieldDetails = rtrim($fieldDetails, ", ");

        $stmt = $this::conn()->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        foreach ($data as $key => $value) :
            $stmt->bindValue(":$key", $value);
        endforeach;
        $stmt->execute();
        $this::closeConn();
    }

    /**
     * alterTable
     * @param string $table Nome da tabela
     * @param string $data Nome da coluna que será alterada
     * @param string $value Novo valor default da coluna
     */
    public function alterTable($table, $data, $value)
    {
        $stmt = $this::conn()->prepare("ALTER TABLE $table ALTER $data SET default :data");
        $stmt->bindValue(":data", $value);
        $stmt->execute();
        $this::closeConn();
    }

    /**
     * delete
     * @param string $table Nome da tabela
     * @param string $where A parte WHERE da query
     */
    public function delete($table, $where, $limit = 1)
    {
        $this::conn()->exec("DELETE FROM $table WHERE $where LIMIT $limit");
        $this::closeConn();
    }
}
