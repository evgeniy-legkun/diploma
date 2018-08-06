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
                            <th>Створений</th>
                            <th>Редагувати</th>
                            <th>Видалити</th>
                        </tr>

                        <template v-for="user in users" v-key="user.id">
                            <tr>
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>21-02-2018</td>
                                <td>
                                    <router-link :to="{name: 'user-edit'}" class="btn btn-info">Редагувати</router-link>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger">Видалити</button>
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