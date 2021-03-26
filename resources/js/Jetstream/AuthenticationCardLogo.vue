<template>
    <inertia-link :href="'/'">
        <img :src="getImage()" class="object-scale-down h-48 w-30 rounded-full h-48 w-30 flex items-center justify-center">
    </inertia-link>
</template>

<script>
 export default {
     methods:{
         getImage(){
             return 'img/ckstore_logomarca.jpeg';
         }
     }
 }
</script>