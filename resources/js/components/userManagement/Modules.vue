<template>
    <section>
        <ul class="list-group">
            <li
                class="list-group-item d-flex justify-content-between align-items-center"
                v-for="module in modules"
                :key="module.id"
            >
                {{ module.name }}
                <div class="custom-control custom-switch">
                    <input
                        type="checkbox"
                        class="custom-control-input"
                        :id="`customSwitch${module.id}`"
                        v-model="module.select"
                        :disabled="disable"
                    />
                    <label
                        class="custom-control-label"
                        :for="`customSwitch${module.id}`"
                    ></label>
                </div>
            </li>
        </ul>
        <div class="module-invalid-feedback" v-if="errors.has('form.modules')">
            {{ errors.first("form.modules") }}
        </div>
    </section>
</template>

<script>
export default {
    inject: ['$validator'],
    props: {
        modules: Array,
        disable: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style></style>
