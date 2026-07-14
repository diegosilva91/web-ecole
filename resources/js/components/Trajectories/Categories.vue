<template>
    <div class="bg-color">
        <div class="box">
            <h2 class="h2-txt-med text-center mb-55">¿Qué puedo encontrar?
            </h2>
            <div class="row justify-content-center">
                <div class="col-lg-4 my-auto pr-0">
                    <h2 class="h3-txt-sbold purple5c mb-3">Programación</h2>
                    <p class="mb-3">Las ventajas de la programación van más allá del entorno laboral. Esta disciplina
                        fomenta el <span>pensamiento computacional</span>, el <span>razonamiento</span>, <span>estructura la mente </span>
                        y <span>ordena las ideas</span>, y ayuda a mejorar la capacidad de
                        <span>resolución de problemas</span>.
                        En las primeras etapas trabajarán con el entorno Minecraft y Scratch y a partir de los 12 años
                        entrarán en las bases de programación con el Lenguaje C.</p>
                    <a href="/es/cursos/s/area-informatica-programacion-y-sistemas/categoria-programacion">
                        <button class="btn-buy text-light">¡Me interesa!</button>
                    </a>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-5 text-center">
                    <img width="500" src="/assets/images/categories/code.svg" alt="">
                </div>
            </div>
            <div class="row flex-column-reverse flex-lg-row justify-content-center mt-100">
                <div class="col-lg-5 text-center">
                    <img width="500" src="/assets/images/categories/game_blue.svg" alt="">
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-4 my-auto">
                    <h2 class="h3-txt-sbold purple5c mb-3">Programación y creación <br> de videojuegos</h2>
                    <p class="mb-3">Desarrollarán competencias como la <span>creatividad</span>, la
                        <span>comunicación</span> o el <span>trabajo en equipo</span>. Empezando por el entorno
                        Minecraft, pasando por Roblox hasta llegar al entorno Unity. En esta trayectoria también
                        trabajarán conceptos de programación.</p>
                    <a href="/es/cursos/s/area-informatica-programacion-y-sistemas/categoria-creacion-de-videojuegos">
                        <button class="btn-buy text-light">¡Me interesa!</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {}
</script>

<style scoped>
.box {
    margin-left: 10%;
    margin-right: 10%;
    padding-top: 55px;
    padding-bottom: 150px;
}

.bg-color {
    background-color: #def2f4;
}

p {
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 300;
    color: #343a40;
}

p > span {
    font-weight: 500;
}

a {
    font-size: 16px;
    font-weight: 600;
    color: #f8f9fa;
}
</style>
