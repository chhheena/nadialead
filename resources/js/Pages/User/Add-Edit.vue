<template>
    <DefaultCard cardTitle="User Add Form">
            <div class="p-8 rounded-lg shadow-md">
                <div class="grid grid-cols-12 gap-6 mb-6">
                    <div class="col-span-6">
                        <InputLabel
                            for="name"
                            value="Name"
                            class="text-gray-600"
                        />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Enter your name"
                        />
                        <InputError class="mt-2" :message="errors.name ? errors.name[0] : '' " />
                    </div>

                    <div class="col-span-6">
                        <InputLabel
                            for="email"
                            value="Email"
                            class="text-gray-600"
                        />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.email"
                            required
                            placeholder="Enter your email"
                        />
                        <InputError class="mt-2" :message="errors.email ? errors.email[0] : '' " />
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6 mb-6">
                    <div class="col-span-6">
                        <InputLabel
                            for="password"
                            value="Password"
                            class="text-gray-600"
                        />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.password"
                            required
                            placeholder="Enter your password"
                        />
                        <InputError class="mt-2" :message="errors.password ? errors.password[0] : '' " />
                    </div>
                    <div class="col-span-6">
                        <InputLabel
                            for="confirm_password"
                            value="Confirm Password"
                            class="text-gray-600"
                        />
                        <TextInput
                            id="confirm_password"
                            type="password"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.confirmPassword"
                            required
                            placeholder="Confirm your password"
                        />
                        <InputError class="mt-2" :message="errors.confirmPassword ? errors.confirmPassword[0] : '' " />
                    </div>
                </div>
                <div class="mb-6">
                    <InputLabel for="role" value="Role" class="text-gray-600" />
                    <SelectInput v-model="form.role"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="" selected>Select user role</option>
                        <option value="client">Client</option>
                        <option value="team">Team</option>
                    </SelectInput>
                    <InputError class="mt-2" :message="errors.role ? errors.role[0] : '' " />
                </div>


                <div class="mt-4" v-if="form.role == 'client'">
                    <InputLabel for="parent" value="Assign Team" class="text-gray-600" />
                    <SelectInput
                        v-model="form.team_id"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="" selected>Select team</option>
                        <option :value="user.id" v-for="(user) in team" :key="user">{{ user.name }}</option>
                    </SelectInput>
                </div>
                <div class="mt-8 flex justify-end">
                    <!-- <a class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300" :href="route('users')">Cancel </a> -->
                    <router-link
                        class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300"
                        :to="{name: 'users'}">
                        Cancel
                    </router-link>
                    <button @click="submitForm()" class="flex items-center gap-2 mx-2 rounded bg-primary px-4.5 py-2 font-medium text-white hover:bg-opacity-80 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300"> {{ formType }} </button>
                </div>
            </div>
        </DefaultCard>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted } from "vue";
// import axios from "axios";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { convertJsonToFormData, notificationMessage } from "@/helpers";
// import { router } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import { useRouter, useRoute } from 'vue-router';
import axios from "../../axios.js";
const routes = useRoute();
const router = useRouter();
let userId = ref("");
const baseUrl = import.meta.env.VITE_API_BASE_URL;
const pageTitle = ref("User");
const form = ref({});
const team = ref([]);
let formType = ref('Add');

const props = defineProps({
    id: Number,
});

const errors = ref({});


const show = () => {

    let endpoint = `${baseUrl}users/${userId.value}`
    axios
        .get(endpoint)
        .then((response) => {
            form.value = response.data.data.row;
            team.value = response.data.data.team
        })
        .catch((error) => {})
        .finally(() => {});
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
            router.push({name: 'users'});
            // router.visit('/users');
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        })
        .finally(() => {});
};

onMounted(() => {

    if(routes.params.id){
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
</script>
