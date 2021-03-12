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
     * @param string $table Name of table
     * @param array $data An associative array to insert
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
     * @param string $table Name of table
     * @param string $data Name of colunms to extract
     * @param string $where the WHERE query part (remember: use '' in string values)
     * @param string $details other details (LIMIT, OFFSET, DESC/ASC and other ALL TOGETHER)
     * @return array An associative array with data from DB
     */
    public function read($table, $data, $where, $details)
    {
        if ($where != "") :
            $stmt = $this::conn()->prepare("SELECT $data FROM $table WHERE $where $details");
        else :
            $stmt = $this::conn()->prepare("SELECT $data FROM $table $details");
        endif;

        $stmt->execute();
        $this::closeConn();

        if ($stmt->rowCount() > 1) :
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        else :
            if ($data == "*") :
                return $this->showObj($stmt->fetch(\PDO::FETCH_ASSOC), $table);
            endif;
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        endif;
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
     * @param string $table Name of table
     * @param array $data An associative array to insert
     * @param string $where the WHERE query part
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
     * delete
     * @param string $table Name of table
     * @param string $where the WHERE query part
     */
    public function delete($table, $where, $limit = 1)
    {
        $this::conn()->exec("DELETE FROM $table WHERE $where LIMIT $limit");
        $this::closeConn();
    }
}
