<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=hair_salon');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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
        return $app['twig']->render('stylist.html.twig', array('stylist' => $selected_stylist, 'clients' => $selected_stylist->getClients()));
    });

    //Add client to stylist on stylist page
    $app->post('/clients', function() use ($app) {
        $client_name = $_POST['client_name'];
        $stylist_id = $_POST['stylist_id'];
        $new_client = new Client($client_name, $stylist_id, $id = null);
        $new_client->save();
        $selected_stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $selected_stylist, 'clients' => $selected_stylist->getClients()));
    });

    //Edit a single stylist from stylist page
    $app->get('/stylist/{id}/edit', function ($id) use ($app) {
        $selected_stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit.html.twig', array('stylist' => $selected_stylist));
    });

    //Update a single stylist from stylist edit
    $app->patch('/stylist/{id}', function($id) use ($app) {
        $new_name = $_POST['new_name'];
        $stylist = Stylist::find($id);
        $stylist->update($new_name);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist));
    });


    //Delete a single stylist from stylist edit page
    $app->delete('/delete/stylist/{id}', function($id) use ($app) {
        $selected_stylist = Stylist::find($id);
        $selected_stylist->delete();
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    return $app;
?>
