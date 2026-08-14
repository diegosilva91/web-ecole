import { defineStore } from "pinia";

export const useAppStore = defineStore("app", {
  state: () => {
    return {
      mainMenu: [
        {
          code: "areas",
          title: "Áreas",
          childrens: [
            {
              code: "programacion-y-videojuegos",
              title: "Programación y videojuegos",
              subtitle: "Minecraft, Roblox, Unity, Scratch...",
              link: "/es/cursos/s/tag-creacion-de-videojuegos"
            },
            {
              code: "robotica",
              title: "Robótica",
              subtitle: "Arduino, Robots, TinkerCad...",
              link: "/es/cursos/s/tag-robotica"
            },
            {
              code: "arte-digital",
              title: "Arte digital",
              subtitle: "Ilustración, manga, diseño...",
              link: "/es/cursos/s/area-arte-digital"
            },
            {
              code: "produccion-audovisual",
              title: "Producción audovisual",
              subtitle: "Edición de video, modelado...",
              link: "/es/cursos/s/area-produccion-audiovisual"
            },
            {
              code: "desarrollo-web",
              title: "Desarrollo web",
              subtitle: "JavaScript, HTML, CSS, Wordpress...",
              link: "/es/cursos/s/tag-programacion-web"
            },
            {
              code: "influencers-y-redes-sociales",
              title: "Influencers y redes sociales",
              subtitle: "YouTube, Twitch, TikTok, RRSS...",
              link: "/es/cursos/s/tag-influencer"
            }
          ]
        },
        {
          code: "oferta-educativa",
          title: "Oferta educativa",
          childrensSpecial: [
            {
              code: "trayectorias-educativas",
              title: "Trayectorias educativas",
              subtitle:
                "Extraescolares anuales con educadores en directo",
              link: "/es/cursos-anuales",
              color: "#29c0d3"
            },
            {
              code: "cursos-intensivos",
              title: "Cursos intensivos",
              subtitle:
                "Cursos mensuales con educadores en directo",
              link: "/es/cursos",
              color: "#793e87"
            },
            {
              code: "campus-de-verano",
              title: "Campus de verano",
              subtitle: "Cursos semanales con educadores en directo",
              link: "/es/campus-verano",
              color: "#ffb300"
            }
          ]
        },
        {
          code: "sobre-mi-empresa",
          title: "¿Quienes somos?",
          link: "/es/sobre-mi-empresa"
        },
        {
          code: "contacto",
          title: "Contacto",
          link: "/es/contacto"
        }
      ],
      overlay: false
    };
  }
});
