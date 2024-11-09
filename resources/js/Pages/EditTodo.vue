<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit Todo
                </h2>
            </div>
        </template>
        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 flex flex-col items-center justify-center">
                    <div>
                        <InputLabel
                            class="text-xl text-purple-600 mr-5"
                            value="Image"
                        ></InputLabel>
                    </div>
                    <div>
                        <FileInput v-model="form.image" />
                    </div>
                    <InputError class="mt-2" :message="form.errors.image" />
                    <br />
                    <div><hr class="w-[350px] bg-white h-1 rounded" /></div>
                    <br />
                    <div>
                        <InputLabel
                            class="text-xl text-purple-600 mr-5"
                            value="Title"
                        ></InputLabel>
                    </div>
                    <div>
                        <TextInput v-model="form.title" class=""></TextInput>
                    </div>
                    <InputError class="mt-2" :message="form.errors.title" />

                    <br />
                    <div><hr class="w-[350px] bg-white h-1 rounded" /></div>
                    <br />
                    <div>
                        <InputLabel
                            class="text-xl text-purple-600 mr-5"
                            value="Description"
                        ></InputLabel>
                    </div>
                    <div>
                        <TextArea
                            v-model="form.description"
                            rows="7"
                            cols="50"
                            class="resize-none"
                        ></TextArea>
                    </div>
                    <InputError
                        class="mt-2"
                        :message="form.errors.description"
                    />
                    <br />
                    <div><hr class="w-[350px] bg-white h-1 rounded" /></div>
                    <br />
                    <div>
                        <InputLabel
                            class="text-xl text-purple-600 mr-5"
                            value="Category"
                        ></InputLabel>
                    </div>
                    <div>
                        <SelectBox
                            :value="props.context.todos.category_id"
                            :array="props.context.categories"
                            @change:option="selectBoxEmit"
                            name="Category"
                        ></SelectBox>
                    </div>
                    <p class="text-sm opacity-50">
                        You can create your own categories on
                        <Link :href="route('dashboard')"
                            ><span class="font-bold text-purple-800"
                                >Dashboard!</span
                            ></Link
                        >
                    </p>
                    <InputError class="mt-2" :message="form.errors.category" />
                    <br />
                    <div><hr class="w-[350px] bg-white h-1 rounded" /></div>
                    <br />
                    <div>
                        <PrimaryButton @click="sendForm(props.context.todos.id)"
                            >Edit Todo</PrimaryButton
                        >
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextArea from "@/Components/TextArea.vue";
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import FileInput from "@/Components/FileInput.vue";
import SelectBox from "@/Components/SelectBox.vue";
import InputError from "@/Components/InputError.vue";
const props = defineProps({
    context: Object,
});

const form = useForm({
    title: props.context.todos.title,
    description: props.context.todos.description,
    image: null,
    category: props.context.todos.category_id,
});

function selectBoxEmit(p) {
    form.category = p;
}

function sendForm(todoId) {
    form.post(route("todo.update", todoId));
}
</script>
