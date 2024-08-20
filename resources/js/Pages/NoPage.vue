<template lang="">
    <div class="misc-wrapper text-center">
    <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">404</h1>
    <h4 class="mb-2 mx-2">Page Not Found️ ⚠️</h4>
    <p class="mb-6 mx-2">we couldn't find the page you are looking for</p>
    <router-link to="/" class="btn btn-primary">Back to home</router-link>
    <div class="mt-6">
      <img :src="url + '/assets/img/illustrations/page-misc-error-light.png'" alt="page-misc-error-light" width="500" class="img-fluid" data-app-light-img="illustrations/page-misc-error-light.png" data-app-dark-img="illustrations/page-misc-error-dark.png">
    </div>
  </div>
</template>
<script>
export default {
    data() {
        return {
            url: window.location.origin
        }
    },
}
</script>
<style lang="">
    
</style>