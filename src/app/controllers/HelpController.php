<?php
class HelpController extends Controller
{
    protected $data = [];

    public function index()
    {
        $this->data['page_title'] = "Help Center";
        $this->data['header'] = [
            'title' => 'Help Center',
            'description' => [
                ['name' => 'Home', 'url' => _WEB_ROOT],
                ['name' => 'Help center', 'url' => '#']
            ]
        ];
        
        $this->render('pages/public/help/index', $this->data);
    }
} 