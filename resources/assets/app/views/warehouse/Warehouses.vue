<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Склади / Mатеріали</h1>
        </section>

        <router-view></router-view>

    </div>
</template>

<script>
    export default {
        components: {
            'WarehouseTabs': require('./WarehouseTabs')
        }
    }
</script>