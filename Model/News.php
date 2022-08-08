<?php

class News
{
    const DB_HOST  = 'localhost';
    const DB_NAME  = 'crescent';
    const DB_USER  = 'sysuser';
    const DB_PASS  = 'secret';
    const DB_TABLE = 'news';

    /**
     *
     * PDOインスタンスを返す
     *
     * @return object
     *
     */
    public static function getPDO(): object
    {
        return new PDO(
            'mysql:host=' . self::DB_HOST . '; dbname=' . self::DB_NAME . '; charset=utf8',
            self::DB_USER,
            self::DB_PASS,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    /**
     * ニュースの全件を返す
     *
     * @param string $desc
     * @param integer $startNum
     * @param integer $getNum
     * @return array
     */
    public static function all(string $desc = '', $startNum = 0, $getNum = 0): array
    {
        $sql = 'SELECT * FROM ' . self::DB_TABLE;

        // dsecという文字列があれば新着順に取得
        if ($desc) {
            $sql .=  ' ORDER BY posted_at DESC';
        }

        // 取得件数が1以上であれば
        if ($getNum > 0) {
            $sql .= ' LIMIT ' . $startNum . ', ' .  $getNum;
        }

        return self::getPDO()->query($sql)->fetchAll();
    }

}
