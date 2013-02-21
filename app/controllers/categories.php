<?php
class CategoriesController extends AppController
{
    public function before_filter(&$action, &$args)
    {
        if (!method_exists($this, $action . '_action') && ctype_digit($action)) {
            array_unshift($args, $action);
            $action = 'index';
        }
        
        parent::before_filter($action, $args);
        
        $this->checkAuth();
    }
    
    public function index_action($id = null)
    {
        if ($id === null) {
            $this->children = R::find('category', 'depth = 0 ORDER BY name');
        } else {
            $this->category = R::load('category', $id);
            $this->children = $this->category->getChildren();
        }
    }
    
    private function flattenCategories($categories, $depth = 0)
    {
        $result = array();
        foreach ($categories as $category) {
            $result[] = array(
                'id'    => $category->id,
                'name'  => $category->name,
                'depth' => $depth,
            );
            $children = R::related($category, 'category');
            $children = array_filter($children, function ($item) use ($depth) { return $item['depth'] > $depth; });
            usort($children, function ($a, $b) { return strcmp($a->name, $b->name); });
            
            if (count($children) > 0) {
                $result = array_merge($result, $this->flattenCategories($children, $depth + 1));
            }
        }
        return $result;
    }

    public function edit_action($id)
    {
        $this->category = R::load('category', $id);
        $parent = $this->category->getParent();

        $categories = R::find('category', 'depth = 0 ORDER BY name');
        $this->categories = $this->flattenCategories($categories);
        $this->parent_id  = $parent ? $parent->id : null;

    }
    
    public function new_action($parent_id = null)
    {
        $categories = R::find('category', 'depth = 0 ORDER BY name');
        $this->categories = $this->flattenCategories($categories);
        $this->parent_id  = $parent_id;
        
        $this->render_action('edit');
    }
    
    public function store_action($id = null)
    {
        $category = ($id === null)
                  ? R::dispense('category')
                  : R::load('category', $id);
        $category->name        = trim($_REQUEST['name']);
        $category->description = trim($_REQUEST['description']) ?: null;
        $category->depth       = 0;
        if (!empty($_REQUEST['parent'])) {
            $parent = R::load('category', $_REQUEST['parent']);
            if (!R::areRelated($category, $parent)) {
                if ($p = $category->getParent()) {
                    R::unassociate($p, $category);
                }
                R::associate($parent, $category);
            }

            $category->depth = $parent->depth + 1;
        } elseif ($p = $category->getParent()) {
            R::unassociate($p, $category);
        }
        $category->mkdate = $category->mkdate ?: time();
        $category->chdate = time();
        R::store($category);

        $this->report_success('Die Kategorie wurde erfolgreich gespeichert.');
        $this->redirect('categories', $category->id);
    }
}