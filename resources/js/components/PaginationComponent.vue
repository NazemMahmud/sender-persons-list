<template>
    <div class="card">
        <div class="card-body">
            <div class="float-right">
                <!--    left pagination icon -->
                <span>
                    <b-button id="left-icon" size="sm" class="p-0 border-0 pagination-icon"
                              :style="[isLeftIconDisabled() ? {'cursor': 'not-allowed'} : {'cursor': 'pointer'} ]"
                              :disabled="isLeftIconDisabled()"
                              @click="updatePaginatedList('prev')">
                        <b-icon-arrow-left-short style="width: 30px; height: 22px;"/>
                    </b-button>
                </span>

                <!--    pagination info ( start - last ) -->
                <span >
                    <strong> {{ paginationData.firstItemNumber }} </strong>
                    -
                    <strong> {{ paginationData.lastItemNumber }}</strong>
                    of
                    <strong> {{ paginationData.total }}</strong>
                </span>

                <!--    right pagination icon -->
                <span>
                    <b-button id="right-icon" size="sm" class="p-0 border-0 pagination-icon"
                              :style="[isRightIconDisabled() ? {'cursor': 'not-allowed'} : {'cursor': 'pointer'} ]"
                              :disabled="isRightIconDisabled()"
                              @click="updatePaginatedList('next')">
                        <b-icon-arrow-right-short style="width: 30px; height: 22px;"/>
                    </b-button>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PaginationComponent",
    props: ['paginationData'],
    methods: {
        // on filter form submit action
        updatePaginatedList: function(prevOrNext) {
            this.$emit('updatePaginatedList', prevOrNext); // send data to main parent
        },

        // left arrow icon disable if it is the 1st page
        isLeftIconDisabled: function () {
            return this.paginationData.firstItemNumber === 1;
        },

        // left arrow icon disable if it is the 1st page
        isRightIconDisabled: function () {
            return this.paginationData.lastItemNumber === this.paginationData.total;
        }
    },
}
</script>

<style scoped>

</style>
