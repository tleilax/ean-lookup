<?
class Cache
{
    protected static $directory    = 'cache/';
    protected static $max_duration = 3600; // 15 * 60 = 15 minutes

    public static function setDirectory($directory)
    {
        self::$directory = rtrim($directory, '/') . '/';
    }

    public static function find($id, $type, $closure, $tags = array())
    {
        $cache_file = self::$directory . $id . '.'. $type;
        if (file_exists($cache_file)) {
            $content = file_get_contents($cache_file);
            if ($type === 'json') {
                $content = json_decode($content, true);
            }
            return $content;
        }

        $content = $closure($id);

        if ($type === 'json') {
            file_put_contents($cache_file, json_encode($content));
        } else {
            file_put_contents($cache_file, $content);
        }
        chmod($cache_file, 0777);

        // TODO: Assign tags

        return $content;
    }
    
    public static function purge()
    {
        $now   = time();
        $files = glob(self::$directory . '*');
        foreach ($files as $file) {
            if (filemtime($file) + self::$max_duration < $now) {
                unlink($file);
            }
        }
    }
}