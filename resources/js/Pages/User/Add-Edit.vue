<template>
    <DefaultCard :cardTitle="`User ${formType} Form`">
        <div class="p-8 rounded-lg shadow-md">
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="name" value="Name" class="text-gray-600" />
                    <TextInput id="name" type="text"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        v-model="form.name" required autofocus autocomplete="name" placeholder="Enter your name" />
                    <InputError class="mt-2" :message="errors.name ? errors.name[0] : ''" />
                </div>

                <div class="col-span-6">
                    <InputLabel for="email" value="Email" class="text-gray-600" />
                    <TextInput id="email" type="email"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        v-model="form.email" required placeholder="Enter your email" />
                    <InputError class="mt-2" :message="errors.email ? errors.email[0] : ''" />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="password" value="Password" class="text-gray-600" />
                    <div class="flex relative">
                        <TextInput id="password" :type="passwordType"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        v-model="form.password" required placeholder="Enter your password" />
                        <svg @click="viewPassword('password')"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current" width="18"
                            height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
                                fill="" />
                            <path
                                d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
                                fill="" />
                        </svg>
                    </div>
                    <InputError class="mt-2" :message="errors.password ? errors.password[0] : ''" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="confirm_password" value="Confirm Password" class="text-gray-600" />
                        <div class="flex relative">
                            <TextInput id="confirm_password" :type="confirmPasswordType"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        v-model="form.confirmPassword" required placeholder="Confirm your password" />
                        <svg @click="viewPassword('confirmPassword')"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current" width="18"
                            height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
                                fill="" />
                            <path
                                d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
                                fill="" />
                        </svg>
                    </div>

                    <InputError class="mt-2" :message="errors.confirmPassword ? errors.confirmPassword[0] : ''" />
                </div>
            </div>
            <div class="mb-6">
                <InputLabel for="role" value="Role" class="text-gray-600" />
                <SelectInput v-model="form.role"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" selected>Select user role</option>
                    <option value="client">Client</option>
                    <option value="team">Team</option>
                </SelectInput>
                <InputError class="mt-2" :message="errors.role ? errors.role[0] : ''" />
            </div>
            <div class="mt-8 flex justify-end">
                <!-- <a class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300" :href="route('users')">Cancel </a> -->
                <router-link
                    class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300"
                    :to="{ name: 'users' }">
                    Cancel
                </router-link>
                <button @click="submitForm()"
                    class="flex items-center gap-2 mx-2 rounded bg-primary px-4.5 py-2 font-medium text-white hover:bg-opacity-80 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                    {{ formType }} </button>
            </div>
        </div>
    </DefaultCard>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted } from "vue";
// import axios from "axios";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import InputLabel from "@/components/InputLabel.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import TextInput from "@/components/TextInput.vue";
import SelectInput from "@/components/SelectInput.vue";
import { convertJsonToFormData, notificationMessage } from "@/helpers";
// import { router } from '@inertiajs/vue3'
import InputError from '@/components/InputError.vue';
import { useRouter, useRoute } from 'vue-router';
import axios from "../../axios.js";
const routes = useRoute();
const router = useRouter();
let userId = ref("");
const baseUrl = import.meta.env.VITE_API_BASE_URL;
const pageTitle = ref("User");
const form = ref({});
let formType = ref('Add');
const passwordType = ref('password');
const confirmPasswordType = ref('password');
const props = defineProps({
    id: Number,
});

const errors = ref({});


const show = () => {

    let endpoint = `${baseUrl}users/${userId.value}`
    axios
        .get(endpoint)
        .then((response) => {
            console.log(response.data.data, 'get-user');
            
            form.value = response.data.data;
            console.log(form.value, 'get-user-value');
        })
        .catch((error) => { })
        .finally(() => { });
};


const submitForm = () => {
    let method = "";
    let actionUrl = "";
    let formData = "";

    const config = {
        headers: {
            "content-type": "multipart/form-data",
        },
    };
    formData = convertJsonToFormData(form.value);

    if (form.value.id) {
        formData.append("_method", "PUT");
        method = "post";
        actionUrl = `${baseUrl}users/${userId.value}`;
    } else {
        method = "post";
        actionUrl = `${baseUrl}users`;
    }
    axios[method](actionUrl, formData, config)
        .then((response) => {
            let messageType = (form.value.id) ? 'updated' : 'created';
            notificationMessage('success', `User ${messageType} successfully`);
            router.push({ name: 'users' });
            // router.visit('/users');
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        })
        .finally(() => { });
};

onMounted(() => {

    if (routes.params.id) {
        userId.value = routes.params.id;
        show();
        formType.value = 'Update';
        // console.log(userId, 'edit');
    }


    // if (props.id) {
    //     show();
    //     formType.value = 'Update';
    // }
});
const viewPassword = (type) => {
    if(type == 'password'){
        passwordType.value = (passwordType.value == 'password') ? 'text' : 'password';
    }else{
        confirmPasswordType.value = (confirmPasswordType.value == 'password') ? 'text' : 'password';
    }
}
</script>
