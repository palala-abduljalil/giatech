<template>
    <v-app>
        <v-card-title>
            <v-container>
                <v-row no-gutters>
                    <v-col cols="12">
                        <v-file-input
                            label="Click here to select an attachment(s)"
                            multiple
                            @change="handleChange"
                            prepend-icon="fa fa-paperclip"
                        ></v-file-input>
                    </v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="12">
                        <v-alert type="info" icon="fas fa-exclamation-circle">
                            Allowed file formats: jpg, png, gif, doc, docx, xls,
                            xlsx, pdf, txt.
                        </v-alert>
                    </v-col>
                </v-row>
                <v-row no-gutters>
                    <v-alert
                        dense
                        outlined
                        dismissible
                        type="error"
                        v-for="(error, index) in invalidFiles"
                        :key="index"
                    >
                        <strong>{{ error.name }}</strong> {{ error.description }}
                    </v-alert>
                </v-row>
            </v-container>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="items"
            hide-default-footer
            class="elevation-1"
        >
            <template v-slot:no-data> List of Attachment </template>
            <template v-slot:item.index="{ item }">
                {{ item.index + 1 }}
            </template>
            <template v-slot:item.action="{ item }">
                <v-menu bottom left>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon small>fa-ellipsis-v</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item link @click="handleOnDownload(item)">
                            <v-list-item-title>
                                <v-icon small left> mdi-download </v-icon>
                                Download
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item link @click="handleOnView(item)">
                            <v-list-item-title>
                                <v-icon small left> mdi-eye </v-icon>
                                View
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item link @click="handleOnRemove(item)">
                            <v-list-item-title>
                                <v-icon small left> mdi-delete </v-icon>
                                Remove
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </template>
        </v-data-table>
    </v-app>
</template>

<script>
export default {
    props: {
        items: Array,
        headers: Array,
        invalidFiles: Array,
    },
    methods: {
        handleOnRemove(index) {
            this.$emit("onRemove", index);
        },
        handleOnView(item) {
            this.$emit("onView", item);
        },
        handleOnDownload(item) {
            this.$emit("onDownload", item);
        },
        handleChange(event) {
            this.$emit("onInputFileChange", event);
        },
    },
};
</script>

<style></style>
