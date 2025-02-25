class TaskManager {
    constructor() {
        console.log('[TaskManager] Constructor called');
        
        if (window.taskManager) {
            console.warn('[TaskManager] Instance already exists!');
            return window.taskManager;
        }

        this.baseUrl = '/api';
        this.submitCount = 0;
        this.currentPage = 1;
        this.limit = 10;
        this.hasMoreTasks = true;
        this.tasks = [];
        
        // DOM Elements
        this.tasksList = document.getElementById('tasksList');
        this.addTaskBtn = document.getElementById('addTaskBtn');
        this.taskModal = document.getElementById('taskModal');
        this.taskForm = document.getElementById('taskForm');
        this.cancelTaskBtn = document.getElementById('cancelTask');
        this.loadMoreBtn = document.getElementById('loadMoreBtn');

        window.taskManager = this;
        this.setupEventListeners();
        this.loadTasks();
        
        console.log('[TaskManager] New instance created');
    }

    setupEventListeners() {
        console.log('[TaskManager] Setting up event listeners');
        
        this.removeEventListeners();
        
        this.handleSubmit = this.handleTaskSubmit.bind(this);
        this.handleAdd = () => {
            console.log('[TaskManager] Add button clicked');
            this.showTaskModal();
        };
        this.handleCancel = () => {
            console.log('[TaskManager] Cancel button clicked');
            this.hideTaskModal();
        };
        this.handleLoadMore = () => {
            console.log('[TaskManager] Load more clicked');
            this.loadMoreTasks();
        };

        this.addTaskBtn.addEventListener('click', this.handleAdd);
        this.cancelTaskBtn.addEventListener('click', this.handleCancel);
        this.taskForm.addEventListener('submit', this.handleSubmit);
        this.loadMoreBtn.addEventListener('click', this.handleLoadMore);
    }

    removeEventListeners() {
        console.log('[TaskManager] Removing event listeners');
        if (this.handleSubmit) {
            this.taskForm.removeEventListener('submit', this.handleSubmit);
        }
        if (this.handleAdd) {
            this.addTaskBtn.removeEventListener('click', this.handleAdd);
        }
        if (this.handleCancel) {
            this.cancelTaskBtn.removeEventListener('click', this.handleCancel);
        }
        if (this.handleLoadMore) {
            this.loadMoreBtn.removeEventListener('click', this.handleLoadMore);
        }
    }

    async loadMoreTasks() {
        this.currentPage++;
        await this.loadTasks(false);
    }

    async loadTasks(reset = true) {
        try {
            if (reset) {
                this.currentPage = 1;
                this.tasks = [];
                this.hasMoreTasks = true;
                this.loadMoreBtn.disabled = false;
            }

            const response = await fetch(`${this.baseUrl}/tasks?page=${this.currentPage}&limit=${this.limit}`, {
                headers: auth.getHeaders()
            });

            if (!response.ok) {
                if (response.status === 401) {
                    auth.handleLogout();
                    throw new Error('Session expired. Please login again.');
                }
                throw new Error('Failed to load tasks. Please try again later.');
            }

            const data = await response.json();
            const newTasks = Array.isArray(data) ? data : (data.data || []);
            
            // Si recibimos menos tareas que el límite, significa que no hay más
            if (newTasks.length < this.limit) {
                this.hasMoreTasks = false;
                this.loadMoreBtn.disabled = true;
            }

            if (reset) {
                this.tasks = newTasks;
            } else {
                this.tasks = [...this.tasks, ...newTasks];
            }

            this.renderTasks();

        } catch (error) {
            console.error('[TaskManager] Error loading tasks:', error);
            if (!error.message.includes('Session expired')) {
                alert(error.message);
            }
        }
    }

    renderTasks() {
        if (!this.tasksList) {
            console.warn('[TaskManager] Tasks list element not found');
            return;
        }

        // Limpiar lista actual
        this.tasksList.innerHTML = '';

        if (this.tasks.length === 0) {
            // Mostrar mensaje cuando no hay tareas
            const emptyMessage = document.createElement('div');
            emptyMessage.className = 'empty-tasks-message';
            emptyMessage.textContent = 'No tasks found';
            this.tasksList.appendChild(emptyMessage);
        } else {
            // Renderizar cada tarea
            this.tasks.forEach(task => {
                const taskElement = document.createElement('div');
                taskElement.className = 'task-item';
                taskElement.dataset.id = task.id;
                taskElement.innerHTML = this.createTaskHTML(task);
                this.tasksList.appendChild(taskElement);
                this.setupTaskEventListeners(taskElement);
            });
        }

        // Mostrar/ocultar el botón según si hay más tareas
        if (this.loadMoreBtn) {
            this.loadMoreBtn.style.display = this.hasMoreTasks && this.tasks.length > 0 ? 'block' : 'none';
        }

        console.log('[TaskManager] Tasks rendered:', this.tasks.length);
    }

    // Template de la tarea en HTML (a falta de component)
    createTaskHTML(task) {
        const created = new Date(task.created_at).toLocaleDateString();
        const updated = new Date(task.updated_at).toLocaleDateString();

        return `
            <div class="task-content" data-id="${task.id}">
                <div class="task-header">
                    <div class="task-main-info">
                        <span class="task-title">${task.text}</span>
                        <div class="task-controls">
                            <span class="task-status status-${task.status}">${task.status.replace('_', ' ')}</span>
                            <button class="delete-task" title="Delete task">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="task-details">
                    <div>Author: ${task.created_by || 'Unknown'}</div>
                    <div>Assigned to: ${task.assigned_to || 'Unassigned'}</div>
                </div>
                <div class="task-dates">
                    <span>Created: ${created}</span> | 
                    <span>Updated: ${updated}</span>
                </div>
            </div>
        `;
    }

    setupTaskEventListeners(taskElement) {
        // Evento para editar al hacer clic en la tarea
        taskElement.addEventListener('click', (e) => {
            // No abrir el modal si se hizo clic en el botón de eliminar
            if (!e.target.classList.contains('delete-task') && !e.target.closest('.delete-task')) {
                console.log('[TaskManager] Task item clicked for edit:', taskElement.dataset.id);
                this.showTaskModal(taskElement);
            }
        });

        // Evento para eliminar
        const deleteBtn = taskElement.querySelector('.delete-task');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', async (e) => {
                e.stopPropagation();
                e.preventDefault();
                const taskId = taskElement.dataset.id;
                console.log('[TaskManager] Delete button clicked for task:', taskId);
                if (taskId) {
                    const deleted = await this.deleteTask(taskId);
                    if (deleted) {
                        // Eliminar el elemento del DOM si se borró exitosamente
                        taskElement.remove();
                        // Actualizar la lista de tareas
                        this.renderTasks();
                    }
                }
            });
        }
    }

    showTaskModal(taskElement = null) {
        console.log('[TaskManager] Showing modal');
        
        const modalTitle = document.getElementById('modalTitle');
        const taskTitle = document.getElementById('taskTitle');
        const assignedTo = document.getElementById('assignedTo');
        const taskStatus = document.getElementById('taskStatus');

        if (taskElement) {
            modalTitle.textContent = 'Edit Task';
            console.log('[TaskManager] Task element dataset:', taskElement.dataset);
            console.log('[TaskManager] Tasks array:', this.tasks);
            const taskId = parseInt(taskElement.dataset.id);
            const task = this.tasks.find(t => t.id === taskId);
            console.log('[TaskManager] Found task:', task);
            if (task) {
                // Guardar el ID en el formulario
                this.taskForm.dataset.taskId = task.id;
                taskTitle.value = task.text || '';
                assignedTo.value = task.assigned_to || '';
                taskStatus.value = task.status || '';
                this.taskForm.dataset.taskId = task.id;
                
                // Quitar required al editar
                taskTitle.removeAttribute('required');
                taskStatus.removeAttribute('required');
            }
        } else {
            modalTitle.textContent = 'New Task';
            this.taskForm.reset();
            delete this.taskForm.dataset.taskId;
            
            // Añadir required al crear
            taskTitle.setAttribute('required', '');
            taskStatus.setAttribute('required', '');
        }

        this.taskModal.classList.remove('hidden');
    }

    hideTaskModal() {
        console.log('[TaskManager] Hiding modal');
        this.taskModal.classList.add('hidden');
        this.taskForm.reset();
        delete this.taskForm.dataset.taskId;
        this.submitCount = 0;
    }

    async handleTaskSubmit(event) {
        event.preventDefault();
        
        console.log('[TaskManager] Submit handler called');
        
        this.submitCount++;
        
        if (this.submitCount > 1) {
            console.warn('[TaskManager] Preventing duplicate submit, count:', this.submitCount);
            return;
        }

        const taskId = this.taskForm.dataset.taskId;
        console.log('[TaskManager] Task form dataset:', this.taskForm.dataset);
        const isEditing = !!taskId;
        
        try {
            const formData = {};
            
            const title = document.getElementById('taskTitle').value.trim();
            const status = document.getElementById('taskStatus').value.trim();
            const assignedToValue = document.getElementById('assignedTo').value.trim();

            if (!isEditing && (!title || !status)) {
                throw new Error('Please fill in the title and status when creating a new task');
            }

            if (title) {
                formData.text = title;
            }
            if (status) {
                formData.status = status;
            }
            
            if (assignedToValue) {
                const assignedTo = parseInt(assignedToValue);
                if (isNaN(assignedTo)) {
                    throw new Error('If provided, Assigned To must be a valid number');
                }
                formData.assigned_to = assignedTo;
            }

            const url = taskId 
                ? `${this.baseUrl}/tasks/${taskId}`
                : `${this.baseUrl}/tasks`;

            console.log('[TaskManager] Sending request to:', url, formData);
            
            const response = await fetch(url, {
                method: taskId ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    ...auth.getHeaders()
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                throw new Error('Failed to save task');
            }

            const savedTask = await response.json();
            console.log('[TaskManager] Saved task:', savedTask);
            
            if (taskId) {
                // Actualizar tarea existente
                const taskIdInt = parseInt(taskId);
                console.log('[TaskManager] Updating task with ID:', taskIdInt);
                const index = this.tasks.findIndex(t => t.id === taskIdInt);
                console.log('[TaskManager] Found task at index:', index);
                if (index !== -1) {
                    this.tasks[index] = savedTask;
                }
            } else {
                // Añadir nueva tarea al principio
                this.tasks.unshift(savedTask);
            }

            console.log('[TaskManager] Tasks after update:', this.tasks);
            this.hideTaskModal();
            this.renderTasks();
        } catch (error) {
            console.error('[TaskManager] Error saving task:', error);
            alert(error.message);
        }
    }

    async deleteTask(taskId) {
        if (!confirm('Are you sure you want to delete this task?')) {
            return false;
        }

        console.log('[TaskManager] Deleting task:', taskId);
        try {
            const response = await fetch(`${this.baseUrl}/tasks/${taskId}`, {
                method: 'DELETE',
                headers: auth.getHeaders()
            });

            if (!response.ok) {
                throw new Error('Failed to delete task');
            }

            // Eliminar la tarea del array local
            this.tasks = this.tasks.filter(t => t.id !== parseInt(taskId));
            
            // Actualizar la vista
            this.renderTasks();
            
            console.log('[TaskManager] Task deleted successfully');
            return true;
        } catch (error) {
            console.error('[TaskManager] Error deleting task:', error);
            alert('Error deleting task. Please try again.');
            return false;
        }
    }
}

// Auto-initialize TaskManager when the script loads
window.taskManager = new TaskManager();
