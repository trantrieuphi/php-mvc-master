<?php 

use Src\Core\View\View;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

if(!function_exists('env')) {
    function env($name){
        $app = [
            'url' => $_ENV['APP_URL'] ?? null,
            'mysql' => (object) [
                'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
                'port' => $_ENV['DB_PORT'] ?? '3306',
                'database' => $_ENV['DB_DATABASE'] ?? '',
                'username' => $_ENV['DB_USERNAME'] ?? 'root',
                'password' => $_ENV['DB_PASSWORD'] ?? ''
            ]
        ];
        return $app[$name];
    }
}

/**
 * Var dump for debug
 */
if (!function_exists('dd')) {
    function dd() {
        list($callee) = debug_backtrace();
        $args = func_get_args();
        $total_args = func_num_args();

        echo '<div><fieldset style="background: #fefefe !important; border:1px red solid; padding:15px">';
        echo '<legend style="background:blue; color:white; padding:5px;">'.$callee['file'].' @line: '.$callee['line'].'</legend><pre><code>';

        $i = 0;
        foreach ($args as $arg) {
            echo '<strong>Debug #' . ++$i . ' of ' . $total_args . '</strong>: ' . '<br>';
            print_r($arg);
            echo "<br>";
        }

        echo "</code></pre></fieldset><div><br>";
        die;
    }
} 

/**
 * @var path_url : url to redirect
 */
if(!function_exists('redirect')) {
    function redirect($path_url) {
        header("Location: " . env('url') . $path_url);
    }
}


/**
 * @var path_file_view : path to file that want to render in Views fofder
 * @var data : is array contains key (name varible use in view) => value
 */
if(!function_exists('view')) {
    function view(string $path_file_view, array $data = [])
    {
        $view = new View(BASE_APP . "/Views");
        return $view->render($path_file_view, $data);
    }
}

/**
 * print path to file in public folder
 */
if(! function_exists('asset')) {
    function asset($path_file_public) {
        $file = BASE_PATH . "/public/" . $path_file_public;
        if(!file_exists($file)) 
            throw new Exception("{$file} is not exist.");
        echo $file; 
    }
}
