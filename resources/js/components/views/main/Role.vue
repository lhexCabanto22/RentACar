<template>
    <div v-if="admin">
    </div>
</template>
<script>
export default {
    data(){
        return {
            admin: localStorage.getItem('admin')
        }
    }
}
</script>