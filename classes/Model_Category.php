<?php
class Model_Category extends RedBean_SimpleModel
{
    public function flatten($with_children = false)
    {
        $result   = array();
        $result[] = array(
            'id'    => $this->id,
            'name'  => $this->name,
            'depth' => $this->depth,
        );

        if ($with_children) {
            foreach ($this->getChildren as $child) {
                $result = array_merge($result, $child->flatten());
            }
        }

        return $result;
    }
    
    public function getChildren()
    {
        return R::related($this->bean, 'category', 'depth > ? ORDER BY name', array($this->depth));
    }
    
    public function getParent()
    {
        return R::relatedOne($this->bean, 'category', 'depth < ? ORDER BY name', array($this->depth));
    }
    
    public function getPath()
    {
        $path = array($this->bean);
        
        $parent = $this->getParent();
        while ($parent) {
            $path[] = $parent;
            $parent = $parent->getParent();
        }
        return array_reverse($path);
    }
}