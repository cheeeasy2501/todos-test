(function () {
    //Tasks Urls
    const deleteTaskUrl = 'api/Tasks/Delete.php';
    const updateTaskUrl = 'api/Tasks/Update.php';
    const createTaskUrl = 'api/Tasks/ReadCreate.php';
    const readTaskUrl = 'api/Tasks/ReadCreate.php';

    //Comment Urls
    const createCommentUrl = 'api/Comments/Create.php';
    const deleteCommentUrl = 'api/Comments/Delete.php';

    //Status const
    const updateStatusUrl = 'api/Tasks/Status/Update.php';
    const todoStatus = { title: 'todo', status_identity: 1 };
    const doingStatus = { title: 'doing', status_identity: 2 };
    const doneStatus = { title: 'done', status_identity: 3 };

    window.app = new Vue({
        el: "#todo",
        data: () => ({
            todos: [],
            doings: [],
            dones: [],

            options: [
                todoStatus,
                doingStatus,
                doneStatus
            ],

            modals: {
                addTask: false,
                addFastComment: false,

                deleteComment:
                {
                    arrNum: null,
                    index: null,
                    deleteId: null,
                },

                deleteTask:
                {
                    arrNum: null,
                    index: null,
                    deleteId: null,
                    status: false
                },
                editTask:
                {
                    arrNum: null,
                    index: null,
                    updateId: null,
                    status: false
                }
            },

            newFastComment: {
                arrNum: null,
                index: null,
                task_id: null,
                content: null
            },
            newTask: {
                arrNum: null,
                task: null,
                description: null,
                status: null
            },
            editTask: {
                task: null,
                description: null,
                status: null,
                comments: null
            }
        }),
        mounted() {
            this.getTodo();
        },
        components:
        {
            'v-select': VueSelect.VueSelect
        },
        computed: {

            dragOptions() {
                return {
                    animation: 200,
                    disabled: false,
                    ghostClass: "ghost",
                    forceFallback: true,
                    fallbackClass: "sortable-fallback",
                    swapThreshold: 50,
                };
            }
        },
        methods: {
            conterBackground(count) {
                if (count <= 3) {
                    return 'well-counter';
                }
                else if (count <= 6) {
                    return 'satisfactorily-counter';
                }
                else if (count > 6) {
                    return 'badly-counter';
                }
            },

            deleteComment(index, arrNum, deleteId,taskIndex) {
                axios.post(
                    deleteCommentUrl,
                    {
                        deleteId: deleteId,
                    }
                )
                    .then(function (response) {
                        switch (parseInt(arrNum)) {
                            case 1:
                                app.todos[taskIndex].comments.splice(index, 1);
                                break;

                            case 2:
                                app.doings[taskIndex].comments.splice(index, 1);
                                break;

                            case 3:
                                app.dones[taskIndex].comments.splice(index, 1);
                                break;
                        }

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            setStatus(event) {
                this.newTask.status = { title: event.title, status_identity: event.status_identity };
            },

            updateStatus(id, status) {
                axios.post(
                    updateStatusUrl,
                    {
                        updateId: id,
                        status: status
                    }
                )
                    .then(function (response) {
                        console.log('status update')
                    })
                    .catch(function (error) {
                        console.log('status update error');
                        console.log(error);
                    });
            },

            endMove(event) {
                if (event.from.dataset.identity != event.to.dataset.identity) {
                    switch (parseInt(event.to.dataset.identity)) {
                        case 1:
                            this.todos[event.newIndex].status = todoStatus.title;
                            this.updateStatus(this.todos[event.newIndex].id, todoStatus.status_identity)
                            break;

                        case 2:
                            this.doings[event.newIndex].status = doingStatus.title;
                            this.updateStatus(this.doings[event.newIndex].id, doingStatus.status_identity)
                            break;

                        case 3:
                            this.dones[event.newIndex].status = doneStatus.title;
                            this.updateStatus(this.dones[event.newIndex].id, doneStatus.status_identity)
                            break;

                        default:
                            console.log('default endMove');
                            break;
                    }
                }
            },

            cancelFastComment() {
                this.modals.addFastComment = false;
                this.newFastComment.content = null;
            },

            createFastComment() {
                if (this.newFastComment.content != null) {
                    axios.post(
                        createCommentUrl,
                        {
                            content: this.newFastComment.content,
                            task_id: this.newFastComment.task_id,
                        }
                    )
                        .then(function (response) {
                            let newComment = { content: app.newFastComment.content, id: response.data }
                            switch (parseInt(app.newFastComment.arrNum)) {
                                case 1:
                                    app.todos[app.newFastComment.index].comments.push(newComment)
                                    break;

                                case 2:
                                    app.doings[app.newFastComment.index].comments.push(newComment)
                                    break;

                                case 3:
                                    app.dones[app.newFastComment.index].comments.push(newComment)
                                    break;
                            }
                            app.modals.addFastComment = false;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },

            addFastComment(index, arrNum) {
                this.newFastComment.index = index;
                this.newFastComment.arrNum = parseInt(arrNum);
                switch (parseInt(this.newFastComment.arrNum)) {
                    case 1:
                        this.newFastComment.task_id = this.todos[index].id;
                        break;

                    case 2:
                        this.newFastComment.task_id = this.doings[index].id;
                        break;

                    case 3:
                        this.newFastComment.task_id = this.dones[index].id;
                        break;
                }
                this.newFastComment.content = null;
                this.modals.addFastComment = true;
            },

            cancelUpdateTaskModal() {
                this.modals.editTask.status = false;
                this.modals.editTask.updateId = this.editTask.task =
                    this.editTask.description = this.editTask.status =
                    this.editTask.comments = null;
            },

            updateTaskModal(index, arrNum) {
                this.modals.editTask.status = true;
                this.modals.editTask.index = index;
                this.modals.editTask.arrNum = parseInt(arrNum);
                switch (parseInt(arrNum)) {
                    case 1:
                        this.modals.editTask.updateId = this.todos[index].id;
                        this.editTask.task = this.todos[index].task;
                        this.editTask.description = this.todos[index].description;
                        this.editTask.comments = this.todos[index].comments;
                        break;

                    case 2:
                        this.modals.editTask.updateId = this.doings[index].id;
                        this.editTask.task = this.doings[index].task;
                        this.editTask.description = this.doings[index].description;
                        this.editTask.comments = this.doings[index].comments;
                        break;

                    case 3:
                        this.modals.editTask.updateId = this.dones[index].id;
                        this.editTask.task = this.dones[index].task;
                        this.editTask.description = this.dones[index].description;
                        this.editTask.comments = this.dones[index].comments;
                        break;
                }

            },

            updateTask() {
                axios.post(
                    updateTaskUrl,
                    {
                        updateId: this.modals.editTask.updateId,
                        task: this.editTask.task,
                        description: this.editTask.description
                    }
                )
                    .then(function (response) {
                        switch (parseInt(app.modals.editTask.arrNum)) {
                            case 1:
                                app.todos[app.modals.editTask.index].task = app.editTask.task;
                                app.todos[app.modals.editTask.index].description = app.editTask.description;
                                break;

                            case 2:
                                app.doings[app.modals.editTask.index].task = app.editTask.task;
                                app.doings[app.modals.editTask.index].description = app.editTask.description;
                                break;

                            case 3:
                                app.dones[app.modals.editTask.index].task = app.editTask.task;
                                app.dones[app.modals.editTask.index].description = app.editTask.description;
                                break;
                        }
                        app.modals.editTask.status = false;
                    })
                    .catch(function (error) {
                        console.log('response error');
                        console.log(error);
                    });
            },

            deleteTaskModal(index, arrNum) {
                this.modals.deleteTask.status = true;
                this.modals.deleteTask.index = Number(index);
                this.modals.deleteTask.arrNum = parseInt(arrNum);
                switch (parseInt(arrNum)) {
                    case 1:
                        this.modals.deleteTask.deleteId = this.todos[index].id;
                        break;

                    case 2:
                        this.modals.deleteTask.deleteId = this.doings[index].id;
                        break;

                    case 3:
                        this.modals.deleteTask.deleteId = this.dones[index].id;
                        break;
                }
            },

            deleteTask() {
                axios.post(
                    deleteTaskUrl,
                    {
                        deleteId: this.modals.deleteTask.deleteId,
                    }
                )
                    .then(function (response) {
                        switch (parseInt(app.modals.deleteTask.arrNum)) {
                            case 1:
                                app.todos.splice(app.modals.deleteTask.index, 1);
                                break;

                            case 2:
                                app.doings.splice(app.modals.deleteTask.index, 1);
                                break;

                            case 3:
                                app.dones.splice(app.modals.deleteTask.index, 1);
                                break;
                        }
                        app.modals.deleteTask.status = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            cancelDeleteTask() {
                this.modals.deleteTask.deleteId = this.modals.deleteTask.index = null;
                this.modals.deleteTask.status = false;
            },

            addTask() {
                this.newTask.status = this.options[0];
                this.newTask.task = this.newTask.description;
                this.modals.addTask = true;
            },

            cancelTask() {
                this.modals.addTask = false;
                this.newTask.task = this.newTask.description = this.newTask.status = null;
            },

            createTask() {
                if (this.newTask.task != null && this.newTask.description != null && this.newTask.status != null) {
                    axios.post(
                        createTaskUrl,
                        {
                            task: this.newTask.task,
                            description: this.newTask.description,
                            status: Number(this.newTask.status.status_identity)
                        }
                    )
                        .then(function (response) {
                            switch (parseInt(app.newTask.status.status_identity)) {
                                case 1:
                                    app.todos.unshift(
                                        {
                                            task: app.newTask.task,
                                            description: app.newTask.description,
                                            status: app.newTask.status,
                                            comments: []
                                        });
                                    break;

                                case 2:
                                    app.doings.unshift(
                                        {
                                            task: app.newTask.task,
                                            description: app.newTask.description,
                                            status: app.newTask.status,
                                            comments: []
                                        });
                                    break;

                                case 3:
                                    app.dones.unshift(
                                        {
                                            task: app.newTask.task,
                                            description: app.newTask.description,
                                            status: app.newTask.status,
                                            comments: []
                                        });
                                    break;
                            }
                            app.newTask.task =
                                app.newTask.description =
                                app.newTask.status = null;
                            app.modals.addTask = false;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },

            prepeareComments(commentsArray) {
                if (commentsArray != null) {
                    commentsArray = commentsArray.split("|");
                    for (numComment in commentsArray) {
                        commentsArray[numComment] = JSON.parse(commentsArray[numComment]);
                    }
                }
                else {
                    commentsArray = [];
                }
                return commentsArray;
            },

            prepeareResponseData(response) {
                for (index in response.data) {
                    response.data[index].comments = this.prepeareComments(response.data[index].comments);
                    switch (response.data[index].status) {
                        case todoStatus.title:
                            response.data[index].status = todoStatus;
                            app.todos.push(response.data[index]);
                            break;

                        case doingStatus.title:
                            response.data[index].status = doingStatus;
                            app.doings.push(response.data[index]);
                            break;

                        case doneStatus.title:
                            response.data[index].status = doneStatus;
                            app.dones.push(response.data[index]);
                            break;

                        default:
                            console.log('default switch');
                            break;
                    }
                }
            },

            getTodo() {
                axios.get(
                    readTaskUrl
                )
                    .then(function (response) {
                        app.prepeareResponseData(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        }
    })
})();