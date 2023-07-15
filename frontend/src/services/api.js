const API_URL = 'http://localhost:8002';

async function callApi(endpoint, method = 'GET', data = null, headers = {}) {
    const config = {
        method,
        headers: {
            'Content-Type': 'application/json',
            ...headers,
        },
    };

    if (data) {
        config.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(API_URL + endpoint, config);
        const responseData = await response.json();

        if (!response.ok) {
            throw new Error(responseData.error || 'API request failed');
        }

        return responseData;
    } catch (error) {
        throw new Error(error.message || 'API request failed');
    }
}

export default {
    get(endpoint, headers = {}) {
        return callApi(endpoint, 'GET', null, headers);
    },
    post(endpoint, data, headers = {}) {
        return callApi(endpoint, 'POST', data, headers);
    },
    put(endpoint, data, headers = {}) {
        return callApi(endpoint, 'PUT', data, headers);
    },
    delete(endpoint, headers = {}) {
        return callApi(endpoint, 'DELETE', null, headers);
    },
};
