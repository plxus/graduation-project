<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use App\Repository;

class RepositoryDimmer extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Repository::count();
        $string = '知识清单';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-documentation',
            'title'  => "{$count} {$string}",
            'text'   => __('您有 '.$count.' 知识清单 在数据库中。点击下面的按钮查看所有'.$string.'。', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => '查看所有知识清单',
                'link' => route('voyager.repositories.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/02.jpg'),
        ]));
    }
}
