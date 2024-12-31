<template>
    <!-- <Head title="Lead Update" />
    <AuthenticatedLayout>
    </AuthenticatedLayout> -->
    <DefaultCard cardTitle="Lead Update">
        <div class="p-8 rounded-lg shadow-md">
            <!-- Lead Name -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="name" value="Name" class="text-gray-600" />
                    <TextInput id="name" type="text" :disabled="isFieldEnable('name')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                         :class="isFieldEnable('leadtag') ? 'bg-gray-200' : ''"
                        v-model="form.name" required placeholder="Enter lead name" />
                </div>

                <!-- Lead Phone -->
                <div class="col-span-6">
                    <InputLabel for="phone" value="Phone" class="text-gray-600" />
                    <TextInput id="phone" type="text" :disabled="isFieldEnable('phone')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                         :class="isFieldEnable('leadtag') ? 'bg-gray-200' : ''"
                        v-model="form.phone" required placeholder="Enter lead phone" />
                </div>
            </div>

            <!-- City and State -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="city" value="City" class="text-gray-600" />
                    <TextInput id="city" type="text" :disabled="isFieldEnable('city')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                         :class="isFieldEnable('leadtag') ? 'bg-gray-200' : ''"
                        v-model="form.city" required placeholder="Enter lead city" />
                </div>

                <div class="col-span-6">
                    <InputLabel for="state" value="State" class="text-gray-600" />
                    <TextInput id="state" type="text" :disabled="isFieldEnable('state')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                         :class="isFieldEnable('leadtag') ? 'bg-gray-200' : ''"
                        v-model="form.state" required placeholder="Enter lead state" />
                </div>
            </div>

            <!-- Source and Lead Tag -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="source" value="Source" class="text-gray-600" />
                    <TextInput id="source" type="text" :disabled="isFieldEnable('source')"
                        class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                         :class="isFieldEnable('leadtag') ? 'bg-gray-200' : ''"
                        v-model="form.source" required placeholder="Enter lead source" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="lead_tag" value="Lead Tag" class="text-gray-600" />
                    <SelectInput v-model="form.lead_tag" :disabled="isFieldEnable('leadtag')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('leadtag') ? 'bg-gray-200' : ''">
                        <option v-for="tag in leadTags" :key="tag" :value="tag">{{ tag }}</option>
                    </SelectInput>
                </div>
            </div>
            <!-- Qualification Status and Rating -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="qualification_status" value="Qualification Status" class="text-gray-600" />
                    <SelectInput v-model="form.qualification_status" :disabled="isFieldEnable('qualificationstatus')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('qualificationstatus') ? 'bg-gray-200' : '' "
                        >
                        <option value="" selected>Select qualification status</option>
                        <option value="0">Unqualified</option>
                        <option value="1">Qualified</option>
                    </SelectInput>
                </div>
                <div class="col-span-6">
                    <InputLabel for="rating" value="Rating" class="text-gray-600" />
                    <SelectInput v-model="form.rating" :disabled="isFieldEnable('leadrating')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('leadrating') ? 'bg-gray-200' : '' ">
                        <option v-for="rating in leadRatings" :key="rating" :value="rating">{{ rating }}</option>
                    </SelectInput>
                </div>
            </div>

            <!-- Additional Notes and Note Strike First -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="additonal_note" value="Additional Notes" class="text-gray-600" />
                    <TextInput id="additonal_note" type="text" :disabled="isFieldEnable('additionalnotes')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('additionalnotes') ? 'bg-gray-200' : '' "
                        v-model="form.note" required placeholder="Enter additional Notes" />
                </div>

                <div class="col-span-6">
                    <InputLabel for="note_strike_first" value="Note Strike First" class="text-gray-600" />
                    <SelectInput v-model="form.note_strike_first" :disabled="isFieldEnable('strikefirst')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('strikefirst') ? 'bg-gray-200' : ''">
                        <option v-for="note in noteStrikeFirst" :key="note" :value="note">{{ note }} {{
                            isFieldEnable('strikefirst') }} </option>
                    </SelectInput>
                </div>
            </div>

            <!-- Action and Status -->
            <div class="grid grid-cols-12 gap-6 mb-6">
                <div class="col-span-6">
                    <InputLabel for="action" value="Listen to Recording" class="text-gray-600" />
                    <TextInput id="action" type="text" :disabled="isFieldEnable('listentorecording')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('listentorecording') ? 'bg-gray-200' : ''"
                        v-model="form.action" required placeholder="Enter action" />
                </div>
                <div class="col-span-6">
                    <InputLabel for="status" value="Status" class="text-gray-600" />
                    <SelectInput v-model="form.status" :disabled="isFieldEnable('leadstatus')"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        :class="isFieldEnable('leadstatus') ? 'bg-gray-200' : ''">
                        <option v-for="status in statuses" :key="status" :value="status">{{ status }}</option>
                    </SelectInput>
                </div>
            </div>
            <!-- Lead Start Time -->
            <div class="mb-6">
                <InputLabel for="start_time" value="Start Time" class="text-gray-600" />
                <TextInput id="start_time" type="datetime-local" :disabled="isFieldEnable('start_time')"
                    class="mt-1 block w-full  border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                     :class="isFieldEnable('leadtag') ? 'bg-gray-200' : ''"
                    v-model="form.start_time" required />
            </div>
            <!-- Submit Button -->
            <div class="mt-8 flex justify-end">
                <router-link :to="{ name: 'leads' }"
                    class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300">
                    Cancel
                </router-link>
                <!-- <Link :href="route('leads')"
                        class="p-3 me-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-400 focus:ring focus:ring-red-300">
                    Cancel
                    </Link> -->
                <PrimaryButton @click="submitForm()"
                    class="py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                    Update Lead
                </PrimaryButton>
            </div>
        </div>
    </DefaultCard>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted, computed } from "vue";
// import axios from "axios";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { convertJsonToFormData, notificationMessage, getFieldsBaseOnRole } from "@/helpers";
// import { router, Link } from '@inertiajs/vue3';
import axios from "@/axios";
import LeadFilters from "@/LeadFilters/filters.js"
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from "@/stores/auth";
const store = useAuthStore();

const routes = useRoute();
const router = useRouter();
const form = ref({});
const baseUrl = import.meta.env.VITE_API_BASE_URL;

const statuses = computed(() => LeadFilters.leadStatus);
const leadTags = computed(() => LeadFilters.leadTags);
const leadRatings = computed(() => LeadFilters.leadRating);
const noteStrikeFirst = computed(() => LeadFilters.leadStrike);
const userRole = computed(() => store.getUserRole);

const userId = ref();
// const props = defineProps({
//     id: Number,
//     leadTags: Array,
//     leadRatings: Array,
//     noteStrikeFirst: Array,
//     statuses: Array
// });


const show = () => {
    let endpoint = `${baseUrl}leads/${userId.value}`
    axios
        .get(endpoint)
        .then((response) => {
            form.value = response.data.data;
        })
        .catch((error) => { })
        .finally(() => { });
};

const submitForm = () => {
    let formData = "";
    const config = {
        headers: {
            "content-type": "multipart/form-data",
        },
    };
    formData = convertJsonToFormData(form.value);
    formData.append("_method", "PUT");
    let endpoint = `${baseUrl}leads/${userId.value}`
    axios.post(endpoint, formData, config)
        .then((response) => {
            if (response.status) {
                notificationMessage('success', 'Lead updated successfully');
                router.push({name: 'leads'});
            }
        })
        .catch((error) => { })
        .finally(() => { });
};

onMounted(() => {
    userId.value = routes.params.id
    if (routes.params.id) {
        show();
    }
});

const isFieldEnable = (field) => {
    if (userRole.value != 'admin') {
        let getFields = getFieldsBaseOnRole(userRole.value);
        if (getFields) {
            let isFieldEnable = getFields.includes(field);
            return !isFieldEnable;
        }
    }
    return false;
}
</script>
