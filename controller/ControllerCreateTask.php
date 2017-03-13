<?php

class ControllerCreateTask extends MainController {
    
    public function index()
    {
        
        $this->title = 'Create Task List';
        $this->loadModel('TaskList');
        $this->loadView('CreateTaskList');
        
	}
}
