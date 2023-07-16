import axios from 'axios';

const API_URL = 'http://localhost:8002/api/';

const api = axios.create({
    baseURL: API_URL,
});

export const fetchTodos = async () => {
    try {
        const response = await api.get('todos', {
            headers: getHeaders(),
        });
        console.log(response.data.data)
        return response.data.data;
    } catch (error) {
        console.error('Error fetching todos:', error);
        return [];
    }
};

export const addTodo = async (title) => {
    try {
        const response = await api.post('todos', { title }, {
            headers: getHeaders(),
        });
        return response.data;
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
