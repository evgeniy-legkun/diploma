<template>
    <section class="content">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Дії</h3>
                </div>
                <div class="box-body">
                    <router-link :to="{name: 'user-create'}" class="btn btn-success">Створити Користувача</router-link>
                </div>

            </div>

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Список користувачів</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody><tr>
                            <th style="width: 10px">#</th>
                            <th>Повне Ім'я</th>
                            <th>Ел. пошта</th>
                            <th>Роль</th>
                            <th>Створений</th>
                            <th>Редагувати</th>
                            <th>Видалити</th>
                        </tr>

                        <template v-for="user in users" v-key="user.id">
                            <tr>
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{ (user.role in roles) ? roles[user.role] : '-'}}</td>
                                <td>{{user.created}}</td>
                                <td>
                                    <router-link :to="{name: 'user-edit', params: {id: user.id}}" class="btn btn-info">Редагувати</router-link>
                                </td>
                                <td>
                                    <button @click.prevent="removeUser(user.id)" type="button" class="btn btn-danger">Видалити</button>
                                </td>
                            </tr>
                        </template>

                        </tbody>
                    </table>
                </div>

            </div>

        </section>
</template>

<script>

    import GraphAPI from '../../api/GraphAPI';

    export default {

        data() {
            return {
                users: [],
                roles: {}
            }
        },

        methods: {
            removeUser(userId) {
                GraphAPI
                    .exec(`mutation { removeUser(id: ${userId}) {id} }`).then(response => {
                        this.loadUsers();
                    })
            },

            loadUsers() {
                GraphAPI
                    .exec(`
                        query {
                            users { id, name, email, created, role },
                            roles { code, name }
                        }
                    `)
                    .then((response) => {
                        this.users = response.data.data.users;

                        for(let role of response.data.data.roles) {
                            this.roles[role.code] = role.name;
                        }
                    });
            }
        },

        created() {
            this.loadUsers();
        }

    }
</script>