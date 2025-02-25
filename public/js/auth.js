class Auth {
    constructor() {
        console.log('[Auth] Constructor called');
        this.baseUrl = '/api';
        
        // Intentar recuperar la sesión
        try {
            this.token = localStorage.getItem('token');
            const storedUser = localStorage.getItem('user');
            this.user = storedUser ? JSON.parse(storedUser) : null;
            console.log('[Auth] Session check - Token exists:', !!this.token);
            console.log('[Auth] Session check - User exists:', !!this.user);
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
        
        console.log('[Auth] Initialization complete');
    }

    async handleLogin(e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        console.log('[Auth] Login attempt for:', email);

        try {
            const loginData = {
                email: email,
                password: password
            };

            console.log('[Auth] Sending login request');
            const response = await fetch(`${this.baseUrl}/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(loginData)
            });

            const data = await response.json();
            console.log('[Auth] Login response status:', response.status);

            if (!response.ok) {
                throw new Error(data.message || 'Login failed');
            }

            const token = data[0];
            //Potencialmente borrable. Tiene sentido que no venga el token?
            if (!token) {
                console.error('[Auth] No token in response:', data);
                throw new Error('No token received from server');
            }

            console.log('[Auth] Login successful, setting up session');
            this.setAuth(token, { name: email });
            this.showTasksView();
            
            // Esperar un momento antes de cargar el script
            //Probar a comentarlo a ver que pasa
            setTimeout(() => {
                if (!window.taskManager) {
                    console.log('[Auth] Loading TaskManager after login');
                    this.loadTasksScript();
                } else {
                    console.log('[Auth] TaskManager already exists, reloading tasks');
                    window.taskManager.loadTasks();
                }
            }, 100);

        } catch (error) {
            console.error('[Auth] Login error:', error);
            alert(error.message || 'Login failed. Please check your credentials.');
        }
    }

    //Que hace esto?? comentarlo a ver que pasa
    loadTasksScript() {
        console.log('[Auth] Checking for tasks.js script');
        const existingScript = document.querySelector('script[src="js/tasks.js"]');
        
        if (!existingScript) {
            console.log('[Auth] Loading tasks.js script');
            const script = document.createElement('script');
            script.src = 'js/tasks.js';
            script.onload = () => {
                console.log('[Auth] tasks.js loaded successfully');
                if (!window.taskManager) {
                    console.log('[Auth] Creating new TaskManager instance');
                    window.taskManager = new TaskManager();
                }
            };
            document.body.appendChild(script);
        } else {
            console.log('[Auth] tasks.js already loaded');
            if (!window.taskManager) {
                console.log('[Auth] Creating new TaskManager instance');
                window.taskManager = new TaskManager();
            } else {
                console.log('[Auth] Using existing TaskManager instance');
                window.taskManager.loadTasks();
            }
        }
    }

    handleLogout() {
        console.log('[Auth] Logging out');
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        this.token = null;
        this.user = null;
        
        if (window.taskManager) {
            console.log('[Auth] Cleaning up TaskManager');
            window.taskManager = null;
        }
        
        this.showLoginView();
    }

    setAuth(token, user) {
        console.log('[Auth] Setting auth data');
        this.token = token;
        this.user = user;
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
        this.updateUserInfo();
    }

    checkAuth() {
        console.log('[Auth] Checking auth status');
        if (this.token && this.user) {
            console.log('[Auth] Session found, showing tasks view');
            this.showTasksView();
            
            // Esperar un momento antes de cargar el script
            setTimeout(() => {
                if (!window.taskManager) {
                    console.log('[Auth] Loading TaskManager after session check');
                    this.loadTasksScript();
                }
            }, 100);
        } else {
            console.log('[Auth] No session found, showing login view');
            this.showLoginView();
        }
    }

    updateUserInfo() {
        if (this.user) {
            this.userNameElement.textContent = this.user.name || this.user.email;
        }
    }

    showLoginView() {
        console.log('[Auth] Showing login view');
        this.loginContainer.classList.remove('hidden');
        this.tasksContainer.classList.add('hidden');
        this.loginForm.reset();
    }

    showTasksView() {
        console.log('[Auth] Showing tasks view');
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
