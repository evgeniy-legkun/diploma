<template>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Редагувати користувача</h3>
            </div>
            <div class="box-body">

                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input v-model="email" type="email" class="form-control" id="email" placeholder="E-mail">
                        </div>
                        <div class="form-group">
                            <label for="name">Імя</label>
                            <input v-model="name" type="text" class="form-control" id="name" placeholder="Імя">
                        </div>
                    </div>

                    <div class="box-footer">
                        <button @click.prevent="editUser" type="submit" class="btn btn-primary">Редагувати</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
</template>

<script>

    import GraphAPI from '../../api/GraphAPI';

    export default {

        data() {
            return {
                id: this.$route.params.id,
                email: '',
                name: '',
            }
        },

        methods: {

            loadUser(userId) {
                GraphAPI.exec(`
                    query {
                      user(id: ${userId}) {
                        id,
                        name,
                        email,
                      }
                    }
                `).then(response => {
                    let user = response.data.data.user;
                    this.email = user.email;
                    this.name = user.name;
                })
            },

            editUser() {
                GraphAPI.exec(`
                    mutation {
                        updateUser(id:${this.id}, name: "${this.name}", email: "${this.email}") {
                            id
                        }
                    }
                `).then(response => {
                    this.$router.push({name: 'users-list'});
                })
            }
        },

        mounted() {
            this.loadUser(this.id);

        }
    }
</script>