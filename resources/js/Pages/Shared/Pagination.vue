<template>
    <div class="flex items-center pb-3" v-if="showPagination">
        <span v-for="(link, key) in links" :key="key">
            <inertia-link class="border shadow-md mr-2 rounded-lg px-3 py-2 hover:bg-brand-light text-brand-dark no-underline hover:bg-accentcolor-dark hover:text-white" v-bind:class="borderRightClass(link)" :href="link.url" v-if="link.url && link.active == false">{{ link.label }}</inertia-link>
            <span class="border-t border-b border-l border-brand-light px-3 mr-2 rounded-lg py-2 bg-accentcolor-light text-white no-underline" v-bind:class="borderRightClass(link)" v-else>{{ link.label }}</span>
        </span>
    </div>
</template>
<script>
    export default {
        props: {
            links: Array,
        },
        computed: {
            showPagination() {
                return this.links.length > 3
            }
        },
        methods: {
            borderRightClass(link) {
                return (link.label == 'Next') ? 'border-r' : ''
            }
        }
    }
</script>