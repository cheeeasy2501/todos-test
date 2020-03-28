(function()
{
    const deleteTaskUrl =  'api/Tasks/Delete.php';
    const updateTaskUrl = 'api/Tasks/Update.php';
    const createTaskUrl =  'api/Tasks/ReadCreate.php';
    const readTaskUrl =  'api/Tasks/ReadCreate.php';

    const createCommentUrl = 'api/Comments/Create.php'; 

    window.app = new Vue({
        el:"#todo",
        data:()=>({

            modals: {
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
            this.loading = true;
            this.getTodo();
            setTimeout(function(){
                window.app.loading = false;
            },2000);
        },

        methods: {
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
                        createCommentUrl,
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

            cancelUpdateTaskModal()
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
                    updateTask,
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
                    deleteTaskUrl,
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
                        createTaskUrl,
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
                    readTaskUrl
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
                                response.data[index].comments = [];
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
})();