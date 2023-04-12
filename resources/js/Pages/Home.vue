<template>
    <Head title="Home"/>

    <section class="px-6 py-3 bg-red-900 border-b-4 border-white mb-12">
        <header class="flex items-center justify-center font-bold text-3xl">
            Large Text Embeddings Test - Olympics 2020
        </header>
    </section>

    <div class="px-40">
        <div class="space-y-6">

        <form @submit.prevent="submit()">
            <div>
                <InputLabel for="question" value="Question" />

                <TextInput
                    id="question"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.question"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.question" />
            </div>
        </form>

            <div v-if="answer">
                <h1 class="text-gray-300">Answer</h1>
                <Container class="mt-1">
                    <p v-html="answer"/>
                </Container>
            </div>

            <div v-if="context">
                <h1 class="text-gray-300">Context</h1>
                <div class="border-2 border-white rounded-md overflow-hidden mt-1">
                    <table>
                        <thead class="border-b-2 border-white bg-white text-red-950">
                        <tr>
                            <th>title</th>
                            <th>heading</th>
                            <th>content</th>
                            <th>tokens</th>
                            <!--                        <th>embedding</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(row, index) in context" :key="index" class="border-t-2 border-white max-h-12">
                            <td class="px-6 border-r border-white">{{ row.title }}</td>
                            <td class="px-6 border-r border-white">{{ row.heading }}</td>
                            <td class="border-r border-white">
                                <div class="max-h-36 overflow-y-auto px-6">
                                    {{ row.content }}
                                </div>
                            </td>
                            <td class="px-6 border-r border-white">{{ row.tokens }}</td>
                            <!--                        <td class="border-l border-white">-->
                            <!--                            <div class="max-h-36 max-w-xl overflow-auto px-6">-->
                            <!--                                {{ embeddings_data[index] }}-->
                            <!--                            </div>-->
                            <!--                        </td>-->
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>

import Container from "@/Shared/Container.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import axios from "axios";
import {ref} from "vue";


defineProps({
    olympics_data: {
        type: Array,
        required: true
    },
    embeddings_data: {
        type: Array,
        required: true
    }
})
const form = useForm({
    question: ''
});

let answer = ref("");
let context = ref("");

function submit() {

    answer.value = "Getting Answer...";
    context.value = "";

    axios.post(`/api/olympics_question?question=${form.question}`)
        .then(response => {
            console.log(response.data);
            answer.value = response.data.answer;
            context.value = response.data.context;

            // console.log(response);
            // answerExplanationText.value = response.data;
        })
        .catch(error => console.log(error));

};

</script>
