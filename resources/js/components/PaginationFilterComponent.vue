<template>
    <div class="card">
        <div class="card-body">
            <b-form @submit.prevent="onSubmit">
                <b-row>
                    <b-col>
                        <b-form-group label="How many people?"
                                      class="mb-2"
                                      id="limit-field-1"
                                      label-for="page-limit">

                            <b-form-input
                                id="page-limit"
                                type="number"
                                :min="1"
                                v-model="$v.paginationLimitData.pageOffset.$model"
                                placeholder="20"></b-form-input>

                        </b-form-group>
                    </b-col>

                    <b-col>
                        <b-button id="set-page-limit"
                                  variant="warning"
                                  size="md"
                                  class="ml-5 mb-2 float-right"
                                  style="margin-top: 2rem !important;"
                                  type="submit">
                            Set Limit
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </div>
    </div>
</template>

<script>

import {validationMixin} from "vuelidate";

export default {
    name: "PaginationFilterComponent",
    mixins: [validationMixin],
    props: ['paginationLimitData'],
    validations: {
        paginationLimitData: {
            pageOffset: {},
        }
    },
    methods: {
        // on pagination limit form submit action
        onSubmit: function () {
            this.$emit('onSubmit', this.paginationLimitData); // send data to main parent
        },
    },
}
</script>

<style scoped>

</style>
