<template>
    <div>
        <b-table bordered hover="hover" class="mb-0"
                 :items="items"
                 :fields="tableFields">
        </b-table>
    </div>
</template>

<script>

export default {
    name: "ListComponent",
    props: ['items'],
    data() {
        return {
            tableFields: [
                {key: 'name', label: 'Main URL'},
                {key: 'email', label: 'Short Code'},
                {key: 'birthday', label: 'Short Code'},
                {key: 'phone', label: 'Short Code'},
                {key: 'ip', label: 'Short Code'},
                {key: 'country_name', label: 'Country'},
            ],
        }
    },
}
</script>

<style scoped>

</style>
