<template>
    <div class="flex items-stretch w-full mb-2 relative">
        <input
            type="text"
            class="w-full form-control form-input form-input-bordered"
            :placeholder="__('Select a file')"
            :value="value"
            @input="$emit('update:value', $event.target.value)"
            :disabled="isReadonly"
        />
        <DefaultButton type="button" class="ml-4 whitespace-nowrap nowrap" @click.prevent="openModalFilemanager">
            {{ __('Open FileManager') }}
        </DefaultButton>
    </div>
</template>

<script>
    export default {
        props: ['value', 'field', 'isReadonly'],

        methods: {
            openModalFilemanager() {
                this.$emit('open-modal');
            },
        },
    };
</script>
