<template>
    <div :class="estilo" role="alert">
        {{ titulo }}
        <hr>
        {{ detalhes.data.errors}}
    </div>
</template>

<script>
export default {
    props: [
        'tipo',
        'titulo',
        'detalhes'
    ],
    computed: {
        estilo() {
            return 'alert alert-'+this.tipo
        }
    }
}
</script>
