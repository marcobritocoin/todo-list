<?php
date_default_timezone_set("Europe/Madrid");
class homeModel extends dbConnect
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function addTodo($todo)
    {
        $query = "INSERT INTO tarea (titulo, descripcion, fecha_creacion, fecha_modificacion, fecha_limite) 
                    VALUES (?, ?, ?, ?, ?)";

        $data = $this->execute_query($query, [  $todo['titulo'],
                                                $todo['descripcion'], 
                                                date('Y-m-d H:i:s'),
                                                date('Y-m-d H:i:s'),
                                                $todo['fecha_limite']]);  
        return true;
    }
    public function todo()
    {
        $todos = [];
        $query = "SELECT * FROM tarea order by id_tarea DESC";
        $data = $this->execute_query($query);
        while($row = $data->fetch(PDO::FETCH_ASSOC)){
            array_push( $todos, $row );
        }
        return $todos;
    }
    public function getTodoById($id)
    {
        $query = 'SELECT titulo FROM tarea WHERE id_tarea="'.$id.'"';
        $data = $this->execute_query($query);
        return $data->fetch(PDO::FETCH_ASSOC);
    }
    public function updateTodoById($id, $titulo, $descripcion)
    {
        $query = 'UPDATE tarea SET
                titulo ="'.$titulo.'",
                descripcion ="'.$descripcion.'",
                fecha_modificacion = "'.date('Y-m-d H:i:s').'"
                WHERE id_tarea ="'.$id.'"
                ';
        $data = $this->execute_query($query);
        return $data;
    }
    public function delTodoById($id)
    {
        $query = 'DELETE FROM tarea WHERE id_tarea= "'.$id.'"';
        $data = $this->execute_query($query);
        return $data;
    }
}