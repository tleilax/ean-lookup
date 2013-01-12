<?php
class Category
{
    protected static $cache = array();

    public static function find($id)
    {
        if (!isset(self::$cache[$id])) {
            self::$cache[$id] = new self($id);
        }
        return self::$cache[$id];
    }

    public $id;
    public $title;
    public $mkdate;
    public $chdate;

    public function __construct($id = null)
    {
        $this->id = $id;

        $query = "SELECT title,
                         UNIX_TIMESTAMP(mkdate) AS mkdate,
                         UNIX_TIMESTAMP(chdate) AS chdate
                  FROM categories
                  WHERE category_id = ?";
        $statement = DB::Get()->prepare($query);
        $statement->execute(array($id));
        $temp = $statement->fetch(PDO::FETCH_ASSOC);

        if ($temp) {
            $this->title       = $temp['title'];
            $this->mkdate      = $temp['mkdate'];
            $this->chdate      = $temp['chdate'];
        }
    }

    public function store()
    {
        $query = "INSERT INTO categories
                    (category_id, title, mkdate, chdate)
                  VALUES
                    (?, ?, NOW(), NOW())
                  ON DUPLICATE KEY
                    UPDATE title = VALUES(title),
                           chdate = NOW()";
        $statement = DB::Get()->prepare($query);
        $statement->execute(array(
            $this->id,
            $this->title,
        ));
        
        if ($this->id === null) {
            $this->id = DB::Get()->lastInsertId();
        }
    }

    public function isNew()
    {
        return empty($this->mkdate);
    }
}