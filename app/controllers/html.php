<?php
class HtmlController extends Trails_Controller
{
    public function img_action() {
        $attributes = (array)@$_GET;
        if (!isset($attributes['alt'])) {
            $attributes['alt'] = '';
        }
        
        $attr = array();
        foreach ($attributes as $key => $value) {
            $attr[] = $key . '="' . htmlspecialchars($value). '"';
        }
        $result = '<img ' . implode(' ', $attr) . '>';
        $this->render_text($result);
    }
}
