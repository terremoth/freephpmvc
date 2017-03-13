<?php

class ViewTaskList extends MainView {

    public function __construct($aData) {
        
        //css files to load
        $aCSS = array(
            'bootstrap.min',
            'bootstrap-theme.min',
            'bootstrap-datepicker.min',
            'template',
        );
        
        $this->loadHead($aCSS);
        
        ?>

                <!-- Fixed navbar -->
                <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#"><?php $this->loadImage('taskero.png', '200', null, null, 'margin-top:-10px'); ?></a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="<?php echo HOME_URI;?>">Home</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <form class="navbar-form">
                                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success">Create Task</button>
                                    </form>
                                </li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </nav>

                <div class="container">

                    <div class="row">
                        <h1>Tasks</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Task Name</th>
                                    <th>Task Date</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                
                            </tbody>
                        </table>
                    </div>

                </div> <!-- /container -->
                
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Create Task</h4>
                            </div>
                            <form id="createTaskForm">
                                <div class="modal-body">
                                        <div class="form-group">
                                            <label>Task Name:</label>
                                            <input maxlength="80" type="text" class="form-control" name="taskName">
                                        </div>
                                        <div class="form-group">
                                            <label>Task Date:</label>
                                            <div class="input-group date">
                                                <input maxlength="10" type="text" name="taskDate" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Description:</label>
                                            <textarea rows="10" maxlength="1024" name="taskDescription" class="form-control"></textarea>
                                        </div>
                                 </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" onclick="createTask();document.getElementById('createTaskForm').reset()" data-dismiss="modal" class="btn btn-success">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                 <!-- Modal -->
                <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalEditLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Edit Task</h4>
                            </div>
                            <form id="editTaskForm">
                                <div class="modal-body">
                                        <div class="form-group">
                                            <label>Task Name:</label>
                                            <input maxlength="80" type="text" class="form-control" name="editTaskName">
                                        </div>
                                        <div class="form-group">
                                            <label>Task Date:</label>
                                            <div class="input-group date">
                                                <input maxlength="10" type="text" name="editTaskDate" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Description:</label>
                                            <textarea rows="10" maxlength="1024" name="editTaskDescription" class="form-control"></textarea>
                                        </div>
                                 </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="editBtn" data-dismiss="modal" class="btn btn-success">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Modal -->
                <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalDeleteLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Delete Task</h4>
                            </div>
                            <form id="createTaskForm">
                                <div class="modal-body">
                                    <h3>Are you sure to delete this task? this cannot be undone!</h3>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="deleteBtn" data-dismiss="modal" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
        <?php
                
            $aScripts = array(
                'jquery-3.1.1.min',
                'bootstrap.min',
                'bootstrap-datepicker.min',
                'bootstrap-datepicker.pt-BR.min',
                'main',
            );
            
          
            $sCustomScript = '$(document).ready(function(){
                
                   var jqxhr = $.ajax(\''.HOME_URI.'/TaskList/loadTasks\')
                        .done(function(html) {
                          $("#tableBody").append(html);
                          $(".glyph-pencil").addClass("glyphicon");
                          $(".glyph-pencil").addClass("glyphicon-pencil");
                          
                          $(".glyph-remove").addClass("glyphicon");
                          $(".glyph-remove").addClass("glyphicon-remove");
                    });
                    

                        
            });
                    $(\'.input-group.date\').datepicker({
                        format: "dd/mm/yyyy",
                        todayBtn: "linked",
                        language: "pt-BR",
                        orientation: "bottom auto"
                    });
            
                    function createTask(){
                        $.ajax({
                            type: "POST",
                            url: \''.HOME_URI.'/TaskList/createTask\',
                            data: $(\'#createTaskForm\').serialize(),
                            success: function(){
                                var jqxhr = $.ajax(\''.HOME_URI.'/TaskList/loadTasks\')
                                    .done(function(html) {
                                      $("#tableBody").html(html);
                                      $(".glyph-pencil").addClass("glyphicon");
                                      $(".glyph-pencil").addClass("glyphicon-pencil");

                                      $(".glyph-remove").addClass("glyphicon");
                                      $(".glyph-remove").addClass("glyphicon-remove");
                                });
                            },
                          });
                    
                    }
                    
                    function prepareDelete(id){
                        var deleteBtn = $("#deleteBtn").attr("onclick", "deleteTask("+id+")");
                        $("#myModalDelete").modal("toggle");
                    }

                    function deleteTask(id){
                        

                        var jqxhr = $.ajax(\''.HOME_URI.'/TaskList/deleteTask/\'+id)
                            .done(function(msg) {
                            console.log(msg);
                              $.ajax(\''.HOME_URI.'/TaskList/loadTasks\').done(function(html) {
                                  $("#tableBody").html(html);
                                  $(".glyph-pencil").addClass("glyphicon");
                                  $(".glyph-pencil").addClass("glyphicon-pencil");

                                  $(".glyph-remove").addClass("glyphicon");
                                  $(".glyph-remove").addClass("glyphicon-remove");
                                  
                              });
                        });
                    }
                    
                    
                    function prepareEdit(id){
                        getAllInfo(id);
                        $("#editBtn").attr("onclick", "editTask("+id+")");
                        $("#myModalEdit").modal("toggle");
                        document.getElementById(\'editTaskForm\').reset();                    
                    }
                    var jsonResponse;
                    function getAllInfo(id){
                         var jqxhr = $.ajax(\''.HOME_URI.'/TaskList/getAllInfo/\'+id)
                            .done(function(json) {
                            jsonResponse = JSON.parse(json);
                                
                               document.getElementsByName("editTaskName")[0].value = jsonResponse[0]["todo_list_name"];
                               
                                var date = jsonResponse[0]["todo_list_final_date"];
                                var formatDate = date.split("-").reverse().join("/");
                                
                               document.getElementsByName("editTaskDate")[0].value = formatDate;
                               document.getElementsByName("editTaskDescription")[0].value = jsonResponse[0]["todo_list_description"];

                        });
                    }

                    function editTask(id){
                        $.ajax({
                            type: "POST",
                            url: \''.HOME_URI.'/TaskList/editTask/\'+id,
                            data: $(\'#editTaskForm\').serialize(),
                            success: function(){
                                var jqxhr = $.ajax(\''.HOME_URI.'/TaskList/loadTasks\')
                                    .done(function(html) {
                                      $("#tableBody").html(html);
                                      $(".glyph-pencil").addClass("glyphicon");
                                      $(".glyph-pencil").addClass("glyphicon-pencil");

                                      $(".glyph-remove").addClass("glyphicon");
                                      $(".glyph-remove").addClass("glyphicon-remove");
                                    document.getElementById(\'editTaskForm\').reset();                    
                                });
                            },
                          });
                         
                    
                    }
                    
                ';
                
                
                
                
            $this->loadPageEnd($aScripts, $sCustomScript);
    }

}
