<?php
require 'vendor/autoload.php';
require 'config.php';

// Create app
$app = new \Slim\App;

// Get container
$container = $app->getContainer();

// Register components on container
$container['config'] = function ($container) {
    return new PKB\Config;
};
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./templates/');
};
$container['filesystem'] = function ($container) {
    $adapter = new League\Flysystem\Adapter\Local(__DIR__.'/contents');
    return new League\Flysystem\Filesystem($adapter);
};

// Define app routes
$app->get('/', function ($request, $response, $args) {
    template($this, 'know', '_index', 0, array('recent_files' => $files));
});

$app->group('/know', function() {
    $this->get('/Draft:{name}', function ($request, $response, $args) {
        template($this, 'know');
    });

    $this->get('/{name}', function ($request, $response, $args) {
        if ( substr($args['name'], 0, 1) == '_' ) {
            return $response->withRedirect(
                $this->router->pathFor('know', array(
                    'name' => substr($args['name'], 1)
                ))
            );
        }
        template($this, 'know');
    })->setName('know');
});

$app->group('/new', function () {
    $this->get('/know', function ($request, $response, $args) {
        template($this, 'know', 0, 'New Knowledge');
    });
});

$app->post('/open', function ($request, $response, $args) {
    $file = $request->getParsedBody()['id'] . '.opml';
    if ($this->filesystem->has($file)) {
        //$response->withHeader('Content-type', 'application/xml+opml');
        $response->withHeader('Content-type', 'text/x-opml');
        return $response->write($this->filesystem->read($file));
    } else {
        $response->withStatus(404);
        $response->withHeader('Content-type', 'text/x-opml');
        return $response->write($this->filesystem->read('_404.opml'));
    }
});

$app->post('/save', function ($request, $response, $args) {
    if ( $this->filesystem->put($request->getParsedBody()['id'] . '.opml', $request->getParsedBody()['opml']) ) {
        return json_encode(array(
            'saved' => true,
            'filename' => $request->getParsedBody()['id'] . '.opml',
            'path' => $request->getParsedBody()['id']
        ));
    }

});

function template($app, $template, $file_id = false, $page_title = false, $args = array()) {
    $config_clone = (array) $app->config;
    $is_draft = false;

    $uri_parts = explode('/', $_SERVER['REQUEST_URI']);
    end($uri_parts);
    prev($uri_parts);

    if ( current($uri_parts) == 'know' ) {
        $matches = array();
        if ( preg_match("/^Draft:(.*)$/", end($uri_parts), $matches) !== 0 ) {
            // Draft
            $draft_id = $matches[1];
            $config_clone['file_id'] = str_replace( 'Draft:', 'drafts/', end($uri_parts) );
            $is_draft = true;
        } else {
            // non-Draft
            $config_clone['file_id'] = end($uri_parts);
        }
    } elseif ( $file_id ) {
        $config_clone['file_id'] = $file_id;
    }

    if ( isset($config_clone['file_id']) && !$app->filesystem->has($config_clone['file_id'] . '.opml') && !$page_title ) {
        $config_clone['site']['title'] .= ' | Not Found';
        $config_clone['file_id'] = '_404';
    } elseif ( $is_draft ) {
        $config_clone['site']['title'] .= ' | Draft: ' . ucwords( str_replace('_' , ' ', $draft_id) );
    } elseif ( isset($config_clone['file_id']) ) {
        $config_clone['site']['title'] .= ' | ' . ucwords( str_replace('_' , ' ', $config_clone['file_id']) );
    } elseif ( $page_title ) {
        $config_clone['site']['title'] .= ' | ' . $page_title;
    }

    $config_clone['is_draft'] = $is_draft;
    return $app->view->render($app->response, $template . '.php', array_merge($config_clone, $args, array('recent_files' => listFiles($app->filesystem))));
}

function listFiles($filesystem) {
    $files = $filesystem->listContents('/', true);
    foreach ($files as $k => $v) {
        if ( $v['type'] == 'dir' || in_array( substr($v['basename'], 0, 1), ['_', '.'] ) ) {
            unset($files[$k]);
            continue;
        }
        $files[$k]['path'] = str_replace('drafts/', 'Draft:', $v['path']);
    }
    return $files;
}

function is_draft($file) {
    return $file['dirname'] == 'drafts';
}

function sort_by_date(&$files) {
    usort($files, function($a, $b) {
    	if ($a['timestamp'] == $b['timestamp'])
    		return 0;
    	return ($a['timestamp'] > $b['timestamp']) ? -1 : 1;
    });
}

// Run app
$app->run();
