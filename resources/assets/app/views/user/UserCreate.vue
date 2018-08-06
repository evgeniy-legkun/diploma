<template>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Створити користувача</h3>
            </div>
            <div class="box-body">

                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input v-model="email" type="email" class="form-control" id="email" placeholder="E-mail">
                        </div>
                        <div class="form-group">
                            <label for="pass">Пароль</label>
                            <input v-model="password" type="password" class="form-control" id="pass" placeholder="Пароль">
                        </div>
                        <div class="form-group">
                            <label for="name">Імя</label>
                            <input v-model="name" type="text" class="form-control" id="name" placeholder="Імя">
                        </div>
                    </div>

                    <div class="box-footer">
                        <button @click.prevent="createUser" type="submit" class="btn btn-primary">Створити</button>
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
                email: '',
                name: '',
                password: '',
            }
        },

        methods: {

            createUser() {
                GraphAPI.exec(`
                    mutation {
                        createUser(
                            name: "${this.name}",
                            email: "${this.email}",
                            password: "${this.password}",
                            role:"user"
                        ) { id, name, email }
                    }
                `).then((response) => {
                    this.$router.push({name: 'users-list'});
                });

            }
        }
    }
</script>