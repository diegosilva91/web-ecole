<template>
  <div>
  <div class="container">
    <h4 class="amsib-26">Buscador de cursos</h4>
  </div>
  <div class="bg-grey mt-2">
  <div class="container">
      <v-text-field
        class="row col-12 mx-auto"
        solo
        label="Busca por tema o profesor"
        prepend-inner-icon="search"
      >
      </v-text-field>
      <v-dialog
        v-model="dialog"
        max-width="400px"
      >
      <template v-slot:activator="{ on, attrs }"> 
        <v-btn 
          v-bind="attrs" 
          v-on="on" 
          depressed 
          color="#29c0d3" 
          class="mr-2 text-transform-btn white--text"
        >
        {{dialogm1}}
        </v-btn>
      </template>
        <v-card>
          <v-card-title>¿Cuándo quiero empezar?</v-card-title>
          <v-divider></v-divider>
          <v-card-text style="height: 100px;">
            <v-radio-group
              v-model="dialogm1"
              column
            >
              <v-radio
                label="A partir de esta semana o después"
                value="A partir de esta semana o después"
              ></v-radio>
              <v-radio
                label="A partir de la semana que viene o después"
                value="A partir de la semana que viene o después"
              ></v-radio>
              <v-radio
                label="A partir del próximo mes o después"
                value="A partir del próximo mes o después"
              ></v-radio>
            </v-radio-group>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog = false"
            >
              Cancelar
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog = false"
            >
              Buscar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      
      
      <v-dialog
        v-model="dialog2"
        max-width="400px"
      >
      <template v-slot:activator="{ on, attrs }">
      <v-btn
        v-bind="attrs" 
        v-on="on"  
        depressed 
        class="mr-2 text-transform-btn change-color"
      >
        Cualquier día u hora
      </v-btn>
       </template>
        <v-card>
          <v-card-title>Que dia u hora</v-card-title>
          <v-divider></v-divider>
          <v-card-text style="height: 100px;">
            <v-radio-group
              v-model="dialogm2"
              column
            >
              <v-radio
                label="A partir de esta semana o después"
                value="A partir de esta semana o después"
              ></v-radio>
              
            </v-radio-group>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog2 = false"
            >
              Cancelar
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog2 = false"
            >
              Buscar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      
      <v-dialog
        v-model="dialog3"
        max-width="400px"
      >
      <template v-slot:activator="{ on, attrs }">
      <v-btn
        v-bind="attrs" 
        v-on="on"  
        depressed 
        color="white" 
        class="mr-2 text-transform-btn change-color"
      >
        Cualquier edad
      </v-btn>
      </template>
        <v-card>
          <!-- <v-card-title>¿Qué edad?</v-card-title>
          <v-divider></v-divider> -->
          <v-card-text style="height: 360px;">
            <v-radio-group
              v-model="dialogm3"
              column
            >
              <v-container fluid>
              <v-row class="light--text">
                <v-col cols="3">
                  <v-checkbox
                    label="3"
                    value= 3
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="7"
                    value= 7
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="11"
                    value= 11
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="15"
                    value= 15
                  ></v-checkbox>
                </v-col>
              </v-row>
              <v-row class="light--text">
                <v-col cols="3">
                  <v-checkbox
                    label="4"
                    value= 4
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="8"
                    value= 8
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="12"
                    value= 12
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="16"
                    value= 16
                  ></v-checkbox>
                </v-col>
              </v-row>
              <v-row class="light--text">
                <v-col cols="3">
                  <v-checkbox
                    label="5"
                    value= 5
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="9"
                    value= 9
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="13"
                    value= 13
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="17"
                    value= 17
                  ></v-checkbox>
                </v-col>
              </v-row>
              <v-row class="light--text">
                <v-col cols="3">
                  <v-checkbox
                    label="6"
                    value= 6
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="10"
                    value= 10
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="14"
                    value= 14
                  ></v-checkbox>
                </v-col>
                <v-col cols="3">
                  <v-checkbox
                    label="18"
                    value= 18
                  ></v-checkbox>
                </v-col>
              </v-row>
              </v-container> 
            </v-radio-group>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog3 = false"
            >
              Cancelar
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog3 = false"
            >
              Buscar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      
      <v-dialog
        v-model="dialog4"
        max-width="400px"
      >
      <template v-slot:activator="{ on, attrs }">
      <v-btn
        v-bind="attrs" 
        v-on="on"  
        depressed 
        color="white" 
        class="mr-2 text-transform-btn change-color"
      >
        Cualquier tema
      </v-btn>
      </template>
        <v-card>
          <v-card-title>¿Qué tema?</v-card-title>
          <v-divider></v-divider>
          <v-card-text style="height: 200px;">
            <v-radio-group
              v-model="dialogm4"
              column
            >
              <v-radio
                label="Artes"
                value="artes"
              ></v-radio>
              <v-radio
                label="Deportes"
                value="deportes"
              ></v-radio>
              <v-radio
                label="Música"
                value="musica"
              ></v-radio>
              <v-radio
                label="Idiomas"
                value="idiomas"
              ></v-radio>
              <v-radio
                label="Refuerzo escolar"
                value="refuerzo"
              ></v-radio>
              <v-radio
                label="Tecnología"
                value="tecnologia"
              ></v-radio>
              
            </v-radio-group>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog4 = false"
            >
              Cancelar
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog4 = false"
            >
              Buscar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog
        v-model="dialog5"
        max-width="400px"
      >
      <template v-slot:activator="{ on, attrs }">
      <v-btn
        v-bind="attrs" 
        v-on="on"  
        depressed 
        color="white" 
        class="text-transform-btn change-color"
      >
        Cualquier precio
      </v-btn>
      </template>
        <v-card>
          <v-card-title>¿Que precio?</v-card-title>
          <v-divider></v-divider>
          <v-card-text style="height: 100px;">
            <!-- <v-radio-group
              v-model="dialogm5"
              column
            > -->
              <v-slider
                class="mt-20"
                v-model="ex3.val"
                append-icon="mdi-currency-eur"
                :thumb-color="ex3.color"
                thumb-label="always"
              ></v-slider>
              
            <!-- </v-radio-group> -->
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog5 = false"
            >
              Cancelar
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="dialog5 = false"
            >
              Buscar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

    </div>
  </div>
</div>  
</template>

<script>
export default {
  data () {
      return {
        dialogm1: 'A partir de esta semana o después',
        dialog: false,
        dialogm2: '',
        dialog2: false,
        dialogm3: '',
        dialog3: false,
        dialogm4: '',
        dialog4: false,
        dialogm5: '',
        dialog5: false,
        ex3: { label: '€', val: 100, color: '#29c0d3' },
      }
    },
}
</script>

<style>

</style>