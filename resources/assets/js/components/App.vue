<template>
    <div class="container mx-auto">
        <TopNavigation/>

        <div class="flex">
            <div class="w-1/6 mb-4 pb-4">
                <h4 class="mb-2 pb-2 text-xs uppercase text-grey-dark tracking-wide"> Logs </h4>

                <ul class="list-reset text-sm">
                    <li class="pb-3">
                        <a href="" class="flex items-center text-blue font-bold">
                            <font-awesome-icon class="text-grey mr-3" icon="file-alt"/>
                            Single
                        </a>
                    </li>
                    <li class="pb-3">
                        <a class="flex items-center text-grey-darkest hover:text-blue hover:font-bold">
                            <font-awesome-icon class="text-grey mr-3" icon="copy"/>
                            Daily
                        </a>
                    </li>
                    <!--<li class="pb-3"><a href=""-->
                    <!--class="flex items-center text-grey-darkest hover:text-blue hover:font-bold">-->
                    <!--<font-awesome-icon class="text-grey mr-3" icon="server"/>-->
                    <!--System Log</a></li>-->
                    <!--<li class="pb-3"><a href=""-->
                    <!--class="flex items-center text-grey-darkest hover:text-blue hover:font-bold">-->
                    <!--<font-awesome-icon class="text-grey mr-3" icon="exclamation-triangle"/>-->
                    <!--Error Log</a></li>-->
                </ul>
            </div>
            <div class="w-5/6">
                <div class="shadow p-6 bg-white w-full">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="mb-2 pb-2 uppercase text-grey-darker tracking-wide"> Overview </h4>
                    </div>
                    <div class="p-4 flex items-center justify-center" v-if="! logs.data">
                        <font-awesome-icon class="text-grey mr-3 text-2xl" icon="spinner" spin/>
                        Loading...
                    </div>

                    <div class="overflow-y-scroll" v-else>

                        <table class="w-full text-left table-collapse">
                            <thead>
                            <tr>
                                <td class="text-sm font-semibold text-grey-darker p-2 bg-grey-lightest">Level</td>
                                <td class="text-sm font-semibold text-grey-darker p-2 bg-grey-lightest">Date</td>
                                <td class="text-sm font-semibold text-grey-darker p-2 bg-grey-lightest">Message</td>
                            </tr>
                            </thead>
                            <tbody class="align-baseline">
                            <tr class="hover:bg-blue-lightest" v-for="log in logs.data">
                                <td class="p-2 border-t border-grey-light text-sm text-grey-darker flex"
                                    :class="log.level_class">
                                    <font-awesome-icon :icon="log.level_img" class="mr-2"/>
                                    {{log.level}}
                                </td>
                                <td class="p-2 border-t border-grey-light text-sm text-grey-darker"
                                    style="min-width: 100px"> {{ log.date}}
                                </td>
                                <td class="p-2 border-t border-grey-light text-sm text-grey-darker"> {{ log.text }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <vue-pagination :pagination="logs"
                                    @paginate="getLogs"
                                    :offset="3">
                    </vue-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    import TopNavigation from './TopNavigation.vue'
    import VuePagination from './Pagination.vue'

    export default {
        name: 'App',
        components: {TopNavigation, VuePagination},
        data() {
            return {
                logs: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    data: false,
                    current_page: 1
                },
                offset: 5,
            }
        },
        mounted() {
            this.getLogs()
        },
        methods: {
            getLogs() {
                axios.get(`/ward/api/logs?page=${this.logs.current_page}`)
                    .then(response => this.logs = response.data)
            }
        }
    };
</script>