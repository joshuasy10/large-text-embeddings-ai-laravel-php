<template>
    <Head title="Home"/>

    <section class="px-6 py-3 bg-red-900 border-b-4 border-gray-300 mb-12">
        <header class="flex items-center justify-between">
            Large Text Embeddings Test
        </header>
    </section>

    <div class="px-40">
        <h1 class="text-gray-300">Title</h1>
        <div class="space-y-6">
            <Container>
                <p>
                    lorem ipsum qwfertbgds qwerfg qwdefrtfg dswqdefr tvdswq eftv
                    werstg wearswQ QWearf wqEARF DWEAFRFSD AEWFRFSD wertbfdvse wfr
                    wefrvsfwgrvf wefrbfg berdg ber fgbf gbfdc vbhytrd fvbnhrgegrh
                    rgesv ebrhgefwsvdbfn thrgevdfnt hrgevsdbnr hegsv brhegwfsvdb rh4y3etwgfsvbd
                    hr4egws dbnrhegsvb dnfrjhegsv bdnrhegwsfv bdnrhegwaf sgnrjhegwfa
                    sgehre gwsfbdnrj hegsvbdnrjhe gdbxdnfrjheg svbdnfrheg sfveh
                </p>
            </Container>

<!--            <p v-for="row in olympics_data">{{row}}</p>-->
            <div class="border-2 border-gray-300 rounded-xl overflow-hidden">
                <table>
                    <thead class="border-b-2 border-gray-300 bg-gray-300 text-red-950">
                    <tr>
                        <th>title</th>
                        <th>heading</th>
                        <th>content</th>
                        <th>tokens</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in olympics_data" :key="index" class="border-t-2 border-gray-300 max-h-12">
                        <td class="px-6 border-r border-gray-300">{{ row.title }}</td>
                        <td class="px-6 border-r border-gray-300">{{ row.heading}}</td>
                        <td class="border-r border-gray-300">
                            <div class="max-h-36 overflow-y-auto px-6">
                                {{ row.content }}
                            </div>
                        </td>
                        <td class="px-6 border-l border-gray-300">{{ row.tokens }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script setup>

import Container from "@/Shared/Container.vue";

defineProps({
    olympics_data: {
        type: Array,
        required: true
    }
})
</script>
