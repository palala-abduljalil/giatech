<template>
    <v-app>
        <v-card>
            <v-card-title>
                <v-container>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-file-input
                                label="Click here to select an attachment(s)"
                                multiple
                                @change="handleChange($event)"
                            />
                        </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-alert type="info">
                                Allowed file formats: jpg, png, gif, doc, docx,
                                xls, xlsx, pdf, txt.
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
                            <strong>{{ error.name }}</strong>
                            {{ error.description }}
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
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                small
                                v-bind="attrs"
                                v-on="on"
                                @click="handleOnRemove(item.index)"
                            >
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Remove from list</span>
                    </v-tooltip>
                </template>
            </v-data-table>
        </v-card>
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
        handleChange(event) {
            this.$emit("onInputFileChange", event);
        },
    },
};
</script>

<style></style>
