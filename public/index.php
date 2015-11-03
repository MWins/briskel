<?php 

require '../vendor/autoload.php';
require 'models/Article.php';

ORM::configure('mysql:host=localhost;dbname=test');
ORM::configure('username', 'YOUR_DB_USERNAME');
ORM::configure('password', 'YOUR_DB_PASSWORD');

    $app = new \Slim\Slim(array(
            'debug' => true, 
            'templates.path' => 'templates', 
        'view' => new \Slim\Views\Twig()
    ));

    $app->add(new \Slim\Middleware\HttpBasicAuthentication([
        "path" => "/admin", 
        "secure" => false,
        "users" => [
            "root" => 'foo3pass',
            "admin" => 'password'
        ]
    ]));



// routes 

// Blog Home.
    $app->get('/', function() use ($app) {
        $articles = Model::factory('Article')->order_by_desc('timestamp')->find_many();
        return $app->render('blog_home.html', array('articles' => $articles));
    });
// Blog View.
    $app->get('/view/(:id)', function($id) use ($app) {
        $article = Model::factory('Article')->find_one($id);
        if (! $article instanceof Article) {
            $app->notFound();
        }
     
        return $app->render('blog_detail.html', array('article' => $article));
    });

// Admin Home.
    $app->get('/admin', function() use ($app) {
        $articles = Model::factory('Article')
                        ->order_by_desc('timestamp')
                        ->find_many();
     
        return $app->render('admin_home.html', array('articles' => $articles));
    });
 // Copied route due to redirect issue - should fix 
     $app->get('/admin/', function() use ($app) {
        $articles = Model::factory('Article')
                        ->order_by_desc('timestamp')
                        ->find_many();
     
        return $app->render('admin_home.html', array('articles' => $articles));
    });
// Admin Add.
    $app->get('/admin/add', function() use ($app) {
        return $app->render('admin_input.html', array('action_name' => 'Add', 'action_url' => './add'));
    });
// Admin Add - POST.
    $app->post('/admin/add', function() use ($app) {
    $article = Model::factory('Article')->create();
    $article->title  = $app->request()->post('title');
    $article->author     = $app->request()->post('author');
    $article->summary    = $app->request()->post('summary');
    $article->content    = $app->request()->post('content');   
    $article->timestamp = date('Y-m-d H:i:s');
    $article->save();
    $app->redirect('.');
 
});

 
// Admin Edit.
    $app->get('/admin/edit/(:id)', function($id) use ($app) {
     $article = Model::factory('Article')->find_one($id);
        if (! $article instanceof Article) {
            $app->notFound();
        }
            return $app->render('admin_input.html', array(
                'action_name'   =>   'Edit', 
                'action_url'    =>   './' . $id,
                'article'       =>   $article
            ));
    });
 
// Admin Edit - POST.
$app->post('/admin/edit/(:id)', function($id) use ($app) {
     $article = Model::factory('Article')->find_one($id);
    if (! $article instanceof Article) {
        $app->notFound();
    }
     
    $article->title  = $app->request()->post('title');
    $article->author     = $app->request()->post('author');
    $article->summary    = $app->request()->post('summary');
    $article->content    = $app->request()->post('content');
    $article->timestamp = date('Y-m-d H:i:s');
    $article->save(); 
    $app->redirect('../');
});
 
// Admin Delete.
$app->get('/admin/delete/(:id)', function($id) use ($app) {
     $article = Model::factory('Article')->find_one($id);
     if ($article instanceof Article) {
        $article->delete();
    }
    $app->redirect('../'); 
     
});

// run it
$app->run();