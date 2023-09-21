<template>
    <div :class="estilo" role="alert">
        A mensagem de feedBack
        {{ tipo }}
    </div>
</template>

<script>
export default {
    props: ['tipo'],
    computed: {
        estilo() {
            return 'alert alert-'+this.tipo
        }
    }
}
</script>
