<template>
    <div class="w-full">
        <div v-for="(item, index) in items" :key="item.id" tabindex="-1">
            <item :item="item" :field="field" @deleted="remove(index)"></item>
        </div>
        <new-item @created="add" :field="field" v-if="edit"></new-item>
    </div>
</template>

<script>
    import Item from './Item.vue';
    import NewItem from './NewItem.vue';

    export default {
        components: { Item, NewItem },
        props: ['items', 'field', 'edit'],
        methods: {
            add(item) {
                this.items.push(item);
                this.$emit('update:modelValue', this.items)
                this.$emit('added');
            },

            remove(index) {
                this.items.splice(index, 1);
                this.$emit('update:modelValue', this.items)
                this.$emit('removed');
            },
        }
    }
</script>
