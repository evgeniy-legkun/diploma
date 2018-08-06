<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Користувачі</h1>
        </section>

        <router-view></router-view>

    </div>
</template>

<script>

    import GraphAPI from '../../api/GraphAPI';

    export default {

        data() {
            return {
                users: []
            }
        },

        created() {
            GraphAPI
                .exec(`query { users {id, name, email} }`)
                .then((response) => {
                    this.users = response.data.data.users;
                });
        }

    }
</script>