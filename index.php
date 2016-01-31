<?php
require 'vendor/autoload.php';
require 'config.php';
require 'class/Template.class.php';

// Configurations for app before start
$container = new \Slim\Container([
    'settings' => [
        'displayErrorDetails' => PKB\Config::$dev_mode,
    ],
]);

// Create app
$app = new \Slim\App($container);

// Get container
$container = $app->getContainer();

// Register components on container
$container['config'] = function ($container) {
    return new PKB\Config;
};
$container['filesystem'] = function ($container) {
    $adapter = new \League\Flysystem\Adapter\Local(__DIR__.'/contents');
    return new \League\Flysystem\Filesystem($adapter);
};
$container['view'] = function ($container) use ($container) {
    $tmpl = new \PKB\Template('./templates/');

    // Set global variables for templates
    $tmpl->site                 = $container->config->site;
    $tmpl->doctypes             = $container->config->doctypes;
    $tmpl->restricted           = $container->config->restricted;
    return $tmpl;
};

// Define app routes
$app->get('/', function ($request, $response, $args) {
    //index.sys.opml
    $this->view->file = [
        'id'      => 'index',
        'doctype'  => 'sys',
    ];
    return $this->view->render($response, 'index.php', $args);
});

$app->get('/know/{name}', function ($request, $response, $args) {
    // Check if requested name is not valid
    if ( preg_match($this->config->restricted, $args['name']) ) {
        //403.sys.opml
        $this->view->file = [
            'id'        => '403',
            'doctype'   => 'sys',
        ];
        $response = $response->withStatus(403);
        return $this->view->render($response, 'index.php', $args);
    }

    // Check if requested outline file doesn't exist
    if ( !$this->filesystem->has("{$args['name']}.know.opml") ) {
        //404.sys.opml
        $this->view->file = [
            'id'        => '404',
            'doctype'   => 'sys',
        ];
        $response = $response->withStatus(404);
        return $this->view->render($response, 'index.php', $args);
    }

    //name.know.opml
    $this->view->file = [
        'id'        => $args['name'],
        'doctype'   => 'know',
    ];
    return $this->view->render($response, 'index.php', $args);
})->setName('know');

$app->group('/new', function () {
    // new.sys.opml
    $this->get('/know', function ($request, $response, $args) {
        // new-know.sys.opml
        $this->view->file = [
            'id'        => false,
            'doctype'   => 'sys',
            'title'     => 'New knowledge',
        ];
        return $this->view->render($response, 'index.php', $args);
    });
});

$app->post('/open', function ($request, $response, $args) {
    // Set OPML header. Another header also has been proposed, opml+xml
    $response = $response->withHeader('Content-type', 'text/x-opml');

    // Set outline file info to retrieve
    $file = [
        'id' => $request->getParsedBody()['id'],
        'doctype' => $request->getParsedBody()['doctype'],
    ];
    $file['path'] = "{$file['id']}.{$file['doctype']}.opml";

    // Check if requested name is not valid
    //  or doctype is not included in allowed doctypes list
    if ( preg_match($this->config->restricted, $file['id'])
            ||  !in_array($file['doctype'], $this->config->doctypes) ) {
        //403.sys.opml
        return $response->withStatus(403)
                        ->write($this->filesystem->read('403.sys.opml'));
    }

    // Check if requested outline file doesn't exist
    if ( !$this->filesystem->has($file['path']) ) {
        //404.sys.opml
        return $response->withStatus(404)
                        ->write($this->filesystem->read('404.sys.opml'));
    }

    //name.doctype.opml
    return $response->write($this->filesystem->read($file['path']));
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

// Functions used
function page_title($custom_title = '', $data_file_path = '') {
    global $container;
    $container->view->page['title'] = '';
    $xml = new \DOMDocument();
    if ( $container->view->file['id'] && $xml->load("contents/{$container->view->file['id']}.{$container->view->file['doctype']}.opml") ) {
        $container->view->file['title'] = trim($xml->getElementsByTagName('title')[0]->nodeValue);
    }
    if ( $container->view->file['title'] ) {
        $container->view->page['title'] .= $container->view->file['title'] . ' | ';
        $container->view->page['title'] .= ( in_array($container->view->file['doctype'], ['notebook', 'tag']) ) ? $container->view->file['doctype'] . ' | ' : '';
    }
    $container->view->page['title'] .= $container->view->site['title'];
}

// Waiting...
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

function file_info($file_path) {
    $file = pathinfo($file_path);
    $file['path'] = $file_path;
    $file['doctype'] = null;

    $parts = explode('.', $file['filename']);

    end($parts);
    if ( in_array(current($parts), ['know', 'draft', 'book', 'tag']) )
        $file['doctype'] = current($parts);

    $len = 0;
    $doctype_len = strlen($file['doctype']);
    $len += ($doctype_len) ? $doctype_len + 1 : 0;
    if ($len)
        $file['filename'] = substr($file['filename'], 0, -$len);

    return $file;
}
function get_doctype($opml_name) {

}

// Run app
$app->run();
