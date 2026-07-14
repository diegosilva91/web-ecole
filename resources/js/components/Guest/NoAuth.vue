<template>
    <div class="container-10 text-center p-5">
        <h3>No estás autorizado para ver esta información</h3>
        <p class="mt-2">¡Descubre nuestra amplia variedad de cursos!</p>
        <a href="/es/cursos"><button class="btn-more-courses mt-2">Ver Cursos</button></a>
    </div>
</template>

<script>
export default {
    name: "NoAuth"
}
</script>

<style scoped>
.container-10{
    margin-left: 15%;
    margin-right: 15%;
    margin-top: auto;
    margin-bottom: auto;
    background-color: #eef0f3;
}

h3{
    font-family: 'Poppins';
    font-size: 21px;
    font-weight: 500;
    line-height: 1.95;
}

p{
    font-family: 'Poppins';
    font-size: 18px;
    font-weight: 500;
    line-height: 1.95;
    color: #343a40;
}

.btn-more-courses {
    width: 176px;
    height: 38px;
    border-radius: 8px;
    box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);
    background-color: #29c0d3;
    text-transform: uppercase;
    color: #fff;
    font-family: 'Open Sans';
    font-size: 16px;
    font-weight: 600;
}

@media (max-width: 500px){
    .container-10{
        margin-left: auto;
        margin-right: auto;
    }
}
</style>
