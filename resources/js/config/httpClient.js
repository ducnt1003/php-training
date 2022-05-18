import axios from 'axios';

export const httpClient = axios.create({
    baseURL:process.env.MIX_PUSHER_API_ENDPOINT,
    // timeout: 3000,
    headers: {
        "Content-Type": "application/json",
    },
});

export function SET_AUTH_TOKEN( accessToken) {
    httpClient.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`

}


