<?php

namespace DefaultModule\Controller;

use Utilities\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Mustache_Engine;

class IndexController extends ActionController
{

    public function indexAction()
    {
//        $m = new Mustache_Engine([
//  'pragmas' => [Mustache_Engine::PRAGMA_BLOCKS],
//  'partials' => [
//    'parent' => 'Hello {{$ content }}planet{{/ content }}'
//  ],
//]);
//
//echo $m->render('{{< parent }}{{$ content }}World!{{/ content }}{{/ parent }}', []);die;
        return new ViewModel();
    }


}

