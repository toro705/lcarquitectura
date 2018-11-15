<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profiler {
    
    private $ci;
    
    public function __construct()
    {
        $this->ci = & get_instance();
    }
    
    public function set()
    {
        $this->ci->output->enable_profiler(PROFILER);
    }
}