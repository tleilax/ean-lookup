<?php
class Navigation
{
    public static function Load($filename)
    {
        if (!file_exists($filename)) {
            throw new RuntimeException('Navigation file "' . $filename . '" does not exist.');
        }
        if (!is_readable($filename)) {
            throw new RuntimeException('Navigation file "' . $filename . '" can not be read.');
        }

        $data = json_decode(file_get_contents($filename), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Navigation file "' . $filename . '" could not be decoded.');
        }

        return new self($data);
    }

    protected $data = array();

    private function __construct($data)
    {
        foreach ($data as $status => $paths) {
            foreach ($paths as $path => $action) {
                $waypoints = explode('/', $path);
                if (count($waypoints) < 2) {
                    array_unshift($waypoints, 'default');
                }
                
                $scope = $waypoints[0];
                $index = $waypoints[1];

                if (!isset($this->data[$scope])) {
                    $this->data[$scope] = array();
                }
                if (!isset($this->data[$scope][$status])) {
                    $this->data[$scope][$status] = array();
                }
                $this->data[$scope][$status][$index] = $action;
            }
        }
    }

    public function get($scope = 'default', $status = 'none', $substitutions = array())
    {
        if (!isset($this->data[$scope])) {
            throw new Exception('Unknown navigation scope "' . $scope . '"');
        }
        $data = $this->data[$scope];
        
        if (!is_array($status)) {
            $status = preg_split('~\W~', $status);
        }
        array_unshift($status, 'all');
        
        $result = array();
        foreach ($status as $key) {
            if (!isset($data[$key])) {
                continue;
            }
            foreach ($data[$key] as $index => $item) {
                $action = array();
                foreach ($item as $x => $y) {
                    $x = interpolate($x, $substitutions);
                    $y = interpolate($y, $substitutions);
                    
                    $action[$x] = $y;
                }

                if (isset($action['position'])) {
                    array_splice($result, $acion['position'], 0, $action);
                } else {
                    $result[] = $action;
                }
            }
        }
        return $result;
    }
}