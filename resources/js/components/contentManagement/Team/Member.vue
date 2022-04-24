<template>
    <div class="card card-primary bg-light d-flex flex-fill card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img
                    class="profile-user-img img-fluid img-circle"
                    :src="localItem.employee.profilePicture.url"
                    alt="User profile picture"
                />
            </div>
            <h3 class="profile-username text-center">
                {{ localItem.employee.name }}
            </h3>
            <p class="text-muted text-center mt-0">
                {{ localItem.employee.position.name }}
            </p>
            <p class="mb-0 font-weight-bold">
                <i class="fab fa-linkedin mr-1"></i>
                LinkedIn
            </p>
            <a :href="`${localItem.linkedInLink}`">
                {{ localItem.linkedInLink }}
            </a>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a
                    @click="handleEdit(item)"
                    class="btn btn-sm bg-primary"
                >
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
                <a
                    @click="handleDelete(item)"
                    class="btn btn-sm btn-danger"
                >
                    <i class="fas fa-times mr-1"></i>Remove
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        item: Object,
    },
    data() {
        return {
            localItem: this.item,
        }
    },
    methods: {
        handleEdit(item) {
            this.$emit("onEdit", item);
        },
        handleDelete(item) {
            this.$emit("onDelete", item);
        }
    },
    watch: {
        item() {
            this.localItem = this.item;
        }
    }
};
</script>

<style></style>
