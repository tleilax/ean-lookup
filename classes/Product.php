<?php
class Product
{
    protected static $cache = array();

    public static function find($ean)
    {
        if (!isset(self::$cache[$ean])) {
            self::$cache[$ean] = new self($ean);
        }
        return self::$cache[$ean];
    }

    public $ean;
    public $title;
    public $description;
    public $category_id;
    public $mkdate;
    public $chdate;

    public function __construct($ean)
    {
        $this->ean = $ean;

        $query = "SELECT title, description,
                         category_id,
                         UNIX_TIMESTAMP(mkdate) AS mkdate,
                         UNIX_TIMESTAMP(chdate) AS chdate
                  FROM products
                  WHERE ean = ?";
        $statement = DB::Get()->prepare($query);
        $statement->execute(array($ean));
        $temp = $statement->fetch(PDO::FETCH_ASSOC);

        if ($temp) {
            $this->title       = $temp['title'];
            $this->description = $temp['description'];
            $this->category_id = $temp['category_id'];
            $this->mkdate      = $temp['mkdate'];
            $this->chdate      = $temp['chdate'];
        }
    }

    public function store()
    {
        $query = "INSERT INTO products
                    (ean, title, description, category_id, mkdate, chdate)
                  VALUES
                    (?, TRIM(?), TRIM(?), ?, NOW(), NOW())
                  ON DUPLICATE KEY
                    UPDATE title = VALUES(title),
                           description = VALUES(description),
                           category_id = VALUES(category_id),
                           chdate = NOW()";
        $statement = DB::Get()->prepare($query);
        $statement->execute(array(
            $this->ean,
            $this->title,
            $this->description,
            $this->category_id
        ));
    }

    public function isNew()
    {
        return empty($this->mkdate);
    }
}