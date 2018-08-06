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
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" id="pass" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="password" class="form-control" id="first_name" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="password" class="form-control" id="last_name" placeholder="Password">
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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