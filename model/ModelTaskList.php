<?php
class ModelTaskList extends MainModel 
{    
    /**
     * Returns to-do list
     * @return array To-do list data
     */
    public function getTodoList() 
    {
        $this->initDB();
        $oList = $this->db;
        $oQuery = $oList->query('SELECT * FROM `todo_list`');
        $oQuery->execute();
        $aTodoList = $oQuery->fetchAll();
        
        if(count($aTodoList) > 0){
            echo $this->createTable($aTodoList);
        } else {
            echo '<tr><td colspan="3">There are no tasks to show :-)</td></tr>';
        }
        
    }
    
    /**
     * 
     * @param array $aTodoList Array with database values 
     * @return string html table
     */
    public function createTable($aTodoList) 
    {
        $sBigList = '';
        
        foreach ($aTodoList as $key) {
            $sBigList .= '
                <tr>'."\n"
                . '<td>'.$key['todo_list_name'].'</td>'."\n"
                . '<td>'.$this->dateToBr($key['todo_list_final_date']).'</td>'."\n"
                . '<td>'
                . '     <button type="button" class="btn btn-default" onclick="prepareEdit('.$key['todo_list_id'].');"><span class="glyph-pencil"></span></button>'
                . '     <button type="button" class="btn btn-danger" onclick="prepareDelete('.$key['todo_list_id'].');"><span class="glyph-remove"></span></button>'
                . '</td>'."\n"
                . '</tr>'."\n";
        }
        
        return $sBigList;
    }
    
    public function dateToBr($sDefaultDate)
    {
        return date('d/m/Y', strtotime($sDefaultDate));
    }
    
    public function convertDateToDefault($sBrazilDate) 
    {
        $aDatePasrts = explode('/', $sBrazilDate);
        return $aDatePasrts[2].'-'.$aDatePasrts[1].'-'.$aDatePasrts[0];
    }


    public function createTask($aPost) 
    {
        $this->initDB();
        $oList = $this->db;
        $oQuery = $oList->query('SELECT * FROM `todo_list`');
        $oQuery->execute();
        
    }
    
    public function insertTask($aInsert) {
        $sTableName = 'todo_list';
        
        $this->initDB();
        $oList = $this->db;
        $oQuery = $oList->insert($sTableName, $aInsert);
        
    }
    
    function deleteTask($id){
        $sTableName = 'todo_list';
        
        $this->initDB();
        $oList = $this->db;
        $sField = 'todo_list_id';
        
        $oQuery = $oList->delete($sTableName, $sField, $id);
    }
    
    function editTask($id, $aValues){
        $sTableName = 'todo_list';
        
        $this->initDB();
        $oList = $this->db;
        $sField = 'todo_list_id';
        
        $oQuery = $oList->update($sTableName, $sField, $id, $aValues);
    }
    
    function getAllInfo($id){
        
        $this->initDB();
        $oList = $this->db;
        $oQuery = $oList->query('SELECT * FROM `todo_list` WHERE `todo_list_id` = '.$id[0]);
        $oQuery->execute();
        return $oQuery->fetchAll();
    }
}
