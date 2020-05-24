<template>
    <footer class="footer">
        <div></div>
        <div class="contact">
            {{$t('footer.contact')}}{{nbsp}}:{{nbsp}}<a href = "mailto: admin@rouzig.bzh">admin@rouzig.bzh</a>
        </div>
        <div class="copyright">
            &copy;Rouzig 2020
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer"
    }
</script>

<style scoped>

</style>