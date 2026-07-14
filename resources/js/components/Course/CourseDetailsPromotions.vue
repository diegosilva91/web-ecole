<template>
    <div class="container">
        <div class="row">
            <div v-show="promotions" class="col-12 col-md-12">
                <h2 class="h2-txt mb-8">Disponibilidades</h2>
                <div v-for="(promotion,key) in promotions" :key="key" class="row container card-promotions-mob mx-auto mb-4">
                    <div class="col-4 p3-txt">
                        <div class="mb-2">Inicio<br><span class="p3-txt-sbold">{{ promotion.start_at | formatted('yyyy-MM-dd') }}</span></div>
                        <div>Día<br>
                            <div v-show="promotion.daily">
                                <span class="p3-txt-sbold">
                                    {{daily}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 p3-txt">
                        <div class="mb-2">Fin<br><span class="p3-txt-sbold">{{ promotion.end_at | formatted('yyyy-MM-dd') }}</span></div>
                        <div>Hora<br><span class="p3-txt-sbold">{{ promotion.start_at | formatted('HH:ii') }}</span></div>
                    </div>
                    <div class="col-4 p3-txt">
                        <div class="purple-title mb-3">Solo<br><span class="p3-txt-sbold">{{ course.students_max}} espacios</span></div>
                        <div>
                            <a href="/es/payment/{{promotion.id}}" class="btn-booking-mob v-btn v-size--default theme--light">
                                <!--@if(config('app.env') == 'production')
                                onclick="Payment()"
                                @endif-->
                            <span class="btn-price blue-title text-capitalize">Reservar</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p3-txt">¿No ves un horario que te funcione?</div>
                <div><a class="p3-txt" href="/es/contacto"><strong class="blue-title">¡Solicita otro nuevo!</strong></a></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CourseDetailsPromotions",
    props:['promotions','count','course'],
    mounted(){
        //count->where('id',$promotion->id)->count()
        if(this.promotions)
            this.promotions.daily && Array.isArray(this.promotions.daily)  ?this.daily= 'Lunes' : this.daily = JSON.parse(this.promotions.daily).map(function (value) {
                switch (value) {
                    case "0":
                        return "Lunes"
                    case "1":
                        return "Martes"
                    case "2":
                        return "Miercoles"
                    case "3":
                        return "Jueves"
                    case "4":
                        return "Viernes"
                    case "5":
                        return "Sábado"
                    default:
                        return "Lunes"
                }
            }).join("/ ")
    },
    filters:{
        formatted(date,format){
            if (format==='yyyy-MM-dd' && date!==''){
                let month= (date.getMonth() + 1)
                if(month<10)
                    month='0'+month
                return date.getDate() + '-' + month+ '-' + date.getFullYear()
            }
            if(format==='HH:ii')
                return date.getHours()+':'+ date.getMinutes()
            //return date.toISOString().split('T')[0]
            return date;
        }
    }
}
</script>

<style scoped>

</style>
