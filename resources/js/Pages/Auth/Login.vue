<template>
    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <InputLabel for="email" value="Email" />

            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                autocomplete="username" />

            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="Password" />
            <div class="flex">
                <TextInput id="password" :type="passwordType" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="current-password" />

                <svg @click="viewPassword" class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
                        fill="" />
                    <path
                        d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
                        fill="" />
                </svg>
            </div>
            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4 block">
            <label class="flex items-center">
                <Checkbox name="remember" v-model:checked="form.remember" />
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="mt-4 flex items-center justify-end">
            <Link v-if="canResetPassword" :href="route('password.request')"
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Forgot your password?
            </Link>

            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Log in
            </PrimaryButton>
        </div>
    </form>
</template>


<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useAuthStore } from '@/stores/auth';
// import { router } from '@inertiajs/vue3';
import { useRouter } from 'vue-router';
const router = useRouter();
const authStore = useAuthStore();
import { notificationMessage } from '@/helpers';
import { ref } from 'vue';
const passwordType = ref('password');
defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});


const submit = async () => {
    let userDetail = await authStore.login({ email: form.email, password: form.password });
    let errors = authStore.error;
    if (errors) {
        notificationMessage('error', errors)
    }
    if (userDetail) {
        router.push({ name: 'dashboard' });
    }
};

const viewPassword = () => {
    passwordType.value = (passwordType.value == 'password') ? 'text' : 'password';
}
</script>