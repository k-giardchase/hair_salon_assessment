<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=hair_salon');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //HOME
    //Render home page
    $app->get('/', function() use ($app) {

        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Post stylists to home page
    $app->post('/stylists', function() use ($app) {
        $stylist_name = $_POST['stylist_name'];
        $new_stylist = new Stylist($stylist_name, $id = null);
        $new_stylist->save();
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Delete all stylists from home page
    $app->post('/delete_stylists', function() use ($app) {
        Stylist::deleteAll();
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    //SINGLE STYLIST PAGE
    //Render single stylist page
    $app->get('/stylist/{id}', function($id) use ($app) {
        $selected_stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $selected_stylist));
    });

    //Edit a single stylist from stylist page
    $app->patch('/stylist/{id}/edit', function ($id) use ($app) {
        $selected_stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit.html.twig', array('stylist' => $selected_stylist));
    });

    //Delete a single stylist from stylist page
    $app->delete('/delete_stylist/{id}', function($id) use ($app) {
        $selected_stylist = Stylist::find($id);
        $selected_stylist->delete();
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });









    return $app;
?>
