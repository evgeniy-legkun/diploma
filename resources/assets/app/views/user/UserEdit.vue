<template>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Редагувати користувача</h3>
            </div>
            <div class="box-body">

                <div v-if="formErrors.length > 0" class="alert alert-error">
                    <ul>
                        <li v-for="error in formErrors">{{error}}</li>
                    </ul>
                </div>

                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label>E-mail *</label>
                            <input v-model="user.email"
                                   type="text"
                                   class="form-control"
                                   placeholder="E-mail"
                                   name="email"
                                   v-validate="'required|email'"
                            >
                            <span v-if="errors.has('email')" class="text-red">Ел. пошта обовязкова</span>
                        </div>
                        <div class="form-group">
                            <label>Пароль *</label>
                            <input v-model="user.password"
                                   name="password"
                                   type="password"
                                   class="form-control"
                                   placeholder="Пароль"
                                   v-validate="'required'"
                            >
                            <span v-if="errors.has('password')" class="text-red">Пароль обовязковий</span>
                        </div>

                        <div class="form-group">
                            <label>Роль *</label>
                            <select class="form-control" v-model="user.role">
                                <option v-for="role in roles" v-bind:value="role.code">{{role.name}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Повне Імя *</label>
                            <input name="name"
                                   v-model="user.name"
                                   type="text"
                                   class="form-control"
                                   placeholder="Імя"
                                   v-validate="'required'"
                            >
                            <span v-if="errors.has('name')" class="text-red">Імя обовязкове</span>
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
                formErrors: [],
                user: {
                    id: this.$route.params.id,
                    email: '',
                    name: '',
                    password: '',
                    role: null
                },
                roles: []
            }
        },

        methods: {

            loadUser(userId) {
                GraphAPI.exec(`
                    query {
                      user(id: ${this.user.id}) { id, name, email, role },
                      roles { code, name }
                    }
                `).then(response => {
                    let user = response.data.data.user;
                    this.roles = response.data.data.roles;
                    this.user.email = user.email;
                    this.user.name = user.name;
                    this.user.role = user.role;
                })
            },

            editUser() {

                this.$validator.validateAll().then((result) => {
                    if (!result) {return;}

                    GraphAPI.exec(`
                        mutation {
                            updateUser(
                                id:${this.user.id},
                                name: "${this.user.name}",
                                email: "${this.user.email}"
                                role: ${this.user.role},
                                password: "${this.user.password}"
                            ) {
                                id
                            }
                        }
                    `).then(response => {
                        let userResponse = response.data;
                        this.formErrors = [];

                        if ( !('errors' in userResponse) ) {
                            this.$router.push({name: 'users-list'});
                        }

                        this.formErrors = userResponse.errors.map(error => {
                            return error.message;
                        });
                    })

                });


            }
        },

        mounted() {

            this.loadUser(this.id);

        }
    }
</script>