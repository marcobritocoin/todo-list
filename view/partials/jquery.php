<?php
$config = require_once('config/dataConfig.php');
?>
<script type="text/javascript">
$(document).ready(function() {
    const todoBtn = $('#add-todo'); //todo button Selector
    const updateTodoModal = $("#modal") // update todo modal selector
    const modalTodoInput = $("#modalInput"); // modal todo input selector
    const todoUpdateBtn = $("#updateBtn"); // modal todo update button selector

    const newTodoForm = $("#new-todo-form");
    const tituloModal = $("#modalInputTarea");
    const descripcionModal = $("#modalInputDescripcion");
    const btnCreate = $("#btn-createTask");

    const fCreacion = $("#modalInputFcreacion");
    const fLimite = $("#modalInputFlimite");

    var selectedId = null;
    var datos = [];

    newTodoForm.on( "submit", function( event ) {
        event.preventDefault();
    })

    const resetModal = ()=>{
        tituloModal.val('');
        descripcionModal.html('');
        descripcionModal.val('');
        descripcionModal.empty();
    }

    const fetchTodos = () => {
        $.ajax({
            type: 'GET',
            url: '<?php echo $config["path"]?>/index.php?controller=todo&function=fetch',
            success: function(res) {
                const parseRes = JSON.parse(res);
                const {
                    success,
                    todos,
                    total
                } = parseRes;
                datos = todos;               
                if (success) {
                    var todosHtml = '';
                    if (total > 0) {

                        $('#total-todos').html('Cantidad Tareas: ' + total);
                        $.map(todos, function(todo, key) {
                            // todosHtml += '<li class="list-group-item d-flex justify-content-between align-items-center">' + todo.titulo + '<span><a class="edit-todo text-success mr-2" data-todo-id="' + todo.id_tarea + '" href="javascript:void(0)"> <i class="fa fa-edit"></i> </a> <a  class="del-todo text-danger" data-todo-id="' + todo.id_tarea + ' " href="javascript:void(0)"> <i class="fas fa-trash-alt"></i> </a><span></li>'
                            // todosHtml += '<tr><td>' + todo.titulo + '</td><td><span><a class="edit-todo text-success mr-2" data-todo-id="' + todo.id_tarea + '" href="javascript:void(0)"> <i class="fa fa-edit"></i> </a> <a  class="del-todo text-danger" data-todo-id="' + todo.id_tarea + ' " href="javascript:void(0)"> <i class="fas fa-trash-alt"></i> </a><span></td><td><input class="end-todo" type="checkbox"  data-todo-id="' + todo.id_tarea + ' " id="taskEnd"/></td></tr>';
                            todosHtml += '<tr><td>' + todo.titulo + '</td><td><span><a class="edit-todo text-success mr-2" data-todo-id="' + todo.id_tarea + '" href="javascript:void(0)"> <i class="fa fa-edit"></i> </a> <a  class="del-todo text-danger" data-todo-id="' + todo.id_tarea + ' " href="javascript:void(0)"> <i class="fas fa-trash-alt"></i> </a><span></td></tr>';

                        });
                        $('#todos-list').html(todosHtml);

                    } else {
                        $('#total-todos').html('Cantidad Tareas: ' + 0);
                        $('#todos-list').html('<li class="list-group-item d-flex justify-content-between align-items-center">Ninguna tarea encontrada :)</li>')
                    }
                } else {
                    toastr.info('Unable to fetch todos')
                }
            }
        })
    }

    fetchTodos();

    btnCreate.click(function() {
        const titulo = $("#title").val();
        const descripcion = $("#content").val();

        if ($.trim(titulo).length > 0 ) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $config["path"]?>/index.php?controller=todo&function=create',
                data: {
                    titulo,
                    descripcion
                },
                success: function(res) {
                    console.log(res);
                    const parseRes = JSON.parse(res);
                    console.log(parseRes);

                    if (parseRes.success) {
                        $("#title").val(null);
                        $("#content").val(null);
                        fetchTodos();
                        toastr.success(parseRes.message)
                    } else toastr.error(parseRes.message)
                }
            })
        } else {
            toastr.info('Por favor escribe el titulo de la Tarea')
        }
    })

    $('#todos-list').on('click', '.del-todo', function() {
        const todoId = $(this).data('todo-id');

        if (confirm("¿Estás seguro que deseas eliminar la tarea?") == true) {
            $.ajax({
                type: 'POST',
                url: `<?php echo $config["path"]?>/index.php?controller=todo&function=delete&id=${todoId}`,
                data: {
                    todoId
                },
                success: function(res) {
                    const parseRes = JSON.parse(res);
                    if (parseRes.success) {
                        fetchTodos();
                        toastr.success(parseRes.message)
                    } else toastr.error(parseRes.message)
                }
            })
        } 

    })

    $('#todos-list').on('click', '.edit-todo', function() {
        const todoId = $(this).data('todo-id');
        const objData = datos.find((a)=> a.id_tarea == todoId);
        console.log(objData);

        selectedId = todoId;
        tituloModal.val(objData.titulo);
        descripcionModal.html(objData.descripcion); 
        descripcionModal.val(objData.descripcion); 

        fCreacion.html("Fecha creación: "+objData.fecha_creacion);

        if(objData.fecha_limite != "0000-00-00 00:00:00"){
            fLimite.html("Fecha Limite: "+objData.fecha_limite);
        }

        updateTodoModal.modal('show');
    })

    $('#todos-list').on('click', '.end-todo', function() {
        const todoId = $(this).data('todo-id');
        const objData = datos.find((a)=> a.id_tarea == todoId);
        console.log(objData);

        if (confirm("¿Desea finalizar la tarea?") == true) {

        }

    })

    todoUpdateBtn.click(function() {
        const titulo = $("#modalInputTarea").val();
        const descripcion = $("#modalInputDescripcion").val();
        resetModal();

        $.ajax({
            type: 'POST',
            url: '<?php echo $config["path"]?>/index.php?controller=todo&function=update',
            data: {
                todoId: selectedId,
                titulo,
                descripcion
            },
            success: function(res) {
                const parseRes = JSON.parse(res);
                if (parseRes.success) {
                    updateTodoModal.modal('hide');
                    toastr.success(parseRes.message);
                    fetchTodos();
                } else toastr.error(parseRes.message)
            }
        })
    })

})

</script>