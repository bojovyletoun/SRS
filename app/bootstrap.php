<?php

use \Nette\Application\Routers\Route;
use \Nette\Diagnostics\Debugger;


SetLocale(LC_ALL, "Czech");

// Load Nette Framework or autoloader generated by Composer
require LIBS_DIR . '/autoload.php';


// Configure application
$configurator = new \Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
//$configurator->setDebugMode($configurator::AUTO);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	//->addDirectory(LIBS_DIR)
	->register();

\Nella\Console\Config\Extension::register($configurator);
\Nella\Doctrine\Config\Extension::register($configurator);
\Nella\Doctrine\Config\MigrationsExtension::register($configurator);

if (strpos($_SERVER['SERVER_NAME'], 'dev.majsky.cz') !== false) {
    $environment = $configurator::DEVELOPMENT;
    $configurator->addConfig(__DIR__ . '/config/config.neon', $environment);
    
}

else if (StrPos($_SERVER['SERVER_NAME'], 'local') !== false) {
    $configurator->addConfig(__DIR__ . '/config/config.neon', 'local');
    
}
else {
    $configurator->addConfig(__DIR__ . '/config/config.neon');
}

$container = $configurator->createContainer();




// Setup router
$container->router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
$container->router[] = new Route('admin/', 'Back:Dashboard:default');
$container->router[] = new Route('login/', 'Auth:login');
$container->router[] = new Route('logout/', 'Auth:logout');
$container->router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');


//Setup ACL
$acl = new \Nette\Security\Permission();
$acl->addRole('guest');
$acl->addRole('registered', 'guest');
$acl->addRole('serviceTeam', 'registered');
$acl->addRole('lector', 'serviceTeam');
$acl->addRole('organizer', 'lector');
$acl->addRole('admin', 'organizer');
$acl->addRole('webmaster');
$acl->addRole('programManager');
$container->user->setAuthorizator($acl);


// Configure and run the application!
if (!defined('CANCEL_START_APP')) {
    $container->application->run();
}
