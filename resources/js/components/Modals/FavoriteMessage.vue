<template>

    <div class="modal fade" :id="action" data-backdrop="static" data-keyboard="false" tabindex="-1"
         role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ffb300;">
                    <div class="modal-title text-light"><strong>Entra o Registrate para seleccionar tus favoritos</strong>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['action'],

}
</script>

<style scoped>

</style>
