<main class="app">
    <div class="container">
    <div class="toDoApp">
		<section class="create-todo">
			<h2>ToDo LIST</h2>
			<form id="new-todo-form">
				<h4>¿Qué vas a añadir?</h4>
				<input 
					type="text" 
					placeholder="Título de la tarea"
					name="title"
					id="title"/>
				<input 
					type="text" 
					placeholder="Descripción"
					name="content"
					id="content"/>
				<input type="submit" id="btn-createTask" value="Añade a tu lista" />
			</form>
			<section class="todo-list">
				<h4>COSAS POR HACER</h4>
				<div class="list" id="total-todos"></div>
			</section>
			
			<div class="container1">
				<!-- <div class="row">
					<div class="col-sm d-flex justify-content-between align-items-center">
						Tarea
					</div>
					<div class="col-sm">
						Acción
					</div>
				</div> -->

				<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col-sm d-flex justify-content-between align-items-center">Tarea</th>
						<th scope="col-sm">Acciones</th>
						<th scope="col-sm">Finalizar</th>
					</tr>
				</thead>
				<tbody id="todos-list">
				</tbody>
				</table>

				<!-- <div class="list" id="todos-list"></div> -->

			</div>
			</section>
</div>
</div>
</main>


 <!-- Edit Todo Modal -->
 <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Edit Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="modalTodoForm">
                    <input class="form-control border border-primary" type="text" id="modalInputTarea">
					<br>
					<textarea class="form-control rounded-0 border border-primary" id="modalInputDescripcion" rows="3"></textarea>
					<br>
					<!-- <input class="form-control border border-primary" type="text" id="modalInputFcreacion">
					<input class="form-control border border-primary" type="text" id="modalInputF"> -->
					<br>
					<span id="modalInputFcreacion"></span>
					<br>
					<span id="modalInputFlimite"></span>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                <button type="button" class="btn btn-primary" id="updateBtn"> Update</button>
            </div>
            </div>
        </div>
    </div>