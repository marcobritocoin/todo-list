<?php
require_once 'baseController.php';
class todoController  extends BaseController
{
    public function __construct() 
    {
        parent::__construct();
        include('model/todoModel.php');
        $this->obj = new homeModel();
    }
    public function index()
    {
        $this->loadView('view/partials/task.php');
    }
    public function fetch()
    {
        $data = $this->obj->todo();
        $response = [
            'success' => true,
            'total' => count($data),
            'todos' => $data
        ];
        echo json_encode($response);
        exit();
    }
    public function create()
    {   
        if (isset($_POST) && !empty($_POST)) {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $dataSend = [
                "titulo"=> $titulo,
                "descripcion"=> $descripcion,
                "fecha_creacion"=> "",
                "fecha_modificacion"=> "",
                "fecha_limite"=> ""
            ];
            $data = $this->obj->addTodo($dataSend);
            if ($data) {
               $response = [
                   'success' => true,
                   'message' => '¡Tarea registrada!'
               ];
            } else {     
                $response = [
                    'success' => false,
                    'message' => 'Error registrando tarea'
                ];
            }
            echo json_encode($response);
            exit();
        }
    }
    public function delete()
    {
        if (isset($_POST)) {
            $id = $_POST['todoId'];
            $todo = $this->obj->delTodoById($id);
            if ($todo) {
                $response = [
                    'success' => true,
                    'message' => '¡Tarea eliminada correctamente!'
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Error eliminando tarea'
                ];
            }
        
            echo json_encode($response);
            exit();
        }
    }
    public function edit()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $todo = $this->obj->getTodoById($id);
            $response = [
                'success' => true,
                'id' => $id,
                'todo' => isset($todo['todo']) ? $todo['todo'] : null 
            ];
            
            echo json_encode($response);
            exit();
        }            
    }
    public function update()
    {
        if (isset($_POST) && !empty($_POST)) {
            $id = $_POST['todoId'];
            $titulo = $_POST['titulo'];  
            $descripcion = $_POST['descripcion'];  
            $data = $this->obj->updateTodoById($id, $titulo, $descripcion);
            if ($data) {
                $response = [
                    'success' => true,
                    'message' => '¡Tarea actualizada correctamente!'
                ];
            } else {     
                $response = [
                    'success' => false,
                    'message' => 'Error actualizando tarea'
                ];
            }
            echo json_encode($response);
            exit();
        }
    }  
}