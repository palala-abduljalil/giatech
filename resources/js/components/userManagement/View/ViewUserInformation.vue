<template>
    <div class="card">
        <div class="card-body">
            <div class="card-body">
                <loader v-if="showSpinner"/>
                <div class="row">
                    <div class="col-md-6 pb-0">
                        <h5 class="font-weight-normal">
                            <i class="fas fa-user-circle mr-2"></i>
                            Account Information
                        </h5>
                        <hr />
                    </div>
                    <div class="col-md-6 pb-0">
                        <h5 class="font-weight-normal">
                            <i class="fas fa-cubes mr-2"></i>
                            Modules
                        </h5>
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pt-0">
                        <div class="col-md-12 pt-0">
                            <div class="form-group">
                                <text-field
                                    label="Username"
                                    name="username"
                                    v-model="form.username"
                                    :readonly="true"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <modules :modules="form.modules" :disable="true"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TextField from "../../customComponents/TextField";
import Modules from "../Modules";
import Loader from "../../customComponents/Loader";

export default {
    props: {
        data: Object
    },
    components: {
        TextField,
        Modules,
        Loader,
    },
    data() {
        return {
            showSpinner: true,
            form: {
                username: "",
                modules: [],
            },
        };
    },
    methods: {
        getModules() {
            axios
                .get("/api/module")
                .then((response) => {
                    this.form.modules = response.data;
                })
                .catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: "Error! " + error.message,
                    });
                    console.log("Error: ", error);
                })
                .finally(() => {
                    if (this.form.modules.length != 0) {
                        this.assignSelect(this.data.modules);
                    }
                    this.$PageLoad.stop();
                    this.showSpinner = false;
                });
        },
        assignSelect(newValue) {
            newValue = newValue.map(
                (items) => ({
                    ...items,
                    select: true,
                })
            );
            newValue.forEach(element => {
                let index = this.form.modules.map(object => object.id).indexOf(element.id);
                Vue.set(this.form.modules, index, element);
            });
        },
        setSelect(value) {
            this.form.modules = this.form.modules.map(
                (items) => ({
                    ...items,
                    select: value,
                })
            );
        },
    },
    watch: {
        'form.username'() {
            this.getModules();
        }
    },
    mounted() {
        this.form.username = this.data.username;
    },
};
</script>

<style scoped>
.card-title {
    margin-bottom: 0px;
    font-size: 20px;
}
</style>
