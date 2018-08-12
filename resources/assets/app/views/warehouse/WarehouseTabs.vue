<template>
    <ul class="nav nav-tabs">
        <li v-bind:class="{active: 'warehouses' === activeTab}">
            <router-link :to="{name: 'warehouses-list'}">Склади</router-link>
        </li>

        <li v-bind:class="{active: 'materials' === activeTab}">
            <router-link :to="{name: 'materials-list'}">Матеріали</router-link>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['activeTab']
    }
</script>