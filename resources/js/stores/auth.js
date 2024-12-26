import { defineStore } from 'pinia';
import axios from 'axios'; // Assuming you're using Axios for HTTP requests
import { useRouter } from 'vue-router';
const router = useRouter();
export const useAuthStore = defineStore('auth', {
    state: () => ({
        baseURL: import.meta.env.VITE_API_BASE_URL,
        user: null,
        token: null,
        loading: false,
        error: null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        async login(formData) {
            this.loading = true;
            this.error = null;
            try {
                let endPoint = `${this.baseURL}login`;
                const response = await axios.post(endPoint, formData);
                this.token = response.data.data.token;
                this.user = response.data.data.user_detail;
                localStorage.setItem('token', this.token);
                return response.data.status;
                // axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            } catch (err) {
                this.error = err.response?.data?.message || 'Login failed';
            } finally {
                this.loading = false;
            }
        },

        logout() {
            this.user = null;
            this.token = null;
            localStorage.removeItem('token');
            return;
        },

        async forgotPassword(email) {
            this.loading = true;
            this.error = null;
            try {
                await axios.post('/api/auth/forgot-password', { email });
            } catch (err) {
                this.error = err.response?.data?.message || 'Request failed';
            } finally {
                this.loading = false;
            }
        },

        async fetchUser() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get('/api/auth/user');
                this.user = response.data.user;
            } catch (err) {
                this.error = err.response?.data?.message || 'Could not fetch user';
            } finally {
                this.loading = false;
            }
        },
    },
});