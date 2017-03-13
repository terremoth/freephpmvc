<?php

class ControllerTaskList extends MainController
{
	public function index() 
    {
        $aData = array('post'=>$this->requestPost);
        
        $this->title = 'TaskList';
		
        $this->loadView('TaskList', $aData);
        
	}
    
    public function loadTasks() 
    {
        $oModelTaskList = $this->loadModel('TaskList');
        echo $oModelTaskList->getTodoList();
        
    }
    
    public function createTask() 
    {
        $aPost = $this->requestPost;
        $sTaskName = $aPost['taskName'];
        $sTaskDate = $aPost['taskDate'];
        $sTaskDescription = $aPost['taskDescription'];
        $oModelTaskList = $this->loadModel('TaskList');
        
    
        
        $aInsert = array(
            'todo_list_name' => $sTaskName,
            'todo_list_final_date' => $oModelTaskList->convertDateToDefault($sTaskDate),
            'todo_list_description' => $sTaskDescription
        );
        
        $oModelTaskList->insertTask($aInsert);
        
    }
    
    public function deleteTask($id) 
    {
        
        $oModelTaskList = $this->loadModel('TaskList');
        $oModelTaskList->deleteTask($id[0]);
        
    }
    
    
    public function editTask($id) 
    {
        $aPost = $this->requestPost;
        
        $sTaskName = $aPost['editTaskName'];
        $sTaskDate = $aPost['editTaskDate'];
        $sTaskDescription = $aPost['editTaskDescription'];
        
        $oModelTaskList = $this->loadModel('TaskList');
        
        $aEdit = array(
            'todo_list_name' => $sTaskName,
            'todo_list_final_date' => $oModelTaskList->convertDateToDefault($sTaskDate),
            'todo_list_description' => $sTaskDescription
        );
        
        $oModelTaskList = $this->loadModel('TaskList');
        $oModelTaskList->editTask($id[0], $aEdit);
        
    }
    
    public function getAllInfo($id=false) 
    {
        $oModelTaskList = $this->loadModel('TaskList');
        $aTaskData = $oModelTaskList->getAllInfo($id);
        
        echo json_encode($aTaskData);
    }
    
}   