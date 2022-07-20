<?php

require_once("conf.php");

// telegram @x_like_the_sky_x
// +380663285949

/* constant pathes */

define("SYS", ROOT."s/");
define("CORE", ROOT."s/s/");
define("MDL", ROOT."m/");
define("TPL", ROOT."v/");
define("CTRL", ROOT."c/");
define("IMG_S", ROOT."v/img/");
define("IMG_D", ROOT."i/");

/* standalone tools */

require_once("s/s/model.php");
require_once("s/s/view.php");
require_once("s/s/controller.php");

require_once("s/s/route.php");


/* bundle tools */

require_once("s/db.php");
require_once("s/bundle.php");
require_once("s/shexp.php");
require_once("s/fields.php");
require_once("s/render.php");
require_once("s/vars.php");
require_once("s/proxy.php");
require_once("s/image.php");
require_once("s/loader.php");

/* bundeling */

$controller = new Bundle();
$model = new Bundle();

//

$model->sett("db", new Db(BASE));

$controller->sett("shexp", new Shexp());
$controller->sett("fields", new Fields());
$controller->sett("render", new Render());
$controller->sett("vars", new Vars());
$controller->sett("proxy", new Proxy());
$controller->sett("image", new Image());
$controller->sett("loader", new Loader($controller, $model));

/* workout */

$route = new Route($controller);