
<template>
    <ul class="pagination flex mx-4 mt-4 list-reset text-white font-bold">
        <li v-if="pagination.current_page > 1">
            <a class="rounded-l rounded-sm border-t border-b border-l border-grey-light px-3 py-2 text-grey-dark hover:bg-grey-light no-underline"
               v-on:click.prevent="changePage(pagination.current_page - 1)">
                &laquo;
            </a>
        </li>
        <li v-else>
            <span class="rounded-l rounded-sm border border-grey-light px-3 py-2 text-grey-dark cursor-not-allowed no-underline">
                &laquo;
            </span>
        </li>
        <li v-for="page in pagesNumber">
            <a class="border-t border-b border-l border-grey-light px-3 py-2 bg-grey-light no-underline" v-if="page == pagination.current_page">{{ page }}</a>
            <a class="border-t border-b border-l border-grey-light px-3 py-2 hover:bg-grey-light text-grey-dark no-underline" v-on:click.prevent="changePage(page)" v-else> {{ page }}</a>
        </li>
        <li v-if="pagination.current_page < pagination.last_page">
            <a  class="rounded-r rounded-sm border border-grey-light px-3 py-2 hover:bg-grey-light text-grey-dark no-underline" v-on:click.prevent="changePage(pagination.current_page + 1)">
                &raquo;
            </a>
        </li>
        <li v-else>
            <span class="rounded-r rounded-sm border border-grey-light px-3 py-2 hover:bg-grey-light text-grey-dark no-underline cursor-not-allowed">
                &raquo;
            </span>
        </li>
    </ul>
</template>
<script>
    export default{
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },
        computed: {
            pagesNumber() {
                if (!this.pagination.to) {
                    return [];
                }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                let pagesArray = [];
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }
                return pagesArray;
            }
        },
        methods : {
            changePage(page) {
                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        }
    }
</script>