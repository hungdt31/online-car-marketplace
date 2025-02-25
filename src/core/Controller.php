<?php
class Controller {
    public function model($model) {
        if (file_exists(_DIR_ROOT.'/app/models/'.$model.'.php')) {
            require_once _DIR_ROOT.'/app/models/'.$model.'.php';
            if (class_exists($model)) {
                $model = new $model();
            }
        }
        return $model;
    }
    public function render($_view, $data=[]) {
        // echo '<pre>'.print_r($data, true).'</pre>';
        extract($data);
        if (file_exists(_DIR_ROOT.'/app/views/'.$_view.'.php')) {
            require_once _DIR_ROOT.'/app/views/'.$_view.'.php';
        }
    }
    public function renderUser ($data=[]) {
        $this->render('layouts/user', $data);
    }
    public function renderAdmin ($data=[]) {
        $this->render('layouts/admin', $data);
    }
}
