<?php

namespace Src\Core\View;

use Exception;

class View {
    /**
     * Path to View directory.
     */
    private $directory;
    
    /**
     * Layout for views.
     * @default null
     */
    private $layout;
    
    /**
     * Section for layout. ex: content, sidebar, header, ...
     */
    private $sections;
    
    /**
     * name current section.
     * @default null
     */
    private $current_section;
    
    /**
     * 
     * Ham khoi tao
     * 
     */
    public function __construct(string $directory)
    {
        $this->setDirectory($directory);
        $this->sections = [];
        $this->layout = null;
        $this->current_section = null;
    }

    /**
     * Set path views's root directory
     */
    private function setDirectory(string $directory)
    {
        if(!is_dir($directory)) {
            throw new Exception("{$directory} is not exist");
        }

        $this->directory = $directory;
    }
    
    /**
     * Check path to view file
     */
    private function resovlePath(string $path)
    {
        $file = $this->directory . "/" . $path . ".php";
        if(!file_exists($file)) {
            throw new Exception("{$file} is not exist");
        }
        return $file;
    }

    /**
     * @var path_file_view : path file view that will be rendered
     * @var data : view will use this data
     * @return string
     */
    public function render(string $path_file_view, array $data)
    {
        if(is_array($data))
            extract($data);

        ob_start();
        include_once $this->resovlePath($path_file_view);
        $content = ob_get_contents();
        if(empty($this->layout)) {
            ob_clean();
            return $content;
        }

        require_once $this->resovlePath($this->layout);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
    /**
     * Include 1 view into other view
     * @var path_file_view : path file view in Views directory that want to include
     */
    public function include(string $path_file_view)
    {
        ob_start();
        require_once $this->resovlePath($path_file_view);
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;
    }
    
    /**
     * Start section
     * @var name : section's name.
     */
    public function section(string $name)
    {
        $this->current_section = $name;
        ob_start();
    }
    
    /**
     * End of section
     */
    public function end()
    {
        if(empty($this->current_section)) {
            throw new Exception("There is no section to start");
        }
        $content = ob_get_contents();
        ob_end_clean();
        
        $this->sections[$this->current_section] = $content;
        $this->current_section = null;
    }
    
    /**
     * @var layout: view file path that want to extends
     */
    public function extendsLayout(string $layout)
    {
        $this->layout = $layout;
    }
    
    /**
     * Define place that want to render the section
     * @var name : section's name
     */
    public function yield(string $name)
    {
        echo $this->sections[$name];
    }
}
