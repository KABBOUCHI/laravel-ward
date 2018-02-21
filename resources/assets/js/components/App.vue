<template>
    <div class="container mx-auto">
        <TopNavigation/>

        <div class="flex">
            <div class="w-1/6 mb-4 pb-4">
                <h4 class="mb-2 pb-2 text-xs uppercase text-grey-dark tracking-wide"> Logs </h4>

                <ul class="list-reset text-sm">
                    <li class="pb-3"><a href=""
                                        class="flex items-center text-grey-darkest hover:text-blue hover:font-bold">
                        <font-awesome-icon class="text-grey mr-3" icon="file-alt"/>
                        Single</a></li>
                    <li class="pb-3"><a href=""
                                        class="flex items-center text-grey-darkest hover:text-blue hover:font-bold">
                        <font-awesome-icon class="text-grey mr-3" icon="copy"/>
                        Daily</a></li>
                    <li class="pb-3"><a href=""
                                        class="flex items-center text-grey-darkest hover:text-blue hover:font-bold">
                        <font-awesome-icon class="text-grey mr-3" icon="server"/>
                        System Log</a></li>
                    <li class="pb-3"><a href=""
                                        class="flex items-center text-grey-darkest hover:text-blue hover:font-bold">
                        <font-awesome-icon class="text-grey mr-3" icon="exclamation-triangle"/>
                        Error Log</a></li>
                </ul>
            </div>
            <div class="w-5/6">
                <div class="shadow p-6 bg-white w-full">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="mb-2 pb-2 uppercase text-grey-darker tracking-wide"> Overview </h4>

                        <div class="relative mr-6 my-2">
                            <input type="search" class="bg-purple-white shadow rounded border-0 p-3"
                                   placeholder="Search...">
                            <div class="absolute pin-r pin-t mt-3 mr-4 text-purple-lighter">
                                <svg version="1.1" class="h-4 text-dark" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 52.966 52.966" style="enable-background:new 0 0 52.966 52.966;" xml:space="preserve">
                                    <path d="M51.704,51.273L36.845,35.82c3.79-3.801,6.138-9.041,6.138-14.82c0-11.58-9.42-21-21-21s-21,9.42-21,21s9.42,21,21,21
                                    c5.083,0,9.748-1.817,13.384-4.832l14.895,15.491c0.196,0.205,0.458,0.307,0.721,0.307c0.25,0,0.499-0.093,0.693-0.279
                                    C52.074,52.304,52.086,51.671,51.704,51.273z M21.983,40c-10.477,0-19-8.523-19-19s8.523-19,19-19s19,8.523,19,19
                                    S32.459,40,21.983,40z"/>

                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 flex items-center justify-center" v-if="! logs">
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
                            <tr v-for="log in logs">
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
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    import TopNavigation from './TopNavigation.vue'

    export default {
        name: 'App',
        components: {TopNavigation},
        data() {
            return {
                logs: false
            }
        },
        created() {
            axios.get('/ward/api/logs')
                .then(response => this.logs = response.data)
        },
    };
</script>