<?php
namespace App\Models;

use App\Models\CoreModel;


class TaskModel extends CoreModel{
    public function __construct()
    {
        parent::__construct();
        if(!$this->hasConnection()){
            $connection_response = $this->makeConnection();
            if(!$this->utilityObject->isSuccessResponse($connection_response)){
                die($connection_response['message']);
            }
        }
        $this->setTableName('task');
    }
    public function countTasks($where){
        $response = $this->executeORM(['count' => true,'where' => $where]);
        if($this->utilityObject->isSuccessResponse($response)){
            return $response['result'];
        }
        return 0;
    }

    public function getTasks($select = [],$where = []){
        $response = $this->executeORM(['where' => $where,'select' => $select]);
        if($this->utilityObject->isSuccessResponse($response)){
            return $response['result'];
        }
        return [];
    }

    public function add($data = []){
        if(!empty($data)){
            return $this->executeORM(['insert' => true,'data' =>$data]);
        }else{
            return ['status' => 'error', 'message' => 'Data is not given to save. Code:TMA1'];
        }
    }

    public function updateTask($id,$data =[]){
        if(!empty($id)){
            return $this->executeORM(['update' => true,'data' =>$data,'where' => ['id' => $id]]);
        }else{
            return ['status' => 'error', 'message' => 'Data is not given to update. Code:TMUT1'];
        }
    }


    public function deleteTask($id){
        if(!empty($id)){
            return $this->executeORM(['delete' => true,'where' => ['id' => $id]]);
        }else{
            return ['status' => 'error', 'message' => 'Data is not given to update. Code:TMUT1'];
        }
    }

    public function removeCompleted(){
        return $this->executeORM(['delete' => true,'where' => ['status' => 1]]);
    }
}