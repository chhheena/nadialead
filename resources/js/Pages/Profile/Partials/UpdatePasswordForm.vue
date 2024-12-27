

<template>
        <section>
            <p class="text-sm text-gray-600">
                Ensure your account is using a long, random password to stay secure.
            </p>

            <form @submit.prevent="submitHandler" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="current_password" value="Current Password" />

                    <TextInput
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="current-password"
                    />

                    <InputError
                        :message="form.errors.current_password"
                        class="mt-2"
                    />
                </div>

                <div>
                    <InputLabel for="password" value="New Password" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.new_password"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                    />

                    <InputError :message="form.errors.new_password" class="mt-2" />
                </div>

                <!-- <div>
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm Password"
                    />

                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                    />

                    <InputError
                        :message="form.errors.password_confirmation"
                        class="mt-2"
                    />
                </div> -->

                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="form.recentlySuccessful"
                            class="text-sm text-gray-600"
                        >
                            Saved.
                        </p>
                    </Transition>
                </div>
            </form>
        </section>
</template>


<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { notificationMessage } from '@/helpers';
import { useRouter } from 'vue-router';
import DefaultCard from "@/components/Forms/DefaultCard.vue";
const store = useAuthStore();
const router = useRouter();

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const user = computed(() => store.getUser);

const form = useForm({
    id: user.value.id,
    current_password: '',
    new_password: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};

const submitHandler = async () => {
    const {id, current_password, new_password} = form;
    let response = await store.updateProfilePassword({id, current_password, new_password})
    if(store.error){
        form.errors.new_password = store.error?.new_password[0];
        form.errors.current_password = store.error?.current_password[0];
    }
    if(response?.status){
        notificationMessage('success', 'User password updated successfully');
        router.push({name:'login'});
    }
}
</script>