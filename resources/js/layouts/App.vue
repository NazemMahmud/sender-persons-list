<template>
    <div class="container mt-4">
        <LoaderComponent :isLoading="isLoading"/>
        <!-- filters & page limit component  -->
        <div class="mt-4">
            <b-row>
                <b-col cols="7">
                    <BirthdayFilterComponent
                        :formData="filterForm"
                        v-on:onSubmit="onBirthdayFilterSubmit($event)"
                        ref="birthdayFilterForm"/>
                </b-col>

                <b-col cols="5">
                    <PaginationFilterComponent
                        :paginationLimitData="paginationForm"
                        v-on:onSubmit="onPaginationLimitSubmit($event)"
                        ref="paginationLimitForm"/>
                </b-col>
            </b-row>

        </div>

        <!--  No data found condition  -->
        <div class="mt-4" v-if="!isLoading && !usersList.length">
            <b-row>
                <b-col cols="12">
                    <NodataFound/>
                </b-col>
            </b-row>
        </div>

        <!--  data table component  -->
        <div class="mt-4" v-if="!isLoading && usersList.length">
            <b-row>
                <b-col>
                    <PaginationComponent
                        :paginationData="paginate"
                        v-on:updatePaginatedList="updatePaginatedList($event)"
                    />
                    <ListComponent :items="usersList"/>
                    <PaginationComponent
                        :paginationData="paginate"
                        v-on:updatePaginatedList="updatePaginatedList($event)"/>
                </b-col>
            </b-row>

        </div>
    </div>
</template>

<script>

import LoaderComponent from "../components/LoaderComponent";
import BirthdayFilterComponent from "../components/BirthdayFilterComponent";
import PaginationFilterComponent from "../components/PaginationFilterComponent";
import ListComponent from "../components/ListComponent";
import NodataFound from "../components/NodataFound";
import PaginationComponent from "../components/PaginationComponent";

import {getUsersList} from "../services/users.service";
import {updateQueryParam, pushParam, updateUrl} from "../utility/utils";

export default {
    name: "App",
    components: {
        LoaderComponent,
        BirthdayFilterComponent,
        PaginationComponent,
        PaginationFilterComponent,
        ListComponent,
        NodataFound
    },

    data() {
        return {
            isLoading: false,
            usersList: [],
            queryParams: '',
            filterForm: {
                birthYear: "",
                birthMonth: "",
            },
            paginationForm: {
                pageOffset: 20,
                page: 1,
            },
            paginate: {
                total: 0,
                firstItemNumber: 0,
                lastItemNumber: 0,
            }
        }
    },

    methods: {
        /** show / hide loader */
        updateLoader: function () {
            this.isLoading = !this.isLoading;
        },

        /** API call: get all users list with country */
        getUsers: async function () {
            await getUsersList(this.queryParams).then(res => {
                /**
                 * Set: users list, queryParam in localStorage
                 * Update: browser url with queryParams, pagination info, empty queryParams string
                 * Stop loader
                 */
                this.usersList = res.data.data;
                updateUrl(this.$route.path, this.queryParams);
                localStorage.setItem('queryParams', this.queryParams);
                this.updatePaginationData(res.data);
                this.reset();
            }).catch(error => {
                console.log(error);
                this.reset();
            });
        },

        // emptying queryParam & close loader
        reset: function () {
            this.queryParams = '';
            this.updateLoader();
        },

        /** ******* Forms submit actions ********* */

        onBirthdayFilterSubmit: function (data) {
            this.filterForm = data;
            this.paginationForm.page = 1;
            this.onSubmit();
        },

        onPaginationLimitSubmit: function (data) {
            this.paginationForm = data;
            this.onSubmit();
        },

        // on forms submit action
        onSubmit: function () {
            this.queryParams = updateQueryParam({
                queryParams: this.queryParams,
                filterForm: this.filterForm,
                paginationForm: this.paginationForm,
            });
            this.updateLoader(); // loading starts
            this.getUsers();
        },
        /** ******* Forms submit actions End ********* */

        /** on pagination button click */
        updatePaginatedList: function (prevOrNext) {
            this.paginationForm.page = prevOrNext === 'prev' ? this.paginationForm.page - 1 : this.paginationForm.page + 1;
            this.onSubmit();
        },

        /**  populate both filter forms after refreshing page if previously year is used */
        populateFilterForms: function () {
            const searchParams = new URL(`${process.env.MIX_API_BASE_URL}?${this.queryParams}`).searchParams;

            if (searchParams.get("year")) {
                this.filterForm.birthYear = searchParams.get("year");
            }

            if (searchParams.get("month")) {
                this.filterForm.birthMonth = searchParams.get("month");
            }

            this.paginationForm.pageOffset = searchParams.get("pageOffset");
            this.paginationForm.page = searchParams.get("page");
        },

        /**
         * Update pagination data so that pagination component get updates
         * @param data
         */
        updatePaginationData: function (data) {
            this.paginationForm = {
                ...this.paginationForm,
                pageOffset: data.per_page,
                page: data.current_page
            };

            const lastItem = data.current_page * this.paginationForm.pageOffset;
            this.paginate = {
                ...this.paginate,
                total: data.total,
                firstItemNumber: lastItem - this.paginationForm.pageOffset + 1,
                lastItemNumber: lastItem > data.total ? data.total : lastItem,
            }
        }
    },

    created() {
        /**
         * If there are any query params in browser url (can occur: after filtering then refresh page | direct type params in URL)
         * Else, check localstorage ( can occur, after filtering then refresh page, because params are stored in local storage )
         * Else, default params are pageOffset & current page number (= 1)
         */
        if (Object.keys(this.$route.query).length) {
            this.queryParams = pushParam({
                queryParams: this.queryParams,
                params: this.$route.query
            });

        } else {
            this.queryParams = localStorage.getItem("queryParams") ?? `pageOffset=${this.paginationForm.pageOffset}&page=${this.paginationForm.page}`;
        }

        this.populateFilterForms();
        this.updateLoader();
        this.getUsers();
    }
}
</script>
