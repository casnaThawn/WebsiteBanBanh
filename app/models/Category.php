<?php

class Category {
    public $category_name;
    public $slug;
    public $is_homepage;
    public $ordering;

    public function __construct($category_name, $slug, $is_homepage=false, $ordering=0) {
        $this->category_name = $category_name;
        $this->slug = $slug;
        $this->is_homepage = $is_homepage;
        $this->ordering = $ordering;
    }

    public function __toString() {
        return $this->category_name;
    }

    public static function getVerboseNamePlural() {
        return "Categories";
    }
}
?>
