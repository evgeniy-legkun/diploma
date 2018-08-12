<template>
    <ul class="nav nav-tabs">
        <li v-bind:class="{active: 'transportation-list' === activeTab}">
            <router-link :to="{name: 'transportation-list'}">Перевезення</router-link>
        </li>

        <li v-bind:class="{active: 'transportation-carriers' === activeTab}">
            <router-link :to="{name: 'transportation-carriers'}">Перевізники</router-link>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['activeTab']
    }
</script>