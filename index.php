<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!--    <script src="js/vuelidate.min.js"></script>-->
<!--    <script src="js/validators.min.js"></script>-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
<header class="hat">
    <div><h1>SpurIt test</h1></div>
</header>
<div id="todo">
    <div class="add-task" @click="addTask">Создать задачу</div>
    <div class="container-grid">
        <div class="column">
            <div class="title todo-title">TODO</div>
            <div class="task-block"  v-for="(todo,index) in todos" :key="index" v-if="todo.status==1">
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
                            <div class="create-comment" @click="addFastComment(index)"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/><path d="M0 0h24v24H0z" fill="none"/></svg></div>
                            <div class="delete-comment" @click="deleteTaskModal(index,todos[index].id)"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M15 16h4v2h-4zm0-8h7v2h-7zm0 4h6v2h-6zM3 18c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V8H3v10zM14 5h-3l-1-1H6L5 5H2v2h12z"/><path d="M0 0h24v24H0z" fill="none"/></svg></div>
                            <div class="update-comment" @click="updateTaskModal(index)"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><g><rect fill="none" height="24" width="24" x="0"/></g><g><g><g><path d="M21,10.12h-6.78l2.74-2.82c-2.73-2.7-7.15-2.8-9.88-0.1c-2.73,2.71-2.73,7.08,0,9.79s7.15,2.71,9.88,0 C18.32,15.65,19,14.08,19,12.1h2c0,1.98-0.88,4.55-2.64,6.29c-3.51,3.48-9.21,3.48-12.72,0c-3.5-3.47-3.53-9.11-0.02-12.58 s9.14-3.47,12.65,0L21,3V10.12z M12.5,8v4.25l3.5,2.08l-0.72,1.21L11,13V8H12.5z"/></g></g></g></svg></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="title doing-title">DOING</div>
            <div class="task-block"  v-for="(todo,index) in todos" :key="index" v-if="todo.status==2">
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
                            <div class="create-comment" @click="addFastComment(index)"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/><path d="M0 0h24v24H0z" fill="none"/></svg></div>
                            <div class="delete-comment" @click="deleteTaskModal(index,todos[index].id)"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M15 16h4v2h-4zm0-8h7v2h-7zm0 4h6v2h-6zM3 18c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V8H3v10zM14 5h-3l-1-1H6L5 5H2v2h12z"/><path d="M0 0h24v24H0z" fill="none"/></svg></div>
                            <div class="update-comment" @click="updateTaskModal(index)"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><g><rect fill="none" height="24" width="24" x="0"/></g><g><g><g><path d="M21,10.12h-6.78l2.74-2.82c-2.73-2.7-7.15-2.8-9.88-0.1c-2.73,2.71-2.73,7.08,0,9.79s7.15,2.71,9.88,0 C18.32,15.65,19,14.08,19,12.1h2c0,1.98-0.88,4.55-2.64,6.29c-3.51,3.48-9.21,3.48-12.72,0c-3.5-3.47-3.53-9.11-0.02-12.58 s9.14-3.47,12.65,0L21,3V10.12z M12.5,8v4.25l3.5,2.08l-0.72,1.21L11,13V8H12.5z"/></g></g></g></svg></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="title done-title">DONE</div>
            <div class="task-block"  v-for="(todo,index) in todos" :key="index" v-if="todo.status==3">
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
                            <div class="create-comment" @click="addFastComment(index)"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/><path d="M0 0h24v24H0z" fill="none"/></svg></div>
                            <div class="delete-comment" @click="deleteTaskModal(index,todos[index].id)"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M15 16h4v2h-4zm0-8h7v2h-7zm0 4h6v2h-6zM3 18c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V8H3v10zM14 5h-3l-1-1H6L5 5H2v2h12z"/><path d="M0 0h24v24H0z" fill="none"/></svg></div>
                            <div class="update-comment" @click="updateTaskModal(index)"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><g><rect fill="none" height="24" width="24" x="0"/></g><g><g><g><path d="M21,10.12h-6.78l2.74-2.82c-2.73-2.7-7.15-2.8-9.88-0.1c-2.73,2.71-2.73,7.08,0,9.79s7.15,2.71,9.88,0 C18.32,15.65,19,14.08,19,12.1h2c0,1.98-0.88,4.55-2.64,6.29c-3.51,3.48-9.21,3.48-12.72,0c-3.5-3.47-3.53-9.11-0.02-12.58 s9.14-3.47,12.65,0L21,3V10.12z M12.5,8v4.25l3.5,2.08l-0.72,1.21L11,13V8H12.5z"/></g></g></g></svg></div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <input type="text" class="add-task-modal__input" v-model.number="newTask.status">
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
            <div class="background" @click="cancelupdateTaskModal"></div>
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
                    <div class="add-task-modal__name">Status</div>
                    <input type="text" class="add-task-modal__input" v-model.number="editTask.status">
                </div>
                <div class="add-task-modal__group">
                    <div class="add-task-modal__name">Comments</div>
                    <div class="comment" v-for = "(comment,index) in editTask.comments" :key="comment.id">
                        {{index}}.<textarea type="text" class="add-task-modal__input" v-model="editTask.comments[index].content" rows="3"></textarea>
                    </div>
                </div>
                <div class="commands">
                    <div class="submit" @click="updateTask">Update Task</div>
                    <div class="cancel" @click="cancelupdateTaskModal">Cancel</div>
                </div>
            </div>
        </div>
    </transition>
</div>
<script>
    var app = new Vue({
        el:"#todo",
        data:()=>({
            modals:
                  {
                      addTask:false,
                      addFastComment:false,
                      deleteTask:
                                  {
                                      status:false,
                                      deleteId:null,
                                      index:null
                                  },
                        editTask:
                                {
                                      status: false,
                                      updateId:null,
                                      index:null
                                }
                      },
            todos:[],
            newFastComment: {
                                index:null,
                                task_id:null,
                                content:null
                             },
            newTask:
                    {
                        task:null,
                        description:null,
                        status:null
                    },
             editTask:
                    {
                        task:null,
                        description:null,
                        status:null,
                        comments:null
                    }
        }),
        mounted()
        {
            this.getTodo();
        },
        methods:
            {
                cancelFastComment()
                {
                    this.modals.addFastComment = false;
                    this.newFastComment.content = null;
                },
                createFastComment()
                {
                    if(this.newFastComment.content!=null)
                    {
                        axios.post(
                            'api/Comments/CreateAction.php',
                            {
                                content: this.newFastComment.content,
                                task_id: this.newFastComment.task_id,
                            }
                        )
                            .then(function (response) {
                                let newComment = {content:app.newFastComment.content,id:response.data}
                                app.todos[app.newFastComment.index].comments.push(newComment)
                                app.modals.addFastComment = false;

                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                addFastComment(index)
                {
                    console.log(index);
                    this.newFastComment.index = index;
                    this.newFastComment.task_id = this.todos[index].id;
                    this.newFastComment.content = null;
                    this.modals.addFastComment = true;
                },
                cancelupdateTaskModal()
                {
                    this.modals.editTask.status = false;
                    this.modals.editTask.updateId = this.editTask.task =
                        this.editTask.description =this.editTask.status =
                            this.editTask.comments = null;
                },
                updateTaskModal(index)
                {
                    this.modals.editTask.status = true;
                    this.modals.editTask.index = index;
                    this.modals.editTask.updateId = this.todos[index].id;
                    this.editTask.task = this.todos[index].task;
                    this.editTask.description = this.todos[index].description;
                    this.editTask.status = this.todos[index].status;
                    this.editTask.comments = this.todos[index].comments;
                },
                updateTask()
                {
                    axios.post(
                        'api/Tasks/UpdateAction.php',
                        {
                            updateId: this.modals.editTask.updateId,
                            task:this.editTask.task,
                            description: this.editTask.description,
                            status:this.editTask.status
                        }
                    )
                        .then(function (response) {
                            app.modals.editTask.status = false;
                            app.todos[app.modals.editTask.index].task = app.editTask.task;
                            app.todos[app.modals.editTask.index].description = app.editTask.description;
                            app.todos[app.modals.editTask.index].status = app.editTask.status;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                deleteTaskModal(index,deleteId)
                {
                    this.modals.deleteTask.status = true;
                    this.modals.deleteTask.index= Number(index);
                    this.modals.deleteTask.deleteId  = Number(deleteId);
                },
                deleteTask()
                {
                    axios.post(
                        'api/Tasks/DeleteAction.php',
                        {
                            deleteId: this.modals.deleteTask.deleteId,
                        }
                    )
                        .then(function (response) {
                            app.todos.splice(app.modals.deleteTask.index,1);
                            app.modals.deleteTask.status = false;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                cancelDeleteTask()
                {
                    this.modals.deleteTask.deleteId = this.modals.deleteTask.index = null;
                    this.modals.deleteTask.status = false;
                },
                addTask()
                {
                    this.newTask.task = this.newTask.description = this.newTask.status = null;
                    this.modals.addTask = true;
                },
                cancelTask()
                {
                    this.modals.addTask = false;
                    this.newTask.task = this.newTask.description = this.newTask.status = null;
                },
                createTask()
                {
                    if(this.newTask.task !=null && this.newTask.description!=null && this.newTask.status!=null)
                    {
                        axios.post(
                            'api/Tasks/TaskApi.php',
                            {
                                task: this.newTask.task,
                                description: this.newTask.description,
                                status:Number(this.newTask.status)
                            }
                        )
                            .then(function (response) {
                                app.todos.push(
                                    {
                                        task:app.newTask.task,
                                        description:app.newTask.description,
                                        status:app.newTask.status,
                                        comments:[]
                                    })
                                app.modals.addTask = false;
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        }
                },
                getTodo()
                {
                    axios.get(
                        'api/Tasks/TaskApi.php'
                    )
                        .then(function (response) {
                            for(index in response.data)
                            {
                                if(response.data[index].comments!=null)
                                {
                                    response.data[index].comments=response.data[index].comments.split("|");
                                    for (numComment in response.data[index].comments)
                                    {
                                        response.data[index].comments[numComment] = JSON.parse(response.data[index].comments[numComment]);
                                    }
                                }
                                else
                                {
                                    response.data[index].comments =[];
                                }
                            }
                            console.log(response.data);
                            app.todos = response.data;

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
            }
    })
</script>
</body>
</html>