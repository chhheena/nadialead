<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <DefaultCard cardTitle="Lead Form">
            <div class="p-8 rounded-lg shadow-md">
                <!-- Lead Field -->
                <div class="grid grid-cols-12 gap-6 mb-6">
                    <div class="col-span-12">
                        <InputLabel for="lead" value="Lead" class="text-gray-600" />
                        <TextInput id="lead" type="file" @change="handleFileChange"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            v-model="form.lead" required autofocus placeholder="Enter the lead name" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <PrimaryButton @click="submitForm()"
                        class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300">
                        Add Lead
                    </PrimaryButton>
                </div>
            </div>
        </DefaultCard>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import axios from "axios";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { router } from '@inertiajs/vue3';
import { notificationMessage } from "@/helpers";

const form = ref({});

const handleFileChange = (event) => {
    form.value.leadFile = event.target.files[0];
};

const submitForm = () => {
    if (!form.value.leadFile) {
        alert("Please select a file to import.");
        return;
    }
    const formData = new FormData();
    formData.append("lead_file", form.value.leadFile);
    axios
        .post(route("import.lead"), formData)
        .then((response) => {
            if (response.status) {
                notificationMessage('success', 'File imported successfully!');
                router.visit('/leads');
            }
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
