<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todos-Test</title>
<!--    <script src="js/vuelidate.min.js"></script>-->
<!--    <script src="js/validators.min.js"></script>-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
<header class="hat">
    <div><h1>Todos-Test</h1></div>
</header>
<div id="todo">
    <div class="todo-actions"> 
        <div class="add-task" @click="addTask">New Task</div>
    </div>

    <div class="container-grid">
        <div class="column">
            <div class="title todo-title">TODO 
            <div class="task-counter" :class="conterBackground(todos.length)">{{todos.length}}</div></div>
            <draggable v-model="todos" group="tasks" @start=""  @end="endMove($event)" class="draggable-area" v-bind="dragOptions" :data-identity="1">
            <div class="task-block"  v-for="(todo,index) in todos" :key="todo.id">
                <div class="task-title"><span>Task {{index+1}}:{{todo.task}}</span></div>
                <div class="task-content">
                    <div class="task-description"> 
                       <span>Description:</span> {{todo.description}}
                    </div>
                    <div class="divider"></div>
                    <div class="task-comments">
                        <div class="task-comments__title">Comments: {{todo.comments.length}}</div>
                        <div class="comment" v-for="(comment,index) in todo.comments" :key="comment.id">
                            <div class="comment-text">{{index+1}}.{{comment.content}} </div>
                        </div>
                        <div class="comment-commands">
                            <div class="create-comment" @click="addFastComment(index,1)"><?= file_get_contents('static/images/Add.svg');?></div>
                            <div class="delete-comment" @click="deleteTaskModal(index,1)"><?= file_get_contents('static/images/Delete.svg');?></div>
                            <div class="update-comment" @click="updateTaskModal(index,1)"><?= file_get_contents('static/images/Update.svg');?></div>
                        </div>
                    </div>
                </div>
            </div>
            </draggable>
        </div>
        <div class="column">
            <div class="title doing-title">DOING 
            <div class="task-counter" :class="conterBackground(doings.length)"> {{doings.length}}</div></div>            
            <draggable v-model="doings" group="tasks" @start="" @end="endMove($event)" class="draggable-area" v-bind="dragOptions" :data-identity="2">
            <div class="task-block" v-for="(doing,index) in doings" :key="doing.id">
                <div class="task-title"><span>Task {{index+1}}:{{doing.task}}</span></div>
                <div class="task-content">
                    <div class="task-description">
                        <span>Description:</span> {{doing.description}}
                    </div>
                    <div class="divider"></div>
                    <div class="task-comments">
                        <div class="task-comments__title">Comments: {{doing.comments.length}}</div>
                        <div class="comment" v-for="(comment,index) in doing.comments" :key="comment.id">
                            <div class="comment-text">{{index+1}}.{{comment.content}} </div>
                        </div>
                        <div class="comment-commands">
                            <div class="create-comment" @click="addFastComment(index,2)"><?= file_get_contents('static/images/Add.svg');?></div>
                            <div class="delete-comment" @click="deleteTaskModal(index,2)"><?= file_get_contents('static/images/Delete.svg');?></div>
                            <div class="update-comment" @click="updateTaskModal(index,2)"><?= file_get_contents('static/images/Update.svg');?></div>
                        </div>
                    </div>
                </div>
            </div>
            </draggable>
        </div>
        <div class="column">
            <div class="title done-title">DONE 
            <div class="task-counter" :class="conterBackground(dones.length)">{{dones.length}}</div></div>
            <draggable v-model="dones" group="tasks" @start="" @end="endMove($event)" class="draggable-area"  v-bind="dragOptions" :data-identity="3">
            <div class="task-block"  v-for="(done,index) in dones" :key="done.id">
                <div class="task-title"><span>Task {{index+1}}:{{done.task}}</span></div>
                <div class="task-content">
                    <div class="task-description">
                        <span>Description:</span> {{done.description}}
                    </div>
                    <div class="divider"></div>
                    <div class="task-comments">
                        <div class="task-comments__title">Comments: {{done.comments.length}}</div>
                        <div class="comment" v-for="(comment,index) in done.comments" :key="comment.id">
                            <div class="comment-text">{{index+1}}.{{comment.content}} </div>
                        </div>
                        <div class="comment-commands">
                            <div class="create-comment" @click="addFastComment(index,3)"><?= file_get_contents('static/images/Add.svg');?></div>
                            <div class="delete-comment" @click="deleteTaskModal(index,3)"><?= file_get_contents('static/images/Delete.svg');?></div>
                            <div class="update-comment" @click="updateTaskModal(index,3)"><?= file_get_contents('static/images/Update.svg');?></div>
                        </div>
                    </div>
                </div>
            </div>
            </draggable>
        </div>
    </div>
<!--    modals-->
<!--    modal addTask-->
    <transition name="fade">
        <div class="add-task-modal__overlay" v-if="modals.addTask">
            <div class="background" @click="cancelTask"></div>
            <div class="add-task-modal_block">
                <div class="add-task-modal__title"><h2>Add Task</h2></div>
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Your Task</div>
                    <input type="text" class="add-task-modal__input" v-model="newTask.task">
                </div>
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Description</div>
                    <textarea type="text" class="add-task-modal__input" v-model="newTask.description" rows="10"></textarea>
                </div>
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Status</div>
                    <v-select v-model="newTask.status" label="title" :options="options" :clearable="false" @input="setStatus"></v-select>
                </div>
                <div class="commands">
                    <div class="submit" @click="createTask">Create New Task</div>
                    <div class="cancel" @click="cancelTask">Cancel</div>
                </div>
            </div>
        </div>
    </transition>
    <!--    modal newComment-->
    <transition name="fade">
        <div class="add-task-modal__overlay" v-if="modals.addFastComment">
            <div class="background" @click="cancelFastComment"></div>
            <div class="add-task-modal_block">
                <div class="add-task-modal__title"><h2>New Comment</h2></div>
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Write your comment</div>
                    <textarea type="text" class="add-task-modal__input" v-model="newFastComment.content" rows="10"></textarea>
                </div>
                <div class="commands">
                    <div class="submit" @click="createFastComment">Create Comment</div>
                    <div class="cancel" @click="cancelFastComment">Cancel</div>
                </div>
            </div>
        </div>
    </transition>
    <!--    modal deleteTask-->
    <transition name="fade">
        <div class="add-task-modal__overlay" v-if="modals.deleteTask.status">
            <div class="background" @click="cancelDeleteTask"></div>
            <div class="modal__block">
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Delete Task?</div>
                </div>
                <div class="commands">
                    <div class="submit" @click="deleteTask">Delete Task</div>
                    <div class="cancel" @click="cancelDeleteTask">Cancel</div>
                </div>
            </div>
        </div>
    </transition>
<!--       modal updateTask-->
    <transition name="fade">
        <div class="add-task-modal__overlay" v-if="modals.editTask.status">
            <div class="background" @click="cancelUpdateTaskModal"></div>
            <div class="add-task-modal_block">
                <div class="add-task-modal__title"><h2>Update Task</h2></div>
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Your Task</div>
                    <input type="text" class="add-task-modal__input" v-model="editTask.task">
                </div>
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Description</div>
                    <textarea type="text" class="add-task-modal__input" v-model="editTask.description" rows="10"></textarea>
                </div>
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Comments</div>
                    <div class="comment" v-for = "(comment,index) in editTask.comments" :key="comment.id">
                    <!-- <textarea type="text" class="add-task-modal__input" v-model="editTask.comments[index].content" rows="3"></textarea> -->
                       <div class="comment-text"><strong>{{index + 1}}. </strong>{{comment.content}}</div>
                    </div>
                </div>
                <div class="commands">
                    <div class="submit" @click="updateTask">Update Task</div>
                    <div class="cancel" @click="cancelUpdateTaskModal">Cancel</div>
                </div>
            </div>
        </div>
    </transition>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>
<script src="https://unpkg.com/vue-select@latest"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
<script src="js/app/index.js"></script>
</body>
</html>