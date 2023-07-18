import axios from 'axios';

const API_URL = 'http://localhost:8002/api/';

const api = axios.create({
    baseURL: API_URL,
});

export const login = async (credentials) => {
    try {
        return await api.post('login', credentials)
    } catch (error) {
        console.error('Error', error);
        
        return error.response
    }
}

export const createAccount = async (data) => {
    try {
        return await api.post('users', data)
    } catch (error) {
        console.error('Error', error);
        
        return error.response
    }
}

export const validateToken = async () => {
    try {
        const response = await api.get('validate-token', {
            headers: getHeaders(),
        });

        if (response.status === 200) {
            return true; 
        } else {
            return false; 
        }
    } catch (error) {
        console.error('Error validating token:', error);
        return false; 
    }
};

export const fetchTodos = async () => {
    try {
        const response = await api.get('todos', {
            headers: getHeaders(),
        });
        
        return response.data.data;
    } catch (error) {
        return [];
    }
};

export const addTodo = async (todo) => {
    try {
        const response = await api.post('todos', todo, {
            headers: getHeaders(),
        });
        return response.data.data.todo;
    } catch (error) {
        console.error('Error adding todo:', error);
        return null;
    }
};

export const updateTodo = async (id, status) => {
    try {
        const response = await api.put(`todos/${id}`, {status}, {
            headers: getHeaders(),
        });
        return response.data.data.todo;
    } catch (error) {
        console.error('Error adding todo:', error);
        return null;
    }
};

const getHeaders = () => { 
    return  {
        'Authorization': `Bearer ${getAccessToken()}`
    } 
}
const getAccessToken = () => localStorage.getItem('accessToken')

export default api;
