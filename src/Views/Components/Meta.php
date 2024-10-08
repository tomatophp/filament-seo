<?php

namespace TomatoPHP\FilamentSeo\Views\Components;


use Illuminate\View\Component;

class Meta extends Component
{
    public ?string $title=null;
    public ?string $description=null;
    public ?string $keywords=null;
    public ?string $author=null;
    public ?string $image=null;
    public ?string $type=null;
    public ?string $category=null;
    public ?string $date=null;

    public function __construct()
    {
        $sections = app()->view->getSections();

        $this->title = isset($sections['title']) ? $sections['title'] : $this->multiLang(setting('site_name'));
        $this->description = isset($sections['description']) ? $sections['description'] : $this->multiLang(setting('site_description'));
        $this->keywords = isset($sections['keywords']) ? $sections['keywords'] : $this->multiLang(setting('site_keywords'));
        $this->author = isset($sections['author']) ? $sections['author'] : $this->multiLang(setting('site_author'));
        $this->image = isset($sections['image']) ? $sections['image'] : url('storage/' . setting('site_profile'));
        $this->type = isset($sections['type']) ? $sections['type'] : 'website';
        $this->category = isset($sections['category']) ? $sections['category'] : 'news';
        $this->date = isset($sections['date']) ? $sections['date'] : \Carbon\Carbon::now()->toDateTimeString();
    }


    private function multiLang($value){
        return app()->getLocale() === 'en' ? str($value)->explode('|')[0]??$value : str($value)->explode('|')[1]??$value;
    }

    public function render()
    {
        return view('filament-seo::tags');
    }
}
