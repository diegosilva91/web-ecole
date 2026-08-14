<template>
  <div>
    <observer v-if="!loading" msg="footer" v-on:intersect="intersected" />

    <div v-else class="footer">
      <div class="box-footer row">
        <!-- MAIN -->
        <div class="col-12 col-sm-6 col-lg-4 d-flex d-sm-block pl-0 pl-sm-3">
          <div class="col-4 p-sm-0">
            <div><a href="/es">Home</a></div>
            <div class="mt-lg-2"><a href="/es/cursos-anuales">Trayectorias</a></div>
            <div class="mt-lg-2"><a href="/es/cursos">Intensivos</a></div>
          </div>
          <div class="col-5 p-sm-0">
            <div class="mt-lg-2">
              <a href="/es/sobre-mi-empresa">Sobre Mi-empresa</a>
            </div>
            <div class="mt-lg-2"><a href="/es/dar-clases">Dar clases</a></div>
            <div class="mt-lg-2"><a href="/es/faq">FAQ</a></div>
          </div>
          <div class="col-3 p-sm-0">
            <div class="mt-lg-2">
              <a href="https://blog.mi-empresa.com/" target="_blank">Blog</a>
            </div>
            <div class="mt-lg-2"><a href="/es/contacto">Contacto</a></div>
          </div>
        </div>

        <!-- AREAS -->
        <div class="col-12 col-sm-6 col-lg-2">
          <div><a href="/es/cursos-anuales/landing">Áreas</a></div>
          <div class="mt-2">
            <a href="/es/cursos/s/area-educacion-metodologia-e-idiomas">
              <span>Educación, metodologías e idiomas</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/area-informatica-programacion-y-sistemas">
              <span>Informática, programación y sistemas</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/area-robotica-e-ingenieria-industrial">
              <span>Robótica e ingeniería industrial</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/area-desarrollo-de-marca-y-estrategia-digital">
              <span>Desarrollo de marca y estrategia digital</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/area-produccion-audiovisual"><span>Producción audiovisual</span></a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/area-arte-digital"><span>Arte digital</span></a>
          </div>
        </div>

        <!-- CATEGORIES -->
        <div class="col-12 col-sm-6 col-lg-2">
          <div class="mt-2"><a href="/es/tech/web">Categorías</a></div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-programacion-junior">
              <span>Programación para niños</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-programacion-profesional">
              <span>Programación avanzada</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-programacion-web">
              <span>Desarrollo web</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-diseno-grafico">
              <span>Diseño gráfico</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-3d"><span>3D</span></a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-robotica"><span>Robótica</span></a>
          </div>
        </div>

        <!-- SPECIALIZATIONS -->
        <div class="col-12 col-sm-6 col-lg-2">
          <div class="mt-2">
            <div class="mt-2"><a href="/es/tech/web">Especializaciones</a></div>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-influencer"><span>Redes sociales</span></a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-creacion-robots">
              <span>Creación de robots</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-mod"><span>Mods Minecraft</span></a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-manga">
              <span>Manga</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-creacion-de-videojuegos">
              <span>Programación videojuegos</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-realidad-virtual"><span>Realidad virtual</span></a>
          </div>
        </div>

        <!-- TAGS -->
        <div class="col-12 col-sm-6 col-lg-2">
          <div class="mt-2"><a href="/es/tech/web">Tags</a></div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-minecraft">
              <span>Minecraft</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-roblox"><span>Roblox</span></a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-arduino"><span>Arduino</span></a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-influencer"><span>Influencer</span></a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-metaverso">
              <span>Metaverso</span>
            </a>
          </div>
          <div class="mt-2">
            <a href="/es/cursos/s/tag-blender">
              <span>Blender</span>
            </a>
          </div>
        </div>
      </div>

      <!-- SUBFOOTER -->
      <div class="sub-footer align-items-center">
        <div class="box-subfooter">
          <div class="row text-center text-sm-left">
            <div
              class="col-12 col-sm-2 mx-auto mx-sm-0 mx-md-2 mx-lg-3 my-auto"
            >
              <img
                src="/assets/images/home/logo-mi-empresa.svg"
                width="125"
                height="25"
                alt=""
              />
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-lg-2 my-auto">
              <div class="d-inline mr-mob-30 mr-tb-35 mr-dk-35">
                <a href="https://www.facebook.com/LifeColeEdu/">
                  <img
                    src="/assets/images/home/facebook.svg"
                    width="11"
                    alt="icon"
                  />
                </a>
              </div>
              <div class="d-inline mr-mob-30 mr-tb-35 mr-dk-35">
                <a href="https://www.instagram.com/mi-empresaedu/">
                  <img
                    src="/assets/images/home/insta.svg"
                    width="21"
                    alt="icon"
                  />
                </a>
              </div>
              <div class="d-inline">
                <a href="https://twitter.com/mi-empresaedu">
                  <img
                    src="/assets/images/home/twitter.svg"
                    width="21"
                    alt="icon"
                  />
                </a>
              </div>
            </div>
            <div class="col-12 col-sm-2 my-auto mr-sm-5">
              <h6 class="mx-auto">
                &copy; Copyrights 2020 Mi-empresa All rights reserved.
              </h6>
            </div>
            <div class="row">
              <div class="col-6 d-sm-flex">
                <li class="col text-center">
                  <a href="/es/aviso-legal">Aviso Legal</a>
                </li>
                <li class="col text-center">
                  <a href="/es/politica-de-privacidad">Política Privacidad</a>
                </li>
              </div>
              <div class="col-6 d-sm-flex">
                <li class="col text-center">
                  <a href="/es/politica-de-cookies">Política Cookies</a>
                </li>
                <li class="col text-center">
                  <a href="/es/terminos-y-condiciones">
                    Condiciones de Servicio
                  </a>
                </li>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Observer from "./Observer";

export default {
  components: {
    Observer,
  },
  data() {
    return {
      loading: false,
    };
  },
  mounted() {
    this.$nextTick(() => {
      if (window.location.pathname !== "/es") {
        this.loading = true;
      }
    });
  },
  methods: {
    intersected() {
      this.loading = true;
    },
  },
};
</script>

<style scoped>
.box-footer {
  margin-left: 5%;
  margin-right: 5%;
  padding-top: 20px;
  padding-bottom: 20px;
}

.box-subfooter {
  margin-left: 5%;
  margin-right: 5%;
}

.footer {
  background-color: #5c2767;
  height: auto;
  margin: 0 !important;
}

.sub-footer {
  height: auto;
  background-color: #4c1d56;
  padding-top: 10px;
  padding-bottom: 10px;
}

.box-footer a {
  font-family: "Poppins";
  font-size: 14px;
  font-weight: 500;
  color: #ffffff;
}

.box-footer a > span {
  opacity: 0.7;
}

h6,
li > a {
  font-family: "Poppins";
  font-size: 11px;
  font-weight: 400;
  color: #b57ac4;
  width: max-content;
}

li {
  list-style: none;
}
</style>
