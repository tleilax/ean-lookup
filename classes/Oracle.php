<?php
class Oracle
{
    public static function guess($strings)
    {
        $tree = self::parseTree($strings);

        $result = array();
        while (count($tree) > 0) {
            $index = false;
            $max   = 0;
            foreach ($tree as $token => $data) {
                if ($data['count'] > $max) {
                    $index = $token;
                    $max   = $data['count'];
                }
            }

            $result[] = $index;
            $tree = $tree[$index]['children'];
        }

        return implode(' ', $result);;
    }

    public static function parseTree($strings)
    {
        $tree = array();

        // Step 1 - Parse tree into array, count duplicates
        foreach ($strings as $row) {
            $node = &$tree;
            $tokens = array_filter(preg_split('/\W/', $row));
            foreach ($tokens as $token) {
                if (!isset($node[$token])) {
                    $node[$token] = array(
                        'count'    => 1,
                        'children' => array(),
                    );
                }

                $node[$token]['count'] += 1;
                $node = &$node[$token]['children'];
            }
        }

        return $tree;
    }
}