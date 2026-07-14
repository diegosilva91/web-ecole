<template>
    <div class="info-perfil-container">
        <div v-show="about" class="row">
            <div class="box-about">
                <div class="d-flex ml-8">
                    <h5>Sobre Ti</h5>
                    <button @click="editAbout()" class="ml-auto mr-5">{{ btnTxt1 ? 'Editar' : 'Guardar' }}</button>
                </div>
                <hr class="w-100">
                <div v-show="btnTxt1" class="ml-8">
                    <div class="mt-5">
                        <h6>Nombre</h6>
                        <input :value="name" type="text" readonly>
                    </div>
                    <div class="mt-7">
                        <h6>Apellidos</h6>
                        <input :value="surname" type="text" readonly>
                    </div>
                    <div class="mt-7">
                        <h6>Cumpleaños</h6>
                        <input :value="birth" type="text" readonly>
                    </div>
                    <div class="mt-7">
                        <h6>Teléfono</h6>
                        <input :value="phone" type="text" readonly>
                    </div>
                </div>
                <div :class="{'d-none':btnTxt1}" class="ml-8">
                    <div class="mt-5">
                        <h6>Nombre</h6>
                        <input ref="nameInput" v-model="name" type="text" name="name" id="nameTeacher">
                    </div>
                    <div class="mt-7">
                        <h6>Apellidos</h6>
                        <input v-model="surname" type="text" name="surname" id="1">
                    </div>
                    <div class="mt-7">
                        <h6>Cumpleaños</h6>
                        <input v-model="birth" type="text" name="birth" id="3">
                    </div>
                    <div class="mt-7">
                        <h6>Teléfono</h6>
                        <input v-model="phone" type="text" name="phone" id="2">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7 col-xl-8 pl-0 pt-0">
                <div class="box-account ml-md-8">
                    <div class="d-flex ml-8">
                        <h5>Cuenta</h5>
                        <button @click="editAccount()" class="ml-auto mr-5">{{
                                btnTxt2 ? 'Editar' : 'Guardar'
                            }}
                        </button>
                    </div>
                    <hr class="w-100">
                    <div v-show="btnTxt2" class="row mt-5 ml-8">
                        <div class="col-12 col-lg-6 pl-0">
                            <h6>Email</h6>
                            <input :value="email" type="email" readonly>
                        </div>
                        <div class="col-12 col-lg-6 pl-0">
                            <h6>Contraseña</h6>
                            <input :value="password" type="text" readonly>
                        </div>
                    </div>
                    <div :class="{'d-none':btnTxt2}" class="row mt-5 ml-8">
                        <div class="col-12 col-lg-6 pl-0 mb-4">
                            <h6>Email</h6>
                            <input v-model="email" type="email" name="email" id="emailAccount" readonly>
                        </div>
                        <div class="col-12 col-lg-6 pl-0 mb-4">
                            <h6>Contraseña</h6>
                            <input v-model="password" type="text" name="password" id="passwordAccount">
                        </div>
                    </div>
                </div>
                <div class="box-bio ml-md-8 pb-0">
                    <div class="d-flex ml-8">
                        <h5>Ficha hij@</h5>
                        <button @click="editBio()" class="ml-auto mr-5">{{ btnTxt3 ? 'Editar' : 'Guardar' }}</button>
                    </div>
                    <hr class="w-100 mb-0">
                    <v-card
                        v-scroll.self="onScroll"
                        class="overflow-y-auto overflow-x-hidden"
                        height="183"
                    >
                        <div v-show="btnTxt3 && !removeSon1" class="row mt-5 ml-8">
                            <div class="col-6 col-md-4 pl-0">
                                <h6>Nombre</h6>
                                <input v-model="son1" type="text" placeholder="Nombre hij@" readonly
                                       style="border-bottom:none !important">
                            </div>
                            <div class="col-4">
                                <h6>Edad</h6>
                                <input :value="age1?`${age1} años`:''" type="text" placeholder="Edad hij@" readonly
                                       style="border-bottom:none !important">
                            </div>
                        </div>
                        <div :class="{'d-none':btnTxt3 || removeSon1}" class="row mt-5 ml-8">
                            <div class="col-6 col-md-4 pl-0">
                                <h6>Nombre</h6>
                                <input class="w-75" v-model="son1" type="text" name="son" id="nameSon1"
                                       placeholder="Nombre hij@">
                            </div>
                            <div class="col-4 col-lg-2">
                                <h6>Edad</h6>
                                <input class="w-50" v-model="age1" type="number" min="3" max="18" name="age"
                                       id="ageSon1">
                            </div>
                            <v-icon @click="removeSon1=true;son1=null;age1=null" color="#29c0d3">{{ mdiDelete }}</v-icon>
                        </div>
                        <div v-show="btnTxt3 && !removeSon2" class="row ml-8">
                            <div class="col-6 col-md-4 pl-0">
                                <h6>Nombre</h6>
                                <input v-model="son2" type="text" placeholder="Nombre hij@" readonly
                                       style="border-bottom:none !important">
                            </div>
                            <div class="col-4">
                                <h6>Edad</h6>
                                <input :value="age2?`${age2} años`:''" type="text" placeholder="Edad hij@" readonly
                                       style="border-bottom:none !important">
                            </div>
                        </div>
                        <div :class="{'d-none':btnTxt3 || removeSon2}" class="row ml-8">
                            <div class="col-6 col-md-4 pl-0">
                                <h6>Nombre</h6>
                                <input class="w-75" v-model="son2" type="text" name="son" id="nameSon2"
                                       placeholder="Nombre hij@">
                            </div>
                            <div class="col-4 col-lg-2">
                                <h6>Edad</h6>
                                <input class="w-50" v-model="age2" type="number" min="3" max="18" name="age" id="ageSon2">
                            </div>
                            <v-icon @click="removeSon2=true;son2=null;age2=null" color="#29c0d3">{{ mdiDelete }}</v-icon>
                        </div>
                        <div v-show="btnTxt3 && !removeSon3" class="row ml-8">
                            <div class="col-6 col-md-4 pl-0">
                                <h6>Nombre</h6>
                                <input v-model="son3" type="text" placeholder="Nombre hij@" readonly
                                       style="border-bottom:none !important">
                            </div>
                            <div class="col-4">
                                <h6>Edad</h6>
                                <input :value="age3?`${age3} años`:''" type="text" placeholder="Edad hij@" readonly
                                       style="border-bottom:none !important">
                            </div>
                        </div>
                        <div :class="{'d-none':btnTxt3 || removeSon3}" class="row ml-8">
                            <div class="col-6 col-md-4 pl-0">
                                <h6>Nombre</h6>
                                <input class="w-75" v-model="son3" type="text" name="son" id="nameSon3"
                                       placeholder="Nombre hij@">
                            </div>
                            <div class="col-4 col-lg-2">
                                <h6>Edad</h6>
                                <input class="w-50" v-model="age3" type="number" min="3" max="18" name="age"
                                       id="ageSon3">
                            </div>
                            <v-icon @click="removeSon3=true;son3=null;age3=null" color="#29c0d3">{{ mdiDelete }}</v-icon>
                        </div>
                        <div v-show="btnTxt3 && !removeSon4" class="row ml-8">
                            <div class="col-6 col-md-4 pl-0">
                                <h6>Nombre</h6>
                                <input v-model="son4" type="text" placeholder="Nombre hij@" readonly
                                       style="border-bottom:none !important">
                            </div>
                            <div class="col-4">
                                <h6>Edad</h6>
                                <input :value="age4?`${age4} años`:''" type="text" placeholder="Edad hij@" readonly
                                       style="border-bottom:none !important">
                            </div>
                        </div>
                        <div :class="{'d-none':btnTxt3 || removeSon4}" class="row ml-8">
                            <div class="col-6 col-md-4 pl-0">
                                <h6>Nombre</h6>
                                <input class="w-75" v-model="son4" type="text" name="son" id="nameSon"
                                       placeholder="Nombre hij@">
                            </div>
                            <div class="col-4 col-lg-2">
                                <h6>Edad</h6>
                                <input class="w-50" v-model="age4" type="number" min="3" max="18" name="age"
                                       id="ageSon4">
                            </div>
                            <v-icon @click="removeSon4=true;son4=null;age4=null" color="#29c0d3">{{ mdiDelete }}</v-icon>
                        </div>
                        <div v-show="!btnTxt3">
                            <div :class="{'bottom-position':removeSon1 && removeSon2}"
                                 class="d-flex justify-content-end mr-3 mb-5 mt-7">
                                <button @click="addSon()" class="btn-add-son">Añadir +</button>
                            </div>
                        </div>
                    </v-card>
                </div>
            </div>
        </div>
        <NotifyUser v-show="cash"/>
    </div>
</template>

<script>
import { mdiDelete } from "@mdi/js";
import Event from '../../event.js';
import NotifyUser from './NotifyUser'
import {DeleteObjectApi, UpdateObject} from "../../axios-services";

export default {
    components: {
        NotifyUser
    },
    data() {
        return {
            about: true,
            cash: false,
            btnTxt1: true,
            btnTxt2: true,
            btnTxt3: true,
            name: '',
            surname: '',
            phone: '',
            birth: '',
            email: '',
            password: '*********',
            nameSon: [],
            ageSon: [],
            user_assistant: [],
            son1: '',
            son2: '',
            son3: '',
            son4: '',
            age1: '',
            age2: '',
            age3: '',
            age4: '',
            removeSon1: false,
            removeSon2: true,
            removeSon3: true,
            removeSon4: true,
            mdiDelete
        }
    },
    computed: {
        formAboutUser() {
            return {
                name: this.name,
                last_name: this.surname,
                phone: this.phone,
                birth: this.birth,
            }
        },
        formAccount() {
            return {
                password: this.password,
            }
        },
        formUserAssistants() {
            return {
                assistant_name: this.nameSon,
                assistant_age: this.ageSon,
            }
        }
    },
    watch: {
        user_assistant(assistant) {
            console.log("update user_assistant" + assistant.length)
            if (assistant.length > 0) {
                this.nameSon = []
                this.ageSon = []
                assistant.forEach((value, key) => {
                    let sonNumber = key + 1
                    this.nameSon[key]=value.name;
                    this.ageSon[key]=value.age;
                    //this[`son${sonNumber}`] = value.name
                    //this[`age${sonNumber}`] = value.age
                    //this[`removeSon${sonNumber}`] = false
                    // this.ageSon.push(value.age);
                });
            }
        },
        nameSon(value) {
            console.log(value)
            /*this.user_assistant.forEach((value, key) => {
                let sonNumber = key + 1
                if (!this[`removeSon${sonNumber}`]) {
                    this.nameSon[key] = this[`son${sonNumber}`]
                    value.name = this[`son${sonNumber}`]
                }
            });*/
        },
        son1(value) {
            if (!this.removeSon1)
                this.nameSon[0] = value;
        },
        age1(value) {
            if (!this.removeSon1)
                this.ageSon[0] = value ? parseInt(value) : value
        },
        removeSon1(value) {
            console.log(value)
            if (value && this.user_assistant.length > 0) {
                this.removeSon(this.user_assistant[0].id)
                this.nameSon.splice(0, 1)
                this.ageSon.splice(0, 1)
            }
        },
        removeSon2(value) {
            console.log(value)
            if (value && this.user_assistant.length > 0) {
                this.user_assistant[1]?this.removeSon(this.user_assistant[1].id):''
                this.nameSon.splice(1, 1)
                this.ageSon.splice(1, 1)
            }
        },
        removeSon3(value) {
            console.log(value)
            if (value && this.user_assistant.length > 0 ) {
                this.user_assistant[2]?this.removeSon(this.user_assistant[2].id):''
                this.nameSon.splice(2, 1)
                this.ageSon.splice(2, 1)
            }
        },
        removeSon4(value) {
            console.log(value)
            if (value && this.user_assistant.length > 0) {
                this.user_assistant[3]?this.removeSon(this.user_assistant[3].id):''
                this.nameSon.splice(3, 1)
                this.ageSon.splice(3, 1)
            }
        },
        son2(value) {
            if (!this.removeSon2)
                this.nameSon[1] = value;
        },
        age2(value) {
            if (!this.removeSon2)
                this.ageSon[1] = value ? parseInt(value) : value
        },
        son3(value) {
            if (!this.removeSon3)
                this.nameSon[2] = value;
        },
        age3(value) {
            if (!this.removeSon3)
                this.ageSon[2] =value ? parseInt(value) : value
        },
        son4(value) {
            if (!this.removeSon4)
                this.nameSon[3] = value;
        },
        age4(value) {
            if (!this.removeSon4)
                this.ageSon[3] = value ? parseInt(value) : value
        },
    },
    mounted() {
        let vm = this
        Event.$on('cashActive', () => {
            this.cash = true;
            this.about = false;
            this.btnTxt1 = true, this.btnTxt2 = true, this.btnTxt3 = true
        })
        Event.$on('aboutActive', () => {
            this.cash = false;
            this.about = true;
        })
        Event.$on('perfil-customer', ({user, url}) => {
            vm.name = user.name
            vm.surname = user.last_name
            vm.phone = user.phone
            vm.email = user.email
            vm.birth = user.birth
            vm.user_assistant = user.user_assistant ? user.user_assistant : []

            if (vm.user_assistant.length > 0)
                vm.user_assistant.forEach((value, key) => {
                    let sonNumber = key + 1
                    vm[`son${sonNumber}`] = value.name
                    vm[`age${sonNumber}`] = value.age
                    // this.ageSon.push(value.age);
                    this[`removeSon${sonNumber}`] = false
                });

        })
    },
    methods: {
        editAbout() {
            this.btnTxt1 = !this.btnTxt1;
            this.$refs.nameInput.autofocus = true;
            if (this.btnTxt1 === true) {
                UpdateObject(`mi-perfil/${this.$route.params.id}`, this.formAboutUser, (error, data) => {

                })
            }
        },
        editAccount() {
            this.btnTxt2 = !this.btnTxt2;
            if (this.btnTxt2 === true) {
                UpdateObject(`mi-perfil/${this.$route.params.id}`, this.formAccount, (error, data) => {

                })
                this.password = '*******'
            } else {
                this.password = ''
            }
        },
        editBio() {
            this.btnTxt3 = !this.btnTxt3;
            if (this.btnTxt3 === true) {
                console.log(this.removeSon1)
                this.filteredNull(this.nameSon)
                this.filteredNull(this.ageSon)
                console.log(this.nameSon)
                console.log(this.formUserAssistants)
                UpdateObject(`mi-perfil/${this.$route.params.id}`, this.formUserAssistants, (error, data) => {
                    if (error) {

                    } else {
                        this.user_assistant = data.user_assistant ? data.user_assistant : []
                    }
                })
                // this.removeSon1?this.nameSon.splice(this.nameSon.indexOf(this.son1), 1):this.nameSon.push(this.son1);
            }
        },
        removeSon(id_user_assistant) {
            if (this.user_assistant.length > 0) {
                DeleteObjectApi(`user-assistant/${this.$route.params.id}?assistant_id=${id_user_assistant}`, null,(error, data) => {
                    if (error) {
                        this.user_assistant = error.user ? error.user.user_assistant : this.user_assistant
                    } else {
                        this.user_assistant = data.user ? data.user.user_assistant : this.user_assistant
                    }
                })
            }
        },
        addSon() {
            if (this.removeSon1 && this.removeSon2 && this.removeSon3 && this.removeSon4) {
                this.removeSon1 = false;
            } else if (this.removeSon2) {
                this.removeSon2 = false;
            } else if (this.removeSon3) {
                this.removeSon3 = false;
            } else if (this.removeSon1) {
                this.removeSon1 = false;
            } else if (this.removeSon4) {
                this.removeSon4 = false;
            }
        },
        filteredNull (array) {
            return array.filter(function (el) {
                return el != null;
            });
        },
        onScroll() {

        }
    }
}
</script>

<style scoped>
.info-perfil-container {
    margin-left: 10%;
    margin-right: 10%;
    margin-bottom: 100px;
}

.box-about {
    min-width: 350px;
    height: 451px;
    margin-top: 50px;
    padding: 26px 0 29px;
    border-radius: 12px;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
    background-color: #ffffff;
}

.box-account {
    height: 173px;
    margin-top: 50px;
    padding: 26px 0 44px;
    border-radius: 12px;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
    background-color: #ffffff;
}

.box-bio {
    height: auto;
    margin-top: 32px;
    padding: 26px 0 44px;
    border-radius: 12px;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.15);
    background-color: #ffffff;
}

h5 {
    font-weight: 600;
    text-transform: uppercase;
}

button {
    font-family: 'Poppins';
    font-size: 14px;
    font-weight: 600;
    color: #29c0d3;
}

h6 {
    font-weight: 500;
    opacity: 0.7;
}

input {
    font-family: 'Poppins';
    font-size: 16px;
    font-weight: 400;
    color: #343a40;
    margin-top: 4px;
    border: none;
    border-bottom: 1px solid #29c0d3;
    padding-top: 4px;
    max-width: 290px;
}

input[readonly]{
    border-bottom:none !important;
}

.v-sheet.v-card:not(.v-sheet--outlined) {
    box-shadow: none;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

.btn-add-son {
    width: 87px;
    height: 31px;
    border-radius: 8px;
    box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.27);
    border: solid 1px #29c0d3;
}

.bottom-position {
    position: relative;
    top: 94px;
}

@media (max-width: 1000px) {
    .box-account {
        height: auto;
        min-width: 350px;
    }

    .box-bio {
        height: auto;
        min-width: 350px;
    }
}
</style>
