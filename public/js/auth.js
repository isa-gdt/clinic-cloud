class Auth {
    constructor() {
        this.baseUrl = '/api';

        // Intentar recuperar la sesión
        try {
            this.token = localStorage.getItem('token');
            const storedUser = localStorage.getItem('user');
            this.user = storedUser ? JSON.parse(storedUser) : null;
        } catch (e) {
            console.error('[Auth] Error loading session:', e);
            this.token = null;
            this.user = null;
        }

        // DOM Elements
        this.loginForm = document.getElementById('loginForm');
        this.loginContainer = document.getElementById('loginContainer');
        this.tasksContainer = document.getElementById('tasksContainer');
        this.userNameElement = document.getElementById('userName');
        this.logoutBtn = document.getElementById('logoutBtn');

        // Event Listeners
        this.loginForm.addEventListener('submit', (e) => this.handleLogin(e));
        this.logoutBtn.addEventListener('click', () => this.handleLogout());

        // Check authentication status
        this.checkAuth();

    }

    async handleLogin(e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;


        try {
            const loginData = {
                email: email,
                password: password
            };

            const response = await fetch(`${this.baseUrl}/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(loginData)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Login failed');
            }

            const token = data[0];
            //Potencialmente borrable. Tiene sentido que no venga el token?
            if (!token) {
                console.error('[Auth] No token in response:', data);
                throw new Error('No token received from server');
            }

            this.setAuth(token, { name: email });
            this.showTasksView();

        } catch (error) {
            console.error('[Auth] Login error:', error);
            alert(error.message || 'Login failed. Please check your credentials.');
        }
    }

    // Carga las tasks
    loadTasksScript() {
        const existingScript = document.querySelector('script[src="js/tasks.js"]');

        if (!existingScript) {
            const script = document.createElement('script');
            script.src = 'js/tasks.js';
            script.onload = () => {
                if (!window.taskManager) {
                    window.taskManager = new TaskManager();
                }
            };
            document.body.appendChild(script);
        } else {
            if (!window.taskManager) {
                window.taskManager = new TaskManager();
            } else {
                window.taskManager.loadTasks();
            }
        }
    }

    handleLogout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.token = null;
        this.user = null;

        if (window.taskManager) {
            window.taskManager = null;
        }

        this.showLoginView();
    }

    setAuth(token, user) {
        this.token = token;
        this.user = user;
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
        this.updateUserInfo();
    }

    checkAuth() {
        if (this.token && this.user) {
            this.showTasksView();

            // Esperar un momento antes de cargar el script
            setTimeout(() => {
                if (!window.taskManager) {
                    this.loadTasksScript();
                }
            }, 100);
        } else {
            this.showLoginView();
        }
    }

    updateUserInfo() {
        if (this.user) {
            this.userNameElement.textContent = this.user.name || this.user.email;
        }
    }

    showLoginView() {
        this.loginContainer.classList.remove('hidden');
        this.tasksContainer.classList.add('hidden');
        this.loginForm.reset();
    }

    showTasksView() {
        this.loginContainer.classList.add('hidden');
        this.tasksContainer.classList.remove('hidden');
        this.updateUserInfo();
    }

    getHeaders() {
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': this.token ? `Bearer ${this.token}` : ''
        };
    }
}

// Initialize Auth
const auth = new Auth();
