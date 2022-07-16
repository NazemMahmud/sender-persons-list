<template>
    <div class="card">
        <div class="card-body">
            <b-form @submit.prevent="onSubmit">
                <b-row>
                    <!-- Birth year field -->
                    <b-col>
                        <b-form-group  label="Birth year"
                                       class="mb-2"
                                       id="fieldset-1"
                                       label-for="birth-year">

                            <b-form-input
                                id="birth-year"
                                type="number"
                                :min="100"
                                v-model="$v.filterForm.birthYear.$model"
                                placeholder="1969"></b-form-input>

                        </b-form-group>
                    </b-col>
                    <!-- Birth month field -->
                    <b-col>
                        <b-form-group  label="Birth month"
                                       class="mb-2"
                                       id="fieldset-2"
                                       label-for="birth-month">

                            <b-form-input
                                id="birth-month"
                                type="number"
                                :min="1"
                                v-model="$v.filterForm.birthMonth.$model"
                                placeholder="12"></b-form-input>

                        </b-form-group>
                    </b-col>

                    <b-col>
                        <b-button id="filter-btn" variant="warning" class="ml-5 mb-2 float-right" style="margin-top: 2rem !important;" size="md" type="submit">Filter</b-button>
                    </b-col>
                </b-row>

            </b-form>
        </div>
    </div>
</template>

<script>

import { validationMixin } from "vuelidate";

export default {
    name: "BirthdayFilterComponent",
    mixins: [validationMixin],
    props: ['formData'],
    data() {
        return {
            filterForm: {
                birthYear: this.formData.birthYear,
                birthMonth: this.formData.birthMonth,
            },
        }
    },
    validations: {
        filterForm: {
            birthYear: {
                minValue: 1000
            },
            birthMonth: {},
        },
    },
    methods: {
        // on filter form submit action
        onSubmit: function() {
            this.$emit('onSubmit', this.filterForm); // send data to main parent
        },
    },
}
</script>

<style scoped>

</style>
